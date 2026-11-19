<?php
// :: START CARE PAGE AUTHENTICATION
require_once __DIR__ . '/../../vendor/autoload.php';
$careAuth = new \App\Controller\Authentication_Controller();
if (!$careAuth->isLogin()) {
    header('Location: ../login.php');
    exit();
}
if (!isset($carePage) || !is_array($carePage)) {
    http_response_code(404);
    exit();
}
// :: END CARE PAGE AUTHENTICATION
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#fff9f0">
    <link rel="stylesheet" href="../src/output.css">
    <link href="https://cdn.boxicons.com/3.0.8/fonts/basic/boxicons.min.css" rel="stylesheet">
    <title><?= htmlspecialchars($carePage['pageTitle'], ENT_QUOTES, 'UTF-8') ?> | PAWSITIVE</title>
</head>

<body class="min-h-screen bg-background text-text">
    <!-- :: START SHARED CARE PAGE HEADER -->
    <div class="fixed left-0 right-0 top-0 z-50 bg-white">
        <div class="mx-auto w-full max-w-350">
            <?php include __DIR__ . '/../../includes/header.php'; ?>
        </div>
    </div>
    <!-- :: END SHARED CARE PAGE HEADER -->

    <main class="bg-background pt-24">
        <!-- :: START CARE PAGE HERO -->
        <section
            class="mx-auto grid w-full max-w-350 items-center gap-10 px-6 py-12 sm:px-8 lg:min-h-180 lg:grid-cols-2 lg:px-12">
            <div class="relative z-10">
                <span
                    class="inline-flex items-center gap-2 rounded-full border border-border bg-card-outer px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-tertiary">
                    <i class="<?= htmlspecialchars($carePage['icon'], ENT_QUOTES, 'UTF-8') ?>" aria-hidden="true"></i>
                    <?= htmlspecialchars($carePage['eyebrow'], ENT_QUOTES, 'UTF-8') ?>
                </span>
                <h1 class="mt-6 max-w-2xl text-4xl font-bold leading-tight text-text sm:text-5xl lg:text-6xl">
                    <?= htmlspecialchars($carePage['headline'], ENT_QUOTES, 'UTF-8') ?>
                    <span
                        class="text-tertiary"><?= htmlspecialchars($carePage['highlight'], ENT_QUOTES, 'UTF-8') ?></span>
                </h1>
                <p class="mt-6 max-w-xl text-base leading-8 text-muted sm:text-lg">
                    <?= htmlspecialchars($carePage['intro'], ENT_QUOTES, 'UTF-8') ?>
                </p>
                <div class="mt-8 flex flex-wrap items-center gap-3">

                    <button data-modal-target="default-modal" data-modal-toggle="default-modal"
                        class="inline-flex items-center gap-2 rounded-xl bg-tertiary px-6 py-3.5 text-sm font-bold text-white shadow-lg transition hover:-translate-y-0.5 hover:bg-primary">
                        Book now
                        <i class="bx bx-arrow-up-right text-lg" aria-hidden="true"></i>
                    </button>

                    <a href="#packages"
                        class="inline-flex items-center gap-2 rounded-xl border border-border bg-card-outer px-6 py-3.5 text-sm font-bold text-text transition hover:border-primary hover:text-primary">Explore
                        packages
                    </a>
                </div>
                <div class="mt-8 flex flex-wrap gap-3 text-sm text-muted">

                    <span
                        class="inline-flex items-center gap-2 rounded-full bg-card-inner px-4 py-2  border border-gray-300/60">
                        <i class="bx bx-heart text-tertiary" aria-hidden="true"></i>
                        Made for your pet
                    </span>
                </div>
            </div>
            <div class="relative isolate mx-auto w-full max-w-xl">
                <div class="absolute -left-5 -top-5 h-28 w-28 rounded-full bg-tertiary/70 blur-2xl"></div>
                <div class="absolute -bottom-5 -right-5 h-36 w-36 rounded-full bg-primary/70 blur-2xl"></div>
                <div
                    class="relative min-h-105 overflow-hidden rounded-4xl border-8 border-card-outer bg-card-inner shadow-2xl sm:min-h-135">
                    <img src="<?= htmlspecialchars($carePage['image'], ENT_QUOTES, 'UTF-8') ?>"
                        alt="<?= htmlspecialchars($carePage['imageAlt'], ENT_QUOTES, 'UTF-8') ?>"
                        class="absolute inset-0 h-full w-full object-cover">
                    <div class="absolute inset-0 bg-linear-to-t from-text/80 via-text/10 to-transparent"></div>
                    <div class="absolute inset-x-0 bottom-0 p-6 sm:p-8">
                        <span
                            class="inline-flex rounded-full bg-secondary px-4 py-2 text-xs font-bold uppercase tracking-wider text-text">PAWSITIVE
                            CARE</span>
                        <p class="mt-4 max-w-sm text-2xl font-bold leading-snug text-white sm:text-3xl">
                            <?= htmlspecialchars($carePage['imageNote'], ENT_QUOTES, 'UTF-8') ?>
                        </p>
                    </div>
                    <div
                        class="absolute right-5 top-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-card-outer text-3xl text-tertiary shadow-lg">
                        <i class="<?= htmlspecialchars($carePage['icon'], ENT_QUOTES, 'UTF-8') ?>"
                            aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </section>
        <!-- :: END CARE PAGE HERO -->

        <!-- :: START CARE PACKAGE DETAILS -->
        <section id="packages" class="bg-card-outer px-6 py-16 sm:px-8 lg:py-24">
            <div class="mx-auto w-full max-w-350">
                <div class="mx-auto max-w-2xl text-center">
                    <p class="text-xs font-bold uppercase tracking-[0.22em] text-primary">
                        <?= htmlspecialchars($carePage['sectionEyebrow'], ENT_QUOTES, 'UTF-8') ?>
                    </p>
                    <h2 class="mt-3 text-3xl font-bold text-text sm:text-4xl">
                        <?= htmlspecialchars($carePage['sectionTitle'], ENT_QUOTES, 'UTF-8') ?>
                    </h2>
                    <p class="mt-4 text-sm leading-7 text-muted sm:text-base">
                        <?= htmlspecialchars($carePage['sectionIntro'], ENT_QUOTES, 'UTF-8') ?>
                    </p>
                    <div class="mx-auto mt-6 h-2 w-24 rounded-full bg-tertiary"></div>
                </div>
                <div class="mt-12 grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
                    <?php foreach ($carePage['packages'] as $index => $package): ?>
                        <article
                            class="group rounded-3xl border border-border bg-card-inner p-7 transition duration-300 hover:-translate-y-1 hover:border-primary hover:shadow-xl">
                            <div class="flex items-center justify-between">
                                <span
                                    class="flex h-14 w-14 items-center justify-center rounded-2xl bg-card-outer text-2xl text-tertiary shadow-sm">
                                    <i class="<?= htmlspecialchars($package['icon'], ENT_QUOTES, 'UTF-8') ?>"
                                        aria-hidden="true"></i>
                                </span>
                                <span class="text-sm font-bold tracking-widest text-muted">0<?= $index + 1 ?></span>
                            </div>
                            <h3 class="mt-6 text-xl font-bold text-text">
                                <?= htmlspecialchars($package['title'], ENT_QUOTES, 'UTF-8') ?>
                            </h3>
                            <p class="mt-3 text-sm leading-7 text-muted">
                                <?= htmlspecialchars($package['description'], ENT_QUOTES, 'UTF-8') ?>
                            </p>
                            <ul class="mt-5 space-y-3">
                                <?php foreach ($package['items'] as $item): ?>
                                    <li class="flex items-start gap-3 text-sm leading-6 text-text">
                                        <i class="bx bx-check-circle mt-0.5 text-lg text-primary" aria-hidden="true"></i>
                                        <span><?= htmlspecialchars($item, ENT_QUOTES, 'UTF-8') ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <!-- :: END CARE PACKAGE DETAILS -->

        <!-- :: START CARE PAGE CTA -->
        <section class="px-6 py-16 sm:px-8 lg:py-20">
            <div
                class="relative mx-auto flex w-full max-w-350 flex-col gap-6 overflow-hidden rounded-4xl bg-tertiary px-7 py-10 text-white sm:px-10 lg:flex-row lg:items-center lg:justify-between lg:px-14 lg:py-12">
                <div aria-hidden="true"
                    class="absolute -right-10 -top-20 h-64 w-64 rounded-full border-35 border-white/10"></div>

                <!-- :: START APPOINTMENT CTA AND MODAL -->
                <div class="relative max-w-2xl">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-secondary">Give your pet the care they
                        deserve</p>
                    <h2 class="mt-3 text-2xl font-bold sm:text-3xl">
                        Ready to schedule <?= htmlspecialchars($carePage['shortName'], ENT_QUOTES, 'UTF-8') ?>?
                    </h2>
                    <p class="mt-3 text-sm leading-7 text-white/85">
                        Request an appointment and our team will help you find the right time for your pet.
                    </p>
                </div>

                <button data-modal-target="default-modal" data-modal-toggle="default-modal"
                    class="relative inline-flex w-fit shrink-0 items-center gap-2 rounded-xl bg-card-outer px-6 py-3.5 text-sm font-bold text-text transition hover:-translate-y-0.5 hover:bg-secondary"
                    type="button">
                    Request an appointment <i class="bx bx-arrow-up-right text-lg" aria-hidden="true"></i>
                </button>

                <div id="default-modal" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-text/50 backdrop-blur-sm">
                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-card-outer border border-border rounded-2xl shadow-xl p-4 md:p-6">
                            <!-- Modal header -->
                            <div class="flex items-center justify-between border-b border-border pb-4 md:pb-5">
                                <h3 class="text-lg font-primary font-semibold text-text uppercase">
                                    <?= htmlspecialchars($carePage['shortName'], ENT_QUOTES, 'UTF-8') ?>
                                </h3>
                                <button type="button"
                                    class="text-muted bg-transparent hover:bg-card-inner hover:text-text rounded-xl text-sm w-12 h-12 border border-gray-300/70 ms-auto inline-flex justify-center items-center"
                                    data-modal-hide="default-modal">
                                    <i class="bx bx-x text-2xl text-tertiary"></i>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="space-y-4 md:space-y-6 py-4 md:py-6 font-primary">
                                <p class="leading-relaxed text-muted">
                                    lorem
                                </p>
                                <p class="leading-relaxed text-muted">
                                    lorem
                                </p>
                                <p class="leading-relaxed text-muted">
                                    lorem
                                </p>
                            </div>
                            <!-- Modal footer -->
                            <div class="flex items-center border-t border-border space-x-4 pt-4 md:pt-5">
                                <p class="text-xs text-muted">Pawsitive</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- :: END APPOINTMENT CTA AND MODAL -->
            </div>
        </section>
        <!-- :: END CARE PAGE CTA -->
    </main>

    <!-- :: START SHARED CARE PAGE FOOTER -->
    <footer class="relative w-full overflow-hidden bg-black text-white">
        <?php include __DIR__ . '/../../includes/footer.php'; ?>
    </footer>
    <!-- :: END SHARED CARE PAGE FOOTER -->

    <script>
        const appointmentModal = document.getElementById('default-modal');

        document.querySelectorAll('[data-modal-toggle="default-modal"]').forEach((button) => {
            button.addEventListener('click', () => {
                appointmentModal.classList.remove('hidden');
                appointmentModal.classList.add('flex');
                appointmentModal.setAttribute('aria-hidden', 'false');
            });
        });

        document.querySelectorAll('[data-modal-hide="default-modal"]').forEach((button) => {
            button.addEventListener('click', () => {
                appointmentModal.classList.add('hidden');
                appointmentModal.classList.remove('flex');
                appointmentModal.setAttribute('aria-hidden', 'true');
            });
        });

        appointmentModal.addEventListener('click', (event) => {
            if (event.target === appointmentModal) {
                appointmentModal.classList.add('hidden');
                appointmentModal.classList.remove('flex');
                appointmentModal.setAttribute('aria-hidden', 'true');
            }
        });
    </script>
</body>

</html>