<?php
$assetPrefix = '../';
require_once __DIR__ . '/../data/mock_data.php';

$allPosts = isset($posts) && is_array($posts) ? $posts : [];

// Query string (?id=...) මඟින් අදාළ post එක සෙවීම
$requestedId = trim((string) ($_GET['id'] ?? ''));
$currentPost = null;

foreach ($allPosts as $item) {
    if ((string) ($item['id'] ?? '') === $requestedId) {
        $currentPost = $item;
        break;
    }
}

if ($currentPost === null && !empty($allPosts)) {
    $currentPost = $allPosts[0];
}

$postTitle    = $currentPost['title'] ?? 'Why Homemade Food Can Be Special';
$postAuthor   = $currentPost['author'] ?? 'Dimuthu Rathnayaka';
$postDate     = $currentPost['date'] ?? '29 Sept, 2026';
$postCategory = $currentPost['category'] ?? 'Lifestyle';
$postReadTime = $currentPost['read_time'] ?? '4 min read';
$postImage    = $currentPost['image'] ?? ($currentPost['cover_image'] ?? '');
$postExcerpt  = $currentPost['excerpt'] ?? 'Homemade food can be more than just a meal. Cooking at home gives you the opportunity to experiment with fresh ingredients, flavors, and routines that fit your day.';
$postViews    = (int) ($currentPost['views'] ?? 33);

if (isset($currentPost['content']) && is_array($currentPost['content'])) {
    $postParagraphs = $currentPost['content'];
} elseif (isset($currentPost['content']) && is_string($currentPost['content']) && trim($currentPost['content']) !== '') {
    $postParagraphs = preg_split('/\R{2,}/', trim($currentPost['content']));
} else {
    $postParagraphs = [
        $postExcerpt,
        'Preparing meals in your own kitchen lets you control portion sizes, ingredient quality, and cooking pace without rushing. Even simple everyday recipes feel more rewarding when made fresh.',
        'Over time, small habits like planning weekly ingredients or trying a new spice blend turn routine cooking into a calm, creative break from busy screen-heavy hours.',
    ];
}

$authorInitial = strtoupper(substr(trim($postAuthor), 0, 1)) ?: 'D';

// "More posts" sidebar සඳහා වෙනත් posts
$morePosts = array_values(array_filter(
    $allPosts,
    fn($item) => (string) ($item['id'] ?? '') !== (string) ($currentPost['id'] ?? '')
));
if (empty($morePosts)) {
    $morePosts = $allPosts;
}
$morePosts = array_slice($morePosts, 0, 4);

$pageTitle = $postTitle . ' — Gdoop CMS';
$pageCss   = $assetPrefix . 'bin/css/post.css';
$pageJs    = $assetPrefix . 'bin/js/post.js';

include __DIR__ . '/home/header.php';
?>

<main class="container post-detail-page">
    <div class="post-detail-layout">
        <!-- Left Main Article Column -->
        <article class="post-article-col" aria-label="Article details">
            <div class="post-author-bar">
                <div class="post-author-left">
                    <span class="post-author-avatar" aria-hidden="true">
                        <?= htmlspecialchars($authorInitial, ENT_QUOTES, 'UTF-8') ?>
                    </span>
                    <div class="post-author-meta">
                        <strong class="post-author-name"><?= htmlspecialchars($postAuthor, ENT_QUOTES, 'UTF-8') ?></strong>
                        <span class="post-publish-date">
                            <?= htmlspecialchars($postDate, ENT_QUOTES, 'UTF-8') ?>
                            <?php if ($postCategory !== ''): ?>
                                • <?= htmlspecialchars($postCategory, ENT_QUOTES, 'UTF-8') ?>
                            <?php endif; ?>
                            <?php if ($postReadTime !== ''): ?>
                                • <?= htmlspecialchars($postReadTime, ENT_QUOTES, 'UTF-8') ?>
                            <?php endif; ?>
                        </span>
                    </div>
                </div>

                <button
                    type="button"
                    id="bookmarkPostBtn"
                    class="bookmark-icon-btn"
                    title="Save post"
                    aria-label="Save post"
                    aria-pressed="false"
                >
                    <i data-lucide="bookmark" id="bookmarkIcon" class="icon-sm" aria-hidden="true"></i>
                </button>
            </div>

            <h1 class="post-detail-title"><?= htmlspecialchars($postTitle, ENT_QUOTES, 'UTF-8') ?></h1>

            <div class="post-cover-wrap">
                <?php if ($postImage !== ''): ?>
                    <img
                        src="<?= htmlspecialchars($postImage, ENT_QUOTES, 'UTF-8') ?>"
                        alt="<?= htmlspecialchars($postTitle, ENT_QUOTES, 'UTF-8') ?>"
                        class="post-cover-img"
                    >
                <?php else: ?>
                    <div class="post-cover-placeholder">
                        <i data-lucide="image" class="icon-lg" aria-hidden="true"></i>
                        <span>No cover image</span>
                    </div>
                <?php endif; ?>
            </div>

            <div class="post-engagement-bar">
                <div class="post-views-stat" title="Views">
                    <span id="postViewsCount"><?= $postViews ?></span>
                    <i data-lucide="eye" class="icon-sm" aria-hidden="true"></i>
                </div>

                <button type="button" id="reportPostBtn" class="report-post-btn">
                    <i data-lucide="flag" class="icon-xs" aria-hidden="true"></i>
                    <span>Report</span>
                </button>
            </div>

            <p id="postActionNotice" class="post-action-notice" role="status" aria-live="polite" hidden></p>

            <div class="post-body-content">
                <?php foreach ($postParagraphs as $para): ?>
                    <?php if (trim((string) $para) !== ''): ?>
                        <p><?= htmlspecialchars(trim((string) $para), ENT_QUOTES, 'UTF-8') ?></p>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </article>

        <!-- Right "More posts" Sidebar -->
        <aside class="more-posts-col" aria-label="More posts">
            <h2 class="more-posts-heading">More posts</h2>

            <div class="more-posts-list">
                <?php foreach ($morePosts as $sidePost): ?>
                    <?php
                    $sideId      = (string) ($sidePost['id'] ?? '1');
                    $sideHref    = 'post.php?id=' . urlencode($sideId);
                    $sideAuthor  = $sidePost['author'] ?? $postAuthor;
                    $sideDate    = $sidePost['date'] ?? '1 Oct, 2026';
                    $sideTitle   = $sidePost['title'] ?? 'Untitled Post';
                    $sideImage   = $sidePost['image'] ?? ($sidePost['cover_image'] ?? '');
                    $sideViews   = (int) ($sidePost['views'] ?? 12);
                    $sideInitial = strtoupper(substr(trim($sideAuthor), 0, 1)) ?: 'D';
                    ?>
                    <a href="<?= htmlspecialchars($sideHref, ENT_QUOTES, 'UTF-8') ?>" class="more-post-card">
                        <div class="more-post-meta-row">
                            <div class="more-post-author-wrap">
                                <span class="more-post-avatar" aria-hidden="true">
                                    <?= htmlspecialchars($sideInitial, ENT_QUOTES, 'UTF-8') ?>
                                </span>
                                <div class="more-post-author-info">
                                    <span class="more-post-author"><?= htmlspecialchars($sideAuthor, ENT_QUOTES, 'UTF-8') ?></span>
                                    <span class="more-post-date"><?= htmlspecialchars($sideDate, ENT_QUOTES, 'UTF-8') ?></span>
                                </div>
                            </div>

                            <span class="more-post-views">
                                <span><?= $sideViews ?></span>
                                <i data-lucide="eye" class="icon-xs" aria-hidden="true"></i>
                            </span>
                        </div>

                        <div class="more-post-thumb">
                            <?php if ($sideImage !== ''): ?>
                                <img
                                    src="<?= htmlspecialchars($sideImage, ENT_QUOTES, 'UTF-8') ?>"
                                    alt="<?= htmlspecialchars($sideTitle, ENT_QUOTES, 'UTF-8') ?>"
                                >
                            <?php else: ?>
                                <div class="more-post-thumb-empty">
                                    <i data-lucide="image" class="icon-sm" aria-hidden="true"></i>
                                </div>
                            <?php endif; ?>
                        </div>

                        <h3 class="more-post-title"><?= htmlspecialchars($sideTitle, ENT_QUOTES, 'UTF-8') ?></h3>
                    </a>
                <?php endforeach; ?>
            </div>
        </aside>
    </div>
</main>

<?php include __DIR__ . '/home/footer.php'; ?>