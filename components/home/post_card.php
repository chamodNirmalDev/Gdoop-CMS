<?php
$assetPrefix = $assetPrefix ?? '';
$postId      = (string) ($post['id'] ?? 1);
$postHref    = $assetPrefix . 'components/post.php?id=' . urlencode($postId);
$postTitle   = $post['title'] ?? 'Untitled Post';
$postExcerpt = $post['excerpt'] ?? '';
$postAuthor  = $post['author'] ?? 'Gdoop Author';
$postDate    = $post['date'] ?? date('d M, Y');
$postCat     = $post['category'] ?? 'General';
$postImage   = $post['image'] ?? ($post['cover_image'] ?? '');
$postViews   = (int) ($post['views'] ?? 0);
$authorInit  = strtoupper(substr(trim($postAuthor), 0, 1)) ?: 'G';
?>
<article
    class="post-card"
    data-category="<?= htmlspecialchars($postCat, ENT_QUOTES, 'UTF-8') ?>"
    data-title="<?= htmlspecialchars(strtolower($postTitle), ENT_QUOTES, 'UTF-8') ?>">

    <div class="post-meta-top">
        <div class="author-info">
            <span class="author-dot" aria-hidden="true"><?= htmlspecialchars($authorInit, ENT_QUOTES, 'UTF-8') ?></span>
            <div>
                <div class="author-name"><?= htmlspecialchars($postAuthor, ENT_QUOTES, 'UTF-8') ?></div>
                <div class="post-date"><?= htmlspecialchars($postDate, ENT_QUOTES, 'UTF-8') ?></div>
            </div>
        </div>

        <span class="post-views" title="Views">
            <span><?= $postViews ?></span>
            <i data-lucide="eye" class="icon-xs" aria-hidden="true"></i>
        </span>
    </div>

    <a href="<?= htmlspecialchars($postHref, ENT_QUOTES, 'UTF-8') ?>" class="thumb-link">
        <div class="thumb-wrap">
            <?php if ($postImage !== ''): ?>
                <img
                    src="<?= htmlspecialchars($postImage, ENT_QUOTES, 'UTF-8') ?>"
                    alt="<?= htmlspecialchars($postTitle, ENT_QUOTES, 'UTF-8') ?>"
                    loading="lazy">
            <?php endif; ?>
        </div>
    </a>

    <div class="post-body">
        <span class="category-tag"><?= htmlspecialchars($postCat, ENT_QUOTES, 'UTF-8') ?></span>

        <h3 class="post-title">
            <a href="<?= htmlspecialchars($postHref, ENT_QUOTES, 'UTF-8') ?>">
                <?= htmlspecialchars($postTitle, ENT_QUOTES, 'UTF-8') ?>
            </a>
        </h3>

        <?php if ($postExcerpt !== ''): ?>
            <p class="post-excerpt"><?= htmlspecialchars($postExcerpt, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
    </div>
</article>