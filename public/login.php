<?php
// :: START LOGIN SESSION HANDLER
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\Authentication_Controller;

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$auth = new Authentication_Controller();
$loginError = '';

if ($auth->isLogin()) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loginError = $auth->login() ?? '';
}
// :: END LOGIN SESSION HANDLER
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#fff9f0">

    <link rel="stylesheet" href="src/output.css">
    <link href="https://cdn.boxicons.com/3.0.8/fonts/basic/boxicons.min.css" rel="stylesheet">

    <title>Sign in | Welcome Back</title>
</head>

<body class="min-h-screen bg-background text-text font-primary antialiased">
    <!-- :: START LOGIN PAGE DESIGN -->
    <main class="relative flex min-h-screen items-center justify-center overflow-hidden px-4 py-10 sm:px-6 lg:px-8">
        <div
            class="relative grid w-full max-w-5xl overflow-hidden -mt-25 md:mt-0 rounded-3xl border border-border bg-card-outer shadow-[0_24px_80px_rgba(51,51,51,0.10)] lg:min-h-150 lg:grid-cols-2">
            <section
                class="relative hidden flex-col justify-between overflow-hidden bg-black p-10 text-white lg:flex xl:p-14">

                <!-- :: START BACKGROUND IMAGE AND DARK OVERLAY -->
                <img src="./assets/pictures/dog_and_cat.jpg" alt="" aria-hidden="true"
                    class="absolute inset-0 z-0 h-full w-full object-cover select-none pointer-events-none">

                <!-- :: END BACKGROUND IMAGE AND DARK OVERLAY -->

                <!-- :: START CONTENT ABOVE OVERLAY -->

                <div class="relative z-20 max-w-sm">
                    <p class="mb-2 text-xs font-semibold uppercase tracking-[0.2em] text-primary">
                        A good day starts here
                    </p>
                    <h1 class="text-3xl font-bold leading-tighter tracking-wider">STAY PAWSITIVE.</h1>
                </div>

                <!-- :: END CONTENT ABOVE OVERLAY -->
            </section>

            <section class="flex items-center justify-center px-6 py-10 sm:px-10 lg:px-12 xl:px-16">
                <div class="w-full max-w-md">


                    <div class="mb-8">
                        <p class="mb-3 text-xs font-bold uppercase tracking-[0.2em] text-primary">Welcome back</p>
                        <h2 class=" text-3xl font-bold tracking-normal text-text sm:text-4xl">Sign in to your
                            account</h2>
                        <p class="mt-3 text-sm leading-6 text-muted">Enter your details below to continue.</p>
                    </div>

                    <form action="" method="post" class="space-y-5">
                        <?php if ($loginError !== ''): ?>
                            <!-- :: START LOGIN ERROR MESSAGE -->
                            <p role="alert"
                                class="rounded-xl border border-tertiary/30 bg-tertiary/10 px-4 py-3 text-sm text-tertiary">
                                <?= htmlspecialchars($loginError, ENT_QUOTES, 'UTF-8') ?>
                            </p>
                            <!-- :: END LOGIN ERROR MESSAGE -->
                        <?php endif; ?>

                        <div>
                            <label for="email" class="mb-2 block text-sm font-semibold text-text">Email
                                address</label>
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
                                <input type="password" name="password" id="password" autocomplete="current-password"
                                    placeholder="Enter your password" required
                                    class="w-full rounded-xl border border-border bg-card-inner px-4 py-3.5 pl-11 text-sm text-text outline-none transition placeholder:text-muted/70 focus:border-primary focus:ring-4 focus:ring-primary/10">
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center justify-between gap-3 py-3 text-sm">
                            <label for="remember"
                                class="inline-flex cursor-pointer items-center gap-2.5 text-muted text-xs">
                                <input type="checkbox" name="remember" id="remember"
                                    class="h-4 w-4 rounded border-border accent-primary focus:ring-primary">
                                Remember me
                            </label>
                            <a href=""
                                class="font-semibold text-primary transition hover:text-primary-hover hover:underline text-xs">
                                Forgot password?</a>
                        </div>

                        <button type="submit" name="login-btn"
                            class="group mt-2 flex w-full items-center justify-center gap-2 rounded-xl bg-primary px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-primary/20 transition-all duration-200 hover:rounded-none hover:bg-tertiary focus:outline-none focus:ring-4 focus:ring-primary-hover">
                            Sign in
                        </button>
                    </form>

                    <p class="mt-8 text-center text-xs text-muted">
                        Don’t have an account?
                        <!-- :: START REGISTRATION PAGE LINK -->
                        <a href="register.php"
                            class="ml-1 font-bold text-primary transition hover:text-primary-hover hover:underline">Create
                            one</a>
                        <!-- :: END REGISTRATION PAGE LINK -->
                    </p>
                </div>
            </section>
        </div>
    </main>
    <!-- :: END LOGIN PAGE DESIGN -->
</body>

</html>