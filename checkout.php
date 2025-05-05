<?php
session_start();

if (!isset($_SESSION['cart']) || count($_SESSION['cart']) === 0) {
    echo "Корзина пуста. <a href='index.php'>Вернуться в каталог</a>";
    exit;
}

$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Оформление заказа</title>
</head>
<body>
<h2>Оформление заказа</h2>

<form action="process_order.php" method="POST">
    <label>ФИО:<br>
        <input type="text" name="full_name" required>
    </label><br><br>

    <label>Телефон:<br>
        <input type="tel" name="phone" required>
    </label><br><br>

    <label>Адрес доставки:<br>
        <textarea name="address" required></textarea>
    </label><br><br>

    <h3>Сумма к оплате: <?= htmlspecialchars($total) ?> грн</h3>

    <button type="submit">Подтвердить заказ</button>
</form>

<a href="cart.php">← Вернуться в корзину</a>
</body>
</html>
