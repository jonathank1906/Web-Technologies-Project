const filtersBtn = document.getElementById("filtersBtn");
const filtersDropdown = document.getElementById("filtersList");

filtersBtn.addEventListener("click", () => {
    filtersDropdown.style.display =
        filtersDropdown.style.display === "flex" ? "none" : "flex";
});

Array.from(document.getElementById("filtersList").children).forEach((btn) => {
    btn.addEventListener("click", () => {
        const pressed = btn.getAttribute("aria-pressed") === "true";
        btn.setAttribute("aria-pressed", !pressed);
    });
});
