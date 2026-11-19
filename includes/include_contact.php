<div class="mx-auto grid w-full max-w-350 grid-cols-1 items-stretch gap-8 lg:grid-cols-2 lg:gap-12">

    <div class="flex flex-col justify-center gap-6">
        <div class="text-center flex flex-col justify-center items-start mb-10">
            <span class="text-sm font-semibold uppercase tracking-[0.2em] text-tertiary">Get in touch</span>
            <h2 class="text-2xl font-bold leading-tight text-text sm:text-3xl md:text-4xl lg:text-5xl mt-5">
                Contact Us
            </h2>
            <p class="w-full max-w-xl wrap-break-word text-justify text-md md:text-lg mt-5 text-muted leading-7">
                Have a question about adoption or want to share your pet story? Send us a message and our
                team will be happy to help.
            </p>
            <div class="w-24 h-2 bg-tertiary rounded-xl mt-5"></div>
        </div>

        <form action="#"
            class="grid w-full grid-cols-1 gap-5 rounded-3xl border border-border bg-card-inner p-5 shadow-sm sm:grid-cols-2 sm:p-8">
            <div class="sm:col-span-2">
                <label class="mb-2 block text-sm font-medium text-text" for="name">Name</label>
                <input
                    class="h-12 w-full rounded-xl border border-border bg-background px-4 text-text placeholder:text-muted focus:border-tertiary focus:outline-hidden focus:ring-2 focus:ring-tertiary/20"
                    id="name" name="name" type="text" placeholder="e.g. Juan Dela Cruz" />
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-text" for="email">Email</label>
                <input
                    class="h-12 w-full rounded-xl border border-border bg-background px-4 text-text placeholder:text-muted focus:border-tertiary focus:outline-hidden focus:ring-2 focus:ring-tertiary/20"
                    id="email" name="email" type="email" placeholder="e.g. juan@email.com" />
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-text" for="phone">Phone</label>
                <input
                    class="h-12 w-full rounded-xl border border-border bg-background px-4 text-text placeholder:text-muted focus:border-tertiary focus:outline-hidden focus:ring-2 focus:ring-tertiary/20"
                    id="phone" name="phone" type="tel" placeholder="+63 912 345 6780" pattern="^(09\d{0}|\+63\d{10}" />
            </div>

            <div class="sm:col-span-2">
                <label class="mb-2 block text-sm font-medium text-text" for="message">Message</label>
                <textarea
                    class="w-full resize-none rounded-xl border border-border bg-background px-4 py-3 text-text placeholder:text-muted focus:border-tertiary focus:outline-hidden focus:ring-2 focus:ring-tertiary/20"
                    id="message" name="message" rows="5" placeholder="Tell us how we can help..."></textarea>
            </div>

            <div class="sm:col-span-2">
                <button
                    class="inline-flex w-full items-center justify-center rounded-xl bg-tertiary px-6 py-3.5 text-sm font-semibold text-white transition-all duration-200 hover:bg-primary hover:rounded-none focus:outline-hidden focus:ring-2 focus:ring-tertiary focus:ring-offset-2"
                    type="submit">
                    Send Message
                </button>
            </div>
        </form>
    </div>

    <!-- MAP -->
    <div class="relative">
        <div id="map" class="block h-80 min-h-80 w-full overflow-hidden rounded-xl sm:h-96 lg:h-full"></div>

        <!-- Recenter Button -->
        <button id="recenterBtn"
            class="absolute bottom-5 left-5 z-9999 bg-white h-12 w-12 flex justify-center items-center rounded-full shadow-lg text-sm font-bold hover:bg-orange-500 hover:text-white transition">
            <i class="bx bx-target text-xl md:text-3xl"></i>
        </button>
    </div>
</div>