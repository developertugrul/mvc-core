<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MVC Core Starter</title>
</head>
<body>
    <h1><?= htmlspecialchars(__('messages.welcome'), ENT_QUOTES, 'UTF-8'); ?></h1>
    <p>Shared hosting compatible starter.</p>
    <?php if ($isAuthenticated): ?>
        <a href="/dashboard"><?= htmlspecialchars(__('messages.dashboard'), ENT_QUOTES, 'UTF-8'); ?></a>
    <?php else: ?>
        <a href="/login"><?= htmlspecialchars(__('messages.login'), ENT_QUOTES, 'UTF-8'); ?></a> |
        <a href="/register"><?= htmlspecialchars(__('messages.register'), ENT_QUOTES, 'UTF-8'); ?></a>
    <?php endif; ?>
</body>
</html>
