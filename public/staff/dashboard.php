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

$dashboardController = new \App\Controller\Adoption_Application_Controller();
$statusMessage = '';

if (
    ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST'
    && ($_POST['form_action'] ?? '') === 'update_status'
) {
    $statusMessage = $dashboardController->updateStaffStatus($_POST);
}

// :: START STAFF DELETE ACTION
if (
    ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST'
    && in_array($_POST['form_action'] ?? '', ['delete_adoption', 'delete_service_request'], true)
) {
    $statusMessage = $dashboardController->removeStaffRecord($_POST);
}
// :: END STAFF DELETE ACTION

$dashboardData = $dashboardController->getStaffDashboard();
$escapeValue = static fn($value): string => htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
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
    <title>Staff Dashboard | PAWSITIVE</title>
</head>

<body class="min-h-screen bg-background text-text antialiased">
    <!-- :: START STAFF DASHBOARD -->
    <div class="fixed inset-x-0 top-0 z-50 border-b border-border bg-card-outer/95 backdrop-blur">
        <div class="mx-auto max-w-350 px-4 sm:px-8">
            <?php include __DIR__ . '/../../includes/header.php'; ?>
        </div>
    </div>

    <main class="mx-auto w-full max-w-350 px-4 pb-16 pt-28 sm:px-8">
        <section class="mb-8">
            <p class="text-xs font-bold uppercase tracking-[0.22em] text-tertiary">PAWSITIVE · STAFF</p>
            <h1 class="mt-2 text-3xl font-bold sm:text-4xl">Dashboard</h1>
            <p class="mt-2 text-sm text-muted">Review adoption applications and care service requests.</p>
        </section>

        <?php if ($statusMessage !== ''): ?>
            <p role="status"
                class="mb-6 rounded-xl border border-primary/30 bg-primary/10 px-4 py-3 text-sm text-primary-hover">
                <?= $escapeValue($statusMessage) ?>
            </p>
        <?php endif; ?>

        <section class="mb-8 overflow-hidden rounded-3xl border border-border bg-card-outer shadow-sm">
            <div class="border-b border-border px-5 py-5 sm:px-6">
                <h2 class="text-lg font-bold">Adoption applications</h2>
            </div>
            <div class="divide-y divide-border py-2">
                <?php if ($dashboardData['adoption_applications'] === []): ?>
                    <p class="px-5 py-6 text-sm text-muted">There are no adoption applications yet.</p>
                <?php else: ?>
                    <?php foreach ($dashboardData['adoption_applications'] as $application): ?>
                        <?php $modalId = 'application-details-' . (int) $application['application_id']; ?>
                        <article class="flex flex-col gap-4 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                            <div>
                                <p class="font-bold uppercase">
                                    <?= $escapeValue(trim(($application['first_name'] ?? '') . ' ' . ($application['last_name'] ?? ''))) ?>
                                    · <?= $escapeValue($application['adoption_pet_name']) ?>
                                </p>
                                <p class="mt-1 text-xs text-muted">
                                    <?= $escapeValue($application['email']) ?>
                                    · Applied <?= $escapeValue($application['application_date']) ?>
                                </p>

                            </div>

                            <!-- :: START ADOPTION APPLICATION VIEW AND STATUS -->
                            <div class="flex flex-wrap items-center gap-2">

                                <form method="post" class="flex flex-wrap items-center gap-2">
                                    <input type="hidden" name="form_action" value="update_status">
                                    <input type="hidden" name="record_type" value="adoption">
                                    <input type="hidden" name="record_id" value="<?= (int) $application['application_id'] ?>">
                                    <select name="status" aria-label="Adoption application status"
                                        class="rounded-xl border border-border bg-background px-3 py-2 text-sm text-text">
                                        <?php foreach (['Pending', 'Approved', 'Rejected'] as $status): ?>
                                            <option value="<?= $status ?>" <?= $application['status'] === $status ? 'selected' : '' ?>>
                                                <?= $status ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="button" data-application-open="<?= $escapeValue($modalId) ?>"
                                        class="rounded-xl border border-border px-4 py-2 text-sm text-text transition hover:bg-card-inner">
                                        View
                                    </button>
                                    <button type="submit"
                                        class="rounded-xl bg-tertiary px-4 py-2 text-sm font-semibold text-white hover:bg-primary">
                                        Save
                                    </button>
                                </form>
                                <!-- :: START REMOVE ADOPTION APPLICATION BUTTON -->
                                <form method="post" class="staff-delete-form">
                                    <input type="hidden" name="form_action" value="delete_adoption">
                                    <input type="hidden" name="record_id" value="<?= (int) $application['application_id'] ?>">
                                    <button type="submit" class="inline-flex items-center gap-2 rounded-xl border border-red-300 px-4 py-2 text-sm font-semibold text-red-700 transition hover:bg-red-50">
                                        <i class="bx bx-trash" aria-hidden="true"></i>
                                        Remove
                                    </button>
                                </form>
                                <!-- :: END REMOVE ADOPTION APPLICATION BUTTON -->
                            </div>
                            <!-- :: END ADOPTION APPLICATION VIEW AND STATUS -->

                            <!-- :: START ADOPTION APPLICATION DETAILS MODAL -->
                            <div id="<?= $escapeValue($modalId) ?>" aria-hidden="true" role="dialog" aria-modal="true"
                                aria-labelledby="<?= $escapeValue($modalId) ?>-title"
                                class="hidden fixed inset-0 z-1000000 items-center justify-center overflow-y-auto bg-text/60 p-4 backdrop-blur-sm">
                                <section
                                    class="relative my-auto w-full max-w-2xl rounded-3xl border border-border bg-card-outer p-5 shadow-2xl sm:p-8">
                                    <div class="mb-6 flex items-start justify-between gap-4 border-b border-border pb-5">
                                        <div>
                                            <p class="text-xs font-bold uppercase tracking-[0.18em] text-tertiary">Adoption
                                                applicant</p>
                                            <h2 id="<?= $escapeValue($modalId) ?>-title"
                                                class="mt-2 text-2xl font-bold text-text sm:text-3xl">
                                                Application details
                                            </h2>
                                        </div>
                                        <button type="button" data-application-close aria-label="Close application details"
                                            class="flex size-11 shrink-0 items-center justify-center rounded-xl border border-border text-muted transition hover:bg-card-inner hover:text-text">
                                            <i class="bx bx-x text-2xl" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    <div class="grid gap-5 text-sm sm:grid-cols-2">
                                        <div>
                                            <p class="font-semibold text-muted">Applicant</p>
                                            <p class="mt-1 text-text uppercase">
                                                <?= $escapeValue(trim(($application['first_name'] ?? '') . ' ' . ($application['last_name'] ?? ''))) ?: 'Not provided' ?>
                                            </p>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-muted">Age</p>
                                            <p class="mt-1 text-text">
                                                <?= $escapeValue($application['applicant_age'] ?? '') ?: 'Not provided' ?>
                                            </p>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-muted">Email</p>
                                            <p class="mt-1 break-all text-text">
                                                <?= $escapeValue($application['email'] ?? '') ?: 'Not provided' ?>
                                            </p>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-muted">Application date</p>
                                            <p class="mt-1 text-text">
                                                <?= $escapeValue($application['application_date'] ?? '') ?: 'Not provided' ?>
                                            </p>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-muted">Status</p>
                                            <p class="mt-1 text-text">
                                                <?= $escapeValue($application['status'] ?? '') ?: 'Not provided' ?>
                                            </p>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-muted">Pet</p>
                                            <p class="mt-1 text-text">
                                                <?= $escapeValue($application['adoption_pet_name'] ?? '') ?: 'Not provided' ?>
                                            </p>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-muted">Monthly income</p>
                                            <p class="mt-1 text-text">
                                                <?= !empty($application['monthly_income']) ? '₱' . $escapeValue($application['monthly_income']) : 'Not provided' ?>
                                            </p>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-muted">Species / breed</p>
                                            <p class="mt-1 text-text uppercase">
                                                <?= $escapeValue(trim(($application['species'] ?? '') . ' / ' . ($application['breed'] ?? ''), ' /')) ?: 'Not provided' ?>
                                            </p>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-muted">Address</p>
                                            <p class="mt-1 text-text">
                                                <?= $escapeValue($application['address'] ?? '') ?: 'Not provided' ?>
                                            </p>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-muted">Pet age / sex</p>
                                            <p class="mt-1 text-text">
                                                <?= $escapeValue(trim(($application['pet_age'] ?? '') . ' / ' . ($application['pet_sex'] ?? ''), ' /')) ?: 'Not provided' ?>
                                            </p>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-muted">Occupation</p>
                                            <p class="mt-1 text-text uppercase">
                                                <?= $escapeValue($application['occupation'] ?? '') ?: 'Not provided' ?>
                                            </p>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-muted">Household members</p>
                                            <p class="mt-1 text-text">
                                                <?= $escapeValue($application['household_members'] ?? '') ?: 'Not provided' ?>
                                            </p>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-muted">Committed to care</p>
                                            <p class="mt-1 text-text">
                                                <?= ($application['is_committed'] ?? '') === 'Y' ? 'Yes' : (($application['is_committed'] ?? '') === 'N' ? 'No' : 'Not provided') ?>
                                            </p>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <p class="font-semibold text-muted">Reason for adoption</p>
                                            <p class="mt-1 whitespace-pre-line text-text">
                                                <?= $escapeValue($application['reason_for_adoption'] ?? '') ?: 'Not provided' ?>
                                            </p>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <!-- :: END ADOPTION APPLICATION DETAILS MODAL -->
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

        <section class="overflow-hidden rounded-3xl border border-border bg-card-outer shadow-sm">
            <div class="border-b border-border px-5 py-5 sm:px-6">
                <h2 class="text-lg font-bold">Care service requests</h2>
            </div>
            <div class="divide-y divide-border py-5">
                <?php if ($dashboardData['service_requests'] === []): ?>
                    <p class="px-5 py-6 text-sm text-muted">There are no care service requests yet.</p>
                <?php else: ?>
                    <?php foreach ($dashboardData['service_requests'] as $request): ?>
                        <article class="flex flex-col gap-4 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                            <div>
                                <p class="font-bold">
                                    <?= $escapeValue($request['pet_name']) ?>
                                    · <?= $escapeValue($request['service_name']) ?>
                                </p>
                                <p class="mt-1 text-xs text-muted">
                                    <?= $escapeValue(trim(($request['first_name'] ?? '') . ' ' . ($request['last_name'] ?? ''))) ?>
                                    · <?= $escapeValue($request['email']) ?>
                                    · Scheduled <?= $escapeValue($request['schedule_date']) ?>
                                </p>
                            </div>

                            <!-- :: START RIGHT ALIGNED CARE REQUEST ACTIONS -->
                            <div class="flex flex-wrap items-center gap-2 sm:ml-auto sm:justify-end">
                                <form method="post" class="flex flex-wrap items-center gap-2">
                                    <input type="hidden" name="form_action" value="update_status">
                                    <input type="hidden" name="record_type" value="service">
                                    <input type="hidden" name="record_id" value="<?= (int) $request['request_id'] ?>">
                                    <?php $requestStatus = $request['status'] ?: 'Pending'; ?>
                                    <select name="status" aria-label="Service request status"
                                        class="rounded-xl border border-border bg-background px-3 py-2 text-sm text-text">
                                        <?php foreach (['Pending', 'Approved', 'Rejected'] as $status): ?>
                                            <option value="<?= $status ?>" <?= $requestStatus === $status ? 'selected' : '' ?>>
                                                <?= $status ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="submit"
                                        class="rounded-xl bg-tertiary px-4 py-2 text-sm font-semibold text-white hover:bg-primary">
                                        Save
                                    </button>
                                </form>
                                <!-- :: START REMOVE CARE APPOINTMENT BUTTON -->
                                <form method="post" class="staff-delete-form">
                                    <input type="hidden" name="form_action" value="delete_service_request">
                                    <input type="hidden" name="record_id" value="<?= (int) $request['request_id'] ?>">
                                    <button type="submit" class="inline-flex items-center gap-2 rounded-xl border border-red-300 px-4 py-2 text-sm font-semibold text-red-700 transition hover:bg-red-50">
                                        <i class="bx bx-trash" aria-hidden="true"></i>
                                        Remove
                                    </button>
                                </form>
                                <!-- :: END REMOVE CARE APPOINTMENT BUTTON -->
                            </div>
                            <!-- :: END RIGHT ALIGNED CARE REQUEST ACTIONS -->
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <!-- :: START STAFF DELETE CONFIRMATION MODAL -->
    <div id="staff-delete-modal" aria-hidden="true" role="dialog" aria-modal="true"
        aria-labelledby="staff-delete-title"
        class="hidden fixed inset-0 z-1000000 items-center justify-center bg-text/60 p-4 backdrop-blur-sm">
        <section class="w-full max-w-md rounded-3xl border border-border bg-card-outer p-6 shadow-2xl">
            <div class="mx-auto flex size-14 items-center justify-center rounded-full bg-red-100 text-red-600">
                <i class="bx bx-trash text-2xl" aria-hidden="true"></i>
            </div>
            <h2 id="staff-delete-title" class="mt-4 text-center text-xl font-bold text-text">Remove this record?</h2>
            <p id="staff-delete-message" class="mt-2 text-center text-sm leading-6 text-muted">
                This action cannot be undone.
            </p>
            <div class="mt-6 flex justify-center gap-3">
                <button id="staff-delete-cancel" type="button"
                    class="rounded-xl border border-border px-5 py-2.5 text-sm font-semibold text-text transition hover:bg-card-inner">
                    No, cancel
                </button>
                <button id="staff-delete-confirm" type="button"
                    class="rounded-xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700">
                    Yes, remove
                </button>
            </div>
        </section>
    </div>
    <!-- :: END STAFF DELETE CONFIRMATION MODAL -->

    <!-- :: START ADOPTION APPLICATION MODAL SCRIPT -->
    <script>
        // :: START STAFF DELETE CONFIRMATION HANDLER
        const staffDeleteModal = document.getElementById('staff-delete-modal');
        const staffDeleteMessage = document.getElementById('staff-delete-message');
        let pendingDeleteForm = null;

        document.querySelectorAll('.staff-delete-form').forEach((form) => {
            form.addEventListener('submit', (event) => {
                event.preventDefault();
                pendingDeleteForm = form;

                const action = form.querySelector('[name="form_action"]').value;
                staffDeleteMessage.textContent = action === 'delete_adoption'
                    ? 'This adoption application and its saved details will be deleted permanently.'
                    : 'This appointment and its related care records will be deleted permanently.';

                staffDeleteModal.classList.remove('hidden');
                staffDeleteModal.classList.add('flex');
                staffDeleteModal.setAttribute('aria-hidden', 'false');
            });
        });

        function closeStaffDeleteModal() {
            staffDeleteModal.classList.add('hidden');
            staffDeleteModal.classList.remove('flex');
            staffDeleteModal.setAttribute('aria-hidden', 'true');
            pendingDeleteForm = null;
        }

        document.getElementById('staff-delete-cancel').addEventListener('click', closeStaffDeleteModal);
        staffDeleteModal.addEventListener('click', (event) => {
            if (event.target === staffDeleteModal) closeStaffDeleteModal();
        });
        document.getElementById('staff-delete-confirm').addEventListener('click', () => {
            if (pendingDeleteForm) pendingDeleteForm.submit();
        });
        // :: END STAFF DELETE CONFIRMATION HANDLER

        document.querySelectorAll('[data-application-open]').forEach((button) => {
            button.addEventListener('click', () => {
                const modal = document.getElementById(button.dataset.applicationOpen);
                if (!modal) return;

                modal.classList.remove('hidden');
                modal.classList.add('flex');
                modal.setAttribute('aria-hidden', 'false');
            });
        });

        const closeApplicationModal = (modal) => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            modal.setAttribute('aria-hidden', 'true');
        };

        document.querySelectorAll('[data-application-close]').forEach((button) => {
            button.addEventListener('click', () => {
                closeApplicationModal(button.closest('[role="dialog"]'));
            });
        });

        document.querySelectorAll('[role="dialog"][aria-modal="true"]').forEach((modal) => {
            modal.addEventListener('click', (event) => {
                if (event.target === modal) closeApplicationModal(modal);
            });
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                document.querySelectorAll('[role="dialog"][aria-modal="true"]:not(.hidden)').forEach((modal) => {
                    closeApplicationModal(modal);
                });
            }
        });
    </script>
    <!-- :: END ADOPTION APPLICATION MODAL SCRIPT -->
    <!-- :: END STAFF DASHBOARD -->
</body>

</html>
