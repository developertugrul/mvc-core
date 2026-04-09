<!doctype html>
<html lang="en">
<head><meta charset="UTF-8"><title>OAuth Clients</title><link rel="stylesheet" href="/assets/app.css"></head>
<body class="bg-slate-50 text-slate-900">
<main class="max-w-4xl mx-auto p-6 space-y-4">
    <h1 class="text-2xl font-bold">OAuth Client Management</h1>

    <?php if (is_array($generated ?? null)): ?>
        <div class="p-3 rounded border bg-amber-50">
            <p><strong>Client ID:</strong> <?= htmlspecialchars((string) $generated['client_id'], ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Client Secret (only shown once):</strong> <?= htmlspecialchars((string) $generated['client_secret'], ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
    <?php endif; ?>

    <form method="post" action="/admin/oauth-clients" class="space-y-2 p-3 border rounded bg-white">
        <input type="hidden" name="_csrf" value="<?= htmlspecialchars((string) $csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
        <label>Client name <input type="text" name="name" required value="New Client"></label><br>
        <label><input type="checkbox" name="grants[]" value="client_credentials" checked> client_credentials</label><br>
        <label><input type="checkbox" name="grants[]" value="password" checked> password</label><br>
        <label><input type="checkbox" name="grants[]" value="refresh_token" checked> refresh_token</label><br>
        <button class="btn" type="submit">Create client</button>
    </form>

    <div class="space-y-2">
        <?php foreach ($clients as $client): ?>
            <div class="p-3 border rounded bg-white">
                <p><strong><?= htmlspecialchars((string) $client['name'], ENT_QUOTES, 'UTF-8'); ?></strong></p>
                <p>Client ID: <?= htmlspecialchars((string) $client['client_id'], ENT_QUOTES, 'UTF-8'); ?></p>
                <p>Grants: <?= htmlspecialchars((string) $client['grants'], ENT_QUOTES, 'UTF-8'); ?></p>
                <p>Status: <?= ((int) $client['is_active'] === 1) ? 'active' : 'revoked'; ?></p>

                <form method="post" action="/admin/oauth-clients/<?= urlencode((string) $client['client_id']); ?>/rotate" style="display:inline-block">
                    <input type="hidden" name="_csrf" value="<?= htmlspecialchars((string) $csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
                    <button class="btn" type="submit">Rotate secret</button>
                </form>
                <form method="post" action="/admin/oauth-clients/<?= urlencode((string) $client['client_id']); ?>/revoke" style="display:inline-block">
                    <input type="hidden" name="_csrf" value="<?= htmlspecialchars((string) $csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
                    <button class="btn" type="submit">Revoke</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</main>
</body>
</html>
