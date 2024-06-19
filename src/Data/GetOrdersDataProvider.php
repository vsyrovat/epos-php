<?php declare(strict_types=1);

namespace App\Data;

use PDO;

class GetOrdersDataProvider
{
    public function __construct(private PDO $pdo)
    {
    }

    public function execute(array $userIds)
    {
        $users = $this->getUsersByIds($userIds);
        $relations = $this->getOrderedSortedProducts($userIds);
        $requiredProductIds = array_unique(array_merge(...$relations));
        $products = $this->getProductsByIds($requiredProductIds);

        $result = array_reduce($users, function ($carry, $user) use ($relations, $products) {
            $r = $relations[$user['id']] ?? [];
            $p = array_map(fn ($product_id) => $products[$product_id], $r);
            $carry[] = ['user' => $user, 'products' => $p];
            return $carry;
        }, []);

        return $result;
    }

    /**
     * @param array $ids
     * @return array
     */
    private function getUsersByIds($userIds): array
    {
        $ids = implode(',', array_map('intval', $userIds));
        if (empty($ids)) {
            return [];
        }
        $stmt = $this->pdo->query("SELECT u.* FROM user u where u.id in ($ids)");
        $users = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users [(int)$row['id']] = $row;
        }
        return $users;
    }

    private function getOrderedSortedProducts($userIds): array
    {
        $ids = implode(',', array_map('intval', $userIds));
        if (empty($ids)) {
            return [];
        }
        $stmt = $this->pdo->prepare("select u.id user_id, p.id product_id
           from user u
           join user_order uo ON (u.id = uo.user_id)
           join products p ON (uo.product_id = p.id)
           where u.id in ($ids)
           order by p.title, p.price desc");
        $stmt->execute();
        $relations = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $relations[(int)$row['user_id']][] = (int)$row['product_id'];
        }
        return $relations;
    }

    private function getProductsByIds($productIds): array
    {
        $ids = implode(',', array_map('intval', $productIds));
        if (empty($ids)) {
            return [];
        }
        $stmt = $this->pdo->query("SELECT p.* FROM products p where p.id in ($ids)");
        $stmt->execute();
        $products = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $products [(int)$row['id']] = $row;
        }
        return $products;
    }

}
