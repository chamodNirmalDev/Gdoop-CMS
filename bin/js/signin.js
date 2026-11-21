/* ==========================================================================
   SIGN IN PAGE SCRIPT — Password Visibility, Remember Email & Validation
   ========================================================================== */
document.addEventListener("DOMContentLoaded", () => {
    const signInForm = document.getElementById("signInForm");
    const emailInput = document.getElementById("signInEmail");
    const passwordInput = document.getElementById("signInPassword");
    const togglePasswordBtn = document.getElementById("togglePasswordBtn");
    const rememberMeCheckbox = document.getElementById("rememberMe");
    const errorBox = document.getElementById("clientErrorBox");

    const REMEMBER_EMAIL_KEY = "gdoop_remembered_email";

    function renderPasswordToggleIcon(isVisible) {
        if (!togglePasswordBtn) return;
        const iconName = isVisible ? "eye-off" : "eye";
        togglePasswordBtn.innerHTML = `<i data-lucide="${iconName}" class="icon-sm" aria-hidden="true"></i>`;
        if (window.lucide && typeof window.lucide.createIcons === "function") {
            window.lucide.createIcons({ root: togglePasswordBtn });
        }
    }

    function showError(message) {
        if (!errorBox) return;
        errorBox.textContent = message;
        errorBox.hidden = false;
    }

    function hideError() {
        if (!errorBox) return;
        errorBox.textContent = "";
        errorBox.hidden = true;
    }

    // Saved email එකක් තිබේ නම් autofill කිරීම
    const savedEmail = localStorage.getItem(REMEMBER_EMAIL_KEY);
    if (savedEmail && emailInput && !emailInput.value) {
        emailInput.value = savedEmail;
        if (rememberMeCheckbox) rememberMeCheckbox.checked = true;
    }

    // Password show / hide toggle
    if (togglePasswordBtn && passwordInput) {
        togglePasswordBtn.addEventListener("click", () => {
            const isNowVisible = passwordInput.type === "password";
            passwordInput.type = isNowVisible ? "text" : "password";
            renderPasswordToggleIcon(isNowVisible);
            passwordInput.focus();
        });
    }

    // Client-side validation + remember email
    if (signInForm) {
        signInForm.addEventListener("submit", (e) => {
            hideError();

            const email = emailInput?.value.trim() || "";
            const password = passwordInput?.value || "";
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!email || !emailRegex.test(email)) {
                e.preventDefault();
                showError("කරුණාකර වලංගු Email ලිපිනයක් ඇතුළත් කරන්න.");
                emailInput?.focus();
                return;
            }

            if (!password) {
                e.preventDefault();
                showError("Password එක ඇතුළත් කරන්න.");
                passwordInput?.focus();
                return;
            }

            if (password.length < 6) {
                e.preventDefault();
                showError("Password එක අවම වශයෙන් අක්ෂර 6ක්වත් තිබිය යුතුයි.");
                passwordInput?.focus();
                return;
            }

            if (rememberMeCheckbox?.checked) {
                localStorage.setItem(REMEMBER_EMAIL_KEY, email);
            } else {
                localStorage.removeItem(REMEMBER_EMAIL_KEY);
            }
        });
    }

    [emailInput, passwordInput].forEach((input) => {
        input?.addEventListener("input", hideError);
    });
});