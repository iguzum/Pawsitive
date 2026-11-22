<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Controller\Authentication_Controller;
use App\Controller\Adoption_Application_Controller;

// :: START CUSTOMER SCHEDULE PAGE DATA
$auth = new Authentication_Controller();

if (!$auth->isLogin()) {
    header('Location: ../login.php');
    exit();
}

if (strtolower((string) ($_SESSION['user_role'] ?? 'customer')) !== 'customer') {
    header('Location: ../index.php');
    exit();
}

$scheduleController = new Adoption_Application_Controller();
$schedule = $scheduleController->getCustomerSchedule((int) ($_SESSION['user_id'] ?? 0));
$careRequestSubmitted = ($_GET['care_request'] ?? '') === 'success';
$escapeValue = static fn($value): string => htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
// :: END CUSTOMER SCHEDULE PAGE DATA
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#fff9f0">
    <link rel="stylesheet" href="../src/output.css">
    <link href="https://cdn.boxicons.com/3.0.8/fonts/basic/boxicons.min.css" rel="stylesheet">
    <title>My Schedule | PAWSITIVE</title>
</head>

<body class="flex min-h-screen flex-col bg-background text-text antialiased">
    <!-- :: START CUSTOMER SCHEDULE HEADER -->
    <div class="fixed inset-x-0 top-0 z-50 border-b border-border bg-card-outer/95 backdrop-blur">
        <div class="mx-auto max-w-350 px-4 sm:px-8">
            <?php include __DIR__ . '/../../includes/header.php'; ?>
        </div>
    </div>
    <!-- :: END CUSTOMER SCHEDULE HEADER -->

    <!-- :: START CUSTOMER SCHEDULE CONTENT -->
    <main class="mx-auto flex w-full max-w-350 flex-1 flex-col px-4 pb-16 pt-32 sm:px-8">
        <section class="mb-8">
            <p class="text-xs font-bold uppercase tracking-[0.22em] text-tertiary">PAWSITIVE · CUSTOMER</p>
            <h1 class="mt-2 text-3xl font-bold sm:text-4xl">My Schedule</h1>
            <p class="mt-2 text-sm text-muted">Check the status of your adoption applications and care requests.</p>
        </section>

        <?php if ($careRequestSubmitted): ?>
            <p role="status" class="mb-6 rounded-xl border border-primary/30 bg-primary/10 px-4 py-3 text-sm text-primary-hover">
                Your care appointment has been submitted and added to your schedule.
            </p>
        <?php endif; ?>

        <div class="grid gap-6 lg:grid-cols-2">
            <section class="overflow-hidden rounded-3xl border border-border bg-card-outer shadow-sm">
                <div class="border-b border-border px-5 py-5">
                    <h2 class="text-lg font-bold">Adoption applications</h2>
                </div>
                <div class="divide-y divide-border py-2">
                    <?php if ($schedule['adoption_applications'] === []): ?>
                        <p class="px-5 py-6 text-sm text-muted">You have no adoption applications yet.</p>
                    <?php else: ?>
                        <?php foreach ($schedule['adoption_applications'] as $application): ?>
                            <article class="flex flex-wrap items-center justify-between gap-3 px-5 py-5">
                                <div>
                                    <p class="font-semibold text-text"><?= $escapeValue($application['adoption_pet_name']) ?>
                                    </p>
                                    <p class="mt-1 text-xs text-muted">
                                        Applied <?= $escapeValue($application['application_date']) ?>
                                    </p>
                                </div>
                                <span class="rounded-full bg-secondary/40 px-3 py-1 text-xs font-semibold text-text">
                                    <?= $escapeValue($application['status']) ?>
                                </span>
                            </article>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>

            <section class="overflow-hidden rounded-3xl border border-border bg-card-outer shadow-sm">
                <div class="border-b border-border px-5 py-5">
                    <h2 class="text-lg font-bold">Care service requests</h2>
                </div>
                <div class="divide-y divide-border py-2">
                    <?php if ($schedule['service_requests'] === []): ?>
                        <p class="px-5 py-6 text-sm text-muted mt-2">You have no care requests yet.</p>
                    <?php else: ?>
                        <?php foreach ($schedule['service_requests'] as $request): ?>
                            <article class="flex flex-wrap items-center justify-between gap-3 px-5 py-5">
                                <div>
                                    <p class="font-semibold text-text">
                                        <?= $escapeValue($request['pet_name']) ?>
                                        · <?= $escapeValue($request['service_name']) ?>
                                    </p>
                                    <p class="mt-1 text-xs text-muted">
                                        Scheduled <?= $escapeValue($request['schedule_date']) ?>
                                    </p>
                                </div>
                                <span class="rounded-full bg-secondary/40 px-3 py-1 text-xs font-semibold text-text">
                                    <?= $escapeValue($request['status'] ?: 'Pending') ?>
                                </span>
                            </article>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </main>
    <!-- :: END CUSTOMER SCHEDULE CONTENT -->

    <!-- :: START CUSTOMER SCHEDULE FOOTER -->
    <footer class="relative mt-auto w-full overflow-hidden bg-black text-white">
        <?php include __DIR__ . '/../../includes/footer.php'; ?>
    </footer>
    <!-- :: END CUSTOMER SCHEDULE FOOTER -->
</body>

</html>
