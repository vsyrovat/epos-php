<?php

declare(strict_types=1);

namespace App\Core\Response;

abstract class Response
{
    public function __construct(public string $content, public int $code, public string $contentType)
    {
    }
}
