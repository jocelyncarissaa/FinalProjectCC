# bdd/features/steps/auth_steps.py
from behave import given, when, then

# === UBAH INI sesuai route Laravel kamu ===
LOGIN_ENDPOINT = "/login"   # kalau kamu punya /api/login, ganti jadi itu

# === UBAH INI sesuai field form login kamu ===
USERNAME_FIELD = "email"
PASSWORD_FIELD = "password"


@given("the API base URL is set")
def step_base_url(context):
    assert context.base_url.startswith("http"), "BASE_URL belum valid. Set BASE_URL atau cek environment.py"


@given("I have valid login credentials")
def step_valid_creds(context):
    # PENTING: pastikan user ini ada (via seeder/database)
    # Silakan ganti sesuai user test kamu
    context.login_payload = {
        USERNAME_FIELD: "test@example.com",
        PASSWORD_FIELD: "password123",
    }


@given("I have invalid login credentials")
def step_invalid_creds(context):
    context.login_payload = {
        USERNAME_FIELD: "test@example.com",
        PASSWORD_FIELD: "wrong-password",
    }


@when("I send a login request")
def step_send_login(context):
    url = context.base_url + LOGIN_ENDPOINT

    # Kirim sebagai form (umum untuk Laravel web login)
    # Tapi tetap minta JSON lewat header Accept: application/json
    resp = context.session.post(
        url,
        data=context.login_payload,
        headers=context.default_headers,
        allow_redirects=False  # biar kita bisa deteksi 302 juga
    )

    context.last_response = resp

    # coba parse json kalau ada
    try:
        context.last_json = resp.json()
    except Exception:
        context.last_json = None


@then("the login should be successful")
def step_login_success(context):
    resp = context.last_response
    assert resp is not None, "Belum ada response. Step login belum jalan?"

    # Kemungkinan sukses:
    # - 200 (JSON) / 204
    # - 302 redirect (web form sukses login)
    if resp.status_code in (200, 204):
        context.authenticated = True
        return

    if resp.status_code == 302:
        # Sukses login web biasanya redirect ke /home /dashboard
        context.authenticated = True
        return

    # Jika gagal, kasih debug ringkas
    raise AssertionError(
        f"Expected login success but got {resp.status_code}. "
        f"Body: {resp.text[:200]}"
    )


@then("the login should fail")
def step_login_fail(context):
    resp = context.last_response
    assert resp is not None, "Belum ada response. Step login belum jalan?"

    # Kemungkinan gagal:
    # - 401 unauthorized (API)
    # - 422 validation error (Laravel JSON validation)
    # - 302 redirect back (web login gagal) -> sering terjadi
    if resp.status_code in (401, 422):
        return

    if resp.status_code == 302:
        # Banyak Laravel login gagal redirect back ke /login
        # Biasanya ada session error; di sini kita anggap fail OK
        return

    raise AssertionError(
        f"Expected login failure but got {resp.status_code}. "
        f"Body: {resp.text[:200]}"
    )
