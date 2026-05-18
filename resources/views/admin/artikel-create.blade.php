<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Data Berita</title><link rel="icon" type="image/svg+xml" href="{{ asset('favicon-rgt.svg') }}">
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
            width: min(860px, 100%);
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
            margin: 7px 0 0;
            color: var(--muted);
            font-size: 0.92rem;
        }
        .content {
            padding: 24px 28px 28px;
        }
        .field { margin-bottom: 16px; }
        .field label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.9rem;
            font-weight: 600;
        }
        .field input, .field textarea {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 0.95rem;
            font-family: inherit;
            outline: none;
        }
        .field textarea {
            min-height: 140px;
            resize: vertical;
        }
        .error {
            margin-top: 7px;
            color: var(--err-text);
            font-size: 0.8rem;
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
            text-decoration: none;
            cursor: pointer;
        }
        .btn-primary {
            color: #fff;
            background: linear-gradient(90deg, #1738cc, #239dff);
        }
        .btn-light {
            color: var(--text);
            background: #eff4fb;
        }
    </style>
</head>
<body>
    <section class="panel">
        <div class="header">
            <h1 class="title">Tambah Data Berita</h1>
            <p class="sub">Isi form berikut untuk menambahkan berita baru.</p>
        </div>
        <div class="content">
            <form method="POST" action="{{ route('admin.artikel.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="field">
                    <label for="judul_artikel">Judul Berita</label>
                    <input id="judul_artikel" type="text" name="judul_artikel" value="{{ old('judul_artikel') }}" required>
                    @error('judul_artikel')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="judul_artikel_en">News Title (English)</label>
                    <input id="judul_artikel_en" type="text" name="judul_artikel_en" value="{{ old('judul_artikel_en') }}">
                    @error('judul_artikel_en')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" required>{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="deskripsi_en">Description (English)</label>
                    <textarea id="deskripsi_en" name="deskripsi_en">{{ old('deskripsi_en') }}</textarea>
                    @error('deskripsi_en')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="gambar">Upload Gambar</label>
                    <input id="gambar" type="file" name="gambar" accept="image/*" required>
                    @error('gambar')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="actions">
                    <button type="submit" class="btn btn-primary">Simpan Berita</button>
                    <a href="{{ route('admin.artikel.index') }}" class="btn btn-light">Kembali</a>
                </div>
            </form>
        </div>
    </section>
    @include('partials.whatsapp-float')
</body>
</html>



