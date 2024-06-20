<?php

declare(strict_types=1);

namespace App\Core;

// Primitive router
class Router
{
    private array $rules = [];

    public function addRule(string $method, string $url, $action): void
    {
        $this->rules[$method . ' ' .$url] = [$method, $url, $action];
    }

    public function get(string $url, $action): void
    {
        $this->addRule('GET', $url, $action);
    }

    public function post(string $url, $action): void
    {
        $this->addRule('POST', $url, $action);
    }

    public function resolve(Request $request)
    {
        return $this->rules[$request->method . ' ' . $request->path][2] ?? null;
    }
}
