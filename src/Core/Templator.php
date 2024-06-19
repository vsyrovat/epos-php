<?php declare(strict_types=1);

namespace App\Core;

// Primitive template engine
class Templator
{
    public function __construct(private readonly string $base)
    {
    }

    public function renderPhp($file, $data): string
    {
        ob_start();
        extract($data);
        include($this->base . '/' .$file);
        return ob_get_clean();
    }
}
