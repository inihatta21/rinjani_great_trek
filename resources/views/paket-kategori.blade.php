<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e($kategori->nama_kategori); ?> | Rinjani Great Trek</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #eef3fb;
            --surface: #ffffff;
            --ink: #111827;
            --muted: #58677f;
            --line: #d6e1f2;
            --primary: #2a67d1;
            --primary-2: #1d4ea7;
        }

        * { box-sizing: border-box; }
        html, body { margin: 0; padding: 0; }

        body {
            font-family: 'Manrope', sans-serif;
            color: var(--ink);
            background: var(--surface);
            line-height: 1.6;
        }

        .page-shell { width: 100%; margin: 0; background: var(--surface); }

        .top-nav {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            gap: 18px;
            padding: 22px 34px;
            border-bottom: 1px solid var(--line);
            background: rgba(255, 255, 255, .94);
        }

        .brand {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.15rem;
            font-weight: 700;
            letter-spacing: .2px;
            justify-self: start;
            text-decoration: none;
            color: var(--ink);
        }

        .menu {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 18px;
            list-style: none;
            margin: 0;
            padding: 0;
            justify-self: center;
        }

        .menu a {
            color: var(--muted);
            text-decoration: none;
            font-size: .92rem;
            font-weight: 600;
        }

        .menu a:hover {
            color: var(--primary-2);
        }

        .lang-switch {
            justify-self: end;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1px solid var(--line);
            border-radius: 999px;
            padding: 4px;
            background: #fff;
        }

        .lang-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 38px;
            height: 30px;
            border-radius: 999px;
            color: var(--muted);
            text-decoration: none;
            font-size: .8rem;
            font-weight: 700;
        }

        .lang-link.active {
            background: var(--primary);
            color: #fff;
        }

        .menu-dropdown { position: relative; }

        .menu-dropdown summary {
            list-style: none;
            cursor: pointer;
            color: var(--muted);
            font-size: .92rem;
            font-weight: 600;
        }

        .menu-dropdown summary::-webkit-details-marker { display: none; }

        .dropdown-list {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            min-width: 220px;
            margin: 0;
            padding: 8px;
            list-style: none;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 12px;
            box-shadow: 0 12px 24px rgba(16, 24, 40, .1);
            display: none;
            z-index: 20;
        }

        .menu-dropdown[open] .dropdown-list { display: block; }

        .dropdown-list a {
            display: block;
            padding: 8px 10px;
            border-radius: 8px;
            font-size: .88rem;
        }

        .dropdown-list a:hover { background: #eef4ff; }

        .content {
            padding: 28px 34px 44px;
            max-width: 980px;
            margin: 0 auto;
        }

        .page-title {
            margin: 0;
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(1.8rem, 4.8vw, 3rem);
            line-height: 1.08;
        }

        .page-sub {
            margin: 8px 0 0;
            color: var(--muted);
        }

        .paket-list {
            margin-top: 18px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .paket-item {
            position: relative;
            min-height: 280px;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #d8e2df;
            background: #0f172a center/cover no-repeat;
        }

        .paket-item a {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 280px;
            padding: 12px;
            color: #f8fbff;
            text-decoration: none;
        }

        .paket-item::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                linear-gradient(180deg, rgba(2, 8, 23, .08) 22%, rgba(2, 8, 23, .82) 100%);
            z-index: 0;
        }

        .paket-badge {
            align-self: flex-start;
            border: 1px solid rgba(255, 255, 255, .45);
            background: rgba(2, 8, 23, .35);
            border-radius: 999px;
            padding: 3px 8px;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .2px;
        }

        .paket-content {
            margin-top: auto;
        }

        .paket-head {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 10px;
        }

        .paket-item h3 {
            margin: 0;
            font-size: .97rem;
            line-height: 1.3;
            color: #fff;
        }

        .paket-price {
            font-weight: 800;
            color: #fff;
            font-size: .92rem;
            white-space: nowrap;
        }

        .paket-meta {
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: .72rem;
            color: rgba(255, 255, 255, .9);
            opacity: .95;
        }

        .empty {
            margin-top: 16px;
            border: 1px dashed var(--line);
            border-radius: 12px;
            padding: 14px;
            color: var(--muted);
            background: #f8fbff;
        }

        @media (max-width: 1020px) {
            .paket-list { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 760px) {
            .top-nav, .content { padding-left: 16px; padding-right: 16px; }

            .top-nav {
                flex-direction: column;
                align-items: flex-start;
                display: flex;
            }

            .lang-switch { margin-left: auto; }

            .dropdown-list {
                position: static;
                margin-top: 8px;
                width: 100%;
                box-shadow: none;
            }

            .paket-list { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <?php
        $cardGalleryList = (isset($galleryList) ? $galleryList : collect())->values();
        $paketByKategori = (isset($paketList) ? $paketList : collect())
            ->groupBy(fn ($item) => filled($item->kategori) ? $item->kategori : 'Umum');
    ?>
    <div class="page-shell">
        <nav class="top-nav">
            <a class="brand" href="<?php echo e(url('/')); ?>">Rinjani Great Trek</a>
            <ul class="menu">
                <li><a href="<?php echo e(url('/')); ?>">Home</a></li>
                <li><a href="<?php echo e(route('about.index')); ?>"><?php echo e(__('site.nav.about')); ?></a></li>
                <li>
                    <details class="menu-dropdown">
                        <summary><?php echo e(__('site.nav.packages')); ?></summary>
                        <ul class="dropdown-list">
                            <?php if($paketByKategori->count() > 0): ?>
                                <?php $__currentLoopData = $paketByKategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $namaKategori => $kategoriItems): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $firstPaket = $kategoriItems->first(); ?>
                                    <?php if($firstPaket && $firstPaket->kategori_id): ?>
                                        <li>
                                            <a href="<?php echo e(route('paket.kategori', $firstPaket->kategori_id)); ?>"><?php echo e($namaKategori); ?></a>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <li><a href="<?php echo e(url('/')); ?>#paket"><?php echo e(__('site.nav.empty_packages')); ?></a></li>
                            <?php endif; ?>
                        </ul>
                    </details>
                </li>
                <li><a href="<?php echo e(route('artikel.index')); ?>"><?php echo e(__('site.nav.news')); ?></a></li>
                <li><a href="<?php echo e(route('gallery.index')); ?>"><?php echo e(__('site.nav.gallery')); ?></a></li>
            </ul>
            <div class="lang-switch" aria-label="<?php echo e(__('site.language.label')); ?>">
                <a class="lang-link <?php echo e(app()->getLocale() === 'id' ? 'active' : ''); ?>" href="<?php echo e(route('language.switch', ['locale' => 'id'])); ?>">ID</a>
                <a class="lang-link <?php echo e(app()->getLocale() === 'en' ? 'active' : ''); ?>" href="<?php echo e(route('language.switch', ['locale' => 'en'])); ?>">EN</a>
            </div>
        </nav>

        <section class="content" id="paket">
            <h1 class="page-title"><?php echo e($kategori->nama_kategori); ?></h1>
            <p class="page-sub">Daftar paket untuk kategori ini.</p>

            <?php if(isset($kategoriPaketList) && $kategoriPaketList->count() > 0): ?>
                <div class="paket-list">
                    <?php $__currentLoopData = $kategoriPaketList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $cardImage = $cardGalleryList->count() > 0
                                ? ($cardGalleryList->get($loop->index % $cardGalleryList->count())->image_url ?? asset('images/admin-login-bg.jpg'))
                                : asset('images/admin-login-bg.jpg');
                        ?>
                        <article class="paket-item" id="paket-<?php echo e($paket->id_paket); ?>" style="background-image: url('<?php echo e($cardImage); ?>');">
                            <a href="<?php echo e(route('paket.show', $paket->id_paket)); ?>">
                                <span class="paket-badge"><?php echo e($paket->kategori ?? 'General'); ?></span>
                                <div class="paket-content">
                                    <div class="paket-head">
                                        <h3><?php echo e($paket->nama_paket_localized); ?></h3>
                                        <div class="paket-price">$<?php echo e(number_format($paket->harga, 0, '.', ',')); ?></div>
                                    </div>
                                    <div class="paket-meta">
                                        <span><?php echo e($paket->kategori ?? 'General'); ?></span>
                                        <span>Trip</span>
                                        <span>#<?php echo e($paket->id_paket); ?></span>
                                    </div>
                                </div>
                            </a>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="empty">Belum ada paket pada kategori ini.</div>
            <?php endif; ?>
        </section>
    </div>
    <?php echo $__env->make('partials.whatsapp-float', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html>
