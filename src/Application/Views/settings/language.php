<!doctype html>
<html lang="en">
<head><meta charset="UTF-8"><title>Language Settings</title><link rel="stylesheet" href="/assets/app.css"></head>
<body class="bg-slate-50 text-slate-900">
<main class="max-w-xl mx-auto p-6 space-y-3">
<h2 class="text-2xl font-bold">Language Settings</h2>
<form class="space-y-2" method="post" action="/settings/language">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
    <?php foreach ($allLocales as $locale): ?>
        <label>
            <input type="checkbox" name="enabled_locales[]" value="<?= $locale; ?>" <?= in_array($locale, $enabled, true) ? 'checked' : ''; ?>>
            <?= strtoupper($locale); ?>
        </label><br>
    <?php endforeach; ?>
    <button class="btn" type="submit">Save</button>
</form>
</main>
</body>
</html>
