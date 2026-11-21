<?php if (!empty($featuredPost)): ?>
<section class="hero-section" aria-label="Featured story">
    <div class="hero-card">
        <div class="hero-content">
            <div class="hero-badges">
                <span class="featured-pill">Featured</span>
                <span class="category-tag"><?= htmlspecialchars($featuredPost['category'], ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <h1 class="hero-title">
                <a href="#post-<?= (int)$featuredPost['id'] ?>">
                    <?= htmlspecialchars($featuredPost['title'], ENT_QUOTES, 'UTF-8') ?>
                </a>
            </h1>
            <p class="hero-excerpt"><?= htmlspecialchars($featuredPost['excerpt'], ENT_QUOTES, 'UTF-8') ?></p>

            <div class="hero-footer">
                <div class="author-info">
                    <span class="author-dot"><?= strtoupper(substr($featuredPost['author'], 0, 1)) ?></span>
                    <div>
                        <div class="author-name"><?= htmlspecialchars($featuredPost['author'], ENT_QUOTES, 'UTF-8') ?></div>
                        <div class="post-date">
                            <?= htmlspecialchars($featuredPost['date'], ENT_QUOTES, 'UTF-8') ?> • <?= htmlspecialchars($featuredPost['read_time'], ENT_QUOTES, 'UTF-8') ?>
                        </div>
                    </div>
                </div>
                <a href="#post-<?= (int)$featuredPost['id'] ?>" class="hero-cta">
                    <span>Read Story</span>
                    <i data-lucide="arrow-right" class="icon-sm" aria-hidden="true"></i>
                </a>
            </div>
        </div>

        <a href="#post-<?= (int)$featuredPost['id'] ?>" class="hero-media">
            <img
                src="<?= htmlspecialchars($featuredPost['image'], ENT_QUOTES, 'UTF-8') ?>"
                alt="<?= htmlspecialchars($featuredPost['title'], ENT_QUOTES, 'UTF-8') ?>"
            >
        </a>
    </div>
</section>
<?php endif; ?>
