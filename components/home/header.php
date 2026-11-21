<?php
$assetPrefix = $assetPrefix ?? '';
$pageTitle   = $pageTitle ?? 'Gdoop CMS - Publish & Discover Stories';
$pageCss     = $pageCss ?? '';
$isLoggedIn  = $isLoggedIn ?? false;
$userInitial = $userInitial ?? 'G';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="<?= htmlspecialchars($assetPrefix . 'bin/css/home.css', ENT_QUOTES, 'UTF-8') ?>">
    <?php if ($pageCss !== ''): ?>
        <link rel="stylesheet" href="<?= htmlspecialchars($pageCss, ENT_QUOTES, 'UTF-8') ?>">
    <?php endif; ?>
</head>

<body>
    <header class="topbar">
        <div class="container topbar-inner">
            <a class="brand" href="<?= htmlspecialchars($assetPrefix . 'index.php', ENT_QUOTES, 'UTF-8') ?>">
                <span class="brand-badge">G</span>
                <span class="brand-name">Gdoop CMS<span>.</span></span>
            </a>

            <div class="search-box">
                <i data-lucide="search" class="search-icon" aria-hidden="true"></i>
                <input
                    type="text"
                    id="searchInput"
                    placeholder="Search articles, topics or authors..."
                    aria-label="Search posts" />
                <button type="button" id="clearSearchBtn" class="clear-btn" title="Clear search" aria-label="Clear search" hidden>
                    <i data-lucide="x" aria-hidden="true"></i>
                </button>
            </div>

            <div class="nav-actions">
                <button type="button" id="themeToggleBtn" class="icon-btn" title="Toggle theme" aria-label="Toggle dark and light theme">
                    <i data-lucide="sun" id="themeIcon" class="icon-sm" aria-hidden="true"></i>
                </button>

                <a href="<?= htmlspecialchars($assetPrefix . 'components/create-post.php', ENT_QUOTES, 'UTF-8') ?>" class="icon-btn" title="Create new post" aria-label="Create new post">
                    <i data-lucide="plus" class="icon-sm" aria-hidden="true"></i>
                </a>

                <?php if ($isLoggedIn): ?>
                    <a href="#profile" class="avatar-btn" title="Account" aria-label="Account">
                        <?= htmlspecialchars(strtoupper(substr($userInitial, 0, 1)), ENT_QUOTES, 'UTF-8') ?>
                    </a>
                <?php else : ?>
                    <a href="<?= htmlspecialchars($assetPrefix . 'components/signin/signin.php', ENT_QUOTES, 'UTF-8') ?>" id="signInBtn" class="signin-btn" title="Sign in" aria-label="Sign in">
                        <i data-lucide="log-in" class="icon-sm" aria-hidden="true"></i>
                        <span>Sign in</span>
                    </a>
                <?php endif; ?>
            </div>

        </div>
    </header>