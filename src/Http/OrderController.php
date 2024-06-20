<?php

declare(strict_types=1);

namespace App\Http;

use App\Core\Container;
use App\Core\Request;
use App\Core\Response\HtmlResponse;
use App\Core\Response\JsonResponse;
use App\Core\Response\Response;
use App\Core\Templator;
use App\Data\GetOrdersDataProvider;

/**
 * Retrieving users with ordered products sorted by title asc and then by price desc.
 */
class OrderController
{
    public function __construct(private readonly Container $container)
    {
    }

    public function getJson(Request $request): Response
    {
        $userIds = explode(',', $request->query['user_id'] ?? '');
        $users = $this->container->get(GetOrdersDataProvider::class)
            ->execute($userIds);
        return (new JsonResponse(['users' => $users]));
    }

    public function getHtml(Request $request): Response
    {
        $userIds = explode(',', $request->query['user_id'] ?? '');
        $users = $this->container->get(GetOrdersDataProvider::class)
            ->execute($userIds);
        $html = $this->container->get(Templator::class)
            ->renderPhp('get-orders.html.php', ['users' => $users]);
        return new HtmlResponse($html);
    }
}
