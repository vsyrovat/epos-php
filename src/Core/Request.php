<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Exception\Http400;
use JsonException;

readonly class Request
{
    public string $path;
    public array $query;
    public array|string|int|float|bool|null $data;

    /**
     * @throws Http400
     */
    public function __construct(public string $method, string $url, public string $rawBody, public array $headers)
    {
        $parsed = parse_url($url);
        $this->path = $parsed['path'];
        parse_str($parsed['query'] ?? '', $q);
        $this->query = $q;
        $this->extractData();
    }

    private function extractData(): void
    {
        if ($this->isJson()) {
            try {
                $this->data = json_decode($this->rawBody, true, 512, JSON_THROW_ON_ERROR);
            } catch (JsonException $e) {
                throw new Http400($e->getMessage());
            }
        } else {
            $this->data = null;
        }
    }

    public function contentType(): ?string
    {
        return $this->headers['Content-Type'] ?? null;
    }

    public function isJson(): bool
    {
        return $this->contentType() === 'application/json';
    }
}
