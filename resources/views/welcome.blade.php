<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rinjani Great Trek</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #eef3fb;
            --surface: #ffffff;
            --surface-soft: #eaf1fb;
            --ink: #111827;
            --muted: #58677f;
            --line: #d6e1f2;
            --primary: #2a67d1;
            --primary-2: #1d4ea7;
            --accent: #7aa8ff;
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
            background:
                radial-gradient(1200px 500px at -10% -10%, #dce9ff 0%, transparent 60%),
                radial-gradient(1000px 500px at 110% 5%, #e6f0ff 0%, transparent 65%),
                var(--bg);
            line-height: 1.6;
        }

        .page-shell {
            width: 100%;
            margin: 0;
            background: var(--surface);
            border: none;
            border-radius: 0;
            overflow: hidden;
            box-shadow: none;
        }

        .top-nav {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            gap: 18px;
            padding: 22px 34px;
            border-bottom: 1px solid var(--line);
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(6px);
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

        .hero {
            display: grid;
            grid-template-columns: 1.1fr .9fr;
            gap: 26px;
            padding: 44px 34px 28px;
        }

        .hero-copy h1 {
            margin: 0;
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(2.1rem, 4.8vw, 4.2rem);
            line-height: .97;
            letter-spacing: -1px;
            max-width: 13ch;
        }

        .hero-copy p {
            margin: 18px 0 0;
            max-width: 52ch;
            color: var(--muted);
            font-size: 1rem;
        }

        .hero-actions {
            margin-top: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-primary,
        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            border-radius: 999px;
            font-weight: 700;
            font-size: .9rem;
            padding: 12px 18px;
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
        }

        .btn-secondary {
            border: 1px solid var(--line);
            color: var(--ink);
            background: #fff;
        }

        .hero-visual {
            position: relative;
            min-height: 340px;
            border-radius: 28px;
            background: url('/images/admin-login-bg.jpg') center/cover no-repeat;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .28);
        }

        .hero-visual::before {
            content: '';
            position: absolute;
            width: 240px;
            height: 240px;
            border-radius: 50%;
            right: -30px;
            top: -34px;
            border: 1px dashed rgba(255, 255, 255, .55);
        }

        .hero-visual::after {
            content: 'RINJANI JOURNEY';
            position: absolute;
            left: 18px;
            bottom: 16px;
            color: rgba(255, 255, 255, .9);
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 600;
            letter-spacing: 1.8px;
            font-size: .8rem;
        }

        .section {
            padding: 56px 34px;
        }

        .section-head {
            max-width: 760px;
        }

        .eyebrow {
            display: inline-block;
            margin: 0;
            font-size: .76rem;
            letter-spacing: 1.1px;
            text-transform: uppercase;
            color: #60706d;
            font-weight: 700;
        }

        h2 {
            margin: 10px 0 0;
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(1.8rem, 4vw, 3rem);
            line-height: 1.06;
            letter-spacing: -.5px;
        }

        .section-head p {
            margin: 14px 0 0;
            color: var(--muted);
        }

        .destination-row {
            margin-top: 28px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
        }

        .destination-card {
            height: 186px;
            border-radius: 18px;
            overflow: hidden;
            position: relative;
            border: 1px solid #d8e2df;
            background: url('/images/admin-login-bg.jpg') center/cover no-repeat;
        }

        .destination-card:nth-child(2) {
            transform: rotate(-4deg);
            background-position: center 22%;
        }

        .destination-card:nth-child(3) {
            transform: rotate(2deg);
            background-position: center 58%;
        }

        .destination-card:nth-child(4) {
            transform: rotate(-3deg);
            background-position: center 75%;
        }

        .destination-card span {
            display: none;
        }

        .paket-list-title {
            margin: 34px 0 0;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.35rem;
            line-height: 1.2;
        }

        .paket-list {
            margin-top: 14px;
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

        .paket-empty {
            margin-top: 14px;
            border: 1px dashed var(--line);
            border-radius: 12px;
            padding: 14px;
            color: var(--muted);
            background: #f8fbff;
        }

        .article-list {
            margin-top: 26px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .article-item {
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 14px 16px;
            background: #f8fbfa;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .article-link {
            text-decoration: none;
            color: inherit;
        }

        .article-item h3 {
            margin: 0;
            font-size: 1rem;
        }

        .article-item p {
            margin: 3px 0 0;
            color: #5a6371;
            font-size: .88rem;
        }

        .article-tag {
            white-space: nowrap;
            font-weight: 800;
            color: var(--primary-2);
            font-size: .85rem;
        }

        .closing-panel {
            margin: 0 34px 34px;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid var(--line);
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: #e8f0ff;
        }

        .closing-copy {
            padding: 34px;
            background: linear-gradient(180deg, #eef4ff 0%, #dce9ff 100%);
        }

        .closing-copy h3 {
            margin: 0;
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(1.5rem, 3.2vw, 2.6rem);
            line-height: 1.08;
        }

        .closing-copy p {
            margin-top: 14px;
            color: #50606d;
            max-width: 42ch;
        }

        .closing-copy a {
            margin-top: 16px;
            display: inline-flex;
            text-decoration: none;
            color: #fff;
            background: var(--primary-2);
            border-radius: 999px;
            padding: 11px 16px;
            font-size: .88rem;
            font-weight: 700;
        }

        .closing-visual {
            min-height: 260px;
            background: url('/images/admin-login-bg.jpg') center/cover no-repeat;
        }

        .footer {
            background: #132120;
            color: #d8e5df;
            padding: 28px 34px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            flex-wrap: wrap;
        }

        .footer small {
            color: #b0c0bc;
        }

        @media (max-width: 1020px) {
            .hero,
            .closing-panel {
                grid-template-columns: 1fr;
            }

            .destination-row {
                grid-template-columns: 1fr 1fr;
            }

            .paket-list {
                grid-template-columns: 1fr 1fr;
            }

            .destination-card {
                transform: none !important;
            }
        }

        @media (max-width: 680px) {
            .top-nav,
            .hero,
            .section,
            .closing-copy,
            .footer {
                padding-left: 16px;
                padding-right: 16px;
            }

            .top-nav {
                flex-direction: column;
                align-items: flex-start;
                display: flex;
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

            .hero {
                padding-top: 24px;
                padding-bottom: 16px;
            }

            .destination-row {
                grid-template-columns: 1fr;
            }

            .paket-list {
                grid-template-columns: 1fr;
            }

            .article-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .closing-panel {
                margin-left: 16px;
                margin-right: 16px;
                margin-bottom: 16px;
            }
        }
    </style>
</head>
<body>
    <?php
        $adminId = session('admin_user.id');
        $dbWaNumber = null;
        $heroImagePath = (isset($galleryList) && $galleryList->count() > 0)
            ? $galleryList->first()->image_url
            : '/images/admin-login-bg.jpg';
        $closingImagePath = (isset($galleryList) && $galleryList->count() > 1)
            ? ($galleryList->get(1)->image_url ?: $heroImagePath)
            : $heroImagePath;

        if ($adminId) {
            $dbWaNumber = \App\Models\User::where('id', $adminId)->value('no_wa');
        }

        if (! $dbWaNumber) {
            $dbWaNumber = \App\Models\User::whereNotNull('no_wa')->orderBy('id')->value('no_wa');
        }

        $waNumber = preg_replace('/\D+/', '', $dbWaNumber ?: env('WHATSAPP_SELLER_NUMBER', '6281234567890'));
        $waDefaultMessage = __('site.whatsapp.default_message');
        $waText = urlencode(env('WHATSAPP_DEFAULT_MESSAGE', $waDefaultMessage));
        $waUrl = 'https://wa.me/' . $waNumber . '?text=' . $waText;
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
                                <?php $__currentLoopData = $paketByKategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kategori => $kategoriItems): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $firstPaket = $kategoriItems->first(); ?>
                                    <?php if($firstPaket && $firstPaket->kategori_id): ?>
                                        <li class="dropdown-category">
                                            <a href="<?php echo e(route('paket.kategori', $firstPaket->kategori_id)); ?>"><?php echo e($kategori); ?></a>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <li><a href="#paket"><?php echo e(__('site.nav.empty_packages')); ?></a></li>
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

        <header class="hero" id="home">
            <div class="hero-copy">
                <h1><?php echo e(__('site.home.hero_title')); ?></h1>
                <p><?php echo e(__('site.home.hero_text')); ?></p>
                <div class="hero-actions">
                    <a class="btn-secondary" href="<?php echo e($waUrl); ?>" target="_blank" rel="noopener noreferrer"><?php echo e(__('site.home.contact_us')); ?></a>
                </div>
            </div>
            <div class="hero-visual" style="background-image: url('<?php echo e($heroImagePath); ?>');"></div>
        </header>

        <section class="section" id="gallery">
            <div class="section-head">
                <p class="eyebrow"><?php echo e(__('site.home.discover_eyebrow')); ?></p>
                <h2><?php echo e(__('site.home.discover_title')); ?></h2>
                <p><?php echo e(__('site.home.discover_text')); ?></p>
            </div>

            <div class="destination-row">
                <?php if(isset($galleryList) && $galleryList->count() > 0): ?>
                    <?php $__currentLoopData = $galleryList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $foto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <article
                            class="destination-card"
                            style="background-image: url('<?php echo e($foto->image_url); ?>');"
                        ></article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <article class="destination-card"></article>
                    <article class="destination-card"></article>
                    <article class="destination-card"></article>
                    <article class="destination-card"></article>
                <?php endif; ?>
            </div>

            <h3 class="paket-list-title"><?php echo e(__('site.home.package_title')); ?></h3>
            <?php if(isset($featuredPaketList) && $featuredPaketList->count() > 0): ?>
                <div class="paket-list" id="paket">
                    <?php $__currentLoopData = $featuredPaketList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                <div class="paket-empty" id="paket">
                    <?php echo e(__('site.home.empty_package')); ?>

                </div>
            <?php endif; ?>
        </section>
        <section class="section" id="artikel">
            <div class="section-head">
                <p class="eyebrow"><?php echo e(__('site.home.news_eyebrow')); ?></p>
                <h2><?php echo e(__('site.home.news_title')); ?></h2>
            </div>
            <div class="article-list">
                <?php if(isset($artikelList) && $artikelList->count() > 0): ?>
                    <?php $__currentLoopData = $artikelList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $artikel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a class="article-link" href="<?php echo e(route('artikel.show', $artikel->id_artikel)); ?>">
                            <article class="article-item" id="artikel-<?php echo e($artikel->id_artikel); ?>">
                                <div>
                                    <h3><?php echo e($artikel->judul_localized); ?></h3>
                                    <p><?php echo e(\Illuminate\Support\Str::limit($artikel->deskripsi_localized, 130)); ?></p>
                                </div>
                                <span class="article-tag"><?php echo e(__('site.home.view_detail')); ?></span>
                            </article>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <article class="article-item">
                        <div>
                            <h3><?php echo e(__('site.home.empty_news')); ?></h3>
                        </div>
                    </article>
                <?php endif; ?>
            </div>
        </section>

        <section class="closing-panel">
            <div class="closing-copy">
                <h3><?php echo e(__('site.home.closing_title')); ?></h3>
                <p><?php echo e(__('site.home.closing_text')); ?></p>
                <a href="<?php echo e($waUrl); ?>" target="_blank" rel="noopener noreferrer"><?php echo e(__('site.home.contact_us')); ?></a>
            </div>
            <div class="closing-visual" style="background-image: url('<?php echo e($closingImagePath); ?>');"></div>
        </section>

        <footer class="footer" id="footer-contact">
            <div>
                <strong>Rinjani Great Trek</strong><br>
                <p class="mb-0">
                    © 2026 Rinjani Great Trek. All rights reserved. <br>
                </p>
            </div>
            <small><?php echo e(__('site.home.footer_contact')); ?>: +<?php echo e($waNumber); ?></small>
        </footer>
    </div>
    <?php echo $__env->make('partials.whatsapp-float', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html>
