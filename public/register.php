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
    <link href="https://cdn.boxicons.com/3.0.8/fonts/basic/boxicons.min.css" rel="stylesheet">

    <title>Create account | PAWSITIVE</title>
</head>

<body class="min-h-screen bg-background text-text font-primary antialiased">
    <!-- :: START REGISTRATION DESIGN MATCHING LOGIN -->
    <main class="relative flex min-h-screen items-center justify-center overflow-hidden px-4 py-10 sm:px-6 lg:px-8">
        <div
            class="relative -mt-25 grid w-full max-w-5xl overflow-hidden rounded-3xl border border-border bg-card-outer shadow-[0_24px_80px_rgba(51,51,51,0.10)] md:mt-0 lg:min-h-150 lg:grid-cols-2">
            <section
                class="relative hidden flex-col justify-between overflow-hidden bg-black p-10 text-white lg:flex xl:p-14">

                <!-- :: START MATCHED LOGIN PHOTO PANEL -->
                <img src="./assets/pictures/dog_and_cat.jpg" alt="" aria-hidden="true"
                    class="pointer-events-none absolute inset-0 z-0 h-full w-full select-none object-cover">
                <div class="relative z-20 max-w-sm">
                    <p class="mb-2 text-xs font-semibold uppercase tracking-[0.2em] text-primary">A good day starts here</p>
                    <h1 class="text-3xl font-bold leading-tight tracking-wider">STAY PAWSITIVE.</h1>
                </div>
                <!-- :: END MATCHED LOGIN PHOTO PANEL -->
            </section>

            <section class="flex items-center justify-center px-6 py-10 sm:px-10 lg:px-12 xl:px-16">
                <div class="w-full max-w-md">
                    <div class="mb-8">
                        <p class="mb-3 text-xs font-bold uppercase tracking-[0.2em] text-primary">Get started</p>
                        <h2 class="text-3xl font-bold tracking-normal text-text sm:text-4xl">Create your account</h2>
                        <p class="mt-3 text-sm leading-6 text-muted">Enter your details below to join PAWSITIVE.</p>
                    </div>

                    <?php if ($registerMessage !== ''): ?>
                        <!-- :: START REGISTRATION MESSAGE -->
                        <p role="alert"
                            class="mb-5 rounded-xl border <?= $registrationComplete ? 'border-primary/30 bg-primary/10 text-primary-hover' : 'border-tertiary/30 bg-tertiary/10 text-tertiary' ?> px-4 py-3 text-sm">
                            <?= htmlspecialchars($registerMessage, ENT_QUOTES, 'UTF-8') ?>
                        </p>
                        <!-- :: END REGISTRATION MESSAGE -->
                    <?php endif; ?>

                    <form action="" method="post" class="space-y-5">
                        <div>
                            <label for="email" class="mb-2 block text-sm font-semibold text-text">Email address</label>
                            <div class="relative">
                                <i class="bx bx-envelope pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-lg text-muted"
                                    aria-hidden="true"></i>
                                <input type="email" name="email" id="email" autocomplete="email"
                                    placeholder="you@example.com" required
                                    class="w-full rounded-xl border border-border bg-card-inner px-4 py-3.5 pl-11 text-sm text-text outline-none transition placeholder:text-muted/70 focus:border-primary focus:ring-4 focus:ring-primary/10">
                            </div>
                        </div>

                        <div>
                            <label for="password" class="mb-2 block text-sm font-semibold text-text">Password</label>
                            <div class="relative">
                                <i class="bx bx-lock pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-lg text-muted"
                                    aria-hidden="true"></i>
                                <input type="password" name="password" id="password" autocomplete="new-password"
                                    minlength="8" placeholder="At least 8 characters" required
                                    class="w-full rounded-xl border border-border bg-card-inner px-4 py-3.5 pl-11 text-sm text-text outline-none transition placeholder:text-muted/70 focus:border-primary focus:ring-4 focus:ring-primary/10">
                            </div>
                        </div>

                        <div>
                            <label for="confirm_password" class="mb-2 block text-sm font-semibold text-text">Confirm password</label>
                            <div class="relative">
                                <i class="bx bx-lock pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-lg text-muted"
                                    aria-hidden="true"></i>
                                <input type="password" name="confirm_password" id="confirm_password"
                                    autocomplete="new-password" minlength="8" placeholder="Re-enter your password"
                                    required
                                    class="w-full rounded-xl border border-border bg-card-inner px-4 py-3.5 pl-11 text-sm text-text outline-none transition placeholder:text-muted/70 focus:border-primary focus:ring-4 focus:ring-primary/10">
                            </div>
                        </div>

                        <button type="submit" name="register-btn"
                            class="group mt-2 flex w-full items-center justify-center gap-2 rounded-xl bg-primary px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-primary/20 transition-all duration-200 hover:rounded-none hover:bg-tertiary focus:outline-none focus:ring-4 focus:ring-primary-hover">
                            Create account
                            <i class="bx bx-right-arrow-alt text-lg transition-transform group-hover:translate-x-1"
                                aria-hidden="true"></i>
                        </button>
                    </form>

                    <p class="mt-8 text-center text-xs text-muted">
                        Already have an account?
                        <a href="login.php"
                            class="ml-1 font-bold text-primary transition hover:text-primary-hover hover:underline">
                            Sign in</a>
                    </p>
                </div>
            </section>
        </div>
    </main>
    <!-- :: END REGISTRATION DESIGN MATCHING LOGIN -->
    <!-- :: START LOAD AOS FOR REGISTRATION -->
    <?php require __DIR__ . '/../includes/aos.php'; ?>
    <!-- :: END LOAD AOS FOR REGISTRATION -->
</body>

</html>
