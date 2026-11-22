// :: START AOS INITIALIZATION AND COMPONENT WRAPPERS
(function () {
    const loadAos = function () {
        const stylesheet = document.createElement("link");
        stylesheet.rel = "stylesheet";
        stylesheet.href = "https://unpkg.com/aos@2.3.4/dist/aos.css";
        document.head.appendChild(stylesheet);

        const aosScript = document.createElement("script");
        aosScript.src = "https://unpkg.com/aos@2.3.4/dist/aos.js";
        aosScript.onload = function () {
            // :: START KEEP SHARED NAVIGATION VISIBLE
            const componentSelector = [
                // :: START ADD HERO CONTENT TARGETS
                "#home > div:first-child > div:not([class*='fixed'])",
                "body > div:not(#home) > div > div:not([class*='fixed'])",
                // :: END ADD HERO CONTENT TARGETS
                "body > section",
                "main > section",
                "main > article",
                "main section",
                "main article",
                "main .grid > div",
                "main .grid > article",
                "footer",
                "footer .grid > div"
            ].join(",");
            // :: END KEEP SHARED NAVIGATION VISIBLE

            let animationNumber = 0;

            document.querySelectorAll(componentSelector).forEach(function (component) {
                if (
                    component.closest('[aria-hidden="true"]')
                    || component.classList.contains("hidden")
                    || window.getComputedStyle(component).display === "none"
                    || !component.parentElement
                    || component.parentElement.dataset.aosWrapper === "true"
                ) {
                    return;
                }

                const wrapper = document.createElement("div");
                wrapper.dataset.aosWrapper = "true";
                wrapper.setAttribute("data-aos", animationNumber % 3 === 2 ? "zoom-in" : "fade-up");
                wrapper.setAttribute("data-aos-once", "true");

                // :: START KEEP HERO CONTENT WIDTH
                if (component.matches("#home > div:first-child > div:not([class*='fixed']), body > div:not(#home) > div > div:not([class*='fixed'])")) {
                    wrapper.style.width = "100%";
                }
                // :: END KEEP HERO CONTENT WIDTH

                animationNumber += 1;

                component.parentElement.insertBefore(wrapper, component);
                wrapper.appendChild(component);
            });

            AOS.init({
                duration: 700,
                easing: "ease-out-cubic",
                once: true,
                offset: 70,
                mirror: false,
                disable: function () {
                    return window.matchMedia("(prefers-reduced-motion: reduce)").matches;
                }
            });
        };

        document.body.appendChild(aosScript);
    };

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", loadAos, { once: true });
    } else {
        loadAos();
    }
})();
// :: END AOS INITIALIZATION AND COMPONENT WRAPPERS
