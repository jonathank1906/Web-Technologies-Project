document.addEventListener("DOMContentLoaded", () => {
    const toggleViewBtn = document.getElementById("toggleViewBtn");
    const backBtn = document.getElementById("backToConnectionsBtn");
    const connectionsView = document.getElementById("connectionsView");
    const requestsView = document.getElementById("requestsView");

    let currentView = "connections";

    function showConnections() {
        if (currentView === "connections") return;
        requestsView.classList.add("hidden");
        connectionsView.classList.remove("hidden");
        currentView = "connections";
    }

    function showRequests() {
        if (currentView === "requests") return;
        connectionsView.classList.add("hidden");
        requestsView.classList.remove("hidden");
        currentView = "requests";
    }

    toggleViewBtn?.addEventListener("click", showRequests);
    backBtn?.addEventListener("click", showConnections);

    window.addEventListener("resize", () => {
        const isDesktop = window.innerWidth >= 1024;
        if (isDesktop && currentView === "requests") {
            showConnections();
        }
    });
});