import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

import "keen-slider/keen-slider.min.css";
import KeenSlider from "keen-slider";
import "hammerjs";

function navigation(slider) {
    let wrapper, dots, arrowLeft, arrowRight;

    function markup(remove) {
        wrapperMarkup(remove);
        dotMarkup(remove);
        arrowMarkup(remove);
    }

    function removeElement(elment) {
        elment.parentNode.removeChild(elment);
    }
    function createDiv(className) {
        var div = document.createElement("div");
        var classNames = className.split(" ");
        classNames.forEach((name) => div.classList.add(name));
        return div;
    }

    function arrowMarkup(remove) {
        if (remove) {
            removeElement(arrowLeft);
            removeElement(arrowRight);
            return;
        }
        arrowLeft = createDiv("arrow arrow--left");
        arrowLeft.addEventListener("click", () => slider.prev());
        arrowRight = createDiv("arrow arrow--right");
        arrowRight.addEventListener("click", () => slider.next());

        wrapper.appendChild(arrowLeft);
        wrapper.appendChild(arrowRight);
    }

    function wrapperMarkup(remove) {
        if (remove) {
            var parent = wrapper.parentNode;
            while (wrapper.firstChild)
                parent.insertBefore(wrapper.firstChild, wrapper);
            removeElement(wrapper);
            return;
        }
        wrapper = createDiv("navigation-wrapper");
        slider.container.parentNode.insertBefore(wrapper, slider.container);
        wrapper.appendChild(slider.container);
    }

    function dotMarkup(remove) {
        if (remove) {
            removeElement(dots);
            return;
        }
        dots = createDiv("dots");
        slider.track.details.slides.forEach((_e, idx) => {
            var dot = createDiv("dot");
            dot.addEventListener("click", () => slider.moveToIdx(idx));
            dots.appendChild(dot);
        });
        wrapper.appendChild(dots);
    }

    function updateClasses() {
        var slide = slider.track.details.rel;
        slide === 0
            ? arrowLeft.classList.add("arrow--disabled")
            : arrowLeft.classList.remove("arrow--disabled");
        slide === slider.track.details.slides.length - 1
            ? arrowRight.classList.add("arrow--disabled")
            : arrowRight.classList.remove("arrow--disabled");
        Array.from(dots.children).forEach(function (dot, idx) {
            idx === slide
                ? dot.classList.add("dot--active")
                : dot.classList.remove("dot--active");
        });
    }

    slider.on("created", () => {
        markup();
        updateClasses();
    });
    slider.on("optionsChanged", () => {
        console.log(2);
        markup(true);
        markup();
        updateClasses();
    });
    slider.on("slideChanged", () => {
        updateClasses();
    });
    slider.on("destroyed", () => {
        markup(true);
    });
}

// Initialize all post sliders
function initializePostSliders() {
    document.querySelectorAll('[id^="post-slider-"]').forEach((sliderElement) => {
        if (!sliderElement.classList.contains('keen-slider-initialized')) {
            new KeenSlider('#' + sliderElement.id, {
                loop: false,
                slides: {
                    perView: 1,
                    spacing: 10,
                }
            }, [navigation]);
            sliderElement.classList.add('keen-slider-initialized');
        }
    });
}

class ResponsiveSidebar {
    constructor() {
        this.sidebar = document.getElementById("sidebar");
        this.mainContent = document.getElementById("mainContent");
        this.currentMode = null;

        this.breakpoints = {
            mobile: 767,
            medium: 1300,
            large: 1301,
        };

        this.init();
    }

    init() {
        // Set initial state
        this.handleResize();

        // Add resize listener with debouncing
        let resizeTimeout;
        window.addEventListener("resize", () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                this.handleResize();
            }, 50); // 50ms debounce
        });
    }

    handleResize() {
        const width = window.innerWidth;
        let newMode;

        if (width <= this.breakpoints.mobile) {
            newMode = "mobile";
        } else if (width <= this.breakpoints.medium) {
            newMode = "medium";
        } else {
            newMode = "large";
        }

        // Only update if mode changed
        if (newMode !== this.currentMode) {
            this.updateSidebar(newMode);
            this.currentMode = newMode;
        }
    }

    updateSidebar(mode) {
        // Remove all existing classes
        this.sidebar.classList.remove(
            "sidebar-mobile",
            "sidebar-medium",
            "sidebar-large"
        );
        this.mainContent.classList.remove(
            "content-mobile",
            "content-medium",
            "content-large"
        );

        // Add new classes
        this.sidebar.classList.add(`sidebar-${mode}`);
        this.mainContent.classList.add(`content-${mode}`);

        console.log(`Sidebar updated to: ${mode} mode`);
    }
}


// Light/Dark Mode
function initThemeToggle() {
    const root = document.documentElement;
    const buttons = document.querySelectorAll(".theme-toggle");
    const labelSelector = ".theme-label";

    // Get saved theme or system preference
    let theme = localStorage.getItem("theme");
    if (!theme) {
        theme = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
    }

    // Apply theme
    root.setAttribute("data-theme", theme);
    root.classList.toggle("dark", theme === "dark");
    // Update Settings button labels
    const updateLabels = () => {
        buttons.forEach(btn => {
            const label = btn.querySelector(labelSelector);
            if (label) label.textContent = theme === "dark" ? "Toggle Light Mode" : "Toggle Dark Mode";
        });
    };

    updateLabels();

    // Toggle theme on button click
    buttons.forEach(btn => {
        btn.addEventListener("click", () => {
            theme = theme === "dark" ? "light" : "dark";
            root.setAttribute("data-theme", theme);
            root.classList.toggle("dark", theme === "dark");
            localStorage.setItem("theme", theme);
            updateLabels();
        });
    });
}


// Initialize when DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
    new ResponsiveSidebar();
    initThemeToggle();
    initializePostSliders();
});

// Re-initialize after Livewire updates
//document.addEventListener('livewire:navigated', initializePostSliders);

document.querySelectorAll('.like-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const postId = this.getAttribute('data-post-id');
        fetch(`/posts/${postId}/toggle-like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById(`like-count-${postId}`).textContent = data.likes_count;
            this.setAttribute('data-liked', data.liked ? 'true' : 'false');

            // Only show SVG icon, no text
            if (data.liked) {
                this.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-thumb-up">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M13 3a3 3 0 0 1 2.995 2.824l.005 .176v4h2a3 3 0 0 1 2.98 2.65l.015 .174l.005 .176l-.02 .196l-1.006 5.032c-.381 1.626 -1.502 2.796 -2.81 2.78l-.164 -.008h-8a1 1 0 0 1 -.993 -.883l-.007 -.117l.001 -9.536a1 1 0 0 1 .5 -.865a2.998 2.998 0 0 0 1.492 -2.397l.007 -.202v-1a3 3 0 0 1 3 -3z" />
                        <path d="M5 10a1 1 0 0 1 .993 .883l.007 .117v9a1 1 0 0 1 -.883 .993l-.117 .007h-1a2 2 0 0 1 -1.995 -1.85l-.005 -.15v-7a2 2 0 0 1 1.85 -1.995l.15 -.005h1z" />
                    </svg>
                `;
            } else {
                this.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-thumb-up">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M7 11v8a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-7a1 1 0 0 1 1 -1h3a4 4 0 0 0 4 -4v-1a2 2 0 0 1 4 0v5h3a2 2 0 0 1 2 2l-1 5a2 3 0 0 1 -2 2h-7a3 3 0 0 1 -3 -3" />
                    </svg>
                `;
            }
        });
    });
});