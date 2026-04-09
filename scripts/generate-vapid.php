<?php

declare(strict_types=1);

use Minishlink\WebPush\VAPID;

define('BASE_PATH', dirname(__DIR__));
require BASE_PATH . '/vendor/autoload.php';

function base64UrlEncode(string $data): string
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

try {
    $keys = VAPID::createVapidKeys();
} catch (Throwable $e) {
    $resource = openssl_pkey_new([
        'private_key_type' => OPENSSL_KEYTYPE_EC,
        'curve_name' => 'prime256v1',
    ]);

    if ($resource !== false) {
        $details = openssl_pkey_get_details($resource);
        if (is_array($details) && isset($details['ec']['x'], $details['ec']['y'], $details['ec']['d'])) {
            $x = $details['ec']['x'];
            $y = $details['ec']['y'];
            $d = str_pad($details['ec']['d'], 32, "\0", STR_PAD_LEFT);
            $publicRaw = "\x04" . $x . $y;

            $keys = [
                'publicKey' => base64UrlEncode($publicRaw),
                'privateKey' => base64UrlEncode($d),
            ];
        }
    }

    if (!isset($keys)) {
        $json = shell_exec('npx web-push generate-vapid-keys --json 2>nul');
        $nodeKeys = is_string($json) ? json_decode($json, true) : null;
        if (is_array($nodeKeys) && isset($nodeKeys['publicKey'], $nodeKeys['privateKey'])) {
            $keys = [
                'publicKey' => (string) $nodeKeys['publicKey'],
                'privateKey' => (string) $nodeKeys['privateKey'],
            ];
        }
    }

    if (!isset($keys)) {
        fwrite(STDERR, 'VAPID key generation failed. Enable OpenSSL EC support or install Node web-push CLI.' . PHP_EOL);
        exit(1);
    }
}

echo 'WEBPUSH_PUBLIC_KEY=' . $keys['publicKey'] . PHP_EOL;
echo 'WEBPUSH_PRIVATE_KEY=' . $keys['privateKey'] . PHP_EOL;
