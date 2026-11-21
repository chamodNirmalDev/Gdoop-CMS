<section class="category-bar-wrap" aria-label="Categories">
    <div class="category-scroll" id="categoryList">
        <?php foreach ($categories as $index => $cat): ?>
            <button
                type="button"
                class="category-pill <?= $index === 0 ? 'active' : '' ?>"
                data-category="<?= htmlspecialchars($cat, ENT_QUOTES, 'UTF-8') ?>"
            >
                <?= htmlspecialchars($cat, ENT_QUOTES, 'UTF-8') ?>
            </button>
        <?php endforeach; ?>
    </div>
    <button type="button" id="scrollRightBtn" class="scroll-arrow-btn" aria-label="Scroll categories right">
        <i data-lucide="chevron-right" class="icon-sm" aria-hidden="true"></i>
    </button>
</section>