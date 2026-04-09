<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Core\Config;
use RuntimeException;

final class UploadService
{
    public function __construct(private Config $config)
    {
    }

    public function publicPath(): string
    {
        return $this->config->basePath('public/uploads');
    }

    public function privatePath(): string
    {
        return $this->config->storagePath('private/uploads');
    }

    public function ensureDirectories(): void
    {
        foreach ([$this->publicPath(), $this->privatePath()] as $path) {
            if (!is_dir($path) && !mkdir($path, 0775, true) && !is_dir($path)) {
                throw new RuntimeException('Failed to create upload directory: ' . $path);
            }
        }
    }

    public function store(array $file, string $visibility = 'private'): string
    {
        $this->ensureDirectories();
        $tmp = $file['tmp_name'] ?? '';
        $name = preg_replace('/[^a-zA-Z0-9._-]/', '_', (string) ($file['name'] ?? 'upload.bin')) ?: 'upload.bin';
        $targetDir = $visibility === 'public' ? $this->publicPath() : $this->privatePath();
        $targetPath = $targetDir . DIRECTORY_SEPARATOR . uniqid('file_', true) . '_' . $name;

        if (!is_uploaded_file($tmp) && !file_exists($tmp)) {
            throw new RuntimeException('Upload temp file is missing.');
        }

        if (!@move_uploaded_file($tmp, $targetPath) && !@rename($tmp, $targetPath)) {
            throw new RuntimeException('File move failed.');
        }

        return $targetPath;
    }
}
