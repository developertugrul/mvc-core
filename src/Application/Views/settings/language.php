<!doctype html>
<html lang="en">
<head><meta charset="UTF-8"><title>Language Settings</title></head>
<body>
<h2>Language Settings</h2>
<form method="post" action="/settings/language">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
    <?php foreach ($allLocales as $locale): ?>
        <label>
            <input type="checkbox" name="enabled_locales[]" value="<?= $locale; ?>" <?= in_array($locale, $enabled, true) ? 'checked' : ''; ?>>
            <?= strtoupper($locale); ?>
        </label><br>
    <?php endforeach; ?>
    <button type="submit">Save</button>
</form>
</body>
</html>
