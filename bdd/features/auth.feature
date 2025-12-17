# bdd/features/environment.py
import os
import requests

def before_all(context):
    # Ambil BASE_URL dari env, kalau tidak ada pakai default
    # Jalankan Laravel: php artisan serve -> biasanya http://127.0.0.1:8000
    context.base_url = os.getenv("BASE_URL", "http://127.0.0.1:8000").rstrip("/")
    context.session = requests.Session()

    # Headers default untuk “minta JSON” (Laravel biasanya balikin 422 kalau invalid)
    context.default_headers = {
        "Accept": "application/json",
    }

def before_scenario(context, scenario):
    context.last_response = None
    context.last_json = None
    context.authenticated = False

def after_all(context):
    context.session.close()
