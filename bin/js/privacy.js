/* ==========================================================================
   PRIVACY PAGE SCRIPT — Active TOC Highlight & Local Preferences Reset
   ========================================================================== */
document.addEventListener("DOMContentLoaded", () => {
    const tocLinks = Array.from(document.querySelectorAll(".toc-link"));
    const sections = tocLinks
        .map((link) => {
            const id = link.getAttribute("href")?.replace("#", "");
            return id ? document.getElementById(id) : null;
        })
        .filter(Boolean);

    const clearPrefsBtn = document.getElementById("clearLocalPrefsBtn");
    const clearPrefsFeedback = document.getElementById("clearPrefsFeedback");

    function setActiveTocLink(activeId) {
        tocLinks.forEach((link) => {
            const targetId = link.getAttribute("href")?.replace("#", "");
            link.classList.toggle("active", targetId === activeId);
        });
    }

    // Smooth scroll + active highlight on click
    tocLinks.forEach((link) => {
        link.addEventListener("click", (e) => {
            const href = link.getAttribute("href");
            if (!href || !href.startsWith("#")) return;
            const targetEl = document.querySelector(href);
            if (!targetEl) return;

            e.preventDefault();
            targetEl.scrollIntoView({ behavior: "smooth", block: "start" });
            setActiveTocLink(href.slice(1));
        });
    });

    // Update active TOC link while scrolling
    if (sections.length > 0 && "IntersectionObserver" in window) {
        const observer = new IntersectionObserver(
            (entries) => {
                const visible = entries
                    .filter((entry) => entry.isIntersecting)
                    .sort((a, b) => a.boundingClientRect.top - b.boundingClientRect.top);

                if (visible.length > 0 && visible[0].target.id) {
                    setActiveTocLink(visible[0].target.id);
                }
            },
            { rootMargin: "-18% 0px -65% 0px", threshold: 0.1 }
        );

        sections.forEach((sec) => observer.observe(sec));
    }

    // Clear saved Gdoop localStorage preferences
    if (clearPrefsBtn) {
        clearPrefsBtn.addEventListener("click", () => {
            const keysToClear = [
                "gdoop_theme",
                "gdoop_remembered_email",
                "gdoop_terms_accepted",
            ];
            keysToClear.forEach((key) => localStorage.removeItem(key));

            if (clearPrefsFeedback) {
                clearPrefsFeedback.textContent = "Saved local preferences cleared from this browser.";
            }
        });
    }
});