/* ==========================================================================
   POST DETAILS PAGE SCRIPT — Bookmark Toggle & Report Action Feedback
   ========================================================================== */
document.addEventListener("DOMContentLoaded", () => {
    const bookmarkBtn = document.getElementById("bookmarkPostBtn");
    const reportBtn = document.getElementById("reportPostBtn");
    const noticeEl = document.getElementById("postActionNotice");

    const postId = new URLSearchParams(window.location.search).get("id") || "default";
    const bookmarkKey = `gdoop_bookmarked_${postId}`;

    function showNotice(text) {
        if (!noticeEl) return;
        noticeEl.textContent = text;
        noticeEl.hidden = false;
    }

    function setBookmarkState(isSaved) {
        if (!bookmarkBtn) return;
        bookmarkBtn.classList.toggle("saved", isSaved);
        bookmarkBtn.setAttribute("aria-pressed", String(isSaved));
        bookmarkBtn.title = isSaved ? "Saved post" : "Save post";
        bookmarkBtn.setAttribute("aria-label", isSaved ? "Saved post" : "Save post");

        bookmarkBtn.innerHTML = `<i data-lucide="bookmark" class="icon-sm" aria-hidden="true"></i>`;
        if (window.lucide && typeof window.lucide.createIcons === "function") {
            window.lucide.createIcons({ root: bookmarkBtn });
        }
    }

    if (bookmarkBtn) {
        const initiallySaved = localStorage.getItem(bookmarkKey) === "true";
        setBookmarkState(initiallySaved);

        bookmarkBtn.addEventListener("click", () => {
            const nextState = bookmarkBtn.getAttribute("aria-pressed") !== "true";
            localStorage.setItem(bookmarkKey, String(nextState));
            setBookmarkState(nextState);
            showNotice(
                nextState
                    ? "Post saved to your reading list."
                    : "Post removed from your saved list."
            );
        });
    }

    if (reportBtn) {
        reportBtn.addEventListener("click", () => {
            const alreadyReported = reportBtn.classList.contains("reported");
            if (alreadyReported) {
                showNotice("You have already submitted a report for this post.");
                return;
            }
            reportBtn.classList.add("reported");
            showNotice("Post report noted. Moderation/backend handling can be connected later.");
        });
    }
});