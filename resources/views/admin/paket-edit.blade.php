<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Data Paket</title>
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

        .field input,
        .field select,
        .field textarea {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 0.95rem;
            font-family: inherit;
            outline: none;
        }

        .field textarea {
            min-height: 120px;
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
            <h1 class="title">Edit Data Paket</h1>
            <p class="sub">Perbarui data paket sesuai kebutuhan.</p>
        </div>

        <div class="content">
            <form method="POST" action="<?php echo e(route('admin.paket.update', $paket->id_paket)); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="field">
                    <label for="nama_paket">Nama Paket</label>
                    <input id="nama_paket" type="text" name="nama_paket" value="<?php echo e(old('nama_paket', $paket->nama_paket)); ?>" required>
                    <?php $__errorArgs = ['nama_paket'];
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

                <div class="field">
                    <label for="nama_paket_en">Package Name (English)</label>
                    <input id="nama_paket_en" type="text" name="nama_paket_en" value="<?php echo e(old('nama_paket_en', $paket->nama_paket_en)); ?>">
                    <?php $__errorArgs = ['nama_paket_en'];
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

                <div class="field">
                    <label for="kategori">Kategori</label>
                    <select id="kategori" name="kategori_id" required>
                        <option value="">Pilih kategori</option>
                        <?php $__currentLoopData = $kategoriList ?? collect(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kategori): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($kategori->id); ?>" <?php echo e((string) old('kategori_id', $paket->kategori_id) === (string) $kategori->id ? 'selected' : ''); ?>>
                                <?php echo e($kategori->nama_kategori); ?>
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['kategori_id'];
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

                <div class="field">
                    <label for="harga">Harga (USD)</label>
                    <input id="harga" type="text" name="harga" value="<?php echo e(old('harga', $paket->harga)); ?>" inputmode="numeric" autocomplete="off" placeholder="example: 1,500" required>
                    <?php $__errorArgs = ['harga'];
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

                <div class="field">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" required><?php echo e(old('deskripsi', $paket->deskripsi)); ?></textarea>
                    <?php $__errorArgs = ['deskripsi'];
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

                <div class="field">
                    <label for="deskripsi_en">Description (English)</label>
                    <textarea id="deskripsi_en" name="deskripsi_en"><?php echo e(old('deskripsi_en', $paket->deskripsi_en)); ?></textarea>
                    <?php $__errorArgs = ['deskripsi_en'];
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

                <div class="field">
                    <label for="itinerary">Itinerary</label>
                    <textarea id="itinerary" name="itinerary" required><?php echo e(old('itinerary', $paket->itinerary)); ?></textarea>
                    <?php $__errorArgs = ['itinerary'];
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

                <div class="field">
                    <label for="itinerary_en">Itinerary (English)</label>
                    <textarea id="itinerary_en" name="itinerary_en"><?php echo e(old('itinerary_en', $paket->itinerary_en)); ?></textarea>
                    <?php $__errorArgs = ['itinerary_en'];
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

                <div class="actions">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="<?php echo e(route('admin.paket.index')); ?>" class="btn btn-light">Kembali</a>
                </div>
            </form>
        </div>
    </section>
    <?php echo $__env->make('partials.whatsapp-float', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <script>
        (function () {
            const hargaInput = document.getElementById('harga');
            const form = hargaInput ? hargaInput.closest('form') : null;

            if (!hargaInput || !form) {
                return;
            }

            const formatUsd = function (value) {
                const digits = String(value || '').replace(/\D/g, '');
                if (!digits) {
                    return '';
                }
                return new Intl.NumberFormat('en-US').format(Number(digits));
            };

            hargaInput.value = formatUsd(hargaInput.value);

            hargaInput.addEventListener('input', function () {
                hargaInput.value = formatUsd(hargaInput.value);
            });

            form.addEventListener('submit', function () {
                hargaInput.value = String(hargaInput.value || '').replace(/\D/g, '');
            });
        })();
    </script>
</body>
</html>


