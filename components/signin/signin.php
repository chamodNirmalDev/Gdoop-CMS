<?php
$assetPrefix = '../../';
$pageTitle   = 'Sign In — Gdoop CMS';
$pageCss     = $assetPrefix . 'bin/css/signin.css';
$pageJs      = $assetPrefix . 'bin/js/signin.js';
$isLoggedIn  = false;

$errors = [];
$successMessage = '';
$emailValue = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailValue = trim($_POST['email'] ?? '');
    $password   = $_POST['password'] ?? '';

    if ($emailValue === '' || !filter_var($emailValue, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'කරුණාකර වලංගු Email ලිපිනයක් ඇතුළත් කරන්න.';
    }
    if ($password === '') {
        $errors[] = 'Password එක ඇතුළත් කරන්න.';
    } elseif (strlen($password) < 6) {
        $errors[] = 'Password එක අවම වශයෙන් අක්ෂර 6ක්වත් තිබිය යුතුයි.';
    }

    if (empty($errors)) {
        // Backend authentication / database check එක පසුව මෙහි සම්බන්ධ කරන්න
        $successMessage = 'Form validation සාර්ථකයි! Backend auth සම්බන්ධ කළ පසු login වේ.';
    }
}

include __DIR__ . '/../home/header.php';
?>

<main class="container auth-page">
    <section class="auth-card" aria-label="Sign in form">
        <a href="<?= htmlspecialchars($assetPrefix . 'index.php', ENT_QUOTES, 'UTF-8') ?>" class="auth-back-link">
            <i data-lucide="arrow-left" class="icon-sm" aria-hidden="true"></i>
            <span>Back to Home</span>
        </a>

        <div class="auth-header">
            <span class="auth-badge">G</span>
            <h1 class="auth-title">Welcome back</h1>
            <p class="auth-subtitle">Sign in to manage and publish stories on Gdoop CMS.</p>
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

        <form id="signInForm" class="auth-form" method="POST" action="signin.php" novalidate>
            <div class="auth-field">
                <label for="signInEmail" class="auth-label">Email Address</label>
                <div class="auth-input-wrap">
                    <i data-lucide="mail" class="auth-field-icon" aria-hidden="true"></i>
                    <input
                        type="email"
                        id="signInEmail"
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
                <div class="auth-label-row">
                    <label for="signInPassword" class="auth-label">Password</label>
                    <a href="#forgot-password" class="auth-link-muted">Forgot password?</a>
                </div>
                <div class="auth-input-wrap">
                    <i data-lucide="lock" class="auth-field-icon" aria-hidden="true"></i>
                    <input
                        type="password"
                        id="signInPassword"
                        name="password"
                        class="auth-input auth-input-password"
                        placeholder="Enter your password"
                        autocomplete="current-password"
                        required
                    >
                    <button
                        type="button"
                        id="togglePasswordBtn"
                        class="password-toggle-btn"
                        title="Show or hide password"
                        aria-label="Show or hide password"
                    >
                        <i data-lucide="eye" class="icon-sm" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <div class="auth-options-row">
                <label class="remember-check">
                    <input type="checkbox" id="rememberMe" name="remember_me" value="1">
                    <span>Remember me on this device</span>
                </label>
            </div>

            <button type="submit" id="signInSubmitBtn" class="auth-submit-btn">
                <i data-lucide="log-in" class="icon-sm" aria-hidden="true"></i>
                <span>Sign In</span>
            </button>
        </form>

        <p class="auth-footer-text">
            Don't have an account yet?
            <a href="<?= htmlspecialchars($assetPrefix . 'components/signup/signup.php', ENT_QUOTES, 'UTF-8') ?>" class="auth-link-accent">
                Create account
            </a>
        </p>
    </section>
</main>

<?php include __DIR__ . '/../home/footer.php'; ?>