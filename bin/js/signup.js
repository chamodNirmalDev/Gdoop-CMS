/* ==========================================================================
   SIGN UP PAGE SCRIPT — Password Toggle, Strength Meter & Form Validation
   ========================================================================== */
document.addEventListener("DOMContentLoaded", () => {
    const signUpForm = document.getElementById("signUpForm");
    const nameInput = document.getElementById("signUpName");
    const usernameInput = document.getElementById("signUpUsername");
    const emailInput = document.getElementById("signUpEmail");
    const passwordInput = document.getElementById("signUpPassword");
    const confirmPasswordInput = document.getElementById("signUpConfirmPassword");
    const agreeTermsCheckbox = document.getElementById("agreeTerms");
    const errorBox = document.getElementById("clientErrorBox");

    const strengthBarFill = document.getElementById("strengthBarFill");
    const strengthText = document.getElementById("strengthText");
    const toggleButtons = document.querySelectorAll(".password-toggle-btn");

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

    // Password show / hide toggle (Password & Confirm Password දෙකටම)
    toggleButtons.forEach((btn) => {
        btn.addEventListener("click", () => {
            const targetId = btn.dataset.target;
            const inputEl = targetId ? document.getElementById(targetId) : null;
            if (!inputEl) return;

            const isNowVisible = inputEl.type === "password";
            inputEl.type = isNowVisible ? "text" : "password";

            const iconName = isNowVisible ? "eye-off" : "eye";
            btn.innerHTML = `<i data-lucide="${iconName}" class="icon-sm" aria-hidden="true"></i>`;
            if (window.lucide && typeof window.lucide.createIcons === "function") {
                window.lucide.createIcons({ root: btn });
            }
            inputEl.focus();
        });
    });

    // Live password strength indicator
    function updateStrength(pwd) {
        if (!strengthBarFill || !strengthText) return;

        let score = 0;
        if (pwd.length >= 6) score++;
        if (pwd.length >= 10) score++;
        if (/[A-Z]/.test(pwd) && /[a-z]/.test(pwd)) score++;
        if (/[0-9]/.test(pwd) || /[^A-Za-z0-9]/.test(pwd)) score++;

        const levels = [
            { width: "0%", color: "#ef4444", label: "Password strength: Weak" },
            { width: "30%", color: "#ef4444", label: "Password strength: Weak" },
            { width: "55%", color: "#f59e0b", label: "Password strength: Fair" },
            { width: "80%", color: "#3b82f6", label: "Password strength: Good" },
            { width: "100%", color: "#22c55e", label: "Password strength: Strong" },
        ];

        const level = pwd.length === 0 ? levels[0] : levels[Math.max(1, score)];
        strengthBarFill.style.width = level.width;
        strengthBarFill.style.backgroundColor = level.color;
        strengthText.textContent = level.label;
    }

    if (passwordInput) {
        passwordInput.addEventListener("input", (e) => {
            updateStrength(e.target.value);
            hideError();
        });
        updateStrength(passwordInput.value);
    }

    // Client-side validation
    if (signUpForm) {
        signUpForm.addEventListener("submit", (e) => {
            hideError();

            const fullName = nameInput?.value.trim() || "";
            const username = usernameInput?.value.trim() || "";
            const email = emailInput?.value.trim() || "";
            const password = passwordInput?.value || "";
            const confirmPassword = confirmPasswordInput?.value || "";

            const usernameRegex = /^[a-zA-Z0-9_]{3,20}$/;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!fullName) {
                e.preventDefault();
                showError("Full name එක ඇතුළත් කරන්න.");
                nameInput?.focus();
                return;
            }

            if (!username || !usernameRegex.test(username)) {
                e.preventDefault();
                showError("Username එක අක්ෂර 3–20 අතර (letters, numbers, underscore පමණක්) තිබිය යුතුයි.");
                usernameInput?.focus();
                return;
            }

            if (!email || !emailRegex.test(email)) {
                e.preventDefault();
                showError("කරුණාකර වලංගු Email ලිපිනයක් ඇතුළත් කරන්න.");
                emailInput?.focus();
                return;
            }

            if (password.length < 6) {
                e.preventDefault();
                showError("Password එක අවම වශයෙන් අක්ෂර 6ක්වත් තිබිය යුතුයි.");
                passwordInput?.focus();
                return;
            }

            if (password !== confirmPassword) {
                e.preventDefault();
                showError("Password දෙක එකිනෙකට ගැළපෙන්නේ නැහැ.");
                confirmPasswordInput?.focus();
                return;
            }

            if (!agreeTermsCheckbox?.checked) {
                e.preventDefault();
                showError("Terms & Privacy Policy වලට එකඟ වන්න.");
                agreeTermsCheckbox?.focus();
            }
        });
    }

    [nameInput, usernameInput, emailInput, confirmPasswordInput].forEach((input) => {
        input?.addEventListener("input", hideError);
    });
    agreeTermsCheckbox?.addEventListener("change", hideError);
});