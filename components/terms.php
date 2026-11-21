<?php
$assetPrefix = '../';
$pageTitle   = 'Terms of Service — Gdoop CMS';
$pageCss     = $assetPrefix . 'bin/css/terms.css';
$pageJs      = $assetPrefix . 'bin/js/terms.js';

include __DIR__ . '/home/header.php';
?>

<main class="container legal-page">
    <div class="legal-topbar">
        <a href="<?= htmlspecialchars($assetPrefix . 'index.php', ENT_QUOTES, 'UTF-8') ?>" class="back-link">
            <i data-lucide="arrow-left" class="icon-sm" aria-hidden="true"></i>
            <span>Back to Home</span>
        </a>

        <div class="legal-header">
            <span class="legal-pill">Legal & Guidelines</span>
            <h1 class="legal-title">Terms of Service</h1>
            <p class="legal-meta">
                <span>Last updated: <?= date('F d, Y') ?></span>
                <span aria-hidden="true">•</span>
                <span>Gdoop CMS Platform</span>
            </p>
        </div>
    </div>

    <div class="legal-layout">
        <!-- Left: Table of Contents -->
        <aside class="legal-toc" aria-label="Terms sections">
            <div class="toc-card">
                <h2 class="toc-title">On this page</h2>
                <nav class="toc-list">
                    <a href="#acceptance" class="toc-link active">1. Acceptance of Terms</a>
                    <a href="#accounts" class="toc-link">2. User Accounts</a>
                    <a href="#content" class="toc-link">3. User Content & Rights</a>
                    <a href="#prohibited" class="toc-link">4. Prohibited Conduct</a>
                    <a href="#availability" class="toc-link">5. Service & Liability</a>
                    <a href="#changes" class="toc-link">6. Changes to Terms</a>
                </nav>
            </div>
        </aside>

        <!-- Right: Terms Content -->
        <article class="legal-content">
            <section id="acceptance" class="legal-section">
                <h2>1. Acceptance of Terms</h2>
                <p>
                    By accessing or using <strong>Gdoop CMS</strong>, you agree to be bound by these Terms of Service
                    and all applicable guidelines. If you do not agree with any part of these terms, please do not use
                    the platform.
                </p>
            </section>

            <section id="accounts" class="legal-section">
                <h2>2. User Accounts</h2>
                <p>
                    When creating an account on Gdoop CMS, you must provide accurate and complete information.
                    You are responsible for maintaining the confidentiality of your credentials and for all activities
                    that occur under your account.
                </p>
                <ul>
                    <li>Keep your password secure and notify us immediately of any unauthorized access.</li>
                    <li>Do not share account access or impersonate another person or organization.</li>
                </ul>
            </section>

            <section id="content" class="legal-section">
                <h2>3. User Content & Rights</h2>
                <p>
                    You retain ownership of the articles, drafts, images, and other content you create or publish on
                    Gdoop CMS. By publishing content, you grant the platform permission to display, format, and
                    distribute your content within the service.
                </p>
                <ul>
                    <li>Ensure you have the necessary rights or licenses for any text or media you upload.</li>
                    <li>Drafts and published posts remain under your control unless removed for policy violations.</li>
                </ul>
            </section>

            <section id="prohibited" class="legal-section">
                <h2>4. Prohibited Conduct</h2>
                <p>
                    You agree not to misuse Gdoop CMS or help anyone else do so. Prohibited actions include:
                </p>
                <ul>
                    <li>Posting unlawful, defamatory, infringing, or harmful material.</li>
                    <li>Attempting to bypass security controls, scrape data excessively, or disrupt service stability.</li>
                    <li>Uploading malicious scripts, spam, or misleading links.</li>
                </ul>
            </section>

            <section id="availability" class="legal-section">
                <h2>5. Service & Liability</h2>
                <p>
                    Gdoop CMS is provided on an "as is" and "as available" basis. Features, layouts, and tools may
                    evolve over time as we improve the platform. To the fullest extent permitted by law, Gdoop CMS is
                    not liable for indirect or incidental damages arising from your use of the service.
                </p>
            </section>

            <section id="changes" class="legal-section">
                <h2>6. Changes to Terms</h2>
                <p>
                    We may update these Terms of Service periodically to reflect product updates or legal requirements.
                    Continued use of Gdoop CMS after changes are posted constitutes acceptance of the revised terms.
                </p>
            </section>

            <div class="legal-acknowledgment">
                <label class="ack-check">
                    <input type="checkbox" id="acceptTermsCheckbox">
                    <span>I have read and understood the Gdoop CMS Terms of Service.</span>
                </label>
                <span id="ackStatusText" class="ack-status" aria-live="polite"></span>
            </div>
        </article>
    </div>
</main>

<?php include __DIR__ . '/home/footer.php'; ?>