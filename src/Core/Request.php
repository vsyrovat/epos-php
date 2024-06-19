<?php

declare(strict_types=1);

namespace App\Core;

readonly class Request
{
    public string $path;
    public array $query;

    public function __construct(public string $method, string $url)
    {
        $parsed = parse_url($url);
        $this->path = $parsed['path'];
        parse_str($parsed['query'] ?? '', $q);
        $this->query = $q;
    }
}
