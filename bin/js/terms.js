/* ==========================================================================
   TERMS PAGE SCRIPT — Active TOC Highlight & Acknowledgment State
   ========================================================================== */
document.addEventListener("DOMContentLoaded", () => {
    const tocLinks = Array.from(document.querySelectorAll(".toc-link"));
    const sections = tocLinks
        .map((link) => {
            const id = link.getAttribute("href")?.replace("#", "");
            return id ? document.getElementById(id) : null;
        })
        .filter(Boolean);

    const ackCheckbox = document.getElementById("acceptTermsCheckbox");
    const ackStatusText = document.getElementById("ackStatusText");
    const ACK_STORAGE_KEY = "gdoop_terms_accepted";

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

    // Acknowledgment state persistence
    function updateAckStatus(checked) {
        if (!ackStatusText) return;
        ackStatusText.textContent = checked ? "Accepted" : "";
    }

    if (ackCheckbox) {
        const savedAccepted = localStorage.getItem(ACK_STORAGE_KEY) === "true";
        ackCheckbox.checked = savedAccepted;
        updateAckStatus(savedAccepted);

        ackCheckbox.addEventListener("change", () => {
            const isChecked = ackCheckbox.checked;
            localStorage.setItem(ACK_STORAGE_KEY, String(isChecked));
            updateAckStatus(isChecked);
        });
    }
});