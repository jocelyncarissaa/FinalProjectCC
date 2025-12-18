import os
from urllib.parse import urljoin

import requests
import pymysql
from behave import given, when, then


def _get_base_url(context) -> str:
    base_url = getattr(context, "base_url", None) or os.getenv("BASE_URL", "").strip()
    if not base_url:
        base_url = "http://127.0.0.1:8000"
    return base_url.rstrip("/")


def _session(context) -> requests.Session:
    if not hasattr(context, "session"):
        context.session = requests.Session()
    return context.session


def _full_url(context, path: str) -> str:
    base = _get_base_url(context)
    path = path if path.startswith("/") else f"/{path}"
    return urljoin(base + "/", path.lstrip("/"))


def _mysql_conn():
    return pymysql.connect(
        host=os.getenv("DB_HOST", "127.0.0.1"),
        port=int(os.getenv("DB_PORT", "3306")),
        user=os.getenv("DB_USERNAME", "root"),
        password=os.getenv("DB_PASSWORD", ""),
        database=os.getenv("DB_DATABASE", ""),
        charset="utf8mb4",
        cursorclass=pymysql.cursors.DictCursor,
        autocommit=True,
    )


def _get_item_id(name: str):
    conn = _mysql_conn()
    try:
        with conn.cursor() as cur:
            cur.execute("SELECT id FROM items WHERE name=%s LIMIT 1", (name,))
            row = cur.fetchone()
            assert row, f'Item "{name}" tidak ditemukan di DB'
            return row["id"]
    finally:
        conn.close()


def _clear_cart():
    conn = _mysql_conn()
    try:
        with conn.cursor() as cur:
            cur.execute("DELETE FROM carts")
    finally:
        conn.close()


def _get_cart_qty(item_id: int):
    conn = _mysql_conn()
    try:
        with conn.cursor() as cur:
            cur.execute("SELECT quantity FROM carts WHERE item_id=%s LIMIT 1", (item_id,))
            row = cur.fetchone()
            return row["quantity"] if row else None
    finally:
        conn.close()


@given('the cart contains "{item_name}" with quantity {qty:d}')
def step_cart_contains(context, item_name, qty):
    _clear_cart()
    item_id = _get_item_id(item_name)

    conn = _mysql_conn()
    try:
        with conn.cursor() as cur:
            cur.execute(
                "INSERT INTO carts (item_id, quantity) VALUES (%s, %s)",
                (item_id, qty),
            )
    finally:
        conn.close()

@given('there is an item named "{item_name}" with category "{category}"')
def step_there_is_item(context, item_name, category):
    conn = _mysql_conn()
    try:
        with conn.cursor() as cur:
            # kalau ada, update category; kalau belum, insert
            cur.execute("SELECT id FROM items WHERE name=%s LIMIT 1", (item_name,))
            row = cur.fetchone()

            if row:
                cur.execute(
                    "UPDATE items SET category=%s WHERE id=%s",
                    (category, row["id"])
                )
            else:
                cur.execute(
                    "INSERT INTO items (name, category) VALUES (%s, %s)",
                    (item_name, category)
                )
    finally:
        conn.close()



@when('the user adds "{item_name}" to the cart with quantity {qty:d}')
def step_add_to_cart(context, item_name, qty):
    sess = _session(context)
    r = sess.post(
        _full_url(context, "/cart/add"),
        data={"item_name": item_name, "quantity": qty},
        allow_redirects=True,
        timeout=10,
    )
    context.last_response = r


@when('the user increases quantity of "{item_name}" by {qty:d}')
def step_increase(context, item_name, qty):
    step_add_to_cart(context, item_name, qty)


@when('the user decreases quantity of "{item_name}" by {qty:d}')
def step_decrease(context, item_name, qty):
    step_add_to_cart(context, item_name, -qty)



@then('the cart should contain "{item_name}" with quantity {qty:d}')
def step_assert_cart_qty(context, item_name, qty):
    item_id = _get_item_id(item_name)
    db_qty = _get_cart_qty(item_id)
    assert db_qty == qty, f"Expected qty={qty}, got {db_qty}"


@then('the cart should not contain "{item_name}"')
def step_assert_cart_not_contains(context, item_name):
    item_id = _get_item_id(item_name)
    db_qty = _get_cart_qty(item_id)
    assert db_qty is None, f'Item "{item_name}" masih ada di cart'
