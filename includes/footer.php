<?php
// :: START FOOTER CONTACT PATH FIX
$footerCurrentScript = $_SERVER['PHP_SELF'] ?? '';
$footerContactPath = preg_match('~/(services|pages|admin|staff)/~', $footerCurrentScript)
    ? '../pages/contact.php'
    : './pages/contact.php';
// :: END FOOTER CONTACT PATH FIX

// :: START FOOTER HOME PATH FIX
$footerHomePath = preg_match('~/(services|pages|admin|staff)/~', $footerCurrentScript)
    ? '../index.php#home'
    : '#home';
// :: END FOOTER HOME PATH FIX
?>

<div
    class="relative mx-auto grid w-full max-w-350 grid-cols-1 gap-10 px-6 py-16 sm:grid-cols-2 lg:grid-cols-4 lg:gap-12 lg:px-10">

    <div class="flex flex-col items-start w-full">
        <!-- :: START FOOTER LOGO HOME LINK -->
        <a href="<?= htmlspecialchars($footerHomePath, ENT_QUOTES, 'UTF-8') ?>" class="inline-flex items-center gap-3 text-white">
            <span class="text-xl font-extrabold tracking-wide">PAWSITIVE</span>
        </a>
        <!-- :: END FOOTER LOGO HOME LINK -->

        <p class="mt-5 max-w-xs text-sm leading-7 text-muted">
            Thoughtful care for happier, healthier pets in Dagupan.
        </p>

        <!-- :: START FOOTER GET IN TOUCH LINK FIX -->
        <a href="<?= htmlspecialchars($footerContactPath, ENT_QUOTES, 'UTF-8') ?>"
            class="mt-6 inline-flex items-center gap-2 rounded-xl bg-tertiary px-5 py-3 text-sm font-semibold text-white transition-all hover:rounded-none hover:bg-primary duration-200">
            Get in touch
            <i class="bx bx-arrow-up-right text-lg"></i>
        </a>
        <!-- :: END FOOTER GET IN TOUCH LINK FIX -->
    </div>

    <div>
        <h2 class="text-sm font-bold tracking-widest text-accent">VISIT US</h2>

        <div class="mt-5 flex items-start justify-center gap-3">
            <i class="bx bx-map text-xl text-accent mt-1.5"></i>
            <p class="max-w-xs text-sm leading-7 text-muted ">
                Arellano St., Dagupan City, 2400 Pangasinan, Philippines
            </p>
        </div>

        <a href="tel:+63971214798"
            class="mt-4 inline-flex items-center gap-3 text-sm text-muted transition hover:text-primary">
            <i class="bx bx-phone text-xl text-accent"></i>
            +63 971 214 798
        </a>
    </div>

    <div>
        <h2 class="text-sm font-bold uppercase tracking-[0.18em] text-accent">Opening hours</h2>

        <dl class="mt-5 space-y-4 text-sm">
            <div class="flex flex-col gap-1">
                <dt class="font-semibold text-white">Monday–Friday</dt>
                <dd class="text-muted">8:00 AM–5:00 PM</dd>
            </div>
            <div class="flex flex-col gap-1">
                <dt class="font-semibold text-white">Saturday–Sunday</dt>
                <dd class="text-muted">1:00 PM–5:00 PM</dd>
            </div>
        </dl>
    </div>

    <div>
        <h2 class="text-sm font-bold tracking-widest text-accent">EXPLORE</h2>

        <nav class="mt-5 flex flex-col items-start gap-3 text-sm">
            <!-- :: START FOOTER EXPLORE HOME LINK -->
            <a href="<?= htmlspecialchars($footerHomePath, ENT_QUOTES, 'UTF-8') ?>" class="text-muted transition hover:translate-x-1 hover:text-primary">
                Home
            </a>
            <!-- :: END FOOTER EXPLORE HOME LINK -->
            <a href="./pages/about.php" class="text-muted transition hover:translate-x-1 hover:text-primary">
                About us
            </a>
            <!-- :: START FOOTER CONTACT US LINK FIX -->
            <a href="<?= htmlspecialchars($footerContactPath, ENT_QUOTES, 'UTF-8') ?>"
                class="text-muted transition hover:translate-x-1 hover:text-primary">
                Contact us
            </a>
            <!-- :: END FOOTER CONTACT US LINK FIX -->
        </nav>
    </div>
</div>

<div class="relative bg-white">
    <div
        class="mx-auto flex w-full max-w-350 flex-col gap-2 px-6 py-5 text-xs text-text sm:flex-row sm:items-center sm:justify-between lg:px-10">
        <p>&copy;
            <?= date('Y') ?> Pawsitive. All rights reserved.
        </p>
        <p>Made with care for every pet.</p>
    </div>
</div>
