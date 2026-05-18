<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title><link rel="icon" type="image/svg+xml" href="{{ asset('favicon-rgt.svg') }}">
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

        .dashboard {
            width: min(1080px, 100%);
            margin: 0 auto;
            background: var(--panel);
            border-radius: 16px;
            box-shadow: 0 24px 50px rgba(1, 18, 95, 0.35);
            overflow: hidden;
        }

        .header {
            padding: 24px 30px;
            border-bottom: 1px solid var(--line);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .title {
            margin: 0;
            font: 700 1.55rem/1.2 "Space Grotesk", sans-serif;
        }

        .subtitle {
            margin: 6px 0 0;
            color: var(--muted);
            font-size: 0.92rem;
        }

        .user {
            color: var(--muted);
            font-size: 0.9rem;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logout-btn {
            border: 0;
            border-radius: 10px;
            padding: 10px 16px;
            font: 600 0.9rem/1 "Poppins", sans-serif;
            color: #fff;
            background: linear-gradient(90deg, #1738cc, #239dff);
            cursor: pointer;
        }

        .menus {
            padding: 28px;
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 16px;
        }

        .menu-card {
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 20px;
            background: #f8fbff;
            text-decoration: none;
            color: inherit;
        }

        .menu-card h3 {
            margin: 0 0 8px;
            font-size: 1.05rem;
        }

        .menu-card p {
            margin: 0;
            color: var(--muted);
            font-size: 0.9rem;
            line-height: 1.5;
        }

        @media (max-width: 900px) {
            .menus { grid-template-columns: 1fr; }
            .header { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>
    <section class="dashboard">
        <div class="header">
            <div>
                <h1 class="title">Admin Dashboard</h1>
                <p class="subtitle">Pilih menu pengelolaan data admin.</p>
            </div>
            <div class="header-actions">
                <div class="user">
                    Login sebagai: <strong>{{ session('admin_user.username', 'Admin') }}</strong>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>

        <div class="menus">
            <a href="{{ route('admin.paket.index') }}" class="menu-card">
                <h3>Kelola Data Paket</h3>
                <p>Tambah, edit, dan hapus data paket pendakian.</p>
            </a>
            <a href="{{ route('admin.kategori.index') }}" class="menu-card">
                <h3>Kelola Kategori</h3>
                <p>Tambah, edit, dan hapus kategori untuk paket pendakian.</p>
            </a>
            <a href="{{ route('admin.artikel.index') }}" class="menu-card">
                <h3>Kelola Data Berita</h3>
                <p>Kelola konten berita informasi dan update terbaru.</p>
            </a>
            <a href="{{ route('admin.account.edit') }}" class="menu-card">
                <h3>Kelola Data Akun</h3>
                <p>Atur akun admin dan manajemen akses pengguna.</p>
            </a>
            <a href="{{ route('admin.gallery.index') }}" class="menu-card">
                <h3>Kelola Data Gallery</h3>
                <p>Tambahkan foto baru atau hapus foto pada fitur gallery.</p>
            </a>
        </div>
    </section>
    @include('partials.whatsapp-float')
</body>
</html>


