<?php

declare(strict_types=1);

namespace App\Core\Response;

class JsonResponse extends Response
{
    private const FLAGS = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRESERVE_ZERO_FRACTION | JSON_INVALID_UTF8_SUBSTITUTE | JSON_PARTIAL_OUTPUT_ON_ERROR;

    public function __construct($data, int $code = 200)
    {
        parent::__construct(json_encode($data, self::FLAGS), $code, 'application/json');
    }
}
