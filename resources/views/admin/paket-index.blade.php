<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Data Paket</title>
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
        }

        .btn-primary {
            color: #fff;
            background: linear-gradient(90deg, #1738cc, #239dff);
        }

        .header-actions {
            display: flex;
            gap: 10px;
        }

        .table-wrap {
            padding: 22px 28px 28px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }

        th, td {
            text-align: left;
            border-bottom: 1px solid var(--line);
            padding: 12px 10px;
            vertical-align: top;
            font-size: 0.9rem;
        }

        th {
            font-size: 0.82rem;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .price {
            white-space: nowrap;
            font-weight: 600;
        }

        .desc-preview {
            max-width: 320px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .itinerary-preview {
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .action-cell {
            white-space: nowrap;
        }

        .action-group {
            display: inline-flex;
            gap: 8px;
            align-items: center;
        }

        .btn-edit {
            border: 0;
            border-radius: 8px;
            padding: 8px 12px;
            font: 600 0.8rem/1 "Poppins", sans-serif;
            color: #fff;
            background: #2c61d6;
            text-decoration: none;
        }

        .btn-delete {
            border: 0;
            border-radius: 8px;
            padding: 8px 12px;
            font: 600 0.8rem/1 "Poppins", sans-serif;
            color: #fff;
            background: #d83b4a;
            cursor: pointer;
        }

        .empty {
            text-align: center;
            color: var(--muted);
            padding: 30px 12px;
        }

        .alert {
            margin: 18px 28px 0;
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 0.88rem;
            background: #ecfff1;
            color: #0d6a2f;
            border: 1px solid #afe6bf;
        }

        .alert-error {
            background: #fff1f3;
            color: #8a1423;
            border: 1px solid #f2b7be;
        }
    </style>
</head>
<body>
    <section class="panel">
        <div class="header">
            <div>
                <h1 class="title">Kelola Data Paket</h1>
                <p class="sub">Menampilkan seluruh data paket yang sudah terdaftar.</p>
            </div>
            <div class="header-actions">
                <a href="<?php echo e(route('admin.paket.create')); ?>" class="btn btn-primary">Tambah Paket</a>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn">Kembali ke Dashboard</a>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="alert"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-error"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Paket</th>
                        <th>Nama Paket</th>
                        <th>Kategori</th>
                        <th>Harga (USD)</th>
                        <th>Deskripsi</th>
                        <th>Itinerary</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $paketList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td><?php echo e($paket->id_paket); ?></td>
                            <td><?php echo e($paket->nama_paket); ?></td>
                            <td><?php echo e($paket->kategori ?? '-'); ?></td>
                            <td class="price">$<?php echo e(number_format($paket->harga, 0, '.', ',')); ?></td>
                            <td class="desc-preview"><?php echo e($paket->deskripsi); ?></td>
                            <td class="itinerary-preview"><?php echo e($paket->itinerary); ?></td>
                            <td class="action-cell">
                                <div class="action-group">
                                    <a href="<?php echo e(route('admin.paket.edit', $paket->id_paket)); ?>" class="btn-edit">Edit</a>
                                    <form method="POST" action="<?php echo e(route('admin.paket.destroy', $paket->id_paket)); ?>" class="js-delete-confirm" data-delete-item="paket ini">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn-delete">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="empty">Belum ada data paket.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
    <?php echo $__env->make('partials.whatsapp-float', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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


