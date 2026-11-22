<?php
function checker(string $targetPage): string
{
    $currentPage = basename($_SERVER['PHP_SELF']);

    return $currentPage === $targetPage
        ? "text-primary font-semibold"
        : "hover:text-text transition-colors";
}

// :: START HOME AND CONTACT PATH FIX
function isHome(string $targetPage): string
{
    $currentPage = basename($_SERVER['PHP_SELF']);

    return $currentPage === $targetPage
        ? "#home"
        : "../index.php#home";
}

// :: START CONTACT PATH FIX
function isContact(string $targetPage): string
{
    $currentPage = basename($_SERVER['PHP_SELF']);
    $currentScript = $_SERVER['PHP_SELF'] ?? '';

    if ($currentPage === $targetPage) {
        return $targetPage;
    }

    return strpos($currentScript, '/services/') !== false
        || strpos($currentScript, '/admin/') !== false
        || strpos($currentScript, '/staff/') !== false
        ? '../pages/' . $targetPage
        : (strpos($currentScript, '/pages/') !== false
            ? $targetPage
            : './pages/' . $targetPage);
}
// :: END CONTACT PATH FIX

// :: START CARE PAGE PATH
function carePagePath(string $page): string
{
    $currentScript = $_SERVER['PHP_SELF'] ?? '';

    if (strpos($currentScript, '/services/') !== false) {
        return $page;
    }

    return strpos($currentScript, '/pages/') !== false
        || strpos($currentScript, '/admin/') !== false
        || strpos($currentScript, '/staff/') !== false
        ? '../services/' . $page
        : './services/' . $page;
}
// :: END CARE PAGE PATH

// :: START LOGOUT LINK PATH
function signOutPath(): string
{
    $currentScript = $_SERVER['PHP_SELF'] ?? '';

    return strpos($currentScript, '/services/') !== false
        || strpos($currentScript, '/pages/') !== false
        || strpos($currentScript, '/admin/') !== false
        || strpos($currentScript, '/staff/') !== false
        ? '../logout.php'
        : 'logout.php';
}
// :: END LOGOUT LINK PATH

// :: START ROLE DASHBOARD LINKS
function roleDashboardPath(string $role): string
{
    $currentScript = $_SERVER['PHP_SELF'] ?? '';
    $base = preg_match('~/(services|pages|admin|staff)/~', $currentScript) ? '../' : './';

    return $role === 'admin'
        ? $base . 'admin/dashboard.php'
        : $base . 'staff/dashboard.php';
}
// :: END ROLE DASHBOARD LINKS
// :: END HOME AND CONTACT PATH FIX

// :: START CUSTOMER SCHEDULE LINK
function customerSchedulePath(): string
{
    $currentScript = $_SERVER['PHP_SELF'] ?? '';
    $base = preg_match('~/(services|pages|admin|staff)/~', $currentScript) ? '../' : './';

    return $base . 'pages/schedule.php';
}
// :: END CUSTOMER SCHEDULE LINK
?>

<header id="siteHeader"
    class="relative flex flex-wrap items-center justify-between px-5 gap-3 backdrop-blur-md py-4 bg-card lg:flex-nowrap lg:gap-6 rounded-none lg:rounded-2xl">

    <!-- :: START LOGO HOME LINK FIX -->
    <a href="<?= isHome('index.php') ?>" class="order-1 inline-flex items-center gap-2 lg:flex-1 text-text">
        <i class="bx bx-paw-print text-2xl"></i>

        <span class="text-lg font-extrabold tracking-wide md:text-xl hidden sm:block">
            PAWSITIVE
        </span>
    </a>
    <!-- :: END LOGO HOME LINK FIX -->

    <!-- Navigation -->
    <nav id="mainNavigation"
        class="absolute left-0 right-0 top-full z-9999 hidden w-full flex-col gap-1  bg-white p-3 shadow-xl lg:static lg:order-2 -mt-2 rounded-b-2xl lg:mt-0 lg:flex lg:w-auto lg:flex-1 lg:flex-row lg:items-center lg:justify-center lg:gap-1 rounded-none lg:border-0 lg:bg-transparent lg:p-0 lg:shadow-none">

        <!-- :: START HOME LINK FIX -->
        <a href="<?= isHome('index.php') ?>"
            class="flex items-center gap-2 rounded-full px-4 py-2.5 text-sm font-medium text-text transition-colors hover:bg-card-inner hover:text-primary">
            <i class="bx bx-home text-lg icon-mobile"></i>
            Home
        </a>
        <!-- :: END HOME LINK FIX -->
        <!-- :: START ABOUT PAGE LINK FIX -->
        <a href="<?= isContact('about.php') ?>"
            class="flex items-center gap-2 rounded-full px-4 py-2.5 text-sm font-medium text-text transition-colors hover:bg-card-inner hover:text-primary">
            <i class="bx bx-info-circle text-lg icon-mobile"></i>
            About
        </a>
        <!-- :: END ABOUT PAGE LINK FIX -->

        <!-- :: START CONTACT LINK FIX -->
        <a href="<?= isContact('contact.php') ?>"
            class="flex items-center gap-2 rounded-full px-4 py-2.5 text-sm font-medium text-text transition-colors hover:bg-card-inner hover:text-primary">
            <i class="bx bx-envelope text-lg icon-mobile"></i>
            Contact
        </a>
        <!-- :: END CONTACT LINK FIX -->

        <!-- Pet Care dropdown -->
        <div id="petCareDropdown" class="relative">

            <button type="button" id="petCareButton" aria-expanded="false" aria-controls="petCareMenu"
                class="flex w-full cursor-pointer items-center justify-between gap-2 whitespace-nowrap rounded-full px-4 py-2.5 text-sm font-medium text-text transition-colors hover:bg-card-inner hover:text-primary lg:w-auto lg:justify-center">

                <span class="flex items-center gap-2">
                    <i class="bx bx-paw-print text-lg icon-mobile"></i>
                    Pet Care
                </span>

                <i id="petCareIcon" class="bx bx-chevron-down text-lg transition-transform duration-200"></i>
            </button>

            <div id="petCareMenu"
                class="mt-2 hidden w-full overflow-hidden rounded-2xl border border-border bg-white p-2 lg:absolute lg:left-0 lg:top-full lg:z-50 lg:mt-2 lg:w-64 lg:bg-card">

                <!-- :: START CARE PAGE LINKS -->
                <a href="<?= carePagePath('general.php') ?>"
                    class="flex flex-col gap-1 rounded-xl px-4 py-3 transition-colors hover:bg-card-inner-hover">
                    <span class="flex items-center gap-2 text-sm font-semibold text-text">
                        <i class="bx bx-band-aid text-lg text-primary"></i>
                        General Care
                    </span>
                    <span class="text-xs text-muted">Everyday care for happy pets.</span>
                </a>

                <a href="<?= carePagePath('preventive.php') ?>"
                    class="flex flex-col gap-1 rounded-xl px-4 py-3 transition-colors hover:bg-card-inner-hover">
                    <span class="flex items-center gap-2 text-sm font-semibold text-text">
                        <i class="bx bx-pill-bottle text-lg text-primary"></i>
                        Preventive Care
                    </span>
                    <span class="text-xs text-muted">Help keep pets healthy.</span>
                </a>

                <a href="<?= carePagePath('hygiene.php') ?>"
                    class="flex flex-col gap-1 rounded-xl px-4 py-3 transition-colors hover:bg-card-inner-hover">
                    <span class="flex items-center gap-2 text-sm font-semibold text-text">
                        <i class="bx bx-water-drop text-lg text-primary"></i>
                        Hygiene Care
                    </span>
                    <span class="text-xs text-muted">Grooming and cleanliness.</span>
                </a>

                <a href="<?= carePagePath('diagnostic.php') ?>"
                    class="flex flex-col gap-1 rounded-xl px-4 py-3 transition-colors hover:bg-card-inner-hover">
                    <span class="flex items-center gap-2 text-sm font-semibold text-text">
                        <i class="bx bx-syringe text-lg text-primary"></i>
                        Diagnostic Care
                    </span>
                    <span class="text-xs text-muted">Support for pet health concerns.</span>
                </a>
                <!-- :: END CARE PAGE LINKS -->

            </div>
        </div>
    </nav>

    <!-- Actions -->
    <div class="order-2 ml-auto flex items-center gap-2 lg:order-3 lg:ml-0 lg:flex-1 lg:justify-end">

        <span class="h-6 w-px bg-border"></span>

        <!-- :: START SIGN IN AND LOGOUT ACTION -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <!-- :: START ROLE DASHBOARD NAVIGATION -->
            <?php $headerRole = strtolower((string) ($_SESSION['user_role'] ?? 'customer')); ?>
            <?php if ($headerRole === 'admin'): ?>
                <a href="<?= roleDashboardPath('admin') ?>"
                    class="inline-flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold text-text transition-colors hover:bg-card-inner hover:text-primary">
                    <i class="bx bx-grid-alt text-lg" aria-hidden="true"></i>
                    Dashboard
                </a>
            <?php elseif ($headerRole === 'staff'): ?>
                <a href="<?= roleDashboardPath('staff') ?>"
                    class="inline-flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold text-text transition-colors hover:bg-card-inner hover:text-primary">
                    <i class="bx bx-grid-alt text-lg" aria-hidden="true"></i>
                    Dashboard
                </a>
            <?php elseif ($headerRole === 'customer'): ?>
                <a href="<?= customerSchedulePath() ?>"
                    class="inline-flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold text-text transition-colors hover:bg-card-inner hover:text-primary">
                    <i class="bx bx-calendar text-lg" aria-hidden="true"></i>
                    Schedule
                </a>
            <?php endif; ?>
            <!-- :: END ROLE DASHBOARD NAVIGATION -->
            <a href="<?= signOutPath() ?>"
                class="inline-flex w-fit items-center justify-center rounded-xl bg-primary px-5 py-2.5 text-sm font-semibold text-text hover:text-white hover:bg-tertiary focus-visible:outline-tertiary hover:rounded-none transition-all duration-200">
                Logout
            </a>
        <?php endif; ?>
        <!-- :: END SIGN IN AND LOGOUT ACTION -->

        <button type="button" id="mobileMenuButton" aria-label="Open navigation" aria-expanded="false"
            aria-controls="mainNavigation"
            class="flex size-10 cursor-pointer items-center justify-center rounded-full text-xl text-text transition-colors hover:bg-card-inner hover:text-primary lg:hidden">
            <i id="mobileMenuIcon" class="bx bx-menu"></i>
        </button>

    </div>
</header>

<script>
    const siteHeader = document.getElementById("siteHeader");

    const mobileMenuButton = document.getElementById("mobileMenuButton");
    const mobileMenuIcon = document.getElementById("mobileMenuIcon");
    const mainNavigation = document.getElementById("mainNavigation");

    const petCareButton = document.getElementById("petCareButton");
    const petCareMenu = document.getElementById("petCareMenu");
    const petCareIcon = document.getElementById("petCareIcon");

    function closeMobileMenu() {
        mainNavigation.classList.add("hidden");
        mainNavigation.classList.remove("flex");

        mobileMenuButton.setAttribute("aria-expanded", "false");
        mobileMenuButton.setAttribute("aria-label", "Open navigation");

        mobileMenuIcon.classList.add("bx-menu");
        mobileMenuIcon.classList.remove("bx-x");
    }

    function closePetCareMenu() {
        petCareMenu.classList.add("hidden");
        petCareIcon.classList.remove("rotate-180");
        petCareButton.setAttribute("aria-expanded", "false");
    }

    mobileMenuButton.addEventListener("click", () => {
        const isOpen = mobileMenuButton.getAttribute("aria-expanded") === "true";

        mobileMenuButton.setAttribute("aria-expanded", String(!isOpen));
        mobileMenuButton.setAttribute("aria-label", isOpen ? "Open navigation" : "Close navigation");

        mainNavigation.classList.toggle("hidden", isOpen);
        mainNavigation.classList.toggle("flex", !isOpen);

        mobileMenuIcon.classList.toggle("bx-menu", isOpen);
        mobileMenuIcon.classList.toggle("bx-x", !isOpen);
    });

    petCareButton.addEventListener("click", () => {
        const isOpen = !petCareMenu.classList.contains("hidden");

        petCareMenu.classList.toggle("hidden", isOpen);
        petCareIcon.classList.toggle("rotate-180", !isOpen);
        petCareButton.setAttribute("aria-expanded", String(!isOpen));
    });

    document.addEventListener("click", (event) => {
        if (!siteHeader.contains(event.target)) {
            closePetCareMenu();
            closeMobileMenu();
        }
    });

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape") {
            closePetCareMenu();
            closeMobileMenu();
        }
    });

    mainNavigation.querySelectorAll("a").forEach((link) => {
        link.addEventListener("click", () => {
            closePetCareMenu();
            closeMobileMenu();
        });
    });
</script>
