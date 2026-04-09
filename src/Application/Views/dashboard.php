<!doctype html>
<html lang="en">
<head><meta charset="UTF-8"><title>Dashboard</title><link rel="stylesheet" href="/assets/app.css"></head>
<body class="bg-slate-50 text-slate-900">
    <main class="max-w-2xl mx-auto p-6 space-y-3">
    <h2 class="text-2xl font-bold">Dashboard</h2>
    <p>Role: <?= htmlspecialchars($role, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php if ($canViewAdmin): ?>
        <p>Admin policy granted.</p>
        <a class="text-blue-600 underline" href="/admin/oauth-clients">Manage OAuth Clients</a><br>
    <?php else: ?>
        <p>Standard user view.</p>
    <?php endif; ?>
    <a class="text-blue-600 underline" href="/settings/language">Language settings</a>
    <form method="post" action="/logout">
        <input type="hidden" name="_csrf" value="<?= htmlspecialchars(\App\Core\Csrf::token(), ENT_QUOTES, 'UTF-8'); ?>">
        <button class="btn" type="submit">Logout</button>
    </form>
    </main>
</body>
</html>
