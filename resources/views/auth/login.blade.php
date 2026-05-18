<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login - {{ config('app.name', 'Rinjani Great Trek') }}</title>   <link rel="icon" type="image/svg+xml" href="{{ asset('favicon-rgt.svg') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700|space-grotesk:500,700" rel="stylesheet" />
    <style>
        :root {
            --bg-main: #041da8;
            --bg-accent: #0ea5ff;
            --panel-light: #f2f5fb;
            --text-dark: #102a4a;
            --text-muted: #6f7f9a;
            --danger: #dc3545;
            --white: #fff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Poppins", sans-serif;
            color: var(--text-dark);
            background:
                radial-gradient(circle at 14% 80%, rgba(14, 165, 255, 0.5), transparent 30%),
                radial-gradient(circle at 85% 20%, rgba(39, 88, 255, 0.35), transparent 34%),
                linear-gradient(130deg, var(--bg-accent), var(--bg-main) 62%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .login-shell {
            width: min(1080px, 100%);
            background: var(--white);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 26px 60px rgba(1, 18, 95, 0.45);
            display: grid;
            grid-template-columns: 1fr 1.05fr;
            min-height: 620px;
        }

        .promo-panel {
            position: relative;
            overflow: hidden;
            color: var(--white);
            padding: 44px 42px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background:
                linear-gradient(150deg, rgba(38, 173, 255, 0.35), rgba(10, 20, 110, 0.9)),
                url('{{ asset('images/admin-login-bg.jpg') }}') center/cover no-repeat;
        }

        .promo-panel::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(160deg, rgba(0, 0, 0, 0.35), rgba(0, 0, 0, 0.68));
            pointer-events: none;
        }

        .promo-panel > * {
            position: relative;
            z-index: 1;
        }

        .brand {
            font: 700 1.15rem/1 "Space Grotesk", sans-serif;
            letter-spacing: 0.08em;
        }

        .welcome-title {
            margin: 20px 0 12px;
            font-size: clamp(2rem, 2.2vw, 2.9rem);
            line-height: 1.05;
            max-width: 280px;
            font-weight: 700;
        }

        .welcome-text {
            margin: 0;
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.86);
            max-width: 320px;
        }

        .image-pill {
            margin-top: 26px;
            display: inline-block;
            padding: 9px 22px;
            border-radius: 999px;
            color: #0f2a8f;
            background: rgba(255, 255, 255, 0.94);
            font-size: 0.84rem;
            font-weight: 600;
        }

        .form-panel {
            background: var(--panel-light);
            padding: clamp(28px, 5vw, 54px);
            display: flex;
            align-items: center;
        }

        .form-card {
            width: 100%;
            max-width: 430px;
            margin: 0 auto;
        }

        .form-card h1 {
            margin: 0 0 6px;
            font: 700 1.95rem/1.15 "Space Grotesk", sans-serif;
            color: #17335d;
        }

        .sub {
            margin: 0 0 26px;
            color: var(--text-muted);
            font-size: 0.92rem;
        }

        .field {
            margin-bottom: 16px;
        }

        .field label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 0.88rem;
            color: #2f4a73;
        }

        .field input {
            width: 100%;
            border: 1px solid #d7deea;
            background: var(--white);
            border-radius: 9px;
            padding: 12px 14px;
            font-size: 0.95rem;
            color: var(--text-dark);
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .field input:focus {
            border-color: #2e79ff;
            box-shadow: 0 0 0 4px rgba(46, 121, 255, 0.16);
        }

        .btn-login {
            width: 100%;
            border: 0;
            cursor: pointer;
            border-radius: 10px;
            padding: 13px 18px;
            color: var(--white);
            font-weight: 700;
            letter-spacing: 0.01em;
            background: linear-gradient(90deg, #0c2fc8, #1aa4ff);
            box-shadow: 0 14px 24px rgba(16, 59, 201, 0.26);
        }

        .forgot-link {
            margin-top: 12px;
            text-align: right;
        }

        .forgot-link a {
            font-size: .84rem;
            color: #214f9f;
            text-decoration: none;
            font-weight: 600;
        }

        .flash-success {
            margin: 0 0 16px;
            border: 1px solid #afe6bf;
            border-radius: 9px;
            padding: 10px 12px;
            color: #0d6a2f;
            background: #ecfff1;
            font-size: 0.86rem;
        }

        .error {
            margin-top: 7px;
            color: var(--danger);
            font-size: 0.8rem;
        }

        .flash-error {
            margin: 0 0 16px;
            border: 1px solid #f2b7be;
            border-radius: 9px;
            padding: 10px 12px;
            color: #8a1423;
            background: #fff1f3;
            font-size: 0.86rem;
        }

        @media (max-width: 920px) {
            .login-shell {
                grid-template-columns: 1fr;
                min-height: auto;
            }

            .promo-panel {
                min-height: 290px;
            }
        }
    </style>
</head>
<body>
    <section class="login-shell">
        <div class="promo-panel">
            <div>
                <div class="brand">RINJANI GREAT TREK</div>
                <h2 class="welcome-title">Hello,<br>Welcome Back!</h2>
                <p class="welcome-text">
                    Masuk ke dashboard admin untuk mengelola paket, berita, dan galeri pendakian Rinjani.
                </p>
            </div>
            <div>
                <span class="image-pill">Mount Rinjani Edition</span>
            </div>
        </div>

        <div class="form-panel">
            <div class="form-card">
                <h1>Login Admin</h1>
                <p class="sub">Silakan login menggunakan akun admin Anda.</p>

                <form method="POST" action="{{ route('admin.login.submit') }}">
                    @csrf

                    @if (session('error'))
                        <div class="flash-error">{{ session('error') }}</div>
                    @endif

                    @if (session('success'))
                        <div class="flash-success">{{ session('success') }}</div>
                    @endif

                    <div class="field">
                        <label for="username">Username</label>
                        <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus autocomplete="username" class="@error('username') is-invalid @enderror">
                        @error('username')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password" class="@error('password') is-invalid @enderror">
                        @error('password')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn-login">Login</button>
                </form>
                <div class="forgot-link">
                    <a href="{{ route('admin.password.request') }}">Lupa password?</a>
                </div>
            </div>
        </div>
    </section>
    @include('partials.whatsapp-float')
</body>
</html>



