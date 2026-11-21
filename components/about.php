<?php
$assetPrefix = '../';
require_once __DIR__ . '/../data/mock_data.php';

$pageTitle = 'About — Gdoop CMS';
$pageCss   = $assetPrefix . 'bin/css/about.css';
$pageJs    = $assetPrefix . 'bin/js/about.js';

$postCount     = isset($posts) && is_array($posts) ? count($posts) : 0;
$categoryCount = isset($categories) && is_array($categories)
    ? count(array_filter($categories, fn($c) => strtolower((string) $c) !== 'all'))
    : 0;

include __DIR__ . '/home/header.php';
?>

<main class="container about-page">
    <div class="about-topbar">
        <a href="<?= htmlspecialchars($assetPrefix . 'index.php', ENT_QUOTES, 'UTF-8') ?>" class="back-link">
            <i data-lucide="arrow-left" class="icon-sm" aria-hidden="true"></i>
            <span>Back to Home</span>
        </a>
    </div>

    <!-- Hero Banner -->
    <section class="about-hero" aria-label="About Gdoop CMS">
        <span class="about-pill">About Gdoop CMS</span>
        <h1 class="about-title">A clean, focused space to write, organize, and publish stories.</h1>
        <p class="about-lead">
            <strong>Gdoop CMS</strong> is a modular content management web application built with PHP,
            CSS custom properties, and vanilla JavaScript—designed for fast category filtering, live
            post drafting, and a comfortable reading experience in both dark and light themes.
        </p>

        <div class="about-cta-row">
            <a href="<?= htmlspecialchars($assetPrefix . 'components/create-post.php', ENT_QUOTES, 'UTF-8') ?>" class="about-btn-primary">
                <i data-lucide="plus" class="icon-sm" aria-hidden="true"></i>
                <span>Create a Post</span>
            </a>
            <a href="<?= htmlspecialchars($assetPrefix . 'index.php', ENT_QUOTES, 'UTF-8') ?>" class="about-btn-secondary">
                <span>Explore Stories</span>
            </a>
        </div>
    </section>

    <!-- Platform Highlights -->
    <section class="about-stats-grid" aria-label="Platform overview">
        <div class="about-stat-card">
            <span class="stat-value" id="statPostsCount"><?= (int) $postCount ?>+</span>
            <span class="stat-label">Sample Stories Ready</span>
        </div>
        <div class="about-stat-card">
            <span class="stat-value" id="statCategoriesCount"><?= (int) $categoryCount ?>+</span>
            <span class="stat-label">Topic Categories</span>
        </div>
        <div class="about-stat-card">
            <span class="stat-value">Dark / Light</span>
            <span class="stat-label">Persistent Theme Switcher</span>
        </div>
    </section>

    <!-- Core Features -->
    <section class="about-section" aria-labelledby="featuresHeading">
        <h2 id="featuresHeading" class="section-heading">What Gdoop CMS Offers</h2>
        <div class="features-grid">
            <article class="feature-card">
                <div class="feature-icon-wrap">
                    <i data-lucide="layers" class="icon-sm" aria-hidden="true"></i>
                </div>
                <h3>Modular Component Architecture</h3>
                <p>
                    Shared headers, footers, cards, and navigation bars are structured as reusable PHP
                    components with path prefixing across nested routes.
                </p>
            </article>

            <article class="feature-card">
                <div class="feature-icon-wrap">
                    <i data-lucide="pen-square" class="icon-sm" aria-hidden="true"></i>
                </div>
                <h3>Live Post Editor & Preview</h3>
                <p>
                    Draft stories with formatting helpers, character counters, draft/publish states, and
                    a side-by-side live card preview before submitting.
                </p>
            </article>

            <article class="feature-card">
                <div class="feature-icon-wrap">
                    <i data-lucide="filter" class="icon-sm" aria-hidden="true"></i>
                </div>
                <h3>Instant Category & Search Filtering</h3>
                <p>
                    Browse articles by category pills or search across titles, excerpts, authors, and
                    topics without unnecessary page reloads.
                </p>
            </article>

            <article class="feature-card">
                <div class="feature-icon-wrap">
                    <i data-lucide="palette" class="icon-sm" aria-hidden="true"></i>
                </div>
                <h3>Theme-Aware Interface</h3>
                <p>
                    Switch smoothly between dark and light modes with preferences saved locally in your
                    browser via <code>localStorage</code>.
                </p>
            </article>
        </div>
    </section>

    <!-- Interactive Architecture / Workflow Tabs -->
    <section class="about-section" aria-labelledby="workflowHeading">
        <div class="workflow-header-row">
            <h2 id="workflowHeading" class="section-heading">How It Works</h2>
            <div class="workflow-tabs" role="tablist" aria-label="Workflow steps">
                <button type="button" class="workflow-tab active" role="tab" aria-selected="true" data-tab="discover">
                    1. Discover
                </button>
                <button type="button" class="workflow-tab" role="tab" aria-selected="false" data-tab="create">
                    2. Create
                </button>
                <button type="button" class="workflow-tab" role="tab" aria-selected="false" data-tab="manage">
                    3. Grow
                </button>
            </div>
        </div>

        <div class="workflow-panel" id="workflowPanel" role="tabpanel">
            <h3 id="workflowTitle">Discover & Filter Stories</h3>
            <p id="workflowDescription">
                Start on the home feed to explore articles across categories like Programming, Web
                Development, Database, and Technology, or narrow down results using live search.
            </p>
        </div>
    </section>
</main>

<?php include __DIR__ . '/home/footer.php'; ?>