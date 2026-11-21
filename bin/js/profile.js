/* ==========================================================================
   PROFILE PAGE SCRIPT — Tab Switching & Saved Posts Interaction
   ========================================================================== */
document.addEventListener("DOMContentLoaded", () => {
    const profilePage = document.querySelector(".profile-page");
    const tabs = Array.from(document.querySelectorAll(".profile-tab"));
    const panels = {
        profile: document.getElementById("panelProfile"),
        saved: document.getElementById("panelSaved"),
        edit: document.getElementById("panelEdit"),
    };

    const savedPostsList = document.getElementById("savedPostsList");
    const savedEmptyState = document.getElementById("savedEmptyState");
    const savedListCount = document.getElementById("savedListCount");
    const profileSavedCount = document.getElementById("profileSavedCount");

    function activateTab(tabName, updateUrl = true) {
        const targetTab = panels[tabName] ? tabName : "profile";

        tabs.forEach((btn) => {
            const isActive = btn.dataset.tab === targetTab;
            btn.classList.toggle("active", isActive);
            btn.setAttribute("aria-selected", String(isActive));
        });

        Object.entries(panels).forEach(([key, panelEl]) => {
            if (!panelEl) return;
            panelEl.hidden = key !== targetTab;
        });

        if (updateUrl && window.history && typeof window.history.replaceState === "function") {
            const url = new URL(window.location.href);
            if (targetTab === "profile") {
                url.searchParams.delete("tab");
            } else {
                url.searchParams.set("tab", targetTab);
            }
            window.history.replaceState({}, "", url.toString());
        }
    }

    tabs.forEach((btn) => {
        btn.addEventListener("click", () => {
            activateTab(btn.dataset.tab || "profile", true);
        });
    });

    // Initial tab sync from data attribute or query string
    const urlTab = new URLSearchParams(window.location.search).get("tab");
    const initialTab = urlTab || profilePage?.dataset.activeTab || "profile";
    activateTab(initialTab, false);

    // Remove saved post item UI update
    function syncSavedCounts() {
        const remaining = savedPostsList
            ? savedPostsList.querySelectorAll(".saved-post-item").length
            : 0;

        if (savedListCount) {
            savedListCount.textContent = `${remaining} saved`;
        }
        if (profileSavedCount) {
            profileSavedCount.textContent = String(remaining);
        }
        if (savedEmptyState) {
            savedEmptyState.hidden = remaining > 0;
        }
    }

    if (savedPostsList) {
        savedPostsList.addEventListener("click", (e) => {
            const removeBtn = e.target.closest(".remove-saved-btn");
            if (!removeBtn) return;

            const card = removeBtn.closest(".saved-post-item");
            if (card) {
                card.remove();
                syncSavedCounts();
            }
        });
    }
});