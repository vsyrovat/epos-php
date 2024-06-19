<html>
<head>
    <title>Orders</title>
</head>
<body>
    <h1>Orders</h1>
    <?php
    foreach ($users as $row) {
        $user = $row['user'];
        $product = $row['products'];
        ?><p>
            <span><?= htmlspecialchars($user['first_name'] . ' ' . $user['second_name']) ?></span>
            <ul>
                <?php foreach ($product as $product) {
                    ?><li><?= htmlspecialchars($product['title']. ' ' . $product['price']); ?></li><?php
                } ?>
            </ul>
        </p><?php
    }
    ?>
</body>
</html>
