<?php
session_start();

if (!isset($_SESSION['cart']) || count($_SESSION['cart']) === 0) {
    echo "Кошик порожній. <a href='index.php'>Повернутися до каталогу</a>";
    exit;
}

$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
<link rel="stylesheet" href="style.css">

<link rel="stylesheet" href="style.css">

    <meta charset="UTF-8">
    <title>Оформлення замовлення</title>
</head>
<body>
<h2>Оформлення замовлення</h2>

<form action="process_order.php" method="POST">
    <label>ПІБ:<br>
        <input type="text" name="full_name" required>
    </label><br><br>

    <label>Електронна пошта:<br>
        <input type="email" name="email" required>
    </label><br><br>

    <label>Телефон:<br>
        <input type="tel" name="phone" required>
    </label><br><br>

    <label>Адреса доставки:<br>
        <textarea name="address" required></textarea>
    </label><br><br>

    <h3>Сума до сплати: <?= htmlspecialchars($total) ?> грн</h3>

    <button type="submit">Підтвердити замовлення</button>
</form>

<a href="cart.php">← Повернутися до кошика</a>
</body>
</html>