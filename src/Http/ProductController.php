<?php declare(strict_types=1);

namespace App\Http;

use App\Core\Exception\Http400;
use App\Core\Request;
use App\Core\Response\HtmlResponse;
use App\Core\Response\Response;
use App\Core\Templator;
use App\Data\ProductStorage;

class ProductController
{
    public function __construct(private readonly Templator $templator, private readonly ProductStorage $productStorage)
    {
    }

    public function addProductForm(Request $request): Response
    {
        return new HtmlResponse(
            $this->templator
                ->renderPhp('add-product-form.html.php')
        );
    }

    public function addProduct(Request $request): Response
    {
        if (!$request->isJson()) {
            throw new Http400('Expected application/json');
        }

        $products = $request->data['products'];
        foreach ($products as $product) {
            $this->productStorage->createProduct($product['title'], $product['price']);
        }

        return new HtmlResponse('Created', 201);
    }
}
