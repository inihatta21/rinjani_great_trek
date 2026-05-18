<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Akun</title><link rel="icon" type="image/svg+xml" href="{{ asset('favicon-rgt.svg') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700|space-grotesk:500,700" rel="stylesheet" />
    <style>
        :root {
            --bg-1: #051997;
            --bg-2: #0ea5ff;
            --panel: #ffffff;
            --text: #102a4a;
            --muted: #5e7394;
            --line: #d7e1ef;
            --ok-bg: #ecfff1;
            --ok-text: #0d6a2f;
            --err-bg: #fff1f3;
            --err-text: #8a1423;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Poppins", sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at 12% 80%, rgba(14, 165, 255, 0.45), transparent 30%),
                radial-gradient(circle at 88% 16%, rgba(39, 88, 255, 0.28), transparent 34%),
                linear-gradient(130deg, var(--bg-2), var(--bg-1) 62%);
            padding: 28px;
        }

        .panel {
            width: min(760px, 100%);
            margin: 0 auto;
            background: var(--panel);
            border-radius: 16px;
            box-shadow: 0 24px 50px rgba(1, 18, 95, 0.35);
            overflow: hidden;
        }

        .header {
            padding: 24px 28px;
            border-bottom: 1px solid var(--line);
        }

        .title {
            margin: 0;
            font: 700 1.45rem/1.2 "Space Grotesk", sans-serif;
        }

        .sub {
            margin: 8px 0 0;
            color: var(--muted);
            font-size: 0.92rem;
        }

        .content {
            padding: 24px 28px 28px;
        }

        .field {
            margin-bottom: 16px;
        }

        .field label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .field-hint {
            display: block;
            margin: -2px 0 8px;
            color: var(--muted);
            font-size: 0.78rem;
        }

        .field input {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 0.95rem;
            outline: none;
        }

        .actions {
            margin-top: 8px;
            display: flex;
            gap: 10px;
        }

        .btn {
            border: 0;
            border-radius: 10px;
            padding: 11px 16px;
            font: 600 0.9rem/1 "Poppins", sans-serif;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary {
            color: #fff;
            background: linear-gradient(90deg, #1738cc, #239dff);
        }

        .btn-light {
            color: var(--text);
            background: #eff4fb;
        }

        .alert {
            margin-bottom: 16px;
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 0.88rem;
        }

        .alert-success {
            background: var(--ok-bg);
            color: var(--ok-text);
            border: 1px solid #afe6bf;
        }

        .alert-error {
            background: var(--err-bg);
            color: var(--err-text);
            border: 1px solid #f2b7be;
        }

        .error {
            margin-top: 7px;
            color: var(--err-text);
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <section class="panel">
        <div class="header">
            <h1 class="title">Kelola Data Akun</h1>
            <p class="sub">Edit username, password, dan nomor WhatsApp akun admin.</p>
        </div>
        <div class="content">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">Periksa kembali data input Anda.</div>
            @endif

            <form method="POST" action="{{ route('admin.account.update') }}">
                @csrf

                <div class="field">
                    <label for="username">Username</label>
                    <input id="username" type="text" name="username" value="{{ old('username', $adminUser->username) }}" required>
                    @error('username')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="password">Password Baru</label>
                    <small class="field-hint">Kosongkan jika tidak ingin mengganti password.</small>
                    <input id="password" type="password" name="password">
                    @error('password')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="no_wa">No. WhatsApp</label>
                    <small class="field-hint">Contoh penulisan: 6281234567890 (gunakan kode negara, tanpa +, spasi, atau tanda -)</small>
                    <input id="no_wa" type="text" name="no_wa" value="{{ old('no_wa', $adminUser->no_wa) }}" placeholder="Contoh: 6281234567890">
                    @error('no_wa')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="actions">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-light">Kembali ke Dashboard</a>
                </div>
            </form>
        </div>
    </section>
    @include('partials.whatsapp-float')
</body>
</html>



