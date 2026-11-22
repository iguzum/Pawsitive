<?php
// :: START ABOUT PAGE FILE
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Controller\Authentication_Controller;

$auth = new Authentication_Controller();

if (!$auth->isLogin()) {
    header('Location: ../login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/output.css">
    <link href="https://cdn.boxicons.com/3.0.8/fonts/basic/boxicons.min.css" rel="stylesheet">
    <title>About Us | PAWSITIVE</title>
</head>

<body class="min-h-screen w-full bg-background text-text">
    <header class="fixed top-0 left-0 right-0 z-50 bg-white">
        <div class="mx-auto w-full max-w-350">
            <?php include "../../includes/header.php"; ?>
        </div>
    </header>

    <!-- :: START ABOUT HERO -->
    <section id="about"
        class="relative flex min-h-210 items-center justify-center overflow-hidden bg-[url('../assets/pictures/about_hero.png')] bg-cover bg-center px-6 pb-16 pt-32 sm:min-h-210">
        <!-- <div class="absolute inset-0 bg-text/60"></div> -->

        <div class="relative z-10 mx-auto w-full max-w-350 text-center">
            <h1
                class="mx-auto mt-6 lg:mt-12 max-w-4xl text-4xl font-bold leading-tight text-tertiary sm:text-5xl md:text-7xl">
                About PAWSITIVE
            </h1>

            <p class="mx-auto mt-4 max-w-2xl sm:text-lg text-sm leading-7 text-muted sm:text-md md:text-lg">
                We believe every pet deserves care, patience, and the chance to feel at home.
                We help bring adoptable pets and caring people together.
            </p>

            <a href="../index.php#pets"
                class="mt-8 inline-flex items-center gap-2 rounded-xl bg-tertiary px-6 py-3 font-semibold text-white hover:bg-primary hover:rounded-none transition-all duration-200">
                Meet the pets
                <i class="bx bx-arrow-up-right text-lg" aria-hidden="true"></i>
            </a>
        </div>
    </section>
    <!-- :: END ABOUT HERO -->

    <main>
        <!-- :: START ABOUT CONTENT -->
        <section
            class="mx-auto grid w-full max-w-350 gap-10 px-6 py-16 sm:px-8 sm:py-24 lg:grid-cols-2 lg:items-center lg:gap-16">
            <div>
                <span class="text-sm font-bold uppercase tracking-[0.18em] text-tertiary">
                    Who we are
                </span>

                <h2 class="mt-4 text-3xl font-bold leading-tight text-text sm:text-4xl">
                    Every adoption can start a beautiful new chapter.
                </h2>

                <p class="mt-6 leading-8 text-muted">
                    PAWSITIVE is a pet adoption community built around thoughtful matches and compassionate care.
                    We want people to learn about a pet’s personality and needs, so they can make a choice that feels
                    right for both the pet and their household.
                </p>

                <p class="mt-4 leading-8 text-muted">
                    We believe adoption is more than bringing a pet home. It is a commitment to offer safety,
                    kindness, and a loving place to belong.
                </p>
            </div>

            <div class="rounded-3xl border border-border bg-card-inner p-7 sm:p-10">
                <div class="flex size-14 items-center justify-center rounded-2xl bg-card-outer text-3xl text-tertiary">
                    <i class="bx bx-paw-print" aria-hidden="true"></i>
                </div>

                <h3 class="mt-6 text-2xl font-bold text-text">Our purpose</h3>

                <p class="mt-4 leading-8 text-muted">
                    To help pets find caring homes and help future adopters make informed, thoughtful decisions.
                </p>
            </div>
        </section>
        <!-- :: END ABOUT CONTENT -->

        <!-- :: START OUR VALUES -->
        <section class="bg-card-inner px-6 py-16 sm:px-8 sm:py-20">
            <div class="mx-auto w-full max-w-350">
                <div class="mx-auto max-w-2xl text-center">
                    <span class="text-sm font-bold uppercase tracking-[0.18em] text-tertiary">
                        What matters to us
                    </span>

                    <h2 class="mt-4 text-3xl font-bold text-text sm:text-4xl">
                        Care at every step
                    </h2>

                    <p class="mt-4 leading-7 text-muted">
                        A thoughtful adoption experience starts with respect for each pet and each person.
                    </p>
                </div>

                <div class="mt-10 grid gap-5 md:grid-cols-3">
                    <article class="rounded-2xl border border-border bg-card-outer p-6">
                        <i class="bx bx-heart text-3xl text-tertiary" aria-hidden="true"></i>
                        <h3 class="mt-4 text-xl font-bold text-text">Compassion</h3>
                        <p class="mt-3 leading-7 text-muted">
                            We treat every pet with patience, kindness, and respect for their individual needs.
                        </p>
                    </article>

                    <article class="rounded-2xl border border-border bg-card-outer p-6">
                        <i class="bx bx-check-shield text-3xl text-tertiary" aria-hidden="true"></i>
                        <h3 class="mt-4 text-xl font-bold text-text">Thoughtful matches</h3>
                        <p class="mt-3 leading-7 text-muted">
                            We encourage adopters to understand a pet’s personality and care needs before making a
                            commitment.
                        </p>
                    </article>

                    <article class="rounded-2xl border border-border bg-card-outer p-6">
                        <i class="bx bx-home-heart text-3xl text-tertiary" aria-hidden="true"></i>
                        <h3 class="mt-4 text-xl font-bold text-text">Lifelong care</h3>
                        <p class="mt-3 leading-7 text-muted">
                            A loving home means showing up for a pet through every stage of life.
                        </p>
                    </article>
                </div>
            </div>
        </section>
        <!-- :: END OUR VALUES -->

        <!-- :: START TESTIMONIALS -->
        <section class="mx-auto w-full max-w-350 px-6 py-16 sm:px-8 sm:py-24">
            <div class="mx-auto max-w-2xl text-center">
                <span class="text-sm font-bold uppercase tracking-[0.18em] text-tertiary">
                    Adopter stories
                </span>

                <h2 class="mt-4 text-3xl font-bold text-text sm:text-4xl">
                    A new beginning, together
                </h2>

                <p class="mt-4 leading-7 text-muted">
                    Sample testimonials below. Replace these with approved feedback from real adopters.
                </p>
            </div>

            <div class="mt-10 grid gap-5 md:grid-cols-3">
                <article class="flex flex-col rounded-2xl border border-border bg-card-outer p-6 shadow-sm">
                    <div class="flex gap-1 text-secondary" aria-label="5 out of 5 stars">
                        <i class="bx bxs-star" aria-hidden="true"></i>
                        <i class="bx bxs-star" aria-hidden="true"></i>
                        <i class="bx bxs-star" aria-hidden="true"></i>
                        <i class="bx bxs-star" aria-hidden="true"></i>
                        <i class="bx bxs-star" aria-hidden="true"></i>
                    </div>

                    <blockquote class="mt-5 grow leading-7 text-muted">
                        “We took our time getting to know our new companion, and it made welcoming them home feel
                        even more special.”
                    </blockquote>

                    <div class="mt-6 border-t border-border pt-4">
                        <p class="font-bold text-text">Mark Kendra</p>
                        <p class="mt-1 text-sm text-muted">Adopter</p>
                    </div>
                </article>

                <article class="flex flex-col rounded-2xl border border-border bg-card-outer p-6 shadow-sm">
                    <div class="flex gap-1 text-secondary" aria-label="5 out of 5 stars">
                        <i class="bx bxs-star" aria-hidden="true"></i>
                        <i class="bx bxs-star" aria-hidden="true"></i>
                        <i class="bx bxs-star" aria-hidden="true"></i>
                        <i class="bx bxs-star" aria-hidden="true"></i>
                        <i class="bx bxs-star" aria-hidden="true"></i>
                    </div>

                    <blockquote class="mt-5 grow leading-7 text-muted">
                        “Our pet has become part of the family. We’re grateful we found a companion who fits our
                        home so well.”
                    </blockquote>

                    <div class="mt-6 border-t border-border pt-4">
                        <p class="font-bold text-text">Patrick Sterling</p>
                        <p class="mt-1 text-sm text-muted">Adopter</p>
                    </div>
                </article>

                <article class="flex flex-col rounded-2xl border border-border bg-card-outer p-6 shadow-sm">
                    <div class="flex gap-1 text-secondary" aria-label="5 out of 5 stars">
                        <i class="bx bxs-star" aria-hidden="true"></i>
                        <i class="bx bxs-star" aria-hidden="true"></i>
                        <i class="bx bxs-star" aria-hidden="true"></i>
                        <i class="bx bxs-star" aria-hidden="true"></i>
                        <i class="bx bxs-star" aria-hidden="true"></i>
                    </div>

                    <blockquote class="mt-5 grow leading-7 text-muted">
                        “Adoption has brought so much joy into our everyday life. We’re happy to give our pet a safe
                        and loving home.”
                    </blockquote>

                    <div class="mt-6 border-t border-border pt-4">
                        <p class="font-bold text-text">Jerico Smith</p>
                        <p class="mt-1 text-sm text-muted">Adopter</p>
                    </div>
                </article>
            </div>
        </section>
        <!-- :: END TESTIMONIALS -->
    </main>

    <!-- :: START ABOUT FOOTER -->
    <footer class="relative w-full overflow-hidden bg-black text-white">
        <?php include "../../includes/footer.php"; ?>
    </footer>
    <!-- :: END ABOUT FOOTER -->

    <script src="../assets/scripts/main.js"></script>
</body>

</html>
<?php
// :: END ABOUT PAGE FILE
?>