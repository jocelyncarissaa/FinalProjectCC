import os
import re
import pymysql
from behave import given, when, then

# =========================
# MySQL helpers (tanpa step decorator)
# =========================
def _mysql_conn():
    db = os.getenv("DB_DATABASE", "").strip()
    if not db:
        raise AssertionError(
            "DB_DATABASE belum terset. Set dulu di PowerShell:\n"
            '$env:DB_DATABASE="finalprojectcc"'
        )

    return pymysql.connect(
        host=os.getenv("DB_HOST", "127.0.0.1"),
        port=int(os.getenv("DB_PORT", "3306")),
        user=os.getenv("DB_USERNAME", "root"),
        password=os.getenv("DB_PASSWORD", ""),
        database=db,
        charset="utf8mb4",
        cursorclass=pymysql.cursors.DictCursor,
        autocommit=True,
    )

def _fetchone(sql, params=()):
    conn = _mysql_conn()
    try:
        with conn.cursor() as cur:
            cur.execute(sql, params)
            return cur.fetchone()
    finally:
        conn.close()

def _fetchall(sql, params=()):
    conn = _mysql_conn()
    try:
        with conn.cursor() as cur:
            cur.execute(sql, params)
            return cur.fetchall()
    finally:
        conn.close()

def _ensure_cart_row(user_id: int, item_id: int, qty: int):
    row = _fetchone(
        "SELECT id, quantity FROM carts WHERE user_id=%s AND item_id=%s LIMIT 1",
        (user_id, item_id),
    )
    if row:
        _exec("UPDATE carts SET quantity=%s WHERE id=%s", (qty, row["id"]))
    else:
        _exec(
            "INSERT INTO carts (user_id, item_id, quantity, created_at, updated_at) VALUES (%s,%s,%s,NOW(),NOW())",
            (user_id, item_id, qty),
        )

def _exec(sql, params=()):
    conn = _mysql_conn()
    try:
        with conn.cursor() as cur:
            cur.execute(sql, params)
    finally:
        conn.close()

def _get_item_id_by_name(name: str) -> int:
    row = _fetchone("SELECT id FROM items WHERE name=%s LIMIT 1", (name,))
    assert row, f'Item "{name}" tidak ditemukan di DB. Pastikan step seed item jalan.'
    return int(row["id"])

# =========================
# GIVEN (khusus cart)
# =========================
@given("a test user exists")
def step_test_user_exists(context):
    """
    Dipakai untuk testing cart. Kita butuh user_id untuk cek tabel carts.
    Kalau kamu sudah punya user test tetap, isi TEST_USER_ID di env.
    """
    user_id = os.getenv("TEST_USER_ID", "").strip()
    assert user_id, (
        "Set env TEST_USER_ID dulu (id user di tabel users).\n"
        'Contoh: $env:TEST_USER_ID="1"'
    )
    context.test_user_id = int(user_id)

@given('the cart contains "{item_name}" with quantity {qty:d}')
def step_cart_contains(context, item_name, qty):
    item_id = _get_item_id_by_name(item_name)
    _ensure_cart_row(context.test_user_id, item_id, qty)

# =========================
# WHEN (aksi cart via endpoint BDD)
# =========================
@when('the user adds "{item_name}" to the cart with quantity {qty:d}')
def step_add_to_cart(context, item_name, qty):
    item_id = _get_item_id_by_name(item_name)

    # Endpoint khusus BDD (direkomendasikan) supaya tidak perlu login & CSRF ribet.
    # Kamu buat route: POST /bdd/cart/add?user_id=...
    resp = context.http_post(
        f"/bdd/cart/add?user_id={context.test_user_id}",
        json={"item_id": item_id, "quantity": qty},
        allow_redirects=True,
        timeout=10,
        headers={"X-Requested-With": "XMLHttpRequest"},
    )
    assert resp.status_code in (200, 302), f"Add cart gagal. status={resp.status_code}"

@when('the user increases quantity of "{item_name}" by {delta:d}')
def step_increase_qty(context, item_name, delta):
    item_id = _get_item_id_by_name(item_name)
    resp = context.http_post(
        f"/bdd/cart/add?user_id={context.test_user_id}",
        json={"item_id": item_id, "quantity": delta},
        allow_redirects=True,
        timeout=10,
        headers={"X-Requested-With": "XMLHttpRequest"},
    )
    assert resp.status_code in (200, 302)

@when('the user decreases quantity of "{item_name}" by {delta:d}')
def step_decrease_qty(context, item_name, delta):
    item_id = _get_item_id_by_name(item_name)
    resp = context.http_post(
        f"/bdd/cart/add?user_id={context.test_user_id}",
        json={"item_id": item_id, "quantity": -abs(delta)},
        allow_redirects=True,
        timeout=10,
        headers={"X-Requested-With": "XMLHttpRequest"},
    )
    assert resp.status_code in (200, 302)

# =========================
# THEN (cek DB + cek halaman cart)
# =========================
@then('the cart should contain "{item_name}" with quantity {qty:d}')
def step_cart_should_contain(context, item_name, qty):
    item_id = _get_item_id_by_name(item_name)
    row = _fetchone(
        "SELECT quantity FROM carts WHERE user_id=%s AND item_id=%s LIMIT 1",
        (context.test_user_id, item_id),
    )
    assert row, f'Cart row untuk "{item_name}" tidak ada.'
    assert int(row["quantity"]) == qty, f'Quantity salah. Expected {qty}, got {row["quantity"]}.'

@then('the cart should not contain "{item_name}"')
def step_cart_should_not_contain(context, item_name):
    item_id = _get_item_id_by_name(item_name)
    row = _fetchone(
        "SELECT id FROM carts WHERE user_id=%s AND item_id=%s LIMIT 1",
        (context.test_user_id, item_id),
    )
    assert not row, f'Item "{item_name}" masih ada di cart, padahal harusnya sudah terhapus.'
