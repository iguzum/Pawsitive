<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\Authentication_Controller;
use App\Controller\Adoption_Pet_Controller;
use App\Controller\Adoption_Application_Controller;

$auth = new Authentication_Controller();

if (!$auth->isLogin()) {
    header('Location: login.php');
    exit();
}

// :: START ADOPTION APPLICATION CONTROLLER CALL
$adoptionApplicationController = new Adoption_Application_Controller();
$adoptionPageState = $adoptionApplicationController->handlePageRequest(
    (int) ($_SESSION['user_id'] ?? 0),
    $_SERVER['REQUEST_METHOD'] ?? 'GET',
    $_POST,
    $_SESSION
);

if ($adoptionPageState['redirect_to'] !== null) {
    header('Location: ' . $adoptionPageState['redirect_to']);
    exit();
}
// :: END ADOPTION APPLICATION CONTROLLER CALL

$adoption_pets = new Adoption_Pet_Controller();
$adoption_pets = $adoption_pets->getAvailableAdoptionPets();
$escapeAdoptionValue = static fn($value): string => htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./src/output.css">
    <link href="https://cdn.boxicons.com/3.0.8/fonts/basic/boxicons.min.css" rel="stylesheet">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <title>PAWSITIVE</title>
</head>

<body class="min-h-screen w-full">
    <div class="w-full relative mb-24 h-fit" id="home">
        <div
            class="w-full h-210 bg-[url('../assets/pictures/hero.png')] bg-cover bg-center bg-no-repeat relative flex items-center justify-center">

            <!-- START NAVIGATION HEADER -->
            <div class="w-full fixed top-0 left-0 right-0 z-999999 my-4 mt-0 bg-white">
                <div class=" w-full max-w-350 mx-auto">
                    <?php include "../includes/header.php"; ?>
                </div>
            </div>
            <!-- END NAVIGATION HEADER -->

            <div
                class="w-full max-w-350 h-auto lg:h-160 mx-auto flex flex-col md:flex-row items-center justify-between gap-3 mt-3 md:mt-0 px-4 md:px-6">

                <div class="w-full md:w-1/2 max-w-2xl flex flex-col gap-4 px-2 md:px-1 sm:mt-60 md:mt-0">
                    <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-white leading-tight mt-30">
                        ADOPT, DON'T SHOP
                    </h1>

                    <p class="text-base sm:text-lg text-white/90 max-w-lg leading-relaxed">
                        Every pet deserves a loving home. Find your perfect companion and make a difference in their
                        life.
                    </p>
                </div>

                <div class="w-full sm:w-1/2 flex justify-center md:justify-end sm:mb-30 md:mt-20 md:mb-0 lg:mt-40">
                    <img src="./assets/pictures/dog.png" alt="Adoptable dog"
                        class="w-full max-w-md lg:max-w-lg object-contain">
                </div>
            </div>
        </div>


        <div
            class="w-[90%] md:max-w-350 rounded-4xl bg-tertiary h-auto md:h-40 mx-auto absolute bottom-0 left-0 right-0 translate-y-1/2 z-40 shadow-lg flex justify-between items-center gap-6 md:gap-4 px-5 md:px-7 py-4 md:py-5 flex-col md:flex-row">

            <div class="flex justify-between items-center gap-4 md:gap-6 text-white flex-col md:flex-row">
                <span class="hidden md:flex">
                    <i class="bx bx-paw-print text-4xl sm:text-5xl md:text-6xl lg:text-7xl"></i>
                </span>
                <div class="flex flex-col gap-1 text-justify md:text-left tracking-wider">
                    <h1 class="text-md sm:text-lg md:text-xl lg:text-2xl font-semibold">
                        HOME IS NOT A PLACE. IT'S A PERSON. BE THEIRS!
                    </h1>
                    <p class="text-xs md:text-md lg:text-lg">Adopt a pet and give them a loving home.</p>
                </div>
            </div>
            <a href="#pets"
                class="bg-card-inner hover:bg-secondary text-center hover:text-white text-md md:text-lg py-2 px-3 lg:py-4 lg:px-6 rounded-xl transition-all duration-200 hover:rounded-none cursor-pointer w-full md:w-fit tracking-wider">
                Adopt Now
            </a>
        </div>
    </div>

    <main class="mt-40 md:mt-50 w-full flex flex-col" id="pets">
        <!-- :: START CUSTOMER SCHEDULE MOVED TO PAGE -->
        <!-- Customers can open their schedule from the header Schedule link. -->
        <!-- :: END CUSTOMER SCHEDULE MOVED TO PAGE -->

        <?php if ($adoptionPageState['success_message'] !== ''): ?>
            <!-- :: START ADOPTION SUCCESS MESSAGE -->
            <p role="status"
                class="mx-auto mb-8 w-[90%] max-w-4xl rounded-xl border border-primary/30 bg-primary/10 px-5 py-4 text-center text-primary-hover">
                <?= $escapeAdoptionValue($adoptionPageState['success_message']) ?>
            </p>
            <!-- :: END ADOPTION SUCCESS MESSAGE -->
        <?php endif; ?>

        <section class="relative mx-auto flex flex-col items-center justify-center w-full">
            <div class="mx-auto w-full max-w-350">
                <!-- :: START CONSISTENT SECTION GUTTER -->
                <div class="mb-10 flex flex-col items-center text-center px-7 sm:px-8">
                    <h1 class=" text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-center text-text">
                        Meet Your Companion
                    </h1>

                    <p class="mt-4 max-w-2xl text-sm leading-7 text-muted sm:text-md md:text-lg">
                        Find your perfect companion and give them a loving forever home.
                    </p>

                    <div class="w-24 h-2 bg-tertiary rounded-xl mt-5"></div>
                </div>
                <!-- :: END CONSISTENT SECTION GUTTER -->
            </div>

            <div class="w-full max-w-350 mt-15 md:mt-20">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 px-7 md:px-15">

                    <?php if ($adoption_pets === []): ?>
                        <!-- :: START NO PETS EMPTY STATE -->
                        <div class="col-span-full rounded-3xl border border-border bg-card-outer px-6 py-14 text-center shadow-sm">
                            <span class="mx-auto flex size-14 items-center justify-center rounded-2xl bg-card-inner text-2xl text-tertiary">
                                <i class="bx bx-paw-print" aria-hidden="true"></i>
                            </span>
                            <h2 class="mt-5 text-xl font-bold text-text">No pets to adopt right now</h2>
                            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-muted">
                                Please check back soon. New pets may be available for adoption later.
                            </p>
                        </div>
                        <!-- :: END NO PETS EMPTY STATE -->
                    <?php else: ?>
                    <?php foreach ($adoption_pets as $pet): ?>

                        <!-- START NG LOOP -->
                        <!-- START CARD -->
                        <div
                            class="w-full border h-full min-w-0 bg-white rounded-2xl  border-gray-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col group">
                            <div
                                class="relative aspect-square w-full overflow-hidden bg-gray-100 select-none pointer-events-none">
                                <img src="<?= htmlspecialchars($pet['image'] ?? 'https://placehold.co/600x600?text=No+Image') ?>"
                                    class="aspect-square h-full w-full object-cover"
                                    alt="<?= htmlspecialchars($pet['adoption_pet_name']) ?> - Pet available for adoption">
                            </div>

                            <div class="p-5 sm:p-6 flex flex-col grow">

                                <div class="flex flex-col gap-4 grow">
                                    <div class="flex items-center justify-between gap-2">
                                        <h3 class="text-2xl font-semibold text-text tracking-wider">
                                            <?= htmlspecialchars($pet['adoption_pet_name']) ?>
                                        </h3>
                                    </div>

                                    <div class="grid grid-cols-2 pb-4">

                                        <div class="flex flex-col gap-1 bg-gray-50">
                                            <span class="text-xs text-gray-400 font-medium tracking-wide">
                                                Gender
                                            </span>
                                            <span class="text-sm font-semibold text-text uppercase">
                                                <?= htmlspecialchars($pet['sex']) ?>
                                            </span>
                                        </div>

                                        <div class="flex flex-col gap-1 bg-gray-50">
                                            <span class="text-xs text-gray-400 font-medium tracking-wide">
                                                Age
                                            </span>
                                            <span class="text-sm font-semibold text-text">
                                                <?= htmlspecialchars($pet['age']) ?> y/o
                                            </span>
                                        </div>

                                    </div>
                                </div>

                                <div class="flex items-center gap-3 pt-3 mt-3 border-t border-slate-200">

                                    <!-- :: START PET DETAILS BUTTON DATA -->
                                    <button type="button" data-pet-details-open
                                        data-pet-name="<?= $escapeAdoptionValue($pet['adoption_pet_name'] ?? '') ?>"
                                        data-pet-image="<?= $escapeAdoptionValue($pet['image'] ?? '') ?>"
                                        data-pet-species="<?= $escapeAdoptionValue($pet['species'] ?? '') ?>"
                                        data-pet-breed="<?= $escapeAdoptionValue($pet['breed'] ?? '') ?>"
                                        data-pet-age="<?= $escapeAdoptionValue($pet['age'] ?? '') ?>"
                                        data-pet-sex="<?= $escapeAdoptionValue($pet['sex'] ?? '') ?>"
                                        data-pet-behavior="<?= $escapeAdoptionValue($pet['behavior_details'] ?? '') ?>"
                                        data-pet-health="<?= $escapeAdoptionValue($pet['health_condition'] ?? '') ?>"
                                        data-pet-rescue="<?= $escapeAdoptionValue($pet['rescue_history'] ?? '') ?>"
                                        class="flex-1 min-w-0 py-3 px-3 text-sm font-semibold text-text bg-transparent rounded-xl border-2 border-gray-300/70 hover:bg-secondary hover:rounded-none transition-all duration-200 cursor-pointer"
                                    >
                                        Details
                                    </button>
                                    <!-- :: END PET DETAILS BUTTON DATA -->

                                    <!-- :: START OPEN ADOPTION APPLICATION MODAL -->
                                    <button type="button" data-adoption-modal-open
                                        data-pet-id="<?= (int) $pet['adoption_pet_id'] ?>"
                                        data-pet-name="<?= $escapeAdoptionValue($pet['adoption_pet_name']) ?>"
                                        class="flex-1 min-w-0 py-3 px-3 text-sm font-semibold text-white bg-tertiary rounded-xl hover:bg-primary hover:rounded-none transition-all duration-200 cursor-pointer">
                                        Adopt
                                    </button>
                                    <!-- :: END OPEN ADOPTION APPLICATION MODAL -->
                                </div>
                            </div>
                        </div>
                        <!--  END CARD -->
                        <!-- END NG LOOP -->
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>

            </div>
        </section>

        <!-- :: START SINGLE PET DETAILS MODAL -->
        <!-- :: START PET DETAILS MODAL DESIGN -->
        <div id="default-modal" tabindex="-1" aria-hidden="true" role="dialog" aria-modal="true"
            aria-labelledby="pet-modal-name"
            class="hidden fixed inset-0 z-1000000 items-center justify-center overflow-y-auto bg-text/60 p-4 backdrop-blur-sm">
            <section class="relative my-auto w-full max-w-4xl overflow-hidden rounded-3xl border border-border bg-card-outer shadow-2xl">
                <div class="flex items-start justify-between gap-4 border-b border-border px-5 py-5 sm:px-8">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-tertiary">Meet your companion</p>
                        <h2 id="pet-modal-name" class="mt-2 text-2xl font-bold text-text sm:text-3xl">Pet details</h2>
                        <p id="pet-modal-subtitle" class="mt-1 text-sm text-muted">Learn more about this pet.</p>
                    </div>
                    <button type="button" data-pet-modal-close aria-label="Close pet details"
                        class="flex size-11 shrink-0 items-center justify-center rounded-xl border border-border text-muted transition hover:bg-card-inner hover:text-text">
                        <i class="bx bx-x text-2xl" aria-hidden="true"></i>
                    </button>
                </div>

                <div class="grid gap-6 p-5 sm:p-8 md:grid-cols-[0.9fr_1.1fr]">
                    <div class="relative aspect-square overflow-hidden rounded-2xl bg-card-inner">
                        <img id="pet-modal-image" src="" alt=""
                            class="absolute inset-0 aspect-square h-full w-full object-cover">
                    </div>

                    <div class="flex flex-col gap-5">
                        <div class="grid grid-cols-2 gap-3">
                            <div class="rounded-2xl border border-border bg-card-inner p-4">
                                <p class="text-xs font-semibold uppercase tracking-wide text-muted">Species</p>
                                <p id="pet-modal-species" class="mt-2 font-bold capitalize text-text">—</p>
                            </div>
                            <div class="rounded-2xl border border-border bg-card-inner p-4">
                                <p class="text-xs font-semibold uppercase tracking-wide text-muted">Breed</p>
                                <p id="pet-modal-breed" class="mt-2 font-bold text-text">—</p>
                            </div>
                            <div class="rounded-2xl border border-border bg-card-inner p-4">
                                <p class="text-xs font-semibold uppercase tracking-wide text-muted">Age</p>
                                <p id="pet-modal-age" class="mt-2 font-bold text-text">—</p>
                            </div>
                            <div class="rounded-2xl border border-border bg-card-inner p-4">
                                <p class="text-xs font-semibold uppercase tracking-wide text-muted">Sex</p>
                                <p id="pet-modal-sex" class="mt-2 font-bold capitalize text-text">—</p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <article class="rounded-2xl border border-border bg-background p-4">
                                <h3 class="flex items-center gap-2 font-bold text-text">
                                    <i class="bx bx-sparkles text-lg text-tertiary" aria-hidden="true"></i>
                                    Personality
                                </h3>
                                <p id="pet-modal-behavior" class="mt-2 whitespace-pre-line text-sm leading-6 text-muted">—</p>
                            </article>
                            <article class="rounded-2xl border border-border bg-background p-4">
                                <h3 class="flex items-center gap-2 font-bold text-text">
                                    <i class="bx bx-plus-medical text-lg text-primary" aria-hidden="true"></i>
                                    Health
                                </h3>
                                <p id="pet-modal-health" class="mt-2 whitespace-pre-line text-sm leading-6 text-muted">—</p>
                            </article>
                            <article class="rounded-2xl border border-border bg-background p-4">
                                <h3 class="flex items-center gap-2 font-bold text-text">
                                    <i class="bx bx-home-heart text-lg text-tertiary" aria-hidden="true"></i>
                                    Rescue story
                                </h3>
                                <p id="pet-modal-rescue" class="mt-2 whitespace-pre-line text-sm leading-6 text-muted">—</p>
                            </article>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap items-center justify-between gap-3 border-t border-border bg-card-inner/60 px-5 py-4 sm:px-8">
                    <p class="text-xs text-muted">Every pet deserves a safe, loving home.</p>
                    <button type="button" data-pet-modal-close
                        class="rounded-xl bg-tertiary px-5 py-2.5 text-sm font-semibold text-white transition-all duration-200 hover:bg-primary hover:rounded-none">
                        Close details
                    </button>
                </div>
            </section>
        </div>
        <!-- :: END PET DETAILS MODAL DESIGN -->
        <!-- :: END SINGLE PET DETAILS MODAL -->

        <!-- :: START ADOPTION APPLICATION MODAL -->
        <div id="adoption-modal" aria-hidden="true" role="dialog" aria-modal="true"
            aria-labelledby="adoption-modal-title"
            class="<?= $adoptionPageState['show_modal'] ? 'flex' : 'hidden' ?> fixed inset-0 z-1000000 items-center justify-center overflow-y-auto bg-text/60 p-4 backdrop-blur-sm">
            <div
                class="relative my-auto w-full max-w-2xl rounded-3xl border border-border bg-card-outer p-5 shadow-2xl sm:p-8">
                <div class="mb-6 flex items-start justify-between gap-4 border-b border-border pb-5">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-tertiary">Adoption application</p>
                        <h2 id="adoption-modal-title" class="mt-2 text-2xl font-bold text-text sm:text-3xl">
                            Apply to adopt <span id="adoption-pet-name">this pet</span>
                        </h2>
                        <p class="mt-2 text-sm text-muted">Step <span
                                id="adoption-step-number"><?= $adoptionPageState['form_step'] ?></span> of 2</p>
                    </div>
                    <button type="button" data-adoption-modal-close aria-label="Close adoption application"
                        class="flex size-11 shrink-0 items-center justify-center rounded-xl border border-border text-muted transition hover:bg-card-inner hover:text-text">
                        <i class="bx bx-x text-2xl" aria-hidden="true"></i>
                    </button>
                </div>

                <?php if ($adoptionPageState['form_error'] !== ''): ?>
                    <p role="alert"
                        class="mb-5 rounded-xl border border-tertiary/30 bg-tertiary/10 px-4 py-3 text-sm text-tertiary">
                        <?= $escapeAdoptionValue($adoptionPageState['form_error']) ?>
                    </p>
                <?php endif; ?>

                <form id="adoption-application-form" method="post" action="index.php#pets" novalidate>
                    <input type="hidden" name="form_action" value="submit_adoption">
                    <input type="hidden" id="adoption-pet-id" name="adoption_pet_id"
                        value="<?= $escapeAdoptionValue($adoptionPageState['form_values']['adoption_pet_id'] ?? '') ?>" required>

                    <!-- :: START APPLICANT DETAILS STEP -->
                    <section data-adoption-step="1" class="<?= $adoptionPageState['form_step'] === 1 ? '' : 'hidden' ?>">
                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="applicant-first-name"
                                    class="mb-2 block text-sm font-semibold text-text">First name</label>
                                <input id="applicant-first-name" name="first_name" type="text" maxlength="50"
                                    autocomplete="given-name" placeholder="Enter your first name" required
                                    value="<?= $escapeAdoptionValue($adoptionPageState['form_values']['first_name'] ?? $adoptionPageState['applicant_profile']['first_name']) ?>"
                                    class="w-full rounded-xl border border-border bg-background px-4 py-3 text-sm text-text outline-none transition placeholder:text-muted/70 focus:border-primary focus:ring-4 focus:ring-primary/10">
                            </div>

                            <div>
                                <label for="applicant-last-name" class="mb-2 block text-sm font-semibold text-text">Last
                                    name</label>
                                <input id="applicant-last-name" name="last_name" type="text" maxlength="50"
                                    autocomplete="family-name" placeholder="Enter your last name" required
                                    value="<?= $escapeAdoptionValue($adoptionPageState['form_values']['last_name'] ?? $adoptionPageState['applicant_profile']['last_name']) ?>"
                                    class="w-full rounded-xl border border-border bg-background px-4 py-3 text-sm text-text outline-none transition placeholder:text-muted/70 focus:border-primary focus:ring-4 focus:ring-primary/10">
                            </div>

                            <div class="sm:col-span-2">
                                <label for="applicant-age"
                                    class="mb-2 block text-sm font-semibold text-text">Age</label>
                                <input id="applicant-age" name="age" type="number" min="0" max="255" inputmode="numeric"
                                    autocomplete="off" placeholder="Enter your age" required
                                    value="<?= $escapeAdoptionValue($adoptionPageState['form_values']['age'] ?? $adoptionPageState['applicant_profile']['age']) ?>"
                                    class="w-full rounded-xl border border-border bg-background px-4 py-3 text-sm text-text outline-none transition placeholder:text-muted/70 focus:border-primary focus:ring-4 focus:ring-primary/10 sm:max-w-xs">
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <button type="button" id="adoption-next-step"
                                class="inline-flex items-center gap-2 rounded-xl bg-tertiary px-6 py-3 text-sm font-semibold text-white transition-all hover:bg-primary hover:rounded-none">
                                Next <i class="bx bx-right-arrow-alt text-lg" aria-hidden="true"></i>
                            </button>
                        </div>
                    </section>
                    <!-- :: END APPLICANT DETAILS STEP -->

                    <!-- :: START ADOPTION DETAILS STEP -->
                    <section data-adoption-step="2" class="<?= $adoptionPageState['form_step'] === 2 ? '' : 'hidden' ?>">
                        <div class="grid gap-5 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label for="applicant-address"
                                    class="mb-2 block text-sm font-semibold text-text">Address</label>
                                <input id="applicant-address" name="address" type="text" maxlength="255"
                                    autocomplete="street-address" placeholder="House number, street, city" required
                                    value="<?= $escapeAdoptionValue($adoptionPageState['form_values']['address'] ?? '') ?>"
                                    class="w-full rounded-xl border border-border bg-background px-4 py-3 text-sm text-text outline-none transition placeholder:text-muted/70 focus:border-primary focus:ring-4 focus:ring-primary/10">
                            </div>

                            <div>
                                <label for="monthly-income" class="mb-2 block text-sm font-semibold text-text">Monthly
                                    income</label>
                                <input id="monthly-income" name="monthly_income" type="number" min="0" max="99999999.99"
                                    step="0.01" inputmode="decimal" placeholder="e.g. 25000" required
                                    value="<?= $escapeAdoptionValue($adoptionPageState['form_values']['monthly_income'] ?? '') ?>"
                                    class="w-full rounded-xl border border-border bg-background px-4 py-3 text-sm text-text outline-none transition placeholder:text-muted/70 focus:border-primary focus:ring-4 focus:ring-primary/10">
                            </div>

                            <div>
                                <label for="occupation"
                                    class="mb-2 block text-sm font-semibold text-text">Occupation</label>
                                <input id="occupation" name="occupation" type="text" maxlength="100"
                                    autocomplete="organization-title" placeholder="Your occupation" required
                                    value="<?= $escapeAdoptionValue($adoptionPageState['form_values']['occupation'] ?? '') ?>"
                                    class="w-full rounded-xl border border-border bg-background px-4 py-3 text-sm text-text outline-none transition placeholder:text-muted/70 focus:border-primary focus:ring-4 focus:ring-primary/10">
                            </div>

                            <div>
                                <label for="household-members"
                                    class="mb-2 block text-sm font-semibold text-text">Household members</label>
                                <input id="household-members" name="household_members" type="number" min="1" max="255"
                                    inputmode="numeric" placeholder="Number of people in your household" required
                                    value="<?= $escapeAdoptionValue($adoptionPageState['form_values']['household_members'] ?? '') ?>"
                                    class="w-full rounded-xl border border-border bg-background px-4 py-3 text-sm text-text outline-none transition placeholder:text-muted/70 focus:border-primary focus:ring-4 focus:ring-primary/10">
                            </div>

                            <fieldset>
                                <legend class="mb-2 block text-sm font-semibold text-text">Are you committed to caring
                                    for this pet?</legend>
                                <div class="flex gap-5">
                                    <label class="inline-flex items-center gap-2 text-sm text-text">
                                        <input type="radio" name="is_committed" value="Y" required
                                            <?= ($adoptionPageState['form_values']['is_committed'] ?? '') === 'Y' ? 'checked' : '' ?>
                                            class="size-4 accent-primary">
                                        Yes
                                    </label>
                                    <label class="inline-flex items-center gap-2 text-sm text-text">
                                        <input type="radio" name="is_committed" value="N" required
                                            <?= ($adoptionPageState['form_values']['is_committed'] ?? '') === 'N' ? 'checked' : '' ?>
                                            class="size-4 accent-primary">
                                        No
                                    </label>
                                </div>
                            </fieldset>

                            <div class="sm:col-span-2">
                                <label for="reason-for-adoption"
                                    class="mb-2 block text-sm font-semibold text-text">Reason for adoption</label>
                                <textarea id="reason-for-adoption" name="reason_for_adoption" rows="4" required
                                    placeholder="Tell us why you would like to adopt this pet"
                                    class="w-full resize-y rounded-xl border border-border bg-background px-4 py-3 text-sm text-text outline-none transition placeholder:text-muted/70 focus:border-primary focus:ring-4 focus:ring-primary/10"><?= $escapeAdoptionValue($adoptionPageState['form_values']['reason_for_adoption'] ?? '') ?></textarea>
                            </div>
                        </div>

                        <div class="mt-8 flex flex-wrap justify-between gap-3">
                            <button type="button" id="adoption-previous-step"
                                class="rounded-xl border border-border bg-card-inner px-5 py-3 text-sm font-semibold text-text transition-all duration-200 hover:bg-card-inner-hover hover:rounded-none">
                                Back
                            </button>
                            <button type="submit"
                                class="inline-flex items-center gap-2 rounded-xl bg-tertiary px-6 py-3 text-sm font-semibold text-white transition-all hover:bg-primary hover:rounded-none">
                                Submit application <i class="bx bx-check text-lg" aria-hidden="true"></i>
                            </button>
                        </div>
                    </section>
                    <!-- :: END ADOPTION DETAILS STEP -->
                </form>
            </div>
        </div>
        <!-- :: END ADOPTION APPLICATION MODAL -->

        <!-- START SERVICE SECTION -->
        <section class="relative w-full min-h-125 overflow-hidden py-18 px-7 sm:px-8 mt-25">
            <?php include "../includes/include_service.php"; ?>
        </section>

        <!-- :: START GALLERY SECTION -->
        <section class=" w-full bg-card-inner px-7 py-15 sm:py-20 lg:py-40 sm:px-8 border-y border-gray-400/40">
            <?php include "../includes/include_gallery.php"; ?>
        </section>
        <!-- :: END GALLERY SECTION -->

        <!-- START FAQ SECTION -->
        <section class="my-10 w-full bg-white px-7 py-18 sm:px-8 md:my-30">
            <?php include "../includes/faqs.php"; ?>
        </section>
        <!-- END FAQ SECTION -->
    </main>

    <!-- :: START FOOTER REDESIGN -->
    <footer class="relative w-full overflow-hidden bg-black text-white">
        <?php include "../includes/footer.php"; ?>
    </footer>
    <!-- :: END FOOTER REDESIGN -->

    <!-- :: START PET DETAILS MODAL HANDLERS -->
    <script>
        const petModal = document.getElementById('default-modal');
        const petModalName = document.getElementById('pet-modal-name');
        const petModalSubtitle = document.getElementById('pet-modal-subtitle');
        const petModalImage = document.getElementById('pet-modal-image');
        const petModalFields = {
            species: document.getElementById('pet-modal-species'),
            breed: document.getElementById('pet-modal-breed'),
            age: document.getElementById('pet-modal-age'),
            sex: document.getElementById('pet-modal-sex'),
            behavior: document.getElementById('pet-modal-behavior'),
            health: document.getElementById('pet-modal-health'),
            rescue: document.getElementById('pet-modal-rescue')
        };
        const fallbackPetImage = 'https://placehold.co/800x800?text=Pet';

        function openPetDetails(button) {
            const pet = button.dataset;
            const petName = pet.petName || 'Pet details';

            petModalName.textContent = petName;
            petModalSubtitle.textContent = [pet.petSpecies, pet.petBreed].filter(Boolean).join(' · ') || 'Meet your new companion.';
            petModalImage.src = pet.petImage || fallbackPetImage;
            petModalImage.alt = `${petName} available for adoption`;
            petModalFields.species.textContent = pet.petSpecies || 'Not provided';
            petModalFields.breed.textContent = pet.petBreed || 'Not provided';
            petModalFields.age.textContent = pet.petAge ? `${pet.petAge} ${pet.petAge === '1' ? 'year' : 'years'} old` : 'Not provided';
            petModalFields.sex.textContent = pet.petSex || 'Not provided';
            petModalFields.behavior.textContent = pet.petBehavior || 'Details coming soon.';
            petModalFields.health.textContent = pet.petHealth || 'Details coming soon.';
            petModalFields.rescue.textContent = pet.petRescue || 'Details coming soon.';

            petModal.classList.remove('hidden');
            petModal.classList.add('flex');
            petModal.setAttribute('aria-hidden', 'false');
            document.body.classList.add('overflow-hidden');
        }

        function closePetDetails() {
            petModal.classList.add('hidden');
            petModal.classList.remove('flex');
            petModal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('overflow-hidden');
        }

        document.querySelectorAll('[data-pet-details-open]').forEach((button) => {
            button.addEventListener('click', () => {
                openPetDetails(button);
            });
        });

        document.querySelectorAll('[data-pet-modal-close]').forEach((button) => {
            button.addEventListener('click', closePetDetails);
        });

        petModal.addEventListener('click', (event) => {
            if (event.target === petModal) closePetDetails();
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !petModal.classList.contains('hidden')) {
                closePetDetails();
            }
        });
    </script>
    <!-- :: END PET DETAILS MODAL HANDLERS -->

    <!-- :: START ADOPTION APPLICATION MODAL HANDLERS -->
    <script>
        const adoptionModal = document.getElementById('adoption-modal');
        const adoptionForm = document.getElementById('adoption-application-form');
        const adoptionPetId = document.getElementById('adoption-pet-id');
        const adoptionPetName = document.getElementById('adoption-pet-name');
        const adoptionStepNumber = document.getElementById('adoption-step-number');
        const adoptionSteps = [...adoptionForm.querySelectorAll('[data-adoption-step]')];

        function showAdoptionStep(stepNumber) {
            adoptionSteps.forEach((step) => {
                step.classList.toggle('hidden', Number(step.dataset.adoptionStep) !== stepNumber);
            });
            adoptionStepNumber.textContent = String(stepNumber);
        }

        function openAdoptionModal(button) {
            adoptionForm.reset();
            adoptionPetId.value = button.dataset.petId;
            adoptionPetName.textContent = button.dataset.petName || 'this pet';
            showAdoptionStep(1);
            adoptionModal.classList.remove('hidden');
            adoptionModal.classList.add('flex');
            adoptionModal.setAttribute('aria-hidden', 'false');
            document.body.classList.add('overflow-hidden');
        }

        function closeAdoptionModal() {
            adoptionModal.classList.add('hidden');
            adoptionModal.classList.remove('flex');
            adoptionModal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('overflow-hidden');
        }

        document.querySelectorAll('[data-adoption-modal-open]').forEach((button) => {
            button.addEventListener('click', () => openAdoptionModal(button));
        });

        document.querySelectorAll('[data-adoption-modal-close]').forEach((button) => {
            button.addEventListener('click', closeAdoptionModal);
        });

        document.getElementById('adoption-next-step').addEventListener('click', () => {
            const firstStepFields = [...adoptionSteps[0].querySelectorAll('input[required]')];
            const invalidField = firstStepFields.find((field) => !field.checkValidity());

            if (invalidField) {
                invalidField.reportValidity();
                return;
            }

            showAdoptionStep(2);
        });

        document.getElementById('adoption-previous-step').addEventListener('click', () => {
            showAdoptionStep(1);
        });

        adoptionForm.addEventListener('submit', (event) => {
            if (adoptionForm.checkValidity()) {
                return;
            }

            event.preventDefault();
            const invalidField = adoptionForm.querySelector(':invalid');
            const invalidStep = Number(invalidField.closest('[data-adoption-step]').dataset.adoptionStep);
            showAdoptionStep(invalidStep);
            invalidField.reportValidity();
        });

        adoptionModal.addEventListener('click', (event) => {
            if (event.target === adoptionModal) {
                closeAdoptionModal();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !adoptionModal.classList.contains('hidden')) {
                closeAdoptionModal();
            }
        });

        <?php if ($adoptionPageState['show_modal']): ?>
            adoptionPetName.textContent = 'this pet';
            adoptionModal.classList.remove('hidden');
            adoptionModal.classList.add('flex');
            adoptionModal.setAttribute('aria-hidden', 'false');
            document.body.classList.add('overflow-hidden');
        <?php endif; ?>
    </script>
    <!-- :: END ADOPTION APPLICATION MODAL HANDLERS -->

    <script src=" https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="./assets/scripts/main.js"></script>
</body>

</html>
