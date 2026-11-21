<?php
$assetPrefix = '../';
$pageTitle   = 'Privacy Policy — Gdoop CMS';
$pageCss     = $assetPrefix . 'bin/css/privacy.css';
$pageJs      = $assetPrefix . 'bin/js/privacy.js';

include __DIR__ . '/home/header.php';
?>

<main class="container legal-page">
    <div class="legal-topbar">
        <a href="<?= htmlspecialchars($assetPrefix . 'index.php', ENT_QUOTES, 'UTF-8') ?>" class="back-link">
            <i data-lucide="arrow-left" class="icon-sm" aria-hidden="true"></i>
            <span>Back to Home</span>
        </a>

        <div class="legal-header">
            <span class="legal-pill">Privacy & Data</span>
            <h1 class="legal-title">Privacy Policy</h1>
            <p class="legal-meta">
                <span>Last updated: <?= date('F d, Y') ?></span>
                <span aria-hidden="true">•</span>
                <span>Gdoop CMS Platform</span>
            </p>
        </div>
    </div>

    <div class="legal-layout">
        <!-- Left: Table of Contents -->
        <aside class="legal-toc" aria-label="Privacy sections">
            <div class="toc-card">
                <h2 class="toc-title">On this page</h2>
                <nav class="toc-list">
                    <a href="#information-collected" class="toc-link active">1. Information We Collect</a>
                    <a href="#how-we-use" class="toc-link">2. How We Use Information</a>
                    <a href="#local-storage" class="toc-link">3. Local Storage & Preferences</a>
                    <a href="#data-sharing" class="toc-link">4. Data Sharing & Security</a>
                    <a href="#your-rights" class="toc-link">5. Your Choices & Rights</a>
                    <a href="#policy-updates" class="toc-link">6. Policy Updates</a>
                </nav>
            </div>
        </aside>

        <!-- Right: Privacy Content -->
        <article class="legal-content">
            <section id="information-collected" class="legal-section">
                <h2>1. Information We Collect</h2>
                <p>
                    When you use <strong>Gdoop CMS</strong>, we may collect basic account details, content you write
                    or submit (such as post titles, excerpts, drafts, and articles), and technical information needed
                    to keep the platform running smoothly.
                </p>
                <ul>
                    <li>Account details such as your name, username, and email address when signing up or signing in.</li>
                    <li>Editorial content, cover image links, and metadata you enter when creating posts.</li>
                </ul>
            </section>

            <section id="how-we-use" class="legal-section">
                <h2>2. How We Use Information</h2>
                <p>
                    We use collected information to operate, maintain, and improve Gdoop CMS features for readers and
                    authors.
                </p>
                <ul>
                    <li>Display published stories, filter posts by category or search terms, and support post creation workflows.</li>
                    <li>Protect accounts, prevent abuse, and diagnose technical errors.</li>
                </ul>
            </section>

            <section id="local-storage" class="legal-section">
                <h2>3. Local Storage & Preferences</h2>
                <p>
                    Gdoop CMS uses browser <strong>localStorage</strong> to remember interface preferences locally on
                    your device so your experience stays consistent across pages.
                </p>
                <ul>
                    <li>Theme selection (Dark mode or Light mode) is stored locally in your browser.</li>
                    <li>Optional convenience settings such as remembered email or policy acknowledgment may also use local storage.</li>
                </ul>
            </section>

            <section id="data-sharing" class="legal-section">
                <h2>4. Data Sharing & Security</h2>
                <p>
                    We do not sell your personal information. Content you choose to publish on Gdoop CMS may be
                    visible to visitors of the platform, and we apply reasonable safeguards to protect stored data.
                </p>
            </section>

            <section id="your-rights" class="legal-section">
                <h2>5. Your Choices & Rights</h2>
                <p>
                    You have control over your preferences and content. You can clear browser storage at any time
                    through your browser settings, and once account/database features are active, manage your profile
                    and posts directly.
                </p>
            </section>

            <section id="policy-updates" class="legal-section">
                <h2>6. Policy Updates</h2>
                <p>
                    We may update this Privacy Policy as Gdoop CMS grows and adds new capabilities. Any updates will
                    be reflected on this page with an updated revision date.
                </p>
            </section>

            <div class="legal-preferences-bar">
                <div>
                    <strong class="pref-title">Local Browser Storage</strong>
                    <p class="pref-desc">Clear saved theme & UI preferences stored in this browser.</p>
                </div>
                <button type="button" id="clearLocalPrefsBtn" class="clear-prefs-btn">
                    <i data-lucide="trash-2" class="icon-sm" aria-hidden="true"></i>
                    <span>Clear Saved Preferences</span>
                </button>
            </div>
            <p id="clearPrefsFeedback" class="pref-feedback" role="status" aria-live="polite"></p>
        </article>
    </div>
</main>

<?php include __DIR__ . '/home/footer.php'; ?>