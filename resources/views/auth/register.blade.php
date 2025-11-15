<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>PharmaPlus - Sign Up</title>
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
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
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

        /* LEFT HERO */
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
            color: var(--primary);
        }

        .hero-tag {
            font-size: 0.8rem;
            text-transform: uppercase;
            font-weight: 600;
            color: var(--accent);
            letter-spacing: 0.15em;
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
        }

        /* RIGHT AUTH FORM */
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
            max-width: 400px;
        }

        .auth-header {
            margin-bottom: 1.75rem;
        }



        .auth-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.35rem;
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

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.75rem 0.9rem;
            padding-right: 2.4rem;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            background: #f9fafb;
            outline: none;
            font-size: 0.9rem;
            transition:
                border-color 0.15s ease,
                box-shadow 0.15s ease,
                background 0.15s ease;
        }

        input:focus {
            border-color: var(--primary);
            background: #ffffff;
            box-shadow: 0 0 0 1px rgba(16, 83, 212, 0.15);
        }

        .input-wrapper {
            position: relative;
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
        }

        .btn-secondary {
            margin-top: 0.75rem;
            width: 100%;
            padding: 0.7rem 1rem;
            border-radius: 999px;
            border: 1px solid rgba(16, 83, 212, 0.25);
            background: #f3f5ff;
            color: var(--primary);
            font-size: 0.9rem;
            cursor: pointer;
        }

        .auth-footer {
            margin-top: 1rem;
            font-size: 0.82rem;
            text-align: center;
            color: var(--text-muted);
        }

        .auth-footer a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
        }

        /* Mobile */
        @media (max-width: 640px) {
            .hero { display: none; }
            .page { margin: 0; border-radius: 0; }
            .auth { padding: 2rem 1.25rem; }
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
                <div class="hero-tag">PharmaPlus STORE</div>
                <h1 class="hero-title">Join PharmaPlus Today.</h1>
                <p class="hero-subtitle">
                    Create your account and enjoy secure access to health products,
                    personalized wellness services, and exclusive offers.
                </p>
            </div>
        </div>
    </section>

    <!-- RIGHT SIGN UP FORM -->
    <section class="auth">
        <div class="auth-card">

            <div class="auth-header">

                <h2 class="auth-title">Get Started</h2>
                <p class="auth-subtitle">Register your PharmaPlus account.</p>
        </div>

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

{{-- FORM --}}
<form method="POST" action="{{ route('register.post') }}">
    @csrf

    <div class="field">
        <label>Full Name</label>
        <input type="text" name="name" value="{{ old('name') }}" placeholder="Full Name" required>
    </div>

    <div class="field">
        <label>Email Address</label>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
    </div>

    <div class="field">
        <label>Password</label>
        <div class="input-wrapper">
            <input type="password" id="password" name="password" placeholder="Create a password" required>
            <button type="button" class="toggle-password" onclick="
                const p = document.getElementById('password');
                p.type = p.type === 'password' ? 'text' : 'password';
                this.textContent = p.type === 'password' ? 'Show' : 'Hide';
            ">Show</button>
            
            @error('password')
                <span style="font-size:0.8rem; color:#D64779;">{{ $message }}</span>
            @enderror

        </div>
    </div>

    <div class="field">
        <label>Confirm Password</label>
        <div class="input-wrapper">
            <input type="password" id="confirm" name="password_confirmation" placeholder="Confirm password" required>
            <button type="button" class="toggle-password" onclick="
                const c = document.getElementById('confirm');
                c.type = c.type === 'password' ? 'text' : 'password';
                this.textContent = c.type === 'password' ? 'Show' : 'Hide';
            ">Show</button>
        </div>
    </div>

    <button type="submit" class="btn-primary">Create Account</button>

    <button type="button" class="btn-secondary" onclick="window.location.href='{{ route('login') }}'">
        Already have an account? Login
    </button>
</form>

        </div>
    </section>

</div>

</body>
</html>
