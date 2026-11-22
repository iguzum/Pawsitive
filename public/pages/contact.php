<?php
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
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <title>Contact Us | PAWSITIVE</title>
</head>

<body class="min-h-screen w-full">
    <div class="w-full relative">
        <div
            class="w-full h-210 bg-[url('./../assets/pictures/contact_hero.png')] bg-cover bg-center bg-no-repeat relative flex items-center justify-center">

            <!-- START NAVIGATION HEADER -->
            <div class="w-full fixed top-0 left-0 right-0 z-999999 my-4 mt-0 bg-white">
                <div class=" w-full max-w-350 mx-auto">
                    <?php include "../../includes/header.php"; ?>
                </div>
            </div>
            <!-- END NAVIGATION HEADER -->

            <!-- :: START Mobile Responsive Contact Section -->

            <div
                class="w-full sm:h-full max-w-350 mx-auto flex flex-col items-center gap-8 px-4 py-10 sm:px-6 justify-center mt-20 md:mt-20 lg:mt-0">

                <div class="flex flex-col w-full max-w-xl justify-center items-center gap-3 text-center md:h-full">

                    <h1
                        class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-tertiary leading-tight tracking-wide">
                        Contact Us
                    </h1>

                    <p class="mt-4 max-w-2xl text-sm leading-7 text-muted sm:text-md md:text-lg">
                        Check today’s hours, find us on the map or send a quick question — we’re happy to help before
                        you book.
                    </p>

                </div>

                <div class="grid grid-cols-2 lg:grid-cols-4 w-full gap-1 md:gap-6">

                    <div
                        class="flex flex-col justify-center items-center text-center gap-2 text-text px-2 sm:px-4 py-4 sm:py-6 min-w-0">
                        <i class="bx bx-location text-5xl sm:text-6xl lg:text-7xl"></i>

                        <h1 class="text-lg sm:text-2xl font-bold">Our Location</h1>

                        <p
                            class="text-xs sm:text-sm lg:text-base text-muted font-light leading-relaxed wrap-break-word">
                            Arellano St., Dagupan City, 2400 Pangasinan, Philippines
                        </p>
                    </div>

                    <div
                        class="flex flex-col justify-center items-center text-center gap-2 text-text px-2 sm:px-4 py-4 sm:py-6 min-w-0">
                        <i class="bx bx-clock text-5xl sm:text-5xl lg:text-7xl"></i>

                        <h1 class="text-lg sm:text-2xl font-bold">Open Hours</h1>

                        <p
                            class="text-xs sm:text-sm lg:text-base text-muted font-light leading-relaxed wrap-break-word">
                            Monday-Friday 8am - 5pm
                            <br>
                            Saturday-Sunday 1pm - 5pm
                        </p>
                    </div>

                    <div
                        class="flex flex-col justify-center items-center text-center gap-2 text-text px-2 sm:px-4 py-4 sm:py-6 min-w-0">
                        <i class="bx bx-envelope text-5xl sm:text-6xl lg:text-7xl"></i>

                        <h1 class="text-lg sm:text-2xl font-bold">Email</h1>

                        <p
                            class="text-xs sm:text-sm lg:text-base text-muted font-light leading-relaxed wrap-break-word">
                            pawsitive@gmail.com
                            <br>
                            pethub@gmail.com
                        </p>
                    </div>

                    <div
                        class="flex flex-col justify-center items-center text-center gap-2 text-text px-2 sm:px-4 py-4 sm:py-6 min-w-0">
                        <i class="bx bx-phone text-5xl sm:text-6xl lg:text-7xl"></i>

                        <h1 class="text-lg sm:text-2xl font-bold">Phone</h1>

                        <p
                            class="text-xs sm:text-sm lg:text-base text-muted font-light leading-relaxed wrap-break-word">
                            Smart: +63971214798
                            <br>
                            Globe: +639618439955
                        </p>
                    </div>
                </div>
            </div>
            <!-- :: END Mobile Responsive Contact Section -->
        </div>
    </div>

    <!-- START CONTACT SECTION -->
    <section class="w-full flex mt-10 bg-card-outer px-5 py-18 sm:px-8 sm:py-20 md:mt-20">
        <?php include "../../includes/include_contact.php"; ?>
    </section>

    <footer class="relative w-full overflow-hidden bg-black text-white">
        <?php include "../../includes/footer.php"; ?>
    </footer>
    <!-- END CONTACT SECTION -->

    <script src=" https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="../assets/scripts/main.js"></script>
</body>

</html>