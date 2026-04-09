<!doctype html>
<html lang="en">
<head><meta charset="UTF-8"><title>Dashboard</title></head>
<body>
    <h2>Dashboard</h2>
    <p>Role: <?= htmlspecialchars($role, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php if ($canViewAdmin): ?>
        <p>Admin policy granted.</p>
    <?php else: ?>
        <p>Standard user view.</p>
    <?php endif; ?>
    <form method="post" action="/logout">
        <input type="hidden" name="_csrf" value="<?= htmlspecialchars(\App\Core\Csrf::token(), ENT_QUOTES, 'UTF-8'); ?>">
        <button type="submit">Logout</button>
    </form>
</body>
</html>
