<?php
// :: START CUSTOMER REGISTRATION HANDLER
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\Authentication_Controller;

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$auth = new Authentication_Controller();
$registerMessage = '';
$registrationComplete = false;

if ($auth->isLogin()) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $registerMessage = $auth->createAccount() ?? '';
    $registrationComplete = $registerMessage === 'Registration successful. You can now sign in.';
}
// :: END CUSTOMER REGISTRATION HANDLER
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#fff9f0">

    <link rel="stylesheet" href="src/output.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.9.0/fonts/remixicon.css" rel="stylesheet" />

    <title>Create account | PAWSITIVE</title>
</head>

<body class="min-h-screen bg-background text-text font-primary antialiased">
    <!-- :: START CUSTOMER REGISTRATION PAGE -->
    <main class="relative flex min-h-screen items-center justify-center overflow-hidden px-4 py-10 sm:px-6 lg:px-8">
        <div aria-hidden="true"
            class="pointer-events-none absolute -left-28 -top-32 h-80 w-80 rounded-full bg-primary/10 blur-3xl"></div>
        <div aria-hidden="true"
            class="pointer-events-none absolute -bottom-36 -right-24 h-96 w-96 rounded-full bg-secondary/20 blur-3xl">
        </div>

        <div
            class="relative grid w-full max-w-5xl overflow-hidden rounded-3xl border border-border bg-card-outer shadow-[0_24px_80px_rgba(51,51,51,0.10)] lg:min-h-[600px] lg:grid-cols-2">
            <section
                class="relative hidden flex-col justify-between overflow-hidden bg-text p-10 text-white lg:flex xl:p-14">
                <div aria-hidden="true"
                    class="absolute inset-0 bg-gradient-to-br from-primary/30 via-transparent to-tertiary/35"></div>
                <div aria-hidden="true"
                    class="absolute -right-24 -top-20 h-72 w-72 rounded-full border-[40px] border-white/10"></div>
                <div aria-hidden="true"
                    class="absolute -bottom-32 -left-24 h-80 w-80 rounded-full border-[54px] border-secondary/20"></div>

                <div class="relative flex items-center gap-3">
                    <span
                        class="flex h-11 w-11 items-center justify-center rounded-2xl bg-primary text-xl text-white shadow-lg shadow-primary/20">
                        <i class="ri-sparkling-2-line" aria-hidden="true"></i>
                    </span>
                    <span class="text-sm font-bold tracking-[0.18em]">PAWSITIVE</span>
                </div>

                <div class="relative max-w-sm">
                    <p class="mb-4 text-xs font-semibold uppercase tracking-[0.24em] text-primary">Join our community
                    </p>
                    <h1 class="font-sans text-4xl font-bold leading-tight xl:text-5xl">A little kindness changes
                        everything.</h1>
                    <p class="mt-5 font-sans text-base leading-7 text-white/75">Create your account and take the first
                        step toward finding a loving companion.</p>
                </div>

                <div class="relative flex items-center gap-3 text-xs font-sans text-white/60">
                    <span class="h-px w-8 bg-primary"></span>
                    <span>Every pet deserves a loving home.</span>
                </div>
            </section>

            <section class="flex items-center justify-center px-6 py-10 sm:px-10 lg:px-12 xl:px-16">
                <div class="w-full max-w-md">
                    <div class="mb-9 lg:hidden">
                        <span
                            class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-primary text-xl text-white shadow-lg shadow-primary/20">
                            <i class="ri-sparkling-2-line" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="mb-8">
                        <p class="mb-3 text-xs font-bold uppercase tracking-[0.2em] text-primary">Get started</p>
                        <h2 class="font-sans text-3xl font-bold tracking-tight text-text sm:text-4xl">Create your
                            account</h2>
                        <p class="mt-3 font-sans text-sm leading-6 text-muted">Register with your email to get started.
                        </p>
                    </div>

                    <?php if ($registerMessage !== ''): ?>
                        <!-- :: START REGISTRATION MESSAGE -->
                        <p role="alert"
                            class="mb-5 rounded-xl border <?= $registrationComplete ? 'border-primary/30 bg-primary/10 text-primary-hover' : 'border-tertiary/30 bg-tertiary/10 text-tertiary' ?> px-4 py-3 font-sans text-sm">
                            <?= htmlspecialchars($registerMessage, ENT_QUOTES, 'UTF-8') ?>
                        </p>
                        <!-- :: END REGISTRATION MESSAGE -->
                    <?php endif; ?>

                    <form action="" method="post" class="space-y-5">
                        <div>
                            <label for="email" class="mb-2 block font-sans text-sm font-semibold text-text">
                                Email address</label>
                            <div class="relative">
                                <i class="ri-mail-line pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-lg text-muted"
                                    aria-hidden="true"></i>
                                <input type="email" name="email" id="email" autocomplete="email"
                                    placeholder="you@example.com" required
                                    class="w-full rounded-xl border border-border bg-card-inner px-4 py-3.5 pl-11 font-sans text-sm text-text outline-none transition placeholder:text-muted/70 focus:border-primary focus:ring-4 focus:ring-primary/10">
                            </div>
                        </div>

                        <div>
                            <label for="password"
                                class="mb-2 block font-sans text-sm font-semibold text-text">Password</label>
                            <div class="relative">
                                <i class="ri-lock-2-line pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-lg text-muted"
                                    aria-hidden="true"></i>
                                <input type="password" name="password" id="password" autocomplete="new-password"
                                    minlength="8" placeholder="At least 8 characters" required
                                    class="w-full rounded-xl border border-border bg-card-inner px-4 py-3.5 pl-11 font-sans text-sm text-text outline-none transition placeholder:text-muted/70 focus:border-primary focus:ring-4 focus:ring-primary/10">
                            </div>
                        </div>

                        <div>
                            <label for="confirm_password"
                                class="mb-2 block font-sans text-sm font-semibold text-text">Confirm password</label>
                            <div class="relative">
                                <i class="ri-lock-password-line pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-lg text-muted"
                                    aria-hidden="true"></i>
                                <input type="password" name="confirm_password" id="confirm_password"
                                    autocomplete="new-password" minlength="8" placeholder="Re-enter your password"
                                    required
                                    class="w-full rounded-xl border border-border bg-card-inner px-4 py-3.5 pl-11 font-sans text-sm text-text outline-none transition placeholder:text-muted/70 focus:border-primary focus:ring-4 focus:ring-primary/10">
                            </div>
                        </div>

                        <button type="submit" name="register-btn"
                            class="group mt-2 flex w-full items-center justify-center gap-2 rounded-xl bg-primary px-5 py-3.5 font-sans text-sm font-bold text-white shadow-lg shadow-primary/20 transition hover:-translate-y-0.5 hover:bg-primary-hover focus:outline-none focus:ring-4 focus:ring-primary/20">
                            Create account
                            <i class="ri-arrow-right-line text-lg transition-transform group-hover:translate-x-1"
                                aria-hidden="true"></i>
                        </button>
                    </form>

                    <p class="mt-8 text-center font-sans text-sm text-muted">
                        Already have an account?
                        <a href="login.php"
                            class="ml-1 font-bold text-primary transition hover:text-primary-hover hover:underline">
                            Sign in</a>
                    </p>
                </div>
            </section>
        </div>
    </main>
    <!-- :: END CUSTOMER REGISTRATION PAGE -->
</body>

</html>