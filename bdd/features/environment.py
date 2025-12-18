# bdd/features/environment.py
import os
import re
import requests
import urllib.parse

DEFAULT_BASE_URL = "http://127.0.0.1:8000"

# Regex umum untuk ambil CSRF token dari HTML Laravel Blade:
# <meta name="csrf-token" content="...">
META_CSRF_RE = re.compile(r'<meta\s+name="csrf-token"\s+content="([^"]+)"', re.IGNORECASE)

# Hidden input token:
# <input type="hidden" name="_token" value="...">
INPUT_CSRF_RE = re.compile(r'name="_token"\s+value="([^"]+)"', re.IGNORECASE)


def _join_url(base_url: str, path: str) -> str:
    base = base_url.rstrip("/")
    p = (path or "").strip()
    if not p.startswith("/"):
        p = "/" + p
    return base + p


def _extract_csrf_token(html: str) -> str | None:
    if not html:
        return None

    m = META_CSRF_RE.search(html)
    if m:
        return m.group(1)

    m = INPUT_CSRF_RE.search(html)
    if m:
        return m.group(1)

    return None


def before_all(context):
    # Base URL: bisa di override dari terminal:
    # BASE_URL=http://127.0.0.1:8000 behave bdd/features
    context.base_url = os.getenv("BASE_URL", DEFAULT_BASE_URL).rstrip("/")

    # Pakai session supaya cookie laravel (session) kebawa otomatis
    context.session = requests.Session()

    # Header default untuk request HTML biasa (web)
    # NOTE: untuk web-auth Laravel, jangan memaksa Accept: application/json
    # karena bisa mengubah response validasi jadi JSON/422.
    context.default_headers = {
        "User-Agent": "behave-integration-tests",
    }

    # helper methods biar step simpel & konsisten
    def http_get(path: str, **kwargs):
        url = _join_url(context.base_url, path)
        headers = dict(context.default_headers)
        headers.update(kwargs.pop("headers", {}) or {})
        resp = context.session.get(url, headers=headers, **kwargs)
        _save_last_response(context, resp)
        return resp

    def http_post(path: str, data=None, json=None, **kwargs):
        url = _join_url(context.base_url, path)
        headers = dict(context.default_headers)
        headers.update(kwargs.pop("headers", {}) or {})
        resp = context.session.post(url, headers=headers, data=data, json=json, **kwargs)
        _save_last_response(context, resp)
        return resp

    context.http_get = http_get
    context.http_post = http_post


def before_scenario(context, scenario):
    # “state” per scenario
    context.last_response = None
    context.last_html = None
    context.last_json = None
    context.csrf_token = None
    context.authenticated = False


def after_all(context):
    try:
        context.session.close()
    except Exception:
        pass

def _csrf_from_cookie(context):
    # Laravel sering menyimpan token di cookie XSRF-TOKEN (urlencoded)
    jar = context.session.cookies
    if "XSRF-TOKEN" in jar:
        return urllib.parse.unquote(jar.get("XSRF-TOKEN"))
    return None

def _save_last_response(context, resp: requests.Response):
    context.last_response = resp

    # simpan html / json kalau bisa
    content_type = (resp.headers.get("Content-Type") or "").lower()
    text = resp.text or ""
    context.last_html = text

    # coba parse json (kalau memang JSON)
    context.last_json = None
    if "application/json" in content_type:
        try:
            context.last_json = resp.json()
        except Exception:
            context.last_json = None

    # Auto-capture CSRF token kalau halaman mengandung token
    token = _extract_csrf_token(text)
    if token:
        context.csrf_token = token

    if not context.csrf_token:
        token_cookie = _csrf_from_cookie(context)
        if token_cookie:
            context.csrf_token = token_cookie



# Optional helper yang bisa kamu pakai di steps:
def ensure_csrf(context, login_page="/login"):
    """
    Pastikan context.csrf_token terisi dengan cara GET halaman login/register dulu.
    Ini menghindari 419 Page Expired saat POST.
    """
    if context.csrf_token:
        return context.csrf_token
    resp = context.http_get(login_page)
    token = context.csrf_token
    if not token:
        raise AssertionError(
            "CSRF token tidak ditemukan di halaman. "
            "Cek apakah halaman punya <meta name='csrf-token'> atau input name='_token'."
        )
    return token
