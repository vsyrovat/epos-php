<?php declare(strict_types=1);

namespace App\Core\Response;

class HtmlResponse extends Response
{
    public function __construct(string $content, int $code = 200)
    {
        parent::__construct($content, $code, 'text/html');
    }
}
