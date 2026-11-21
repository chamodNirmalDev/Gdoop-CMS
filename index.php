<?php
$assetPrefix = '';
require_once __DIR__ . '/data/mock_data.php';

$pageTitle = 'Gdoop CMS — Home';
include __DIR__ . '/components/home/header.php';
?>

<main class="container main-content">
    <?php include __DIR__ . '/components/home/hero.php'; ?>

    <?php include __DIR__ . '/components/home/category_bar.php'; ?>

    <section aria-label="Latest posts">
        <div class="posts-grid" id="postsGrid">
            <?php foreach ($posts as $post): ?>
                <?php include __DIR__ . '/components/home/post_card.php'; ?>
            <?php endforeach; ?>
        </div>

        <div id="emptyState" class="empty-state" hidden>
            <p>No matching posts found for your filter or search.</p>
            <button type="button" id="resetFiltersBtn" class="secondary-btn">Reset Filters</button>
        </div>

        <div class="load-more-wrap">
            <button type="button" id="loadMoreBtn" class="load-more-btn">Load more</button>
        </div>
    </section>
</main>

<?php include __DIR__ . '/components/home/footer.php'; ?>