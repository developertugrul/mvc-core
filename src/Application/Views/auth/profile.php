<!doctype html>
<html lang="en">
<head><meta charset="UTF-8"><title>Profile</title><link rel="stylesheet" href="/assets/app.css"></head>
<body class="bg-slate-50 text-slate-900">
<main class="max-w-xl mx-auto p-6 space-y-3">
    <h2 class="text-2xl font-bold">Profile</h2>
    <p>User ID: <?= htmlspecialchars((string) $userId, ENT_QUOTES, 'UTF-8'); ?></p>
    <p>Role: <?= htmlspecialchars((string) $role, ENT_QUOTES, 'UTF-8'); ?></p>
</main>
</body>
</html>
