<?php

declare(strict_types=1);

namespace App\Http;

use App\Core\Request;
use App\Core\Response\HtmlResponse;
use App\Core\Response\Response;

class DefaultController
{
    public function __construct()
    {
    }

    public function home(Request $request): Response
    {
        return new HtmlResponse(<<<HTML
<html lang="en">
<head>
    <title>Millennium Epos Demo</title>
<body>
    <p><a href="/orders-json?user_id=1,2,3">View Orders in json</a></p>
    <p><a href="/orders-html?user_id=1,2,3">View Orders in html</a></p>
    <p><a href="/add-product">Add some Products</a></p>
</body>
</html>
HTML
        );
    }
}
