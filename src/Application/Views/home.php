<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MVC Core Starter</title>
    <link rel="stylesheet" href="/assets/app.css">
</head>
<body class="bg-slate-50 text-slate-900">
    <main class="max-w-3xl mx-auto p-6 space-y-4">
    <h1 class="text-3xl font-bold"><?= htmlspecialchars(__('messages.welcome'), ENT_QUOTES, 'UTF-8'); ?></h1>
    <p class="text-slate-600">Shared hosting compatible starter.</p>
    <?= component('language-switcher'); ?>
    <?= component('counter', ['start' => 1]); ?>
    <?php if ($isAuthenticated): ?>
        <a class="text-blue-600 underline" href="/dashboard"><?= htmlspecialchars(__('messages.dashboard'), ENT_QUOTES, 'UTF-8'); ?></a>
    <?php else: ?>
        <a class="text-blue-600 underline" href="/login"><?= htmlspecialchars(__('messages.login'), ENT_QUOTES, 'UTF-8'); ?></a> |
        <a class="text-blue-600 underline" href="/register"><?= htmlspecialchars(__('messages.register'), ENT_QUOTES, 'UTF-8'); ?></a>
    <?php endif; ?>
    <div class="text-sm text-slate-600 space-x-3">
        <a class="underline" href="/cookie-policy">Cookie Policy</a>
        <a class="underline" href="/terms-of-use">Terms of Use</a>
        <a class="underline" href="/privacy-policy">Privacy Policy</a>
    </div>
    </main>
    <script src="/assets/app.js"></script>
</body>
</html>
