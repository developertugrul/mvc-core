<!doctype html>
<html lang="en">
<head><meta charset="UTF-8"><title>Forgot Password</title><link rel="stylesheet" href="/assets/app.css"></head>
<body class="bg-slate-50 text-slate-900">
<main class="max-w-xl mx-auto p-6 space-y-3">
    <h2 class="text-2xl font-bold">Forgot Password</h2>
    <form method="post" action="/forgot-password">
        <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
        <label>Email <input type="email" name="email" required></label><br>
        <button class="btn" type="submit">Send reset link</button>
    </form>
</main>
</body>
</html>
