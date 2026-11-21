<?php
$assetPrefix = '../../';
$pageTitle   = 'Create Account — Gdoop CMS';
$pageCss     = $assetPrefix . 'bin/css/signup.css';
$pageJs      = $assetPrefix . 'bin/js/signup.js';
$isLoggedIn  = false;

$errors = [];
$successMessage = '';
$fullNameValue = '';
$usernameValue = '';
$emailValue = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullNameValue = trim($_POST['full_name'] ?? '');
    $usernameValue = trim($_POST['username'] ?? '');
    $emailValue    = trim($_POST['email'] ?? '');
    $password      = $_POST['password'] ?? '';
    $confirmPass   = $_POST['confirm_password'] ?? '';
    $agreedTerms   = isset($_POST['agree_terms']);

    if ($fullNameValue === '') {
        $errors[] = 'Full name එක ඇතුළත් කරන්න.';
    }
    if ($usernameValue === '' || !preg_match('/^[a-zA-Z0-9_]{3,20}$/', $usernameValue)) {
        $errors[] = 'Username එක අක්ෂර 3–20 අතර (letters, numbers, underscore පමණක්) තිබිය යුතුයි.';
    }
    if ($emailValue === '' || !filter_var($emailValue, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'කරුණාකර වලංගු Email ලිපිනයක් ඇතුළත් කරන්න.';
    }
    if (strlen($password) < 6) {
        $errors[] = 'Password එක අවම වශයෙන් අක්ෂර 6ක්වත් තිබිය යුතුයි.';
    }
    if ($password !== $confirmPass) {
        $errors[] = 'Password දෙක එකිනෙකට ගැළපෙන්නේ නැහැ.';
    }
    if (!$agreedTerms) {
        $errors[] = 'Terms & Privacy Policy වලට එකඟ වන්න.';
    }

    if (empty($errors)) {
        // Backend registration / database insert එක පසුව මෙහි සම්බන්ධ කරන්න
        $successMessage = 'Account form validation සාර්ථකයි! Backend registration සම්බන්ධ කළ පසු account එක හැදේ.';
    }
}

include __DIR__ . '/../home/header.php';
?>

<main class="container auth-page">
    <section class="auth-card" aria-label="Sign up form">
        <a href="<?= htmlspecialchars($assetPrefix . 'index.php', ENT_QUOTES, 'UTF-8') ?>" class="auth-back-link">
            <i data-lucide="arrow-left" class="icon-sm" aria-hidden="true"></i>
            <span>Back to Home</span>
        </a>

        <div class="auth-header">
            <span class="auth-badge">G</span>
            <h1 class="auth-title">Create your account</h1>
            <p class="auth-subtitle">Join Gdoop CMS to write, organize, and share stories.</p>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="auth-alert auth-alert-error" role="alert">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($successMessage !== ''): ?>
            <div class="auth-alert auth-alert-success" role="status">
                <?= htmlspecialchars($successMessage, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <div id="clientErrorBox" class="auth-alert auth-alert-error" role="alert" hidden></div>

        <form id="signUpForm" class="auth-form" method="POST" action="signup.php" novalidate>
            <div class="auth-field">
                <label for="signUpName" class="auth-label">Full Name</label>
                <div class="auth-input-wrap">
                    <i data-lucide="user" class="auth-field-icon" aria-hidden="true"></i>
                    <input
                        type="text"
                        id="signUpName"
                        name="full_name"
                        class="auth-input"
                        placeholder="Your full name"
                        autocomplete="name"
                        value="<?= htmlspecialchars($fullNameValue, ENT_QUOTES, 'UTF-8') ?>"
                        required
                    >
                </div>
            </div>

            <div class="auth-field">
                <label for="signUpUsername" class="auth-label">Username</label>
                <div class="auth-input-wrap">
                    <i data-lucide="at-sign" class="auth-field-icon" aria-hidden="true"></i>
                    <input
                        type="text"
                        id="signUpUsername"
                        name="username"
                        class="auth-input"
                        placeholder="chamod_nirmal"
                        autocomplete="username"
                        value="<?= htmlspecialchars($usernameValue, ENT_QUOTES, 'UTF-8') ?>"
                        required
                    >
                </div>
            </div>

            <div class="auth-field">
                <label for="signUpEmail" class="auth-label">Email Address</label>
                <div class="auth-input-wrap">
                    <i data-lucide="mail" class="auth-field-icon" aria-hidden="true"></i>
                    <input
                        type="email"
                        id="signUpEmail"
                        name="email"
                        class="auth-input"
                        placeholder="you@example.com"
                        autocomplete="email"
                        value="<?= htmlspecialchars($emailValue, ENT_QUOTES, 'UTF-8') ?>"
                        required
                    >
                </div>
            </div>

            <div class="auth-field">
                <label for="signUpPassword" class="auth-label">Password</label>
                <div class="auth-input-wrap">
                    <i data-lucide="lock" class="auth-field-icon" aria-hidden="true"></i>
                    <input
                        type="password"
                        id="signUpPassword"
                        name="password"
                        class="auth-input auth-input-password"
                        placeholder="At least 6 characters"
                        autocomplete="new-password"
                        required
                    >
                    <button
                        type="button"
                        id="togglePasswordBtn"
                        class="password-toggle-btn"
                        data-target="signUpPassword"
                        title="Show or hide password"
                        aria-label="Show or hide password"
                    >
                        <i data-lucide="eye" class="icon-sm" aria-hidden="true"></i>
                    </button>
                </div>
                <div class="password-strength-wrap">
                    <div class="strength-bar-track" aria-hidden="true">
                        <div id="strengthBarFill" class="strength-bar-fill"></div>
                    </div>
                    <span id="strengthText" class="strength-text">Password strength: Weak</span>
                </div>
            </div>

            <div class="auth-field">
                <label for="signUpConfirmPassword" class="auth-label">Confirm Password</label>
                <div class="auth-input-wrap">
                    <i data-lucide="shield-check" class="auth-field-icon" aria-hidden="true"></i>
                    <input
                        type="password"
                        id="signUpConfirmPassword"
                        name="confirm_password"
                        class="auth-input auth-input-password"
                        placeholder="Re-enter your password"
                        autocomplete="new-password"
                        required
                    >
                    <button
                        type="button"
                        id="toggleConfirmPasswordBtn"
                        class="password-toggle-btn"
                        data-target="signUpConfirmPassword"
                        title="Show or hide confirm password"
                        aria-label="Show or hide confirm password"
                    >
                        <i data-lucide="eye" class="icon-sm" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <div class="auth-options-row">
                <label class="remember-check">
                    <input type="checkbox" id="agreeTerms" name="agree_terms" value="1" <?= isset($_POST['agree_terms']) ? 'checked' : '' ?>>
                    <span>I agree to the <a href="<?= htmlspecialchars($assetPrefix . 'components/terms.php', ENT_QUOTES, 'UTF-8') ?>" class="auth-inline-link">Terms</a> and <a href="<?= htmlspecialchars($assetPrefix . 'components/privacy.php', ENT_QUOTES, 'UTF-8') ?>" class="auth-inline-link">Privacy Policy</a></span>
                </label>
            </div>

            <button type="submit" id="signUpSubmitBtn" class="auth-submit-btn">
                <i data-lucide="user-plus" class="icon-sm" aria-hidden="true"></i>
                <span>Create Account</span>
            </button>
        </form>

        <p class="auth-footer-text">
            Already have an account?
            <a href="<?= htmlspecialchars($assetPrefix . 'components/signin/signin.php', ENT_QUOTES, 'UTF-8') ?>" class="auth-link-accent">
                Sign in
            </a>
        </p>
    </section>
</main>

<?php include __DIR__ . '/../home/footer.php'; ?>