import os
from urllib.parse import urljoin

import requests
import pymysql
from behave import given, when, then


# Helper
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


# SQL helpers
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


def _table_columns(table: str):
    conn = _mysql_conn()
    try:
        with conn.cursor() as cur:
            cur.execute(f"SHOW COLUMNS FROM `{table}`")
            rows = cur.fetchall()
            return [r["Field"] for r in rows]
    finally:
        conn.close()


def _ensure_item_exists(name: str, category: str = "General"):
    """
    Insert item jika belum ada.
    Adaptif terhadap struktur tabel `items`.
    """
    conn = _mysql_conn()
    try:
        cols = _table_columns("items")

        with conn.cursor() as cur:
            cur.execute("SELECT id FROM items WHERE name = %s LIMIT 1", (name,))
            if cur.fetchone():
                return

            defaults = {
                "name": name,
                "category": category,
                "price": 10000,
                "dosage_form": "tablet",
                "strength": "500mg",
                "manufacturer": "BDD-Manufacturer",
                "indication": "BDD-Indication",
                "image_path": None,
            }

            if "created_at" in cols:
                defaults["created_at"] = "2025-01-01 00:00:00"
            if "updated_at" in cols:
                defaults["updated_at"] = "2025-01-01 00:00:00"

            insert_cols = [c for c in defaults if c in cols]
            insert_vals = [defaults[c] for c in insert_cols]

            col_sql = ",".join(f"`{c}`" for c in insert_cols)
            placeholders = ",".join(["%s"] * len(insert_cols))
            sql = f"INSERT INTO items ({col_sql}) VALUES ({placeholders})"

            cur.execute(sql, insert_vals)
    finally:
        conn.close()


@given("the application base url is set")
def step_set_base_url(context):
    context.base_url = os.getenv("BASE_URL", "http://127.0.0.1:8000").rstrip("/")


@given('there are items named "{item1}" and "{item2}"')
def step_seed_two_items(context, item1, item2):
    _ensure_item_exists(item1, category="Analgesic")
    _ensure_item_exists(item2, category="Antibiotic")


@given('there is an item named "{name}" with category "{category}"')
def step_seed_item_with_category(context, name, category):
    _ensure_item_exists(name, category=category)


@when('the user opens the catalog page "{path}"')
def step_open_catalog(context, path):
    sess = _session(context)
    r = sess.get(_full_url(context, path), allow_redirects=True, timeout=10)
    context.last_response = r


@when('the user searches catalog at "{path}" with keyword "{keyword}"')
def step_search_catalog(context, path, keyword):
    context.last_search = keyword  # simpan untuk filter lanjutan
    sess = _session(context)
    r = sess.get(
        _full_url(context, path),
        params={"search": keyword},
        allow_redirects=True,
        timeout=10,
    )
    context.last_response = r


@when('the user filters catalog at "{path}" by category "{category}"')
def step_filter_by_category(context, path, category):
    sess = _session(context)
    params = {
        "search": getattr(context, "last_search", ""),
        "category": category,
    }
    r = sess.get(
        _full_url(context, path),
        params=params,
        allow_redirects=True,
        timeout=10,
    )
    context.last_response = r


@then("the catalog page should be displayed")
def step_catalog_displayed(context):
    r = context.last_response
    assert r is not None, "No response captured."
    assert r.status_code == 200, f"Expected 200, got {r.status_code}"


@then('the catalog page should show "{text}"')
def step_page_should_show(context, text):
    r = context.last_response
    assert r.status_code == 200
    assert text.lower() in r.text.lower(), (
        f'Expected to see "{text}" on page, but it was not found.'
    )


@then('the search results should include "{name}"')
def step_results_include(context, name):
    r = context.last_response
    assert r.status_code == 200
    assert name.lower() in r.text.lower(), (
        f'Expected results to include "{name}", but not found.'
    )


@then('the search results should not include "{name}"')
def step_results_not_include(context, name):
    r = context.last_response
    assert r.status_code == 200
    assert name.lower() not in r.text.lower(), (
        f'Expected results NOT to include "{name}", but it was found.'
    )


@then("the search results should be empty")
def step_results_empty(context):
    r = context.last_response
    assert r.status_code == 200
    assert "No products found matching your criteria." in r.text, (
        "Expected empty results message, but it was not found."
    )
