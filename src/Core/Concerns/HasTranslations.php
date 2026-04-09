<?php

declare(strict_types=1);

namespace App\Core\Concerns;

trait HasTranslations
{
    /** @var array<string, array<string, string>> */
    protected array $translations = [];

    public function setTranslation(string $field, string $locale, string $value): static
    {
        $this->translations[$field] ??= [];
        $this->translations[$field][$locale] = $value;
        return $this;
    }

    public function getTranslation(string $field, string $locale, ?string $fallback = null): ?string
    {
        return $this->translations[$field][$locale]
            ?? ($fallback !== null ? ($this->translations[$field][$fallback] ?? null) : null);
    }

    public function translate(string $field, string $locale, ?string $fallback = null): ?string
    {
        return $this->getTranslation($field, $locale, $fallback);
    }

    public function toTranslationJson(string $field): string
    {
        return json_encode($this->translations[$field] ?? [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '{}';
    }
}
