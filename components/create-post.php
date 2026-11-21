<?php
$assetPrefix = '../';
require_once __DIR__ . '/../data/mock_data.php';

$pageTitle = 'Create New Post — Gdoop CMS';
$pageCss = $assetPrefix . 'bin/css/create-post.css';
$pageJs  = $assetPrefix . 'bin/js/create-post.js';

// Categories list එක mock_data.php වලින් නැතිනම් fallback එකක්
$postCategories = array_values(array_filter(
    $categories ?? ['Programming', 'Technology', 'Web Design', 'Web Development', 'Database', 'Lifestyle', 'Education', 'Photography', 'Travel', 'Other'],
    fn($cat) => strtolower($cat) !== 'all'
));

$submittedData = null;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title      = trim($_POST['title'] ?? '');
    $category   = trim($_POST['category'] ?? '');
    $author     = trim($_POST['author'] ?? 'Chamod Nirmal');
    $readTime   = trim($_POST['read_time'] ?? '3 min read');
    $excerpt    = trim($_POST['excerpt'] ?? '');
    $content    = trim($_POST['content'] ?? '');
    $coverImage = trim($_POST['cover_image'] ?? '');
    $status     = ($_POST['status'] ?? 'published') === 'draft' ? 'draft' : 'published';

    if ($title === '') {
        $errors[] = 'Post title එක ඇතුළත් කරන්න.';
    }
    if ($category === '') {
        $errors[] = 'Category එකක් තෝරන්න.';
    }
    if ($excerpt === '') {
        $errors[] = 'Short excerpt එකක් ඇතුළත් කරන්න.';
    }
    if ($content === '') {
        $errors[] = 'Post content එක ඇතුළත් කරන්න.';
    }

    if (empty($errors)) {
        $submittedData = [
            'title'       => $title,
            'category'    => $category,
            'author'      => $author !== '' ? $author : 'Chamod Nirmal',
            'read_time'   => $readTime !== '' ? $readTime : '3 min read',
            'excerpt'     => $excerpt,
            'content'     => $content,
            'cover_image' => $coverImage,
            'status'      => $status,
            'created_at'  => date('d M, Y'),
        ];
    }
}

include __DIR__ . '/home/header.php';
?>

<main class="container create-page">
    <!-- Top Back Bar -->
    <div class="create-topbar">
        <a href="<?= htmlspecialchars($assetPrefix . 'index.php', ENT_QUOTES, 'UTF-8') ?>" class="back-link">
            <i data-lucide="arrow-left" class="icon-sm" aria-hidden="true"></i>
            <span>Back to Home</span>
        </a>
        <div class="create-heading-wrap">
            <h1 class="create-page-title">Create New Post</h1>
            <p class="create-page-subtitle">Write, preview, and publish a story to Gdoop CMS.</p>
        </div>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error" role="alert">
            <strong>කරුණාකර පහත දේවල් සම්පූර්ණ කරන්න:</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($submittedData !== null): ?>
        <div class="alert alert-success" role="status">
            <strong>Post Preview Ready!</strong>
            <span>
                "<?= htmlspecialchars($submittedData['title'], ENT_QUOTES, 'UTF-8') ?>"
                (Status: <strong><?= htmlspecialchars(ucfirst($submittedData['status']), ENT_QUOTES, 'UTF-8') ?></strong>)
                validated සාර්ථකයි. Database/API integration එක සම්බන්ධ කළ පසු මෙය save වේ.
            </span>
        </div>
    <?php endif; ?>

    <div class="create-layout">
        <!-- Left: Create Post Form -->
        <form id="createPostForm" class="editor-panel" method="POST" action="create-post.php" novalidate>
            <div class="form-group">
                <label for="postTitle" class="form-label">Post Title <span>*</span></label>
                <input
                    type="text"
                    id="postTitle"
                    name="title"
                    class="form-input form-input-lg"
                    placeholder="Enter a clear, engaging title..."
                    value="<?= htmlspecialchars($_POST['title'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                    required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="postCategory" class="form-label">Category <span>*</span></label>
                    <select id="postCategory" name="category" class="form-select" required>
                        <option value="">Select a category</option>
                        <?php foreach ($postCategories as $cat): ?>
                            <?php $selected = (($_POST['category'] ?? '') === $cat) ? 'selected' : ''; ?>
                            <option value="<?= htmlspecialchars($cat, ENT_QUOTES, 'UTF-8') ?>" <?= $selected ?>>
                                <?= htmlspecialchars($cat, ENT_QUOTES, 'UTF-8') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="postAuthor" class="form-label">Author Name</label>
                    <input
                        type="text"
                        id="postAuthor"
                        name="author"
                        class="form-input"
                        placeholder="Author name"
                        value="<?= htmlspecialchars($_POST['author'] ?? 'Chamod Nirmal', ENT_QUOTES, 'UTF-8') ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="postCoverUrl" class="form-label">Cover Image URL</label>
                    <input
                        type="url"
                        id="postCoverUrl"
                        name="cover_image"
                        class="form-input"
                        placeholder="https://images.unsplash.com/..."
                        value="<?= htmlspecialchars($_POST['cover_image'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                </div>

                <div class="form-group">
                    <label for="postReadTime" class="form-label">Read Time</label>
                    <input
                        type="text"
                        id="postReadTime"
                        name="read_time"
                        class="form-input"
                        placeholder="e.g. 4 min read"
                        value="<?= htmlspecialchars($_POST['read_time'] ?? '4 min read', ENT_QUOTES, 'UTF-8') ?>">
                </div>
            </div>

            <div class="form-group">
                <div class="label-row">
                    <label for="postExcerpt" class="form-label">Short Excerpt <span>*</span></label>
                    <span id="excerptCount" class="char-counter">0 / 180</span>
                </div>
                <textarea
                    id="postExcerpt"
                    name="excerpt"
                    class="form-textarea form-textarea-sm"
                    maxlength="180"
                    placeholder="Write a brief summary shown on post cards..."
                    required><?= htmlspecialchars($_POST['excerpt'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>

            <!-- Formatting Toolbar + Content -->
            <div class="form-group">
                <div class="label-row">
                    <label for="postContent" class="form-label">Story Content <span>*</span></label>
                    <div class="toolbar-btns" role="toolbar" aria-label="Text formatting">
                        <button type="button" class="tool-btn" data-format="bold" title="Bold">
                            <i data-lucide="bold" class="icon-xs" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="tool-btn" data-format="italic" title="Italic">
                            <i data-lucide="italic" class="icon-xs" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="tool-btn" data-format="heading" title="Heading">
                            <i data-lucide="heading-2" class="icon-xs" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="tool-btn" data-format="code" title="Inline Code">
                            <i data-lucide="code" class="icon-xs" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <textarea
                    id="postContent"
                    name="content"
                    class="form-textarea form-textarea-lg"
                    placeholder="Start writing your article here..."
                    required><?= htmlspecialchars($_POST['content'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" name="status" value="draft" id="saveDraftBtn" class="btn-secondary">
                    <i data-lucide="file-text" class="icon-sm" aria-hidden="true"></i>
                    <span>Save Draft</span>
                </button>
                <button type="submit" name="status" value="published" id="publishPostBtn" class="btn-primary">
                    <i data-lucide="send" class="icon-sm" aria-hidden="true"></i>
                    <span>Publish Post</span>
                </button>
            </div>
        </form>

        <!-- Right: Live Card Preview -->
        <aside class="preview-panel" aria-label="Live post preview">
            <div class="preview-header">
                <span class="preview-badge">Live Preview</span>
                <span id="previewStatusBadge" class="status-pill">Published</span>
            </div>

            <article class="preview-card">
                <div class="preview-meta">
                    <div class="preview-author-wrap">
                        <span id="previewAvatar" class="preview-avatar">C</span>
                        <div>
                            <div id="previewAuthor" class="preview-author">Chamod Nirmal</div>
                            <div id="previewMetaSub" class="preview-sub"><?= date('d M, Y') ?> • 4 min read</div>
                        </div>
                    </div>
                </div>

                <div class="preview-thumb" id="previewThumbWrap">
                    <img id="previewImage" alt="Cover preview" hidden>
                    <div id="previewImagePlaceholder" class="preview-img-placeholder">
                        <i data-lucide="image" class="icon-lg" aria-hidden="true"></i>
                        <span>Cover image preview</span>
                    </div>
                </div>

                <div class="preview-body">
                    <span id="previewCategory" class="preview-category">Technology</span>
                    <h2 id="previewTitle" class="preview-title">Your post title will appear here</h2>
                    <p id="previewExcerpt" class="preview-excerpt">
                        Short summary of your story will show up here as you type...
                    </p>
                </div>
            </article>
        </aside>
    </div>
</main>

<?php include __DIR__ . '/home/footer.php'; ?>