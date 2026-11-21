/* ==========================================================================
   CREATE POST PAGE SCRIPT — Live Preview, Formatting & Validation
   ========================================================================== */
document.addEventListener("DOMContentLoaded", () => {
    // Form & Preview DOM elements
    const form = document.getElementById("createPostForm");
    const titleInput = document.getElementById("postTitle");
    const categorySelect = document.getElementById("postCategory");
    const authorInput = document.getElementById("postAuthor");
    const coverUrlInput = document.getElementById("postCoverUrl");
    const readTimeInput = document.getElementById("postReadTime");
    const excerptInput = document.getElementById("postExcerpt");
    const contentInput = document.getElementById("postContent");

    const excerptCount = document.getElementById("excerptCount");
    const previewTitle = document.getElementById("previewTitle");
    const previewCategory = document.getElementById("previewCategory");
    const previewAuthor = document.getElementById("previewAuthor");
    const previewAvatar = document.getElementById("previewAvatar");
    const previewMetaSub = document.getElementById("previewMetaSub");
    const previewExcerpt = document.getElementById("previewExcerpt");
    const previewImage = document.getElementById("previewImage");
    const previewImagePlaceholder = document.getElementById("previewImagePlaceholder");
    const previewStatusBadge = document.getElementById("previewStatusBadge");

    const toolButtons = document.querySelectorAll(".tool-btn");
    const statusButtons = form ? form.querySelectorAll('button[type="submit"][name="status"]') : [];

    let selectedStatus = "published";

    /* ======================================================================
       LIVE PREVIEW UPDATER
       ====================================================================== */
    function updatePreview() {
        const titleVal = titleInput?.value.trim() || "";
        const categoryVal = categorySelect?.value.trim() || "Technology";
        const authorVal = authorInput?.value.trim() || "Chamod Nirmal";
        const readTimeVal = readTimeInput?.value.trim() || "4 min read";
        const excerptVal = excerptInput?.value.trim() || "";
        const imageVal = coverUrlInput?.value.trim() || "";

        if (previewTitle) {
            previewTitle.textContent = titleVal || "Your post title will appear here";
        }
        if (previewCategory) {
            previewCategory.textContent = categoryVal || "General";
        }
        if (previewAuthor) {
            previewAuthor.textContent = authorVal;
        }
        if (previewAvatar) {
            previewAvatar.textContent = authorVal.charAt(0).toUpperCase() || "G";
        }
        if (previewMetaSub) {
            const parts = previewMetaSub.textContent.split("•");
            const datePart = parts[0]?.trim() || "Today";
            previewMetaSub.textContent = `${datePart} • ${readTimeVal}`;
        }
        if (previewExcerpt) {
            previewExcerpt.textContent =
                excerptVal || "Short summary of your story will show up here as you type...";
        }
        if (excerptCount && excerptInput) {
            excerptCount.textContent = `${excerptInput.value.length} / ${excerptInput.maxLength || 180}`;
        }

        // Cover image preview handling
        if (previewImage && previewImagePlaceholder) {
            if (imageVal) {
                previewImage.src = imageVal;
                previewImage.hidden = false;
                previewImagePlaceholder.hidden = true;
            } else {
                previewImage.removeAttribute("src");
                previewImage.hidden = true;
                previewImagePlaceholder.hidden = false;
            }
        }
    }

    // Broken image URL එකක් දුන්නොත් placeholder එකට fallback කිරීම
    if (previewImage && previewImagePlaceholder) {
        previewImage.addEventListener("error", () => {
            previewImage.hidden = true;
            previewImagePlaceholder.hidden = false;
        });
    }

    [titleInput, categorySelect, authorInput, coverUrlInput, readTimeInput, excerptInput].forEach(
        (el) => {
            if (!el) return;
            el.addEventListener("input", updatePreview);
            el.addEventListener("change", updatePreview);
        }
    );

    /* ======================================================================
       TEXT FORMATTING TOOLBAR (Content Textarea)
       ====================================================================== */
    function wrapSelection(textarea, prefix, suffix, placeholderText) {
        if (!textarea) return;
        const start = textarea.selectionStart ?? 0;
        const end = textarea.selectionEnd ?? 0;
        const currentText = textarea.value;
        const selectedText = currentText.slice(start, end) || placeholderText;
        const formatted = `${prefix}${selectedText}${suffix}`;

        textarea.value =
            currentText.slice(0, start) + formatted + currentText.slice(end);
        textarea.focus();

        const newCursorStart = start + prefix.length;
        const newCursorEnd = newCursorStart + selectedText.length;
        textarea.setSelectionRange(newCursorStart, newCursorEnd);
    }

    toolButtons.forEach((btn) => {
        btn.addEventListener("click", () => {
            const format = btn.dataset.format;
            if (format === "bold") {
                wrapSelection(contentInput, "**", "**", "bold text");
            } else if (format === "italic") {
                wrapSelection(contentInput, "*", "*", "italic text");
            } else if (format === "heading") {
                wrapSelection(contentInput, "\n## ", "\n", "Section Heading");
            } else if (format === "code") {
                wrapSelection(contentInput, "`", "`", "code");
            }
        });
    });

    /* ======================================================================
       STATUS BADGE & FORM SUBMISSION CHECK
       ====================================================================== */
    statusButtons.forEach((btn) => {
        btn.addEventListener("click", () => {
            selectedStatus = btn.value || "published";
            if (previewStatusBadge) {
                previewStatusBadge.textContent =
                    selectedStatus === "draft" ? "Draft" : "Published";
            }
        });
    });

    if (form) {
        form.addEventListener("submit", (e) => {
            const title = titleInput?.value.trim() || "";
            const category = categorySelect?.value.trim() || "";
            const excerpt = excerptInput?.value.trim() || "";
            const content = contentInput?.value.trim() || "";

            if (!title || !category || !excerpt || !content) {
                e.preventDefault();
                alert("කරුණාකර Title, Category, Excerpt, සහ Content යන සියල්ල සම්පූර්ණ කරන්න.");
                if (!title) titleInput?.focus();
                else if (!category) categorySelect?.focus();
                else if (!excerpt) excerptInput?.focus();
                else contentInput?.focus();
            }
        });
    }

    // Initial render
    updatePreview();
});