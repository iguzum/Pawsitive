<?php
// :: START ADMIN DASHBOARD ACCESS AND ACTIONS
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

$staffController = new \App\Controller\Staff_Account_Controller();
$petController = new \App\Controller\Adoption_Pet_Controller();
// :: START DIRECT ADMIN DASHBOARD MODEL ACCESS
$overviewModel = new \App\Model\Admin_Dashboard();
// :: END DIRECT ADMIN DASHBOARD MODEL ACCESS
$dashboardMessage = '';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $formAction = (string) ($_POST['form_action'] ?? '');

    if ($formAction === 'save_staff') {
        if (trim((string) ($_POST['account_id'] ?? '')) === '') {
            $result = $staffController->createStaff($_POST);
        } else {
            $result = $staffController->updateStaff($_POST);
        }
        $dashboardMessage = $result['message'];
    } elseif ($formAction === 'remove_staff') {
        $staffId = filter_var($_POST['account_id'] ?? null, FILTER_VALIDATE_INT);
        $result = $staffController->deleteStaff($staffId === false ? 0 : (int) $staffId);
        $dashboardMessage = $result['message'];
    } elseif ($formAction === 'save_pet') {
        if (trim((string) ($_POST['pet_id'] ?? '')) === '') {
            $result = $petController->createPet($_POST);
        } else {
            $result = $petController->updatePet($_POST);
        }
        $dashboardMessage = $result['message'];
    } elseif ($formAction === 'remove_pet') {
        $petId = filter_var($_POST['pet_id'] ?? null, FILTER_VALIDATE_INT);
        $result = $petController->deletePet($petId === false ? 0 : (int) $petId);
        $dashboardMessage = $result['message'];
    }
}

$staffMembers = $staffController->getAllStaff();
$adoptionPets = $petController->getAllAdoptionPets();
$monthlyOverview = $overviewModel->getMonthlyOverview();
$staffCount = count($staffMembers);
$petCount = count($adoptionPets);
$escapeValue = static fn($value): string => htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');

// :: START LOAD EDIT FORM DATA FROM GET
$staffToEdit = null;
$requestedStaffId = filter_var($_GET['edit_staff'] ?? null, FILTER_VALIDATE_INT);
if ($requestedStaffId !== false && $requestedStaffId > 0) {
    foreach ($staffMembers as $staffMember) {
        if ((int) $staffMember['account_id'] === $requestedStaffId) {
            $staffToEdit = $staffMember;
            break;
        }
    }
}

$petToEdit = null;
$requestedPetId = filter_var($_GET['edit_pet'] ?? null, FILTER_VALIDATE_INT);
if ($staffToEdit === null && $requestedPetId !== false && $requestedPetId > 0) {
    foreach ($adoptionPets as $adoptionPet) {
        if ((int) $adoptionPet['adoption_pet_id'] === $requestedPetId) {
            $petToEdit = $adoptionPet;
            break;
        }
    }
}
// :: END LOAD EDIT FORM DATA FROM GET
// :: END ADMIN DASHBOARD ACCESS AND ACTIONS
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
                <p class="mt-2 text-sm text-muted">Manage the team and adoption pets.</p>
            </div>
            <span
                class="inline-flex w-fit items-center gap-2 rounded-full border border-border bg-card-outer px-4 py-2 text-sm text-muted">
                <i class="bx bx-calendar text-primary" aria-hidden="true"></i><?= date('F Y') ?>
            </span>
        </section>

        <?php if ($dashboardMessage !== ''): ?>
            <p role="status"
                class="mt-6 rounded-xl border border-primary/30 bg-primary/10 px-4 py-3 text-sm text-primary-hover">
                <?= $escapeValue($dashboardMessage) ?>
            </p>
        <?php endif; ?>

        <!-- :: START ADMIN OVERVIEW CARDS -->
        <section class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4" aria-label="Monthly overview">
            <article class="rounded-3xl border border-border bg-card-outer p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-muted">Adoption applicants</span>
                    <i class="bx bx-heart rounded-xl bg-card-inner p-2 text-xl text-tertiary" aria-hidden="true"></i>
                </div>
                <!-- :: START LIVE ADOPTION APPLICANT TOTALS -->
                <p class="mt-5 text-3xl font-bold"><?= $monthlyOverview['total_applicants'] ?></p>
                <p class="mt-1 text-xs text-muted"><?= $monthlyOverview['awaiting_review'] ?> awaiting review</p>
                <!-- :: END LIVE ADOPTION APPLICANT TOTALS -->
            </article>
            <article class="rounded-3xl border border-border bg-card-outer p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-muted">Active staff</span>
                    <i class="bx bx-group rounded-xl bg-card-inner p-2 text-xl text-primary" aria-hidden="true"></i>
                </div>
                <p class="mt-5 text-3xl font-bold"><?= $staffCount ?></p>
                <p class="mt-1 text-xs text-muted">Across the adoption center</p>
            </article>
            <article class="rounded-3xl border border-border bg-card-outer p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-muted">Service bookings</span>
                    <i class="bx bx-calendar rounded-xl bg-card-inner p-2 text-xl text-tertiary" aria-hidden="true"></i>
                </div>
                <!-- :: START LIVE MONTHLY SERVICE BOOKINGS -->
                <p class="mt-5 text-3xl font-bold"><?= $monthlyOverview['service_bookings'] ?></p>
                <p class="mt-1 text-xs text-muted">Scheduled this month</p>
                <!-- :: END LIVE MONTHLY SERVICE BOOKINGS -->
            </article>
            <article class="rounded-3xl border border-border bg-card-outer p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-muted">Monthly service income</span>
                    <i class="bx bx-trending-up rounded-xl bg-card-inner p-2 text-xl text-primary"
                        aria-hidden="true"></i>
                </div>
                <!-- :: START DERIVED MONTHLY SERVICE INCOME -->
                <p class="mt-5 text-2xl font-bold sm:text-3xl">
                    ₱<?= number_format($monthlyOverview['monthly_service_income'], 2) ?></p>
                <p class="mt-1 text-xs text-muted">Estimated from services scheduled this month</p>
                <!-- :: END DERIVED MONTHLY SERVICE INCOME -->
            </article>
        </section>
        <!-- :: END ADMIN OVERVIEW CARDS -->

        <!-- :: START STAFF AND ADOPTION PET PANELS -->
        <section id="admin-panels" class="mt-8 flex flex-col gap-6">
            <article
                class="flex h-90 min-h-0 flex-col overflow-hidden rounded-3xl border border-border bg-card-outer shadow-sm">
                <div
                    class="flex shrink-0 flex-wrap items-center justify-between gap-3 border-b border-border px-5 py-5 sm:px-6">
                    <div>
                        <h2 class="text-lg font-bold">Team directory</h2>
                        <p class="mt-1 text-sm text-muted"><?= $staffCount ?> staff accounts</p>
                    </div>
                    <button type="button" data-open-staff-modal
                        class="inline-flex items-center gap-2 rounded-xl bg-tertiary px-4 py-2.5 text-sm font-bold text-white transition-all hover:bg-primary hover:rounded-none duration-200">
                        <i class="bx bx-plus" aria-hidden="true"></i>Add staff
                    </button>
                </div>
                <div class="min-h-0 flex-1 overflow-y-auto">
                    <?php if ($staffMembers === []): ?>
                        <p class="px-5 py-6 text-sm text-muted">No staff accounts yet. Add one to start the team directory.
                        </p>
                    <?php else: ?>
                        <ul class="divide-y divide-border">
                            <?php foreach ($staffMembers as $staff): ?>
                                <li
                                    class="flex flex-col gap-4 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                                    <div class="flex min-w-0 items-center gap-3">
                                        <span
                                            class="flex size-11 shrink-0 items-center justify-center rounded-full bg-secondary/20 font-bold text-tertiary">

                                            <i class="bx bx-user text-2xl"></i>
                                        </span>
                                        <div class="min-w-0">
                                            <p class="truncate font-semibold uppercase">
                                                <?= $escapeValue(trim(($staff['first_name'] ?? '') . ' ' . ($staff['last_name'] ?? ''))) ?>
                                            </p>
                                            <p class="truncate text-xs text-muted"><?= $escapeValue($staff['email']) ?></p>
                                        </div>
                                    </div>
                                    <div class="flex shrink-0 items-center gap-2">
                                        <a href="?edit_staff=<?= (int) $staff['account_id'] ?>#admin-panels"
                                            class="rounded-lg border border-border px-3 py-2 text-xs font-semibold text-primary-hover transition hover:bg-card-inner">Edit</a>
                                        <form method="post" class="confirm-delete">
                                            <input type="hidden" name="form_action" value="remove_staff">
                                            <input type="hidden" name="account_id" value="<?= (int) $staff['account_id'] ?>">
                                            <button type="submit"
                                                class="rounded-lg border border-tertiary/40 px-3 py-2 text-xs font-semibold text-tertiary transition hover:bg-tertiary hover:text-white">Remove</button>
                                        </form>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </article>

            <article
                class="flex h-130 min-h-0 flex-col overflow-hidden rounded-3xl border border-border bg-card-outer shadow-sm">
                <div
                    class="flex shrink-0 flex-wrap items-center justify-between gap-3 border-b border-border px-5 py-5 sm:px-6">
                    <div>
                        <h2 class="text-lg font-bold">Adoption pets</h2>
                        <p class="mt-1 text-sm text-muted"><?= $petCount ?> pets listed</p>
                    </div>
                    <button type="button" data-open-pet-modal
                        class="inline-flex items-center gap-2 rounded-xl bg-tertiary px-4 py-2.5 text-sm font-bold text-white transition-all hover:bg-primary hover:rounded-none duration-200">
                        <i class="bx bx-plus" aria-hidden="true"></i>Add pet
                    </button>
                </div>
                <div class="min-h-0 flex-1 overflow-y-auto">
                    <?php if ($adoptionPets === []): ?>
                        <p class="px-5 py-6 text-sm text-muted">No adoption pets listed yet. Add a pet to the catalog.</p>
                    <?php else: ?>
                        <ul class="divide-y divide-border">
                            <?php foreach ($adoptionPets as $pet): ?>
                                <li
                                    class="flex flex-col gap-4 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                                    <div class="flex min-w-0 items-center gap-4">
                                        <div
                                            class="h-30 w-30 shrink-0 overflow-hidden rounded-2xl border border-border bg-card-inner shadow-sm">
                                            <img src="<?= $escapeValue($pet['image'] ?: 'https://placehold.co/120x120?text=Pet') ?>"
                                                alt="<?= $escapeValue($pet['adoption_pet_name']) ?>"
                                                class="aspect-square block h-full w-full object-cover object-center">
                                        </div>
                                        <div class="min-w-0">
                                            <p class="truncate font-semibold"><?= $escapeValue($pet['adoption_pet_name']) ?></p>
                                            <p class="truncate text-xs capitalize text-muted">
                                                <?= $escapeValue($pet['species']) ?> · <?= $escapeValue($pet['breed']) ?> ·
                                                <?= $escapeValue($pet['age']) ?> y/o · <?= $escapeValue($pet['sex']) ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex shrink-0 items-center gap-2">
                                        <a href="?edit_pet=<?= (int) $pet['adoption_pet_id'] ?>#admin-panels"
                                            class="rounded-lg border border-border px-3 py-2 text-xs font-semibold text-primary-hover transition hover:bg-card-inner">Edit</a>
                                        <form method="post" class="confirm-delete">
                                            <input type="hidden" name="form_action" value="remove_pet">
                                            <input type="hidden" name="pet_id" value="<?= (int) $pet['adoption_pet_id'] ?>">
                                            <button type="submit"
                                                class="rounded-lg border border-tertiary/40 px-3 py-2 text-xs font-semibold text-tertiary transition hover:bg-tertiary hover:text-white">Remove</button>
                                        </form>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </article>
        </section>
        <!-- :: END STAFF AND ADOPTION PET PANELS -->
    </main>

    <!-- :: START STAFF ADD AND EDIT MODAL -->
    <div id="staff-modal" role="dialog" aria-modal="true" aria-hidden="<?= $staffToEdit !== null ? 'false' : 'true' ?>"
        aria-labelledby="staff-modal-title"
        class="<?= $staffToEdit !== null ? 'flex' : 'hidden' ?> fixed inset-0 z-1000000 items-center justify-center overflow-y-auto bg-text/60 p-4 backdrop-blur-sm">
        <section class="my-auto w-full max-w-xl rounded-3xl border border-border bg-card-outer p-5 shadow-2xl sm:p-8">
            <div class="mb-6 flex items-start justify-between gap-4 border-b border-border pb-5">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-tertiary">Team directory</p>
                    <h2 id="staff-modal-title" class="mt-2 text-2xl font-bold">
                        <?= $staffToEdit !== null ? 'Edit staff' : 'Add staff' ?>
                    </h2>
                </div>
                <button type="button" data-close-modal aria-label="Close staff form"
                    class="flex size-11 items-center justify-center rounded-xl border border-border text-muted hover:bg-card-inner">
                    <i class="bx bx-x text-2xl" aria-hidden="true"></i>
                </button>
            </div>
            <form id="staff-form" method="post" class="space-y-4">
                <input type="hidden" name="form_action" value="save_staff">
                <input type="hidden" id="staff-account-id" name="account_id"
                    value="<?= (int) ($staffToEdit['account_id'] ?? 0) ?: '' ?>">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="staff-first-name" class="mb-2 block text-sm font-semibold">First name</label>
                        <input id="staff-first-name" name="first_name" type="text" maxlength="50" required
                            value="<?= $escapeValue($staffToEdit['first_name'] ?? '') ?>"
                            class="w-full rounded-xl border border-border bg-background px-4 py-3 text-sm outline-none focus:border-primary">
                    </div>
                    <div>
                        <label for="staff-last-name" class="mb-2 block text-sm font-semibold">Last name</label>
                        <input id="staff-last-name" name="last_name" type="text" maxlength="50" required
                            value="<?= $escapeValue($staffToEdit['last_name'] ?? '') ?>"
                            class="w-full rounded-xl border border-border bg-background px-4 py-3 text-sm outline-none focus:border-primary">
                    </div>
                </div>
                <div>
                    <label for="staff-email" class="mb-2 block text-sm font-semibold">Email</label>
                    <input id="staff-email" name="email" type="email" maxlength="150" required
                        value="<?= $escapeValue($staffToEdit['email'] ?? '') ?>"
                        class="w-full rounded-xl border border-border bg-background px-4 py-3 text-sm outline-none focus:border-primary">
                </div>
                <div>
                    <label for="staff-password" class="mb-2 block text-sm font-semibold">Password</label>
                    <input id="staff-password" name="password" type="password" minlength="8" autocomplete="new-password"
                        <?= $staffToEdit === null ? 'required' : '' ?>
                        class="w-full rounded-xl border border-border bg-background px-4 py-3 text-sm outline-none focus:border-primary">
                    <p id="staff-password-help" class="mt-1 text-xs text-muted">
                        <?= $staffToEdit !== null ? 'Leave blank to keep the current password.' : 'At least 8 characters.' ?>
                    </p>
                </div>
                <div class="flex justify-end gap-3 border-t border-border pt-5">
                    <button type="button" data-close-modal
                        class="rounded-xl border border-border px-5 py-2.5 text-sm font-semibold hover:bg-card-inner">Cancel</button>
                    <button type="submit"
                        class="rounded-xl bg-tertiary px-5 py-2.5 text-sm font-semibold text-white hover:bg-primary">Save
                        staff</button>
                </div>
            </form>
        </section>
    </div>
    <!-- :: END STAFF ADD AND EDIT MODAL -->

    <!-- :: START PET ADD AND EDIT MODAL -->
    <div id="pet-modal" role="dialog" aria-modal="true" aria-hidden="<?= $petToEdit !== null ? 'false' : 'true' ?>"
        aria-labelledby="pet-modal-title"
        class="<?= $petToEdit !== null ? 'flex' : 'hidden' ?> fixed inset-0 z-1000000 items-center justify-center overflow-y-auto bg-text/60 p-4 backdrop-blur-sm">
        <section class="my-auto w-full max-w-3xl rounded-3xl border border-border bg-card-outer p-5 shadow-2xl sm:p-8">
            <div class="mb-6 flex items-start justify-between gap-4 border-b border-border pb-5">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-tertiary">Adoption catalog</p>
                    <h2 id="pet-modal-title" class="mt-2 text-2xl font-bold">
                        <?= $petToEdit !== null ? 'Edit adoption pet' : 'Add adoption pet' ?>
                    </h2>
                </div>
                <button type="button" data-close-modal aria-label="Close pet form"
                    class="flex size-11 items-center justify-center rounded-xl border border-border text-muted hover:bg-card-inner">
                    <i class="bx bx-x text-2xl" aria-hidden="true"></i>
                </button>
            </div>
            <form id="pet-form" method="post" class="space-y-4">
                <input type="hidden" name="form_action" value="save_pet">
                <input type="hidden" id="pet-id" name="pet_id"
                    value="<?= (int) ($petToEdit['adoption_pet_id'] ?? 0) ?: '' ?>">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="pet-name" class="mb-2 block text-sm font-semibold">Pet name</label>
                        <input id="pet-name" name="pet_name" type="text" maxlength="100" required
                            value="<?= $escapeValue($petToEdit['adoption_pet_name'] ?? '') ?>"
                            class="w-full rounded-xl border border-border bg-background px-4 py-3 text-sm outline-none focus:border-primary">
                    </div>
                    <div>
                        <label for="pet-species" class="mb-2 block text-sm font-semibold">Species</label>
                        <select id="pet-species" name="species" required
                            class="w-full rounded-xl border border-border bg-background px-4 py-3 text-sm outline-none focus:border-primary">
                            <option value="dog" <?= ($petToEdit['species'] ?? 'dog') === 'dog' ? 'selected' : '' ?>>Dog
                            </option>
                            <option value="cat" <?= ($petToEdit['species'] ?? '') === 'cat' ? 'selected' : '' ?>>Cat
                            </option>
                        </select>
                    </div>
                    <div>
                        <label for="pet-breed" class="mb-2 block text-sm font-semibold">Breed</label>
                        <input id="pet-breed" name="breed" type="text" maxlength="50" required
                            value="<?= $escapeValue($petToEdit['breed'] ?? '') ?>"
                            class="w-full rounded-xl border border-border bg-background px-4 py-3 text-sm outline-none focus:border-primary">
                    </div>
                    <div>
                        <label for="pet-age" class="mb-2 block text-sm font-semibold">Age</label>
                        <input id="pet-age" name="age" type="number" min="0" max="255" required
                            value="<?= $escapeValue($petToEdit['age'] ?? '') ?>"
                            class="w-full rounded-xl border border-border bg-background px-4 py-3 text-sm outline-none focus:border-primary">
                    </div>
                    <div>
                        <label for="pet-sex" class="mb-2 block text-sm font-semibold">Sex</label>
                        <select id="pet-sex" name="sex" required
                            class="w-full rounded-xl border border-border bg-background px-4 py-3 text-sm outline-none focus:border-primary">
                            <option value="male" <?= ($petToEdit['sex'] ?? 'male') === 'male' ? 'selected' : '' ?>>Male
                            </option>
                            <option value="female" <?= ($petToEdit['sex'] ?? '') === 'female' ? 'selected' : '' ?>>Female
                            </option>
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="pet-image" class="mb-2 block text-sm font-semibold">Image URL</label>
                        <input id="pet-image" name="image" type="text" maxlength="255"
                            value="<?= $escapeValue($petToEdit['image'] ?? '') ?>" placeholder="https://..."
                            class="w-full rounded-xl border border-border bg-background px-4 py-3 text-sm outline-none focus:border-primary">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="pet-health" class="mb-2 block text-sm font-semibold">Health condition</label>
                        <input id="pet-health" name="health_condition" type="text" maxlength="255"
                            value="<?= $escapeValue($petToEdit['health_condition'] ?? '') ?>"
                            class="w-full rounded-xl border border-border bg-background px-4 py-3 text-sm outline-none focus:border-primary">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="pet-behavior" class="mb-2 block text-sm font-semibold">Behavior details</label>
                        <textarea id="pet-behavior" name="behavior_details" rows="3"
                            class="w-full rounded-xl border border-border bg-background px-4 py-3 text-sm outline-none focus:border-primary"><?= $escapeValue($petToEdit['behavior_details'] ?? '') ?></textarea>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="pet-rescue" class="mb-2 block text-sm font-semibold">Rescue history</label>
                        <textarea id="pet-rescue" name="rescue_history" rows="3"
                            class="w-full rounded-xl border border-border bg-background px-4 py-3 text-sm outline-none focus:border-primary"><?= $escapeValue($petToEdit['rescue_history'] ?? '') ?></textarea>
                    </div>
                </div>
                <div class="flex justify-end gap-3 border-t border-border pt-5">
                    <button type="button" data-close-modal
                        class="rounded-xl border border-border px-5 py-2.5 text-sm font-semibold hover:bg-card-inner">Cancel</button>
                    <button type="submit"
                        class="rounded-xl bg-tertiary px-5 py-2.5 text-sm font-semibold text-white hover:bg-primary">Save
                        pet</button>
                </div>
            </form>
        </section>
    </div>
    <!-- :: END PET ADD AND EDIT MODAL -->

    <!-- :: START DELETE CONFIRMATION MODAL -->
    <div id="delete-confirmation-modal" role="dialog" aria-modal="true" aria-hidden="true"
        aria-labelledby="delete-confirmation-title"
        class="hidden fixed inset-0 z-1000001 items-center justify-center bg-text/60 p-4 backdrop-blur-sm">
        <section
            class="w-full max-w-sm rounded-3xl border border-border bg-card-outer p-6 text-center shadow-2xl sm:p-7">
            <span class="mx-auto flex size-14 items-center justify-center rounded-2xl bg-tertiary/10 text-tertiary">
                <i class="bx bx-trash text-3xl" aria-hidden="true"></i>
            </span>
            <h2 id="delete-confirmation-title" class="mt-4 text-xl font-bold text-text">Remove this item?</h2>
            <p id="delete-confirmation-message" class="mt-2 text-sm leading-6 text-muted"></p>
            <div class="mt-6 flex justify-center gap-3">
                <button type="button" id="delete-cancel-button"
                    class="rounded-xl border border-border px-5 py-2.5 text-sm font-semibold text-text transition hover:bg-card-inner">
                    No, cancel
                </button>
                <button type="button" id="delete-confirm-button"
                    class="inline-flex items-center gap-2 rounded-xl bg-tertiary px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-primary">
                    <i class="bx bx-trash" aria-hidden="true"></i>Yes, remove
                </button>
            </div>
        </section>
    </div>
    <!-- :: END DELETE CONFIRMATION MODAL -->

    <!-- :: START ADMIN DASHBOARD MODAL HANDLERS -->
    <script>
        const staffModal = document.getElementById('staff-modal');
        const petModal = document.getElementById('pet-modal');
        const deleteConfirmationModal = document.getElementById('delete-confirmation-modal');
        const staffForm = document.getElementById('staff-form');
        const petForm = document.getElementById('pet-form');
        let pendingDeleteForm = null;

        function showModal(modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            modal.setAttribute('aria-hidden', 'false');
            document.body.classList.add('overflow-hidden');
        }

        function hideModal(modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            modal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('overflow-hidden');
        }

        document.querySelector('[data-open-staff-modal]').addEventListener('click', () => {
            staffForm.reset();
            document.getElementById('staff-account-id').value = '';
            document.getElementById('staff-modal-title').textContent = 'Add staff';
            document.getElementById('staff-password').required = true;
            document.getElementById('staff-password-help').textContent = 'At least 8 characters.';
            showModal(staffModal);
        });

        document.querySelector('[data-open-pet-modal]').addEventListener('click', () => {
            petForm.reset();
            document.getElementById('pet-id').value = '';
            document.getElementById('pet-modal-title').textContent = 'Add adoption pet';
            showModal(petModal);
        });

        document.querySelectorAll('[data-close-modal]').forEach((button) => {
            button.addEventListener('click', () => hideModal(button.closest('[role="dialog"]')));
        });

        [staffModal, petModal, deleteConfirmationModal].forEach((modal) => {
            modal.addEventListener('click', (event) => {
                if (event.target === modal) {
                    if (modal === deleteConfirmationModal) pendingDeleteForm = null;
                    hideModal(modal);
                }
            });
        });

        document.querySelectorAll('.confirm-delete').forEach((form) => {
            form.addEventListener('submit', (event) => {
                event.preventDefault();
                pendingDeleteForm = form;

                const formAction = form.querySelector('[name="form_action"]').value;
                const itemType = formAction === 'remove_pet' ? 'pet' : 'staff';
                const title = document.getElementById('delete-confirmation-title');
                const message = document.getElementById('delete-confirmation-message');

                if (itemType === 'pet') {
                    title.textContent = 'Remove this pet?';
                    message.textContent = 'Any adoption applications for this pet will also be deleted.';
                } else {
                    title.textContent = 'Remove this staff account?';
                    message.textContent = 'Any records linked to this staff account may also be deleted.';
                }

                showModal(deleteConfirmationModal);
            });
        });

        document.getElementById('delete-cancel-button').addEventListener('click', () => {
            pendingDeleteForm = null;
            hideModal(deleteConfirmationModal);
        });

        document.getElementById('delete-confirm-button').addEventListener('click', () => {
            if (pendingDeleteForm) {
                const formToSubmit = pendingDeleteForm;
                pendingDeleteForm = null;
                hideModal(deleteConfirmationModal);
                formToSubmit.submit();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                [staffModal, petModal, deleteConfirmationModal].forEach((modal) => {
                    if (!modal.classList.contains('hidden')) {
                        if (modal === deleteConfirmationModal) pendingDeleteForm = null;
                        hideModal(modal);
                    }
                });
            }
        });

        <?php if ($staffToEdit !== null): ?>
            showModal(staffModal);
        <?php elseif ($petToEdit !== null): ?>
            showModal(petModal);
        <?php endif; ?>
    </script>
    <!-- :: END ADMIN DASHBOARD MODAL HANDLERS -->
    <!-- :: END ADMIN DASHBOARD DESIGN -->
</body>

</html>