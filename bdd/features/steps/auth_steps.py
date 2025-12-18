from behave import given, when, then

def _ensure_csrf(context, page="/login", force_refresh=False):
    if force_refresh:
        context.csrf_token = None  # buang token lama

    if getattr(context, "csrf_token", None):
        return context.csrf_token

    context.http_get(page)
    token = getattr(context, "csrf_token", None)
    assert token, (
        "CSRF token tidak ditemukan. Pastikan halaman punya input hidden _token "
        "atau meta csrf-token."
    )
    return token


@given('I open the login page')
def step_open_login(context):
    resp = context.http_get("/login")
    assert resp.status_code in (200, 302), f"Unexpected status: {resp.status_code}"


@when('I login with email "{email}" and password "{password}"')
def step_login(context, email, password):
    token = _ensure_csrf(context, "/login")

    payload = {
        "_token": token,
        "email": email,
        "password": password,
    }

    resp = context.http_post("/login", data=payload, allow_redirects=False)
    context.last_response = resp

    if resp.status_code == 302:
        location = resp.headers.get("Location", "")
        if "/login" not in location:
            context.authenticated = True
        else:
            context.authenticated = False
    else:
        context.authenticated = False


@then('I should be redirected to "{path}"')
def step_redirect_to(context, path):
    resp = context.last_response
    assert resp is not None, "No response captured. Did you run the login step?"

    # kalo login sukses -> redirect ke admin.dashboard atau home
    assert resp.status_code == 302, f"Expected 302 redirect, got {resp.status_code}"
    location = resp.headers.get("Location", "")

    # Location bisa absolute URL atau path, jadi cek suffix/contains
    assert path in location, f"Expected redirect to contain '{path}', got '{location}'"


@then("I should not be authenticated")
def step_not_authenticated(context):
    assert context.authenticated is False, "Expected NOT authenticated, but it seems authenticated."


@when("I logout")
def step_logout(context):
    token = _ensure_csrf(context, "/home", force_refresh=True)

    headers = {
        "X-CSRF-TOKEN": token,
        "Referer": context.base_url + "/home",
    }

    resp = context.http_post(
        "/logout",
        data={"_token": token},
        headers=headers,
        allow_redirects=False
    )

    context.last_response = resp
    assert resp.status_code == 302, f"Expected 302 redirect on logout, got {resp.status_code}"
    context.authenticated = False


@then('accessing "{protected_path}" should redirect to "{login_path}"')
def step_protected_redirect(context, protected_path, login_path):
    # akses halaman protected tanpa login, harus redirect ke /login
    resp = context.http_get(protected_path, allow_redirects=False)
    assert resp.status_code == 302, f"Expected 302, got {resp.status_code}"
    location = resp.headers.get("Location", "")
    assert login_path in location, f"Expected redirect to '{login_path}', got '{location}'"
