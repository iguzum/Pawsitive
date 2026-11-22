<?php
// :: START CARE PAGE AUTHENTICATION
require_once __DIR__ . '/../../vendor/autoload.php';
$careAuth = new \App\Controller\Authentication_Controller();
if (!$careAuth->isLogin()) {
    header('Location: ../login.php');
    exit();
}
if (strtolower((string) ($_SESSION['user_role'] ?? 'customer')) !== 'customer') {
    header('Location: ../index.php');
    exit();
}
if (!isset($carePage) || !is_array($carePage)) {
    http_response_code(404);
    exit();
}

// :: START CARE APPOINTMENT SUBMISSION
$careRequestError = '';
$careFormValues = [];
$careModalStep = 1;

if (
    ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST'
    && ($_POST['form_action'] ?? '') === 'submit_care_request'
) {
    $careFormValues = $_POST;
    $careRequestController = new \App\Controller\Service_Request_Controller();
    $careRequestResult = $careRequestController->submitRequest(
        $_POST,
        (int) ($_SESSION['user_id'] ?? 0)
    );

    if ($careRequestResult['success']) {
        header('Location: ../pages/schedule.php?care_request=success');
        exit();
    }

    $careRequestError = $careRequestResult['message'];
    $careModalStep = $careRequestResult['step'];
}

$escapeCareValue = static fn($value): string => htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
// :: END CARE APPOINTMENT SUBMISSION
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

                    <!-- :: START CARE MODAL HERO BUTTON -->
                    <button data-modal-target="care-modal" data-modal-toggle="care-modal"
                        class="inline-flex items-center gap-2 rounded-xl bg-tertiary px-6 py-3.5 text-sm font-bold text-white shadow-lg transition hover:-translate-y-0.5 hover:bg-primary">
                        Book now
                        <i class="bx bx-arrow-up-right text-lg" aria-hidden="true"></i>
                    </button>
                    <!-- :: END CARE MODAL HERO BUTTON -->

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

                <!-- :: START CARE MODAL CTA BUTTON -->
                <button data-modal-target="care-modal" data-modal-toggle="care-modal"
                    class="relative inline-flex w-fit shrink-0 items-center gap-2 rounded-xl bg-card-outer px-6 py-3.5 text-sm font-bold text-text transition hover:-translate-y-0.5 hover:bg-secondary"
                    type="button">
                    Request an appointment <i class="bx bx-arrow-up-right text-lg" aria-hidden="true"></i>
                </button>
                <!-- :: END CARE MODAL CTA BUTTON -->

                <!-- :: START CARE APPOINTMENT MODAL -->
                <div id="care-modal" aria-hidden="true" role="dialog" aria-modal="true"
                    aria-labelledby="care-modal-title"
                    class="hidden fixed inset-0 z-1000000 items-center justify-center overflow-y-auto bg-text/60 p-4 backdrop-blur-sm">
                    <div class="relative my-auto w-full max-w-2xl rounded-3xl border border-border bg-card-outer p-5 shadow-2xl sm:p-8">
                        <div class="mb-6 flex items-start justify-between gap-4 border-b border-border pb-5">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.18em] text-tertiary">Pet care appointment</p>
                                <h2 id="care-modal-title" class="mt-2 text-2xl font-bold text-text sm:text-3xl">Register the Pet</h2>
                                <p class="mt-2 text-sm text-muted">Step <span id="care-step-number">1</span> of 2</p>
                            </div>
                            <button type="button" data-care-modal-close aria-label="Close pet registration"
                                class="flex size-11 shrink-0 items-center justify-center rounded-xl border border-border text-muted transition hover:bg-card-inner hover:text-text">
                                <i class="bx bx-x text-2xl" aria-hidden="true"></i>
                            </button>
                        </div>

                        <?php if ($careRequestError !== ''): ?>
                            <p role="alert" class="mb-5 rounded-xl border border-primary/30 bg-primary/10 px-4 py-3 text-sm text-primary-hover">
                                <?= $escapeCareValue($careRequestError) ?>
                            </p>
                        <?php endif; ?>

                        <form id="care-request-form" method="post" novalidate>
                            <input type="hidden" name="form_action" value="submit_care_request">

                            <!-- :: START REGISTER PET STEP -->
                            <section data-care-step="1">
                                <div class="grid gap-5 sm:grid-cols-2">
                                    <div class="sm:col-span-2">
                                        <label for="care-pet-name" class="mb-2 block text-sm font-semibold text-text">Pet name</label>
                                        <input id="care-pet-name" name="pet_name" type="text" maxlength="100" value="<?= $escapeCareValue($careFormValues['pet_name'] ?? '') ?>" placeholder="Enter your pet's name" required
                                            class="w-full rounded-xl border border-border bg-background px-4 py-3 text-sm text-text outline-none transition placeholder:text-muted/70 focus:border-primary focus:ring-4 focus:ring-primary/10">
                                    </div>
                                    <div>
                                        <label for="care-pet-species" class="mb-2 block text-sm font-semibold text-text">Species</label>
                                        <select id="care-pet-species" name="species" required
                                            class="w-full rounded-xl border border-border bg-background px-4 py-3 text-sm text-text outline-none transition focus:border-primary focus:ring-4 focus:ring-primary/10">
                                            <option value="" disabled <?= empty($careFormValues['species']) ? 'selected' : '' ?>>Select species</option>
                                            <option value="Dog" <?= ($careFormValues['species'] ?? '') === 'Dog' ? 'selected' : '' ?>>Dog</option>
                                            <option value="Cat" <?= ($careFormValues['species'] ?? '') === 'Cat' ? 'selected' : '' ?>>Cat</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="care-pet-breed" class="mb-2 block text-sm font-semibold text-text">Breed</label>
                                        <input id="care-pet-breed" name="breed" type="text" maxlength="50" value="<?= $escapeCareValue($careFormValues['breed'] ?? '') ?>" placeholder="Enter breed"
                                            class="w-full rounded-xl border border-border bg-background px-4 py-3 text-sm text-text outline-none transition placeholder:text-muted/70 focus:border-primary focus:ring-4 focus:ring-primary/10">
                                    </div>
                                    <div>
                                        <label for="care-pet-age" class="mb-2 block text-sm font-semibold text-text">Age</label>
                                        <input id="care-pet-age" name="age" type="number" min="0" max="255" inputmode="numeric" value="<?= $escapeCareValue($careFormValues['age'] ?? '') ?>" placeholder="Enter age" required
                                            class="w-full rounded-xl border border-border bg-background px-4 py-3 text-sm text-text outline-none transition placeholder:text-muted/70 focus:border-primary focus:ring-4 focus:ring-primary/10">
                                    </div>
                                    <div>
                                        <label for="care-pet-sex" class="mb-2 block text-sm font-semibold text-text">Sex</label>
                                        <select id="care-pet-sex" name="sex" required
                                            class="w-full rounded-xl border border-border bg-background px-4 py-3 text-sm text-text outline-none transition focus:border-primary focus:ring-4 focus:ring-primary/10">
                                            <option value="" disabled <?= empty($careFormValues['sex']) ? 'selected' : '' ?>>Select sex</option>
                                            <option value="Male" <?= ($careFormValues['sex'] ?? '') === 'Male' ? 'selected' : '' ?>>Male</option>
                                            <option value="Female" <?= ($careFormValues['sex'] ?? '') === 'Female' ? 'selected' : '' ?>>Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mt-8 flex justify-end">
                                    <button type="button" id="care-next-step"
                                        class="inline-flex items-center gap-2 rounded-xl bg-tertiary px-6 py-3 text-sm font-semibold text-white transition hover:bg-tertiary-hover">
                                        Next <i class="bx bx-right-arrow-alt text-lg" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </section>
                            <!-- :: END REGISTER PET STEP -->

                            <!-- :: START APPOINTMENT DETAILS STEP -->
                            <section data-care-step="2" class="hidden">
                                <div class="grid gap-5 sm:grid-cols-2">
                                    <div>
                                        <label for="care-schedule-date" class="mb-2 block text-sm font-semibold text-text">Date to be scheduled</label>
                                        <input id="care-schedule-date" name="schedule_date" type="date" value="<?= $escapeCareValue($careFormValues['schedule_date'] ?? '') ?>" required
                                            class="w-full rounded-xl border border-border bg-background px-4 py-3 text-sm text-text outline-none transition focus:border-primary focus:ring-4 focus:ring-primary/10">
                                    </div>
                                    <div>
                                        <label for="care-service-id" class="mb-2 block text-sm font-semibold text-text">Care service</label>
                                        <select id="care-service-id" name="service_id" required
                                            class="w-full rounded-xl border border-border bg-background px-4 py-3 text-sm text-text outline-none transition focus:border-primary focus:ring-4 focus:ring-primary/10">
                                            <option value="" disabled <?= empty($careFormValues['service_id']) ? 'selected' : '' ?>>Select a service</option>
                                            <option value="1" <?= (string) ($careFormValues['service_id'] ?? '') === '1' ? 'selected' : '' ?>>General</option>
                                            <option value="2" <?= (string) ($careFormValues['service_id'] ?? '') === '2' ? 'selected' : '' ?>>Preventive</option>
                                            <option value="3" <?= (string) ($careFormValues['service_id'] ?? '') === '3' ? 'selected' : '' ?>>Hygiene</option>
                                            <option value="4" <?= (string) ($careFormValues['service_id'] ?? '') === '4' ? 'selected' : '' ?>>Diagnostic</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mt-8 flex flex-wrap justify-between gap-3">
                                    <button type="button" id="care-previous-step"
                                        class="rounded-xl border border-border bg-card-inner px-5 py-3 text-sm font-semibold text-text transition hover:bg-card-inner-hover">
                                        Back
                                    </button>
                                    <button type="submit"
                                        class="inline-flex items-center gap-2 rounded-xl bg-tertiary px-6 py-3 text-sm font-semibold text-white transition hover:bg-tertiary-hover">
                                        Submit <i class="bx bx-check text-lg" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </section>
                            <!-- :: END APPOINTMENT DETAILS STEP -->
                        </form>
                    </div>
                </div>
                <!-- :: END CARE APPOINTMENT MODAL -->

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
        // :: START CARE MODAL SCRIPT
        const appointmentModal = document.getElementById('care-modal');
        const careForm = document.getElementById('care-request-form');
        const careSteps = Array.from(document.querySelectorAll('[data-care-step]'));
        const careStepNumber = document.getElementById('care-step-number');

        function showCareStep(step) {
            careSteps.forEach((section) => {
                section.classList.toggle('hidden', Number(section.dataset.careStep) !== step);
            });
            careStepNumber.textContent = String(step);
        }

        document.querySelectorAll('[data-modal-toggle="care-modal"]').forEach((button) => {
            button.addEventListener('click', () => {
                appointmentModal.classList.remove('hidden');
                appointmentModal.classList.add('flex');
                appointmentModal.setAttribute('aria-hidden', 'false');
            });
        });

        document.querySelectorAll('[data-care-modal-close]').forEach((button) => {
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

        document.getElementById('care-next-step').addEventListener('click', () => {
            const firstStep = document.querySelector('[data-care-step="1"]');
            const requiredFields = Array.from(firstStep.querySelectorAll('[required]'));
            const firstInvalidField = requiredFields.find((field) => !field.checkValidity());

            if (firstInvalidField) {
                firstInvalidField.reportValidity();
                return;
            }

            showCareStep(2);
        });

        document.getElementById('care-previous-step').addEventListener('click', () => {
            showCareStep(1);
        });

        careForm.addEventListener('submit', (event) => {
            const firstInvalidStep = careSteps.find((section) =>
                Array.from(section.querySelectorAll('[required]')).some((field) => !field.checkValidity())
            );

            if (firstInvalidStep) {
                event.preventDefault();
                const stepNumber = Number(firstInvalidStep.dataset.careStep);
                showCareStep(stepNumber);
                const firstInvalidField = Array.from(firstInvalidStep.querySelectorAll('[required]'))
                    .find((field) => !field.checkValidity());
                firstInvalidField.reportValidity();
            }
        });

        appointmentModal.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                appointmentModal.classList.add('hidden');
                appointmentModal.classList.remove('flex');
                appointmentModal.setAttribute('aria-hidden', 'true');
            }
        });

        const scheduleDateInput = document.getElementById('care-schedule-date');
        scheduleDateInput.min = new Date().toISOString().split('T')[0];

        <?php if ($careRequestError !== ''): ?>
            appointmentModal.classList.remove('hidden');
            appointmentModal.classList.add('flex');
            appointmentModal.setAttribute('aria-hidden', 'false');
            showCareStep(<?= (int) $careModalStep ?>);
        <?php endif; ?>
        // :: END CARE MODAL SCRIPT
    </script>
</body>

</html>
