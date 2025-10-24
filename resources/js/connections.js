const filtersBtn = document.getElementById("filtersBtn");
const filtersList = document.getElementById("filtersList");

filtersList.style.display = "flex"
filtersBtn.addEventListener("click", () => {
    filtersList.style.display =
        filtersList.style.display === "flex" ? "none" : "flex";
});

filtersList.addEventListener("click", (e) => {
    const btn = e.target.closest("button");
    if (!btn) return;
    const pressed = btn.getAttribute("aria-pressed") === "true";
    btn.setAttribute("aria-pressed", !pressed);
});