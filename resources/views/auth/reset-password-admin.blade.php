<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password Admin - {{ config('app.name', 'Rinjani Great Trek') }}</title>`r`n    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon-rgt.svg') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700|space-grotesk:500,700" rel="stylesheet" />
    <style>
        :root {
            --bg-main: #041da8;
            --bg-accent: #0ea5ff;
            --panel: #f2f5fb;
            --text: #102a4a;
            --muted: #6f7f9a;
            --danger: #8a1423;
            --danger-bg: #fff1f3;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Poppins", sans-serif;
            background:
                radial-gradient(circle at 14% 80%, rgba(14, 165, 255, 0.5), transparent 30%),
                radial-gradient(circle at 85% 20%, rgba(39, 88, 255, 0.35), transparent 34%),
                linear-gradient(130deg, var(--bg-accent), var(--bg-main) 62%);
            display: grid;
            place-items: center;
            padding: 24px;
        }

        .card {
            width: min(460px, 100%);
            background: var(--panel);
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 24px 50px rgba(1, 18, 95, 0.35);
        }

        h1 {
            margin: 0 0 8px;
            font: 700 1.5rem/1.2 "Space Grotesk", sans-serif;
            color: var(--text);
        }

        p {
            margin: 0 0 16px;
            color: var(--muted);
            font-size: .9rem;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #2f4a73;
            font-size: .88rem;
            font-weight: 600;
        }

        input {
            width: 100%;
            border: 1px solid #d7deea;
            border-radius: 9px;
            padding: 12px 14px;
            font-size: .95rem;
            margin-bottom: 12px;
        }

        button {
            width: 100%;
            border: 0;
            border-radius: 10px;
            padding: 12px 14px;
            color: #fff;
            font-weight: 700;
            background: linear-gradient(90deg, #0c2fc8, #1aa4ff);
            cursor: pointer;
        }

        .error-box {
            margin-bottom: 12px;
            border: 1px solid #f2b7be;
            border-radius: 9px;
            padding: 10px 12px;
            color: var(--danger);
            background: var(--danger-bg);
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
    <section class="card">
        <h1>Reset Password</h1>
        <p>Atur password admin baru untuk username <strong>{{ $username }}</strong>.</p>

        @if (session('error'))
            <div class="error-box">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.password.update') }}">
            @csrf
            <input type="hidden" name="username" value="{{ $username }}">
            <input type="hidden" name="token" value="{{ $token }}">

            <label for="password">Password Baru</label>
            <input id="password" type="password" name="password" required>
            @error('password')
                <div class="error-box">{{ $message }}</div>
            @enderror

            <label for="password_confirmation">Konfirmasi Password Baru</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required>

            <button type="submit">Reset Password</button>
        </form>
    </section>
</body>
</html>

