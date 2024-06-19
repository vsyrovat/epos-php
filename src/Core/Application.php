<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Exception\Http404;
use App\Core\Response\Response;
use Throwable;

class Application
{
    private Container $container;
    private Router $router;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->router = $container->get(Router::class);
    }

    public function handleHttp(): void
    {
        try {
            $request = new Request($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
            $route = $this->router->resolve($request);
            $route or throw (new Http404());
            [$klass, $method] = $route;
            $controller = $this->container->get($klass);
            /** @var Response $response */
            $response = $controller->$method($request);

            http_response_code($response->code);
            header("Content-Type: {$response->contentType}");
            echo $response->content;
        } catch (Http404) {
            http_response_code(404);
            echo "Not found";
        } catch (Throwable $e) {
            http_response_code(500);
            echo "Internal error: {$e->getMessage()}";
        }
    }
}
