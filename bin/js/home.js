function initIcons(root = document) {
    if (window.lucide && typeof window.lucide.createIcons === "function") {
        window.lucide.createIcons(root);
    }
}

document.addEventListener("DOMContentLoaded", () => {

 const themeToggleBtn = document.getElementById("themeToggleBtn");
    const savedTheme = localStorage.getItem("gdoop_theme") || "dark";

    function renderThemeIcon(isLight) {
        if (!themeToggleBtn) {
            return
        };
        const iconName = isLight ? "moon" : "sun";
        themeToggleBtn.innerHTML = `<i data-lucide="${iconName}" class="icon-sm" aria-hidden="true"></i>`;
        initIcons(themeToggleBtn);
    }

    function applyTheme(theme) {
        const isLight = theme === "light";
        document.body.classList.toggle("light-theme", isLight);
        localStorage.setItem("gdoop_theme", isLight ? "light" : "dark");
        renderThemeIcon(isLight);
    }

    applyTheme(savedTheme);
    initIcons(document);

    if (themeToggleBtn) {
        themeToggleBtn.addEventListener("click", () => {
            const currentIsLight = document.body.classList.contains("light-theme");
            applyTheme(currentIsLight ? "dark" : "light");
        });
    }

    const categoryPills = document.querySelectorAll(".category-pill");
    const categoryScroll = document.getElementById("categoryList");
    const scrollRightBtn = document.getElementById("scrollRightBtn");
    const searchInput = document.getElementById("searchInput");
    const clearSearchBtn = document.getElementById("clearSearchBtn");
    const postsGrid = document.getElementById("postsGrid");
    const postCards = Array.from(document.querySelectorAll(".post-card"));
    const emptyState = document.getElementById("emptyState");
    const resetFiltersBtn = document.getElementById("resetFiltersBtn");
    const loadMoreBtn = document.getElementById("loadMoreBtn");

    let activeCategory = "All";
    let searchQuery = "";

    function applyFilters() {
        let visibleCount = 0;

        postCards.forEach((card) => {
            const cardCategory = card.dataset.category || "";
            const title = card.dataset.title || "";
            const excerpt = card.dataset.excerpt || "";
            const author = card.dataset.author || "";

            const matchesCategory =
                activeCategory === "All" || cardCategory === activeCategory;

            const matchesSearch =
                !searchQuery ||
                title.includes(searchQuery) ||
                excerpt.includes(searchQuery) ||
                author.includes(searchQuery) ||
                cardCategory.toLowerCase().includes(searchQuery);

            const shouldShow = matchesCategory && matchesSearch;
            card.style.display = shouldShow ? "" : "none";
            if (shouldShow) visibleCount++;
        });

        if (emptyState) emptyState.hidden = visibleCount > 0;
        if (postsGrid) postsGrid.hidden = visibleCount === 0;
        if (clearSearchBtn) clearSearchBtn.hidden = searchQuery.length === 0;
    }

    categoryPills.forEach((pill) => {
        pill.addEventListener("click", () => {
            categoryPills.forEach((p) => p.classList.remove("active"));
            pill.classList.add("active");
            activeCategory = pill.dataset.category || "All";
            applyFilters();
        });
    });

    if(scrollRightBtn && categoryScroll){
        scrollRightBtn.addEventListener("click", () => {
            categoryScroll.scrollBy({left: 240, behavior: "smooth"});
        })
    }

    if (resetFiltersBtn){
        resetFiltersBtn.addEventListener("click", () => {
            activeCategory = "All";
            searchQuery = "";
            if (searchInput) searchInput.value = "";
            categoryPills.forEach((p, index) => {
                p.classList.toggle("active", index === 0);
            });
            applyFilters();
        })
    }

    if(loadMoreBtn){
        loadMoreBtn.addEventListener("click", () => {
            loadMoreBtn.textContent = "All sample posts shown";
            loadMoreBtn.disabled = true;
            loadMoreBtn.style.opacity = "0.6";
            loadMoreBtn.style.cursor = "default";
            initIcons(postsGrid || document);
        });
    }

    if (searchInput) {
        searchInput.addEventListener("input", (e) => {
            searchQuery = e.target.value.trim().toLowerCase();
            applyFilters();
        });

        searchInput.addEventListener("keydown", (e) => {
            if (e.key === "Escape" && searchInput.value){
                searchInput.value = "";
                searchQuery = "";
                applyFilters();
            } 
        })
    }

    if (clearSearchBtn && searchInput) {
        clearSearchBtn.addEventListener("click", () => {
            searchInput.value = "";
            searchQuery = "";
            applyFilters();
            searchInput.focus();
        });
    }

});