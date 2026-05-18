<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Data Gallery</title><link rel="icon" type="image/svg+xml" href="{{ asset('favicon-rgt.svg') }}">
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
            --err: #8a1423;
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
            width: min(1200px, 100%);
            margin: 0 auto;
            background: var(--panel);
            border-radius: 16px;
            box-shadow: 0 24px 50px rgba(1, 18, 95, 0.35);
            overflow: hidden;
        }
        .header {
            padding: 24px 28px;
            border-bottom: 1px solid var(--line);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
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
        .btn {
            border: 0;
            border-radius: 10px;
            padding: 11px 15px;
            font: 600 0.88rem/1 "Poppins", sans-serif;
            text-decoration: none;
            color: var(--text);
            background: #eff4fb;
            cursor: pointer;
        }
        .btn-primary {
            color: #fff;
            background: linear-gradient(90deg, #1738cc, #239dff);
        }
        .content {
            padding: 22px 28px 28px;
        }
        .upload-box {
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 20px;
            background: #f8fbff;
        }
        .upload-box label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 0.9rem;
        }
        .upload-box input[type="file"] {
            width: 100%;
            border: 1px solid var(--line);
            background: #fff;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 10px;
        }
        .error {
            margin-top: 8px;
            color: var(--err);
            font-size: 0.82rem;
        }
        .alert {
            margin-bottom: 14px;
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 0.88rem;
            background: #ecfff1;
            color: #0d6a2f;
            border: 1px solid #afe6bf;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
        }
        .card {
            border: 1px solid var(--line);
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
        }
        .card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            display: block;
        }
        .meta {
            padding: 10px;
        }
        .name {
            margin: 0 0 8px;
            font-size: 0.82rem;
            color: var(--muted);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .btn-delete {
            width: 100%;
            border: 0;
            border-radius: 8px;
            padding: 8px 10px;
            font: 600 0.8rem/1 "Poppins", sans-serif;
            color: #fff;
            background: #d83b4a;
            cursor: pointer;
        }
        .empty {
            color: var(--muted);
            font-size: 0.92rem;
            text-align: center;
            padding: 28px 0 10px;
        }
        @media (max-width: 1000px) {
            .grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        }
        @media (max-width: 760px) {
            .grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
    </style>
</head>
<body>
    <section class="panel">
        <div class="header">
            <div>
                <h1 class="title">Kelola Data Gallery</h1>
                <p class="sub">Tambah dan hapus foto gallery.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn">Kembali ke Dashboard</a>
        </div>

        <div class="content">
            @if (session('success'))
                <div class="alert">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data" class="upload-box">
                @csrf
                <label for="foto">Upload Foto (hanya gambar)</label>
                <input id="foto" type="file" name="foto" accept="image/*" required>
                <button type="submit" class="btn btn-primary">Tambah Foto</button>
                @error('foto')
                    <div class="error">{{ $message }}</div>
                @enderror
            </form>

            @if ($galleryList->isEmpty())
                <div class="empty">Belum ada foto gallery.</div>
            @else
                <div class="grid">
                    @foreach ($galleryList as $foto)
                        <div class="card">
                            <img src="{{ $foto->image_url }}" alt="Foto gallery">
                            <div class="meta">
                                <p class="name">{{ $foto->nama_foto }}</p>
                                <form method="POST" action="{{ route('admin.gallery.destroy', $foto->id_foto) }}" class="js-delete-confirm" data-delete-item="foto ini">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">Hapus</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
    @include('partials.whatsapp-float')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.js-delete-confirm').forEach(function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                const item = form.dataset.deleteItem || 'data ini';

                Swal.fire({
                    title: 'Hapus Data?',
                    text: 'Apakah Anda yakin ingin menghapus ' + item + '?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#d83b4a',
                    cancelButtonColor: '#6b7280'
                }).then(function (result) {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
</body>
</html>

