<?php
$assetPrefix = $assetPrefix ?? '';
$pageJs = $pageJs ?? '';
?>
<footer class="site-footer">
    <div class="container footer-inner">
        <div class="footer-brand">
            <strong>Gdoop.</strong>
            <span>Write, publish, and organize stories cleanly.</span>
        </div>
        <nav class="footer-links" aria-label="Footer navigation">
            <a href="<?= htmlspecialchars($assetPrefix . 'components/about.php', ENT_QUOTES, 'UTF-8') ?>">About</a>
            <a href="<?= htmlspecialchars($assetPrefix . 'components/privacy.php', ENT_QUOTES, 'UTF-8') ?>">Privacy</a>
            <a href="<?= htmlspecialchars($assetPrefix . 'components/terms.php', ENT_QUOTES, 'UTF-8') ?>">Terms</a>
            <a href="<?= htmlspecialchars($assetPrefix . 'components/profile.php', ENT_QUOTES, 'UTF-8') ?>">My profile</a>
            <span class="copyright">© <?= date('Y') ?> Gdoop CMS</span>
        </nav>
    </div>
</footer>

<script src="https://unpkg.com/lucide@latest"></script>
<script src="<?= htmlspecialchars($assetPrefix . 'bin/js/home.js', ENT_QUOTES, 'UTF-8') ?>"></script>
<?php if ($pageJs !== ''): ?>
    <script src="<?= htmlspecialchars($pageJs, ENT_QUOTES, 'UTF-8') ?>"></script>
<?php endif; ?>
</body>

</html>