<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>PharmaPlus - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        :root {
            --light-blue: #DEE9FF;
            --primary: #1053D4;
            --accent: #D64779;
            --text-dark: #111827;
            --text-muted: #6b7280;
            --white: #ffffff;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI",
                sans-serif;
            background: radial-gradient(circle at top left, #f4f7ff, var(--light-blue));
            color: var(--text-dark);
            display: flex;
            align-items: stretch;
            justify-content: center;
        }

        .page {
            width: 100%;
            max-width: 1200px;
            margin: 1.5rem;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.12);
            display: flex;
            overflow: hidden;
        }

        /* Left hero side */
        .hero {
            flex: 1.1;
            padding: 2.5rem 2.75rem;
            background: linear-gradient(135deg, #e1ebff, var(--light-blue));
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
        }

        .hero::before {
            content: "";
            position: absolute;
            inset: 18% -20%;
            background: radial-gradient(circle, #bcd1ff 0, transparent 55%);
            opacity: 0.65;
            pointer-events: none;
        }

        .hero-inner {
            position: relative;
            z-index: 1;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            margin-bottom: 2rem;
        }

        .logo-badge {
            width: 38px;
            height: 38px;
            border-radius: 999px;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-weight: 700;
            font-size: 1.05rem;
            box-shadow: 0 8px 18px rgba(16, 83, 212, 0.45);
        }

        .logo-text {
            font-weight: 700;
            font-size: 1.15rem;
            letter-spacing: 0.02em;
            color: var(--primary);
        }

        .hero-tag {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.16em;
            font-weight: 600;
            color: var(--accent);
            margin-bottom: 0.75rem;
        }

        .hero-title {
            font-size: clamp(1.8rem, 3vw, 2.3rem);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 0.75rem;
        }

        .hero-subtitle {
            font-size: 0.98rem;
            color: var(--text-muted);
            max-width: 360px;
            margin-bottom: 1.75rem;
        }

        .hero-badges {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .avatars {
            display: flex;
        }

        .avatar {
            width: 34px;
            height: 34px;
            border-radius: 999px;
            background: var(--primary);
            border: 2px solid #f3f4ff;
            margin-left: -8px;
            box-shadow: 0 8px 18px rgba(148, 163, 255, 0.7);
        }

        .avatar:nth-child(1) { background: #a5b4fc; margin-left: 0; }
        .avatar:nth-child(2) { background: #60a5fa; }
        .avatar:nth-child(3) { background: #34d399; }

        .badge-text-main {
            font-weight: 700;
            font-size: 1.05rem;
        }

        .badge-text-sub {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .hero-footer {
            position: relative;
            z-index: 1;
            margin-top: 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.25rem;
            flex-wrap: wrap;
            font-size: 0.78rem;
            color: var(--text-muted);
        }

        .hero-pills {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .pill {
            border-radius: 999px;
            padding: 0.45rem 0.9rem;
            background: rgba(255, 255, 255, 0.85);
            font-size: 0.78rem;
            font-weight: 500;
            color: #1f2937;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            box-shadow: 0 7px 18px rgba(148, 163, 255, 0.35);
        }

        .pill-dot {
            width: 7px;
            height: 7px;
            border-radius: 999px;
            background: var(--primary);
        }

        /* Right login card */
        .auth {
            flex: 0.95;
            padding: 2.5rem 2.75rem;
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-card {
            width: 100%;
            max-width: 380px;
        }

        .auth-header {
            margin-bottom: 1.75rem;
        }



        .auth-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.3rem;
        }

        .auth-subtitle {
            font-size: 0.92rem;
            color: var(--text-muted);
        }

        form {
            display: grid;
            gap: 1rem;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }

        label {
            font-size: 0.88rem;
            font-weight: 500;
            color: #374151;
        }

        .input-wrapper {
            position: relative;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            padding: 0.75rem 0.9rem;
            padding-right: 2.4rem;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            font-size: 0.9rem;
            outline: none;
            background: #f9fafb;
            transition:
                border-color 0.15s ease,
                box-shadow 0.15s ease,
                background 0.15s ease;
        }

        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="text"]:focus {
            border-color: var(--primary);
            background: #ffffff;
            box-shadow: 0 0 0 1px rgba(16, 83, 212, 0.15);
        }


        .toggle-password {
            position: absolute;
            right: 0.7rem;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: none;
            cursor: pointer;
            font-size: 0.78rem;
            color: var(--primary);
            font-weight: 600;
        }

        .field-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.25rem;
        }

        .remember {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.8rem;
            color: #4b5563;
        }

        .remember input {
            width: 14px;
            height: 14px;
        }

        .forgot {
            font-size: 0.8rem;
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .forgot:hover {
            text-decoration: underline;
        }

        .btn-primary {
            width: 100%;
            border: none;
            border-radius: 999px;
            padding: 0.75rem 1rem;
            margin-top: 0.35rem;
            background: linear-gradient(135deg, var(--primary), #1c64f2);
            color: var(--white);
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            box-shadow: 0 14px 30px rgba(16, 83, 212, 0.35);
            transition:
                transform 0.12s ease,
                box-shadow 0.12s ease,
                filter 0.12s ease;
        }

        .btn-primary:hover {
            filter: brightness(1.05);
            transform: translateY(-1px);
            box-shadow: 0 18px 40px rgba(16, 83, 212, 0.4);
        }

        .btn-secondary {
            width: 100%;
            margin-top: 0.75rem;
            border-radius: 999px;
            padding: 0.7rem 1rem;
            border: 1px solid rgba(16, 83, 212, 0.25);
            background: #f3f5ff;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            color: var(--primary);
        }

        .auth-footer {
            margin-top: 1.1rem;
            font-size: 0.82rem;
            color: var(--text-muted);
            text-align: center;
        }

        .auth-footer a {
            color: var(--accent);
            font-weight: 600;
            text-decoration: none;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }



        /* Responsive */
        @media (max-width: 900px) {
            .page {
                flex-direction: column;
                margin: 1rem;
                border-radius: 20px;
            }

            .hero {
                padding: 1.75rem 1.75rem 1.5rem;
            }

            .auth {
                padding: 1.75rem;
            }

            .hero-footer {
                margin-top: 1.25rem;
            }
        }

        @media (max-width: 640px) {
            body {
                background: var(--light-blue);
            }

            .page {
                margin: 0;
                min-height: 100vh;
                border-radius: 0;
                box-shadow: none;
            }

            .hero {
                display: none; /* kalau mau tetap tampil di mobile, hapus baris ini */
            }

            .auth {
                flex: 1;
                padding: 2.25rem 1.5rem 2.5rem;
            }

            .auth-card {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
<div class="page">


    <!-- LEFT HERO -->
    <section class="hero">
        <div class="hero-inner">
            <div class="logo">
                <div class="logo-badge">P</div>
                <div class="logo-text">PharmaPlus</div>
            </div>

            <div>
                <div class="hero-tag">PharmaPlus Store</div>
                <h1 class="hero-title">Your Health, Our Priority.</h1>
                <p class="hero-subtitle">
                    Discover secure and seamless access to your PharmaPlus account.
                    Track orders, manage prescriptions, and personalize your wellness
                    journey in one place.
                </p>

                <div class="hero-badges">
                    <div class="avatars">
                        <div class="avatar"></div>
                        <div class="avatar"></div>
                        <div class="avatar"></div>
                    </div>
                    <div>
                        <div class="badge-text-main">100k+ Satisfied Customers</div>
                        <div class="badge-text-sub">Trusted healthcare experience worldwide</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="hero-footer">
            <div>💊 24/7 Online Pharmacy Support</div>
            <div class="hero-pills">
                <div class="pill">
                    <span class="pill-dot"></span>
                    Fast, secure checkout
                </div>
                <div class="pill">
                    <span class="pill-dot" style="background: var(--accent);"></span>
                    Certified pharmacists
                </div>
            </div>
        </div>
    </section>

    <!-- RIGHT LOGIN -->
    <section class="auth">
        <div class="auth-card">
            <div class="auth-header">

                <h2 class="auth-title">Welcome Back 👋</h2>
                <p class="auth-subtitle">
                    Login to continue your healthy journey with PharmaPlus.
                </p>
        </div>
    {{-- error handling --}}
    @if ($errors->any())
        <div style="
            margin-bottom: 1rem;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            background: #FEF2F2;
            color: #B91C1C;
            font-size: 0.85rem;">
            {{ $errors->first() }}
        </div>
    @endif




    <!-- FORM -->
    <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <!-- EMAIL -->
            <div class="field">
                <label for="email">Email address</label>
                <div class="input-wrapper">
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="you@example.com"
                        required
                    />
                    @error('email')
                        <span style="color:#D64779; font-size:0.8rem;">{{ $message }}</span>
                    @enderror

                </div>
            </div>

            <!-- PASSWORD -->
            <div class="field">
                <div class="field-row">
                    <label for="password">Password</label>
                    <a href="#" class="forgot">Forgot password?</a>
                </div>
                <div class="input-wrapper">
                    <input
                        id="password"
                        type="password"
                        name="password"
                        placeholder="Enter your password"
                        required
                    />
                    <button type="button" class="toggle-password" onclick="
                        const input = document.getElementById('password');
                        input.type = input.type === 'password' ? 'text' : 'password';
                        this.textContent = input.type === 'password' ? 'Show' : 'Hide';
                    ">
                        Show
                    </button>
                    @error('password')
                        <span style="color:#D64779; font-size:0.8rem;">{{ $message }}</span>
                    @enderror

                </div>
            </div>

            <!-- REMEMBER ME -->
            <div class="field-row">
                <label class="remember">
                    <input type="checkbox" name="remember" />
                    <span>Remember me</span>
                </label>
            </div>

            <button type="submit" class="btn-primary">
                Login
            </button>

            <div class="auth-footer">
                New here? <a href="{{ route('register') }}">Sign up now</a>
            </div>
        </form>

                </div>
    </section>
    </div>
</body>
</html>
