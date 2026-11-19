<?php
// :: START STAFF DASHBOARD ACCESS
require_once __DIR__ . '/../../vendor/autoload.php';
$dashboardAuth = new \App\Controller\Authentication_Controller();

if (!$dashboardAuth->isLogin()) {
    header('Location: ../login.php');
    exit();
}

if (strtolower((string) ($_SESSION['user_role'] ?? 'customer')) !== 'staff') {
    header('Location: ../index.php');
    exit();
}
// :: END STAFF DASHBOARD ACCESS
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#fff9f0">
    <link rel="stylesheet" href="../src/output.css">
    <link href="https://cdn.boxicons.com/3.0.8/fonts/basic/boxicons.min.css" rel="stylesheet">
    <title>Staff Schedules | PAWSITIVE</title>
</head>

<body class="min-h-screen bg-background text-text antialiased">
    <!-- :: START STAFF DASHBOARD DESIGN -->
    <div class="fixed inset-x-0 top-0 z-50 border-b border-border bg-card-outer/95 backdrop-blur">
        <div class="mx-auto max-w-350 px-4 sm:px-8">
            <?php include __DIR__ . '/../../includes/header.php'; ?>
        </div>
    </div>

    <main class="mx-auto w-full max-w-350 px-4 pb-16 pt-28 sm:px-8">
        <section class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.22em] text-tertiary">PAWSITIVE · STAFF</p>
                <h1 class="mt-2 text-3xl font-bold sm:text-4xl">Your schedules</h1>
                <p class="mt-2 text-sm text-muted">Today’s service visits and adoption applicants.</p>
            </div>
            <span
                class="inline-flex w-fit items-center gap-2 rounded-full border border-border bg-card-outer px-4 py-2 text-sm text-muted"><i
                    class="bx bx-calendar text-primary" aria-hidden="true"></i><?= date('l, F j') ?></span>
        </section>

        <section class="mt-8 grid gap-4 sm:grid-cols-3" aria-label="Staff overview">
            <article class="rounded-3xl border border-border bg-card-outer p-5 shadow-sm">
                <p class="text-sm text-muted">Today’s appointments</p>
                <p class="mt-4 text-3xl font-bold">05</p>
                <p class="mt-1 text-xs text-muted">Across all services</p>
            </article>
            <article class="rounded-3xl border border-border bg-card-outer p-5 shadow-sm">
                <p class="text-sm text-muted">Applicants to review</p>
                <p class="mt-4 text-3xl font-bold">04</p>
                <p class="mt-1 text-xs text-muted">Sample application queue</p>
            </article>
            <article class="rounded-3xl border border-border bg-card-outer p-5 shadow-sm">
                <p class="text-sm text-muted">Next appointment</p>
                <p class="mt-4 text-2xl font-bold">10:30 AM</p>
                <p class="mt-1 text-xs text-muted">Luna · Preventive care</p>
            </article>
        </section>

        <section class="mt-8 grid gap-5 xl:grid-cols-[1.15fr_0.85fr]">
            <article class="overflow-hidden rounded-3xl border border-border bg-card-outer shadow-sm">
                <div class="border-b border-border px-5 py-5 sm:px-6">
                    <h2 class="text-lg font-bold">Client service schedule</h2>
                    <p class="mt-1 text-sm text-muted">Upcoming visits for today · sample entries</p>
                </div>

                <!-- SCHEDULE APPLICATIONS CONTAINER -->
                <div class="divide-y divide-border">
                    <div class="flex flex-col gap-3 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                        <div class="flex items-center gap-4"><span
                                class="rounded-xl bg-card-inner px-3 py-2 text-sm font-bold text-tertiary">09:00</span>
                            <div>
                                <p class="font-bold">Luna · Preventive care</p>
                                <p class="mt-1 text-xs text-muted">Avery Santos · Wellness check</p>
                            </div>
                        </div><span
                            class="w-fit rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold text-primary-hover">Confirmed</span>
                    </div>
                    <div class="flex flex-col gap-3 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                        <div class="flex items-center gap-4"><span
                                class="rounded-xl bg-card-inner px-3 py-2 text-sm font-bold text-tertiary">10:30</span>
                            <div>
                                <p class="font-bold">Mochi · Hygiene care</p>
                                <p class="mt-1 text-xs text-muted">Sam Delgado · Grooming visit</p>
                            </div>
                        </div><span
                            class="w-fit rounded-full bg-secondary/30 px-3 py-1 text-xs font-semibold">Arriving</span>
                    </div>
                    <div class="flex flex-col gap-3 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                        <div class="flex items-center gap-4"><span
                                class="rounded-xl bg-card-inner px-3 py-2 text-sm font-bold text-tertiary">01:00</span>
                            <div>
                                <p class="font-bold">Oliver · General care</p>
                                <p class="mt-1 text-xs text-muted">Jordan Lim · Follow-up visit</p>
                            </div>
                        </div><span
                            class="w-fit rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold text-primary-hover">Confirmed</span>
                    </div>
                    <div class="flex flex-col gap-3 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                        <div class="flex items-center gap-4"><span
                                class="rounded-xl bg-card-inner px-3 py-2 text-sm font-bold text-tertiary">02:30</span>
                            <div>
                                <p class="font-bold">Daisy · Diagnostic care</p>
                                <p class="mt-1 text-xs text-muted">Casey Tan · Consultation</p>
                            </div>
                        </div><span
                            class="w-fit rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold text-primary-hover">Confirmed</span>
                    </div>
                </div>
                <!-- SCHEDULE APPLICATIONS CONTAINER -->
            </article>

            <article class="overflow-hidden rounded-3xl border border-border bg-card-outer shadow-sm">
                <div class="flex items-center justify-between gap-3 border-b border-border px-5 py-5 sm:px-6">
                    <div>
                        <h2 class="text-lg font-bold">Adoption applicants</h2>
                        <p class="mt-1 text-sm text-muted">Recent applications · sample entries</p>
                    </div><span class="rounded-full bg-tertiary/10 px-3 py-1 text-xs font-bold text-tertiary">4
                        new</span>
                </div>
                <!-- :: ADOPTION APPLICANTS CONTAINER -->
                <div class="divide-y divide-border">
                    <div class="flex items-center justify-between gap-3 px-5 py-5 sm:px-6">
                        <div>
                            <p class="font-bold">Alex Morgan</p>
                            <p class="mt-1 text-xs text-muted">Interested in Bella · Nov 16</p>
                        </div><button type="button"
                            class="rounded-xl border border-border px-3 py-2 text-xs font-bold transition hover:bg-card-inner">View</button>
                    </div>
                    <div class="flex items-center justify-between gap-3 px-5 py-5 sm:px-6">
                        <div>
                            <p class="font-bold">Jamie Park</p>
                            <p class="mt-1 text-xs text-muted">Interested in Milo · Nov 15</p>
                        </div><button type="button"
                            class="rounded-xl border border-border px-3 py-2 text-xs font-bold transition hover:bg-card-inner">View</button>
                    </div>
                    <div class="flex items-center justify-between gap-3 px-5 py-5 sm:px-6">
                        <div>
                            <p class="font-bold">Robin Garcia</p>
                            <p class="mt-1 text-xs text-muted">Interested in Coco · Nov 14</p>
                        </div><button type="button"
                            class="rounded-xl border border-border px-3 py-2 text-xs font-bold transition hover:bg-card-inner">View</button>
                    </div>
                </div>
                <!-- :: ADOPTION APPLICANTS CONTAINER -->
                <div class="border-t border-border bg-background px-5 py-4 text-xs text-muted sm:px-6">Application
                    details and review actions are design placeholders.</div>
            </article>
        </section>
        <p class="mt-5 text-center text-xs text-muted">Sample dashboard content · schedule and applicant controls are
            for design preview only.</p>
    </main>
    <!-- :: END STAFF DASHBOARD DESIGN -->
</body>

</html>