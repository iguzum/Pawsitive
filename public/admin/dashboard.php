<?php
// :: START ADMIN DASHBOARD ACCESS
require_once __DIR__ . '/../../vendor/autoload.php';
$dashboardAuth = new \App\Controller\Authentication_Controller();

if (!$dashboardAuth->isLogin()) {
    header('Location: ../login.php');
    exit();
}

if (strtolower((string) ($_SESSION['user_role'] ?? 'customer')) !== 'admin') {
    header('Location: ../index.php');
    exit();
}
// :: END ADMIN DASHBOARD ACCESS
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/output.css">
    <link href="https://cdn.boxicons.com/3.0.8/fonts/basic/boxicons.min.css" rel="stylesheet">
    <title>Admin Dashboard | PAWSITIVE</title>
</head>

<body class="min-h-screen bg-background text-text antialiased">
    <!-- :: START ADMIN DASHBOARD DESIGN -->
    <div class="fixed inset-x-0 top-0 z-50 border-b border-border bg-card-outer/95 backdrop-blur">
        <div class="mx-auto max-w-350 px-4 sm:px-8">
            <?php include __DIR__ . '/../../includes/header.php'; ?>
        </div>
    </div>

    <main class="mx-auto w-full max-w-350 px-4 pb-16 pt-28 sm:px-8">
        <section class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.22em] text-tertiary">PAWSITIVE · ADMIN</p>
                <h1 class="mt-2 text-3xl font-bold sm:text-4xl">Dashboard</h1>
                <p class="mt-2 text-sm text-muted">A simple overview of your adoption center.</p>
            </div>
            <span
                class="inline-flex w-fit items-center gap-2 rounded-full border border-border bg-card-outer px-4 py-2 text-sm text-muted">
                <i class="bx bx-calendar text-primary" aria-hidden="true"></i>
                <?= date('F Y') ?>
            </span>
        </section>

        <section class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4" aria-label="Monthly overview">
            <article class="rounded-3xl border border-border bg-card-outer p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-muted">
                        Adoption applicants
                    </span>
                    <i class="bx bx-heart rounded-xl bg-card-inner p-2 text-xl text-tertiary"></i>
                </div>
                <p class="mt-5 text-3xl font-bold">18</p>
                <p class="mt-1 text-xs text-muted">4 awaiting review</p>
            </article>
            <article class="rounded-3xl border border-border bg-card-outer p-5 shadow-sm">
                <div class="flex items-center justify-between"><span class="text-sm text-muted">Active staff</span><i
                        class="bx bx-group rounded-xl bg-card-inner p-2 text-xl text-primary"></i></div>
                <p class="mt-5 text-3xl font-bold">06</p>
                <p class="mt-1 text-xs text-muted">Across the adoption center</p>
            </article>
            <article class="rounded-3xl border border-border bg-card-outer p-5 shadow-sm">
                <div class="flex items-center justify-between"><span class="text-sm text-muted">Service
                        bookings</span><i class="bx bx-calendar rounded-xl bg-card-inner p-2 text-xl text-tertiary"></i>
                </div>
                <p class="mt-5 text-3xl font-bold">32</p>
                <p class="mt-1 text-xs text-muted">Scheduled this month</p>
            </article>
            <article class="rounded-3xl border border-border bg-card-outer p-5 shadow-sm">
                <div class="flex items-center justify-between"><span class="text-sm text-muted">Monthly service
                        rate</span><i class="bx bx-trending-up rounded-xl bg-card-inner p-2 text-xl text-primary"></i>
                </div>
                <p class="mt-5 text-3xl font-bold">74%</p>
                <p class="mt-1 text-xs text-muted">Illustrative report preview</p>
            </article>
        </section>

        <section class="mt-8 grid gap-5 xl:grid-cols-[1.4fr_0.8fr]">
            <article class="overflow-hidden rounded-3xl border border-border bg-card-outer shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-border px-5 py-5 sm:px-6">
                    <div>
                        <h2 class="text-lg font-bold">Team directory</h2>
                        <p class="mt-1 text-sm text-muted">Staff overview and sample management controls.</p>
                    </div>
                    <button type="button"
                        class="inline-flex items-center gap-2 rounded-xl bg-tertiary px-4 py-2.5 text-sm font-bold text-white transition hover:bg-tertiary-hover"><i
                            class="bx bx-plus" aria-hidden="true"></i>Add staff</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-130 text-left text-sm">
                        <thead class="bg-card-inner text-xs uppercase tracking-wide text-muted">
                            <tr>
                                <th class="px-3 py-3 sm:px-6">Name</th>
                                <th class="px-3 py-3">Role</th>
                                <th class=" px-3 py-3 text-right sm:px-6">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            <tr>
                                <td class=" px-3 py-4 font-semibold sm:px-6">Taylor Cruz</td>
                                <td class=" px-3 py-4 text-muted">Staff</td>
                                <td class="py-4 text-right px-3 sm:px-6">
                                    <button type="button"
                                        class=" text-primary border cursor-pointer border-primary py-1 px-2 rounded-lg mr-1 hover:bg-primary hover:text-text hover:rounded-non transition-all duration-200">
                                        Edit
                                    </button>

                                    <button type="button"
                                        class="text-tertiary cursor-pointer border border-tertiary py-1 px-2 rounded-lg hover:bg-tertiary hover:text-white hover:rounded-non transition-all duration-200">
                                        Remove
                                    </button>
                                </td>
                            </tr>


                        </tbody>
                    </table>
                </div>
            </article>

            <article class="rounded-3xl border border-border bg-card-outer p-5 shadow-sm sm:p-6">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-bold">Monthly service report</h2>
                        <p class="mt-1 text-sm text-muted">Booking activity · illustrative preview</p>
                    </div><i class="bx bx-bar-chart-alt-2 rounded-xl bg-card-inner p-2 text-xl text-tertiary"></i>
                </div>
                <div class="mt-7 flex h-40 items-end gap-3 border-b border-border px-2">
                    <div class="h-[42%] flex-1 rounded-t-lg bg-primary/45"></div>
                    <div class="h-[58%] flex-1 rounded-t-lg bg-primary/60"></div>
                    <div class="h-[49%] flex-1 rounded-t-lg bg-primary/55"></div>
                    <div class="h-[76%] flex-1 rounded-t-lg bg-tertiary"></div>
                    <div class="h-[64%] flex-1 rounded-t-lg bg-primary/70"></div>
                    <div class="h-[88%] flex-1 rounded-t-lg bg-tertiary/80"></div>
                </div>
                <div class="mt-3 flex justify-between text-xs text-muted">
                    <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>May</span><span>Jun</span>
                </div>
                <div class="mt-6 rounded-2xl bg-card-inner p-4">
                    <p class="text-xs text-muted">Bookings this month</p>
                    <p class="mt-1 text-2xl font-bold">32 <span class="text-sm font-medium text-primary-hover">↑
                            8%</span></p>
                </div>
            </article>
        </section>

        <section class="mt-5 rounded-3xl border border-border bg-card-outer p-5 shadow-sm sm:p-6">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h2 class="text-lg font-bold">Adoption listings</h2>
                    <p class="mt-1 text-sm text-muted">Example pets and visual-only management controls.</p>
                </div>
                <!-- <button type="button"
                    class="inline-flex items-center gap-2 rounded-xl border border-border px-4 py-2.5 text-sm font-bold transition hover:bg-card-inner"><i
                        class="bx bx-plus" aria-hidden="true"></i>Add listing
                </button> -->
            </div>
            <div class="mt-5 grid grid-cols-1">
                <div class="flex items-center justify-between gap-3 rounded-2xl bg-background p-4">
                    <div>
                        <p class="font-bold">Bella</p>
                        <p class="mt-1 text-xs text-muted">Dog · Available</p>
                    </div>
                    <div class="flex gap-3 text-sm"><button type="button"
                            class="font-semibold text-primary-hover">Edit</button><button type="button"
                            class="font-semibold text-tertiary">Remove</button>
                    </div>
                </div>

            </div>
        </section>
        <p class="mt-5 text-center text-xs text-muted">Sample dashboard content · controls are for design preview only.
        </p>
    </main>
    <!-- :: END ADMIN DASHBOARD DESIGN -->
</body>

</html>