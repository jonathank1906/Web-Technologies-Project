import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import 'keen-slider/keen-slider.min.css'
import KeenSlider from 'keen-slider'
import 'hammerjs';

function navigation(slider) {
    let wrapper, dots, arrowLeft, arrowRight

    function markup(remove) {
        wrapperMarkup(remove)
        dotMarkup(remove)
        arrowMarkup(remove)
    }

    function removeElement(elment) {
        elment.parentNode.removeChild(elment)
    }
    function createDiv(className) {
        var div = document.createElement("div")
        var classNames = className.split(" ")
        classNames.forEach((name) => div.classList.add(name))
        return div
    }

    function arrowMarkup(remove) {
        if (remove) {
            removeElement(arrowLeft)
            removeElement(arrowRight)
            return
        }
        arrowLeft = createDiv("arrow arrow--left")
        arrowLeft.addEventListener("click", () => slider.prev())
        arrowRight = createDiv("arrow arrow--right")
        arrowRight.addEventListener("click", () => slider.next())

        wrapper.appendChild(arrowLeft)
        wrapper.appendChild(arrowRight)
    }

    function wrapperMarkup(remove) {
        if (remove) {
            var parent = wrapper.parentNode
            while (wrapper.firstChild)
                parent.insertBefore(wrapper.firstChild, wrapper)
            removeElement(wrapper)
            return
        }
        wrapper = createDiv("navigation-wrapper")
        slider.container.parentNode.insertBefore(wrapper, slider.container)
        wrapper.appendChild(slider.container)
    }

    function dotMarkup(remove) {
        if (remove) {
            removeElement(dots)
            return
        }
        dots = createDiv("dots")
        slider.track.details.slides.forEach((_e, idx) => {
            var dot = createDiv("dot")
            dot.addEventListener("click", () => slider.moveToIdx(idx))
            dots.appendChild(dot)
        })
        wrapper.appendChild(dots)
    }

    function updateClasses() {
        var slide = slider.track.details.rel
        slide === 0
            ? arrowLeft.classList.add("arrow--disabled")
            : arrowLeft.classList.remove("arrow--disabled")
        slide === slider.track.details.slides.length - 1
            ? arrowRight.classList.add("arrow--disabled")
            : arrowRight.classList.remove("arrow--disabled")
        Array.from(dots.children).forEach(function (dot, idx) {
            idx === slide
                ? dot.classList.add("dot--active")
                : dot.classList.remove("dot--active")
        })
    }

    slider.on("created", () => {
        markup()
        updateClasses()
    })
    slider.on("optionsChanged", () => {
        console.log(2)
        markup(true)
        markup()
        updateClasses()
    })
    slider.on("slideChanged", () => {
        updateClasses()
    })
    slider.on("destroyed", () => {
        markup(true)
    })
}

var slider = new KeenSlider("#my-keen-slider", {}, [navigation])


class ResponsiveSidebar {
    constructor() {
        this.sidebar = document.getElementById('sidebar');
        this.mainContent = document.getElementById('mainContent');
        this.currentMode = null;

        this.breakpoints = {
            mobile: 767,
            medium: 1300,
            large: 1301
        };

        this.init();
    }

    init() {
        // Set initial state
        this.handleResize();

        // Add resize listener with debouncing
        let resizeTimeout;
        window.addEventListener('resize', () => {
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
            newMode = 'mobile';
        } else if (width <= this.breakpoints.medium) {
            newMode = 'medium';
        } else {
            newMode = 'large';
        }

        // Only update if mode changed
        if (newMode !== this.currentMode) {
            this.updateSidebar(newMode);
            this.currentMode = newMode;
        }
    }

    updateSidebar(mode) {
        // Remove all existing classes
        this.sidebar.classList.remove('sidebar-mobile', 'sidebar-medium', 'sidebar-large');
        this.mainContent.classList.remove('content-mobile', 'content-medium', 'content-large');

        // Add new classes
        this.sidebar.classList.add(`sidebar-${mode}`);
        this.mainContent.classList.add(`content-${mode}`);

        console.log(`Sidebar updated to: ${mode} mode`);
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new ResponsiveSidebar();
});