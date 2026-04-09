<?php

declare(strict_types=1);

namespace App\Core;

final class Response
{
    public function __construct(
        private string $body = '',
        private int $status = 200,
        private array $headers = ['Content-Type' => 'text/html; charset=UTF-8']
    ) {
    }

    public static function json(array $payload, int $status = 200): self
    {
        return new self(json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '{}', $status, [
            'Content-Type' => 'application/json; charset=UTF-8',
        ]);
    }

    public static function redirect(string $url): self
    {
        return new self('', 302, ['Location' => $url]);
    }

    public static function download(string $path, string $filename, string $contentType): self
    {
        return new self(
            body: (string) file_get_contents($path),
            status: 200,
            headers: [
                'Content-Type' => $contentType,
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]
        );
    }

    public function send(): void
    {
        http_response_code($this->status);
        foreach ($this->headers as $name => $value) {
            header($name . ': ' . $value);
        }
        echo $this->body;
    }

    public function withHeaders(array $headers): self
    {
        $clone = clone $this;
        $clone->headers = [...$this->headers, ...$headers];
        return $clone;
    }

    public function statusCode(): int
    {
        return $this->status;
    }

    public function bodyContent(): string
    {
        return $this->body;
    }
}
