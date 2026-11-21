<?php
$assetPrefix = '../';
require_once __DIR__ . '/../data/mock_data.php';

$pageTitle = 'My Profile — Gdoop CMS';
$pageCss   = $assetPrefix . 'bin/css/profile.css';
$pageJs    = $assetPrefix . 'bin/js/profile.js';

// Dropdown links (?tab=saved, ?tab=edit) වලින් එන active tab එක
$requestedTab = strtolower(trim($_GET['tab'] ?? 'profile'));
$activeTab = in_array($requestedTab, ['profile', 'saved', 'edit'], true) ? $requestedTab : 'profile';

$profileData = [
    'name'     => 'chamod nirmal',
    'username' => '@chamod_nirmal',
    'role'     => 'Full Stack Developer & Author',
    'location' => 'Colombo, Sri Lanka',
    'bio'      => 'Building clean web applications, sharing practical engineering notes, and exploring modern software architecture.',
];

$allPosts = isset($posts) && is_array($posts) ? $posts : [];
$savedPosts = array_slice($allPosts, 0, 2);

$profileSavedMessage = '';
$profileErrors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'update_profile') {
    $activeTab = 'edit';
    $updatedName     = trim($_POST['full_name'] ?? '');
    $updatedUsername = trim($_POST['username'] ?? '');
    $updatedRole     = trim($_POST['role'] ?? '');
    $updatedLocation = trim($_POST['location'] ?? '');
    $updatedBio      = trim($_POST['bio'] ?? '');

    if ($updatedName === '') {
        $profileErrors[] = 'Display name එක ඇතුළත් කරන්න.';
    }
    if ($updatedUsername === '') {
        $profileErrors[] = 'Username එක ඇතුළත් කරන්න.';
    }

    if (empty($profileErrors)) {
        $profileData['name']     = $updatedName;
        $profileData['username'] = str_starts_with($updatedUsername, '@') ? $updatedUsername : '@' . $updatedUsername;
        $profileData['role']     = $updatedRole !== '' ? $updatedRole : $profileData['role'];
        $profileData['location'] = $updatedLocation;
        $profileData['bio']      = $updatedBio;
        $profileSavedMessage     = 'Profile details preview update වුණා! Database/session save logic එක backend එකේදී සම්බන්ධ කරන්න.';
    }
}

$isLoggedIn  = true;
$userName    = $profileData['name'];
$userInitial = strtoupper(substr(trim($profileData['name']), 0, 1)) ?: 'C';

include __DIR__ . '/home/header.php';
?>

<main class="container profile-page" data-active-tab="<?= htmlspecialchars($activeTab, ENT_QUOTES, 'UTF-8') ?>">
    <div class="profile-topbar">
        <a href="<?= htmlspecialchars($assetPrefix . 'index.php', ENT_QUOTES, 'UTF-8') ?>" class="back-link">
            <i data-lucide="arrow-left" class="icon-sm" aria-hidden="true"></i>
            <span>Back to Home</span>
        </a>

        <a href="<?= htmlspecialchars($assetPrefix . 'components/create-post.php', ENT_QUOTES, 'UTF-8') ?>" class="profile-new-post-btn">
            <i data-lucide="plus" class="icon-sm" aria-hidden="true"></i>
            <span>New Post</span>
        </a>
    </div>

    <!-- Profile Summary Banner -->
    <section class="profile-banner" aria-label="User profile summary">
        <div class="profile-identity">
            <div class="profile-large-avatar" id="profileLargeAvatar">
                <?= htmlspecialchars($userInitial, ENT_QUOTES, 'UTF-8') ?>
            </div>
            <div class="profile-meta">
                <div class="profile-name-row">
                    <h1 class="profile-name" id="profileDisplayName">
                        <?= htmlspecialchars($profileData['name'], ENT_QUOTES, 'UTF-8') ?>
                    </h1>
                    <span class="profile-handle" id="profileDisplayHandle">
                        <?= htmlspecialchars($profileData['username'], ENT_QUOTES, 'UTF-8') ?>
                    </span>
                </div>
                <p class="profile-role" id="profileDisplayRole">
                    <?= htmlspecialchars($profileData['role'], ENT_QUOTES, 'UTF-8') ?>
                </p>
                <p class="profile-bio" id="profileDisplayBio">
                    <?= htmlspecialchars($profileData['bio'], ENT_QUOTES, 'UTF-8') ?>
                </p>
                <div class="profile-submeta">
                    <span>
                        <i data-lucide="map-pin" class="icon-xs" aria-hidden="true"></i>
                        <span id="profileDisplayLocation"><?= htmlspecialchars($profileData['location'], ENT_QUOTES, 'UTF-8') ?></span>
                    </span>
                </div>
            </div>
        </div>

        <div class="profile-stats">
            <div class="profile-stat-box">
                <strong id="profilePostsCount"><?= count($allPosts) ?></strong>
                <span>Stories</span>
            </div>
            <div class="profile-stat-box">
                <strong id="profileSavedCount"><?= count($savedPosts) ?></strong>
                <span>Saved</span>
            </div>
        </div>
    </section>

    <!-- Navigation Tabs -->
    <div class="profile-tabs" role="tablist" aria-label="Profile sections">
        <button
            type="button"
            class="profile-tab <?= $activeTab === 'profile' ? 'active' : '' ?>"
            id="tabBtnProfile"
            role="tab"
            aria-selected="<?= $activeTab === 'profile' ? 'true' : 'false' ?>"
            aria-controls="panelProfile"
            data-tab="profile"
        >
            My profile
        </button>
        <button
            type="button"
            class="profile-tab <?= $activeTab === 'saved' ? 'active' : '' ?>"
            id="tabBtnSaved"
            role="tab"
            aria-selected="<?= $activeTab === 'saved' ? 'true' : 'false' ?>"
            aria-controls="panelSaved"
            data-tab="saved"
        >
            Saved posts
        </button>
        <button
            type="button"
            class="profile-tab <?= $activeTab === 'edit' ? 'active' : '' ?>"
            id="tabBtnEdit"
            role="tab"
            aria-selected="<?= $activeTab === 'edit' ? 'true' : 'false' ?>"
            aria-controls="panelEdit"
            data-tab="edit"
        >
            Edit profile
        </button>
    </div>

    <?php if (!empty($profileErrors)): ?>
        <div class="profile-alert profile-alert-error" role="alert">
            <ul>
                <?php foreach ($profileErrors as $err): ?>
                    <li><?= htmlspecialchars($err, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($profileSavedMessage !== ''): ?>
        <div class="profile-alert profile-alert-success" role="status">
            <?= htmlspecialchars($profileSavedMessage, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <!-- Tab 1: My Profile -->
    <section
        id="panelProfile"
        class="profile-panel"
        role="tabpanel"
        aria-labelledby="tabBtnProfile"
        <?= $activeTab === 'profile' ? '' : 'hidden' ?>
    >
        <div class="panel-header">
            <h2>Published & Recent Stories</h2>
            <a href="<?= htmlspecialchars($assetPrefix . 'components/create-post.php', ENT_QUOTES, 'UTF-8') ?>" class="panel-action-link">
                Write new story
            </a>
        </div>

        <?php if (!empty($allPosts)): ?>
            <div class="profile-posts-grid">
                <?php foreach ($allPosts as $item): ?>
                    <article class="profile-post-card">
                        <div class="profile-post-top">
                            <span class="profile-post-cat">
                                <?= htmlspecialchars($item['category'] ?? 'General', ENT_QUOTES, 'UTF-8') ?>
                            </span>
                            <span class="profile-post-time">
                                <?= htmlspecialchars($item['read_time'] ?? '3 min read', ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        </div>
                        <h3 class="profile-post-title">
                            <?= htmlspecialchars($item['title'] ?? 'Untitled Post', ENT_QUOTES, 'UTF-8') ?>
                        </h3>
                        <p class="profile-post-excerpt">
                            <?= htmlspecialchars($item['excerpt'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                        </p>
                        <div class="profile-post-foot">
                            <span><?= htmlspecialchars($item['author'] ?? $profileData['name'], ENT_QUOTES, 'UTF-8') ?></span>
                            <span><?= htmlspecialchars($item['date'] ?? date('d M, Y'), ENT_QUOTES, 'UTF-8') ?></span>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="profile-empty-box">
                <p>No stories available yet.</p>
            </div>
        <?php endif; ?>
    </section>

    <!-- Tab 2: Saved Posts -->
    <section
        id="panelSaved"
        class="profile-panel"
        role="tabpanel"
        aria-labelledby="tabBtnSaved"
        <?= $activeTab === 'saved' ? '' : 'hidden' ?>
    >
        <div class="panel-header">
            <h2>Saved Posts</h2>
            <span class="panel-count-badge" id="savedListCount"><?= count($savedPosts) ?> saved</span>
        </div>

        <div class="profile-posts-grid" id="savedPostsList">
            <?php if (!empty($savedPosts)): ?>
                <?php foreach ($savedPosts as $index => $saved): ?>
                    <article class="profile-post-card saved-post-item" data-saved-id="<?= $index ?>">
                        <div class="profile-post-top">
                            <span class="profile-post-cat">
                                <?= htmlspecialchars($saved['category'] ?? 'General', ENT_QUOTES, 'UTF-8') ?>
                            </span>
                            <button
                                type="button"
                                class="remove-saved-btn"
                                title="Remove from saved"
                                aria-label="Remove from saved"
                            >
                                <i data-lucide="bookmark-x" class="icon-xs" aria-hidden="true"></i>
                                <span>Remove</span>
                            </button>
                        </div>
                        <h3 class="profile-post-title">
                            <?= htmlspecialchars($saved['title'] ?? 'Saved Story', ENT_QUOTES, 'UTF-8') ?>
                        </h3>
                        <p class="profile-post-excerpt">
                            <?= htmlspecialchars($saved['excerpt'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                        </p>
                        <div class="profile-post-foot">
                            <span><?= htmlspecialchars($saved['author'] ?? $profileData['name'], ENT_QUOTES, 'UTF-8') ?></span>
                            <span><?= htmlspecialchars($saved['read_time'] ?? '4 min read', ENT_QUOTES, 'UTF-8') ?></span>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div id="savedEmptyState" class="profile-empty-box" <?= !empty($savedPosts) ? 'hidden' : '' ?>>
            <p>You have no saved posts right now.</p>
            <a href="<?= htmlspecialchars($assetPrefix . 'index.php', ENT_QUOTES, 'UTF-8') ?>" class="profile-empty-link">
                Browse stories on Home
            </a>
        </div>
    </section>

    <!-- Tab 3: Edit Profile -->
    <section
        id="panelEdit"
        class="profile-panel"
        role="tabpanel"
        aria-labelledby="tabBtnEdit"
        <?= $activeTab === 'edit' ? '' : 'hidden' ?>
    >
        <div class="panel-header">
            <h2>Edit Profile</h2>
        </div>

        <form id="editProfileForm" class="edit-profile-form" method="POST" action="profile.php?tab=edit" novalidate>
            <input type="hidden" name="action" value="update_profile">

            <div class="edit-form-grid">
                <div class="edit-field">
                    <label for="editFullName" class="edit-label">Display Name</label>
                    <input
                        type="text"
                        id="editFullName"
                        name="full_name"
                        class="edit-input"
                        value="<?= htmlspecialchars($profileData['name'], ENT_QUOTES, 'UTF-8') ?>"
                        required
                    >
                </div>

                <div class="edit-field">
                    <label for="editUsername" class="edit-label">Username</label>
                    <input
                        type="text"
                        id="editUsername"
                        name="username"
                        class="edit-input"
                        value="<?= htmlspecialchars($profileData['username'], ENT_QUOTES, 'UTF-8') ?>"
                        required
                    >
                </div>

                <div class="edit-field">
                    <label for="editRole" class="edit-label">Role / Headline</label>
                    <input
                        type="text"
                        id="editRole"
                        name="role"
                        class="edit-input"
                        value="<?= htmlspecialchars($profileData['role'], ENT_QUOTES, 'UTF-8') ?>"
                    >
                </div>

                <div class="edit-field">
                    <label for="editLocation" class="edit-label">Location</label>
                    <input
                        type="text"
                        id="editLocation"
                        name="location"
                        class="edit-input"
                        value="<?= htmlspecialchars($profileData['location'], ENT_QUOTES, 'UTF-8') ?>"
                    >
                </div>
            </div>

            <div class="edit-field">
                <label for="editBio" class="edit-label">Bio</label>
                <textarea
                    id="editBio"
                    name="bio"
                    class="edit-textarea"
                    rows="4"
                ><?= htmlspecialchars($profileData['bio'], ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>

            <div class="edit-form-actions">
                <button type="submit" class="edit-save-btn">
                    <i data-lucide="check" class="icon-sm" aria-hidden="true"></i>
                    <span>Save Changes</span>
                </button>
            </div>
        </form>
    </section>
</main>

<?php include __DIR__ . '/home/footer.php'; ?>