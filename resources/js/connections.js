const filtersBtn = document.getElementById("filtersBtn");
const filtersList = document.getElementById("filtersList");


filtersList.style.display = "flex"
filtersBtn.addEventListener("click", () => {
    filtersList.style.display =
        filtersList.style.display === "flex" ? "none" : "flex";
});

Array.from(filtersList.children).forEach((btn) => {
    btn.addEventListener("click", () => {
        const pressed = btn.getAttribute("aria-pressed") === "true";
        btn.setAttribute("aria-pressed", !pressed);
    });
});
