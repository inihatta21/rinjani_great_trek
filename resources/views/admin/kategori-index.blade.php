<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Kategori Paket</title>
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
            width: min(980px, 100%);
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
            gap: 10px;
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

        .content {
            padding: 22px 28px 28px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 10px;
            align-items: start;
        }

        .field input {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 0.95rem;
            font-family: inherit;
            outline: none;
        }

        .error {
            margin-top: 7px;
            color: var(--err-text);
            font-size: 0.8rem;
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

        .alert-error {
            background: #fff1f3;
            color: #8a1423;
            border: 1px solid #f2b7be;
        }

        .table-wrap {
            margin-top: 18px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            text-align: left;
            border-bottom: 1px solid var(--line);
            padding: 12px 10px;
            font-size: 0.9rem;
        }

        th {
            font-size: 0.82rem;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .actions {
            white-space: nowrap;
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
            padding: 24px 12px;
        }

        @media (max-width: 720px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <section class="panel">
        <div class="header">
            <div>
                <h1 class="title">Kelola Kategori Paket</h1>
                <p class="sub">Kelola daftar kategori yang dipakai pada paket.</p>
            </div>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn">Kembali ke Dashboard</a>
        </div>

        <div class="content">
            <?php if(session('success')): ?>
                <div class="alert"><?php echo e(session('success')); ?></div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-error"><?php echo e(session('error')); ?></div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('admin.kategori.store')); ?>" class="form-grid">
                <?php echo csrf_field(); ?>
                <div class="field">
                    <input
                        id="nama_kategori"
                        type="text"
                        name="nama_kategori"
                        value="<?php echo e(old('nama_kategori')); ?>"
                        placeholder="Nama kategori baru"
                        required
                    >
                    <?php $__errorArgs = ['nama_kategori'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <button type="submit" class="btn">Tambah Kategori</button>
            </form>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Kategori</th>
                            <th>Jumlah Paket</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $kategoriList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kategori): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($kategori->id); ?></td>
                                <td><?php echo e($kategori->nama_kategori); ?></td>
                                <td><?php echo e($kategori->paket_list_count ?? 0); ?></td>
                                <td>
                                    <div class="actions">
                                        <a href="<?php echo e(route('admin.kategori.edit', $kategori->id)); ?>" class="btn-edit">Edit</a>
                                        <form method="POST" action="<?php echo e(route('admin.kategori.destroy', $kategori->id)); ?>" class="js-delete-confirm" data-delete-item="kategori ini">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn-delete">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="empty">Belum ada kategori.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
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
