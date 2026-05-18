<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e($artikel->judul_localized); ?> | Rinjani Great Trek</title>
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

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Manrope', sans-serif;
            color: var(--ink);
            background: var(--surface);
            line-height: 1.6;
        }

        .page-shell {
            width: 100%;
            margin: 0;
            background: var(--surface);
        }

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
            background: var(--primary-2);
            color: #fff;
        }

        .menu-dropdown {
            position: relative;
        }

        .menu-dropdown summary {
            list-style: none;
            cursor: pointer;
            color: var(--muted);
            font-size: .92rem;
            font-weight: 600;
        }

        .menu-dropdown summary::-webkit-details-marker {
            display: none;
        }

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

        .menu-dropdown[open] .dropdown-list {
            display: block;
        }

        .dropdown-list a {
            display: block;
            padding: 8px 10px;
            border-radius: 8px;
            font-size: .88rem;
        }

        .dropdown-list a:hover {
            background: #eef4ff;
        }

        .dropdown-category {
            padding: 2px 0;
        }

        .dropdown-submenu summary {
            list-style: none;
            cursor: pointer;
            padding: 8px 10px;
            border-radius: 8px;
            font-size: .86rem;
            font-weight: 700;
            color: #334155;
        }

        .dropdown-submenu summary::-webkit-details-marker {
            display: none;
        }

        .dropdown-submenu summary:hover {
            background: #eef4ff;
        }

        .dropdown-sublist {
            list-style: none;
            margin: 4px 0 0;
            padding: 0 0 0 8px;
            display: none;
        }

        .dropdown-submenu[open] .dropdown-sublist {
            display: block;
        }

        .dropdown-sublist a {
            font-size: .84rem;
            padding: 6px 10px;
        }

        .hero-image {
            width: min(500px, calc(100% - 180px));
            aspect-ratio: 1 / 1;
            height: auto;
            margin: 28px auto 0;
            background: url('<?php echo e($artikel->image_url ?? asset('images/admin-login-bg.jpg')); ?>') center/cover no-repeat;
            border: 1px solid var(--line);
            border-radius: 16px;
        }

        .detail-content {
            padding: 28px 34px 44px;
            max-width: 880px;
            margin: 0 auto;
        }

        .artikel-title {
            margin: 0;
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(2rem, 5vw, 3.4rem);
            line-height: 1.05;
            letter-spacing: -.6px;
        }

        .divider {
            margin: 16px 0 18px;
            height: 1px;
            background: var(--line);
        }

        .label {
            margin: 0;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            text-transform: capitalize;
        }

        .text-block {
            margin-top: 10px;
            color: var(--muted);
            white-space: pre-line;
        }

        .recommendation-wrap {
            margin-top: 28px;
        }

        .recommendation-list {
            margin-top: 12px;
            display: grid;
            gap: 10px;
        }

        .recommendation-link {
            display: block;
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 12px 14px;
            text-decoration: none;
            color: inherit;
            background: #f8fbfa;
        }

        .recommendation-link h3 {
            margin: 0;
            font-size: .98rem;
            font-family: 'Space Grotesk', sans-serif;
        }

        .recommendation-link p {
            margin: 4px 0 0;
            color: var(--muted);
            font-size: .88rem;
        }

        @media (max-width: 760px) {
            .top-nav,
            .detail-content {
                padding-left: 16px;
                padding-right: 16px;
            }

            .top-nav {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
            }

            .lang-switch {
                margin-left: auto;
            }

            .dropdown-list {
                position: static;
                margin-top: 8px;
                width: 100%;
                box-shadow: none;
            }

            .hero-image {
                width: min(320px, calc(100% - 64px));
                margin-top: 16px;
            }
        }
    </style>
</head>
<body>
    <?php
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
                                <?php $__currentLoopData = $paketByKategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kategori => $kategoriItems): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $firstPaket = $kategoriItems->first(); ?>
                                    <?php if($firstPaket && $firstPaket->kategori_id): ?>
                                        <li class="dropdown-category">
                                            <a href="<?php echo e(route('paket.kategori', $firstPaket->kategori_id)); ?>"><?php echo e($kategori); ?></a>
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

        <section class="hero-image" aria-label="<?php echo e(__('site.article.photo_alt')); ?>"></section>

        <section class="detail-content" id="artikel">
            <h1 class="artikel-title"><?php echo e($artikel->judul_localized); ?></h1>

            <div class="divider"></div>

            <p class="text-block"><?php echo e($artikel->deskripsi_localized); ?></p>

            <?php if(isset($rekomendasiArtikel) && $rekomendasiArtikel->count() > 0): ?>
                <div class="recommendation-wrap">
                    <p class="label"><?php echo e(__('site.article.read_also')); ?></p>
                    <div class="recommendation-list">
                        <?php $__currentLoopData = $rekomendasiArtikel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a class="recommendation-link" href="<?php echo e(route('artikel.show', $item->id_artikel)); ?>">
                                <h3><?php echo e($item->judul_localized); ?></h3>
                                <p><?php echo e(\Illuminate\Support\Str::limit($item->deskripsi_localized, 120)); ?></p>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </section>
    </div>
    <?php echo $__env->make('partials.whatsapp-float', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html>


