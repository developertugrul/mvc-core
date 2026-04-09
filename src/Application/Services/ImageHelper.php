<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Core\Config;
use Intervention\Image\ImageManager;
use RuntimeException;

final class ImageHelper
{
    public function __construct(private Config $config)
    {
    }

    public function process(string $sourcePath, string $targetPath, ?int $width = null, ?int $height = null, int $quality = 85): string
    {
        if (!file_exists($sourcePath)) {
            throw new RuntimeException('Image source file missing.');
        }

        $sizeLimit = (int) $this->config->get('upload_max_size_mb', 5) * 1024 * 1024;
        if (filesize($sourcePath) > $sizeLimit) {
            throw new RuntimeException('Image exceeds upload size limit.');
        }

        $manager = ImageManager::gd();
        $image = $manager->read($sourcePath);

        if ($width !== null || $height !== null) {
            $image = $image->cover($width ?? $image->width(), $height ?? $image->height());
        }

        $image->toJpeg($quality)->save($targetPath);
        return $targetPath;
    }
}
