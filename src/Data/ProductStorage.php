<?php declare(strict_types=1);

namespace App\Data;

use PDO;

class ProductStorage
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function createProduct(string $title, string $price): int
    {
        $stmt = $this->pdo->prepare('INSERT INTO products (title, price) VALUES (:title, :price)');
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':price', $price);
        $stmt->execute();
        return (int) $this->pdo->lastInsertId();
    }
}
