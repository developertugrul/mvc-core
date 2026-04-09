<!doctype html>
<html lang="en">
<head><meta charset="UTF-8"><title>Login</title></head>
<body>
    <h2>Login</h2>
    <form method="post" action="/login">
        <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
        <label>Email <input type="email" name="email" required></label><br>
        <label>Password <input type="password" name="password" required></label><br>
        <button type="submit">Sign in</button>
    </form>
</body>
</html>
