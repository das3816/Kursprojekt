<?php
session_start();
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Кошик</title>
    <script>
        // Автоотправка формы при изменении количества
        function autoSubmit() {
            document.getElementById('cart-form').submit();
        }
    </script>
</head>
<body>

<?php
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    echo "<form id='cart-form' action='update_cart.php' method='POST'>
            <table border='1'>
            <tr>
                <th>Назва товару</th>
                <th>Ціна</th>
                <th>Кількість</th>
                <th>Сума</th>
                <th>Дія</th>
            </tr>";

    foreach ($_SESSION['cart'] as $index => $item) {
        if (is_array($item) && isset($item['name'], $item['price'], $item['quantity'])) {
            $total = $item['price'] * $item['quantity'];
            echo "<tr>
                    <td>" . htmlspecialchars($item['name']) . "</td>
                    <td>" . htmlspecialchars($item['price']) . " грн</td>
                    <td>
                        <input type='number' name='quantity[{$index}]' value='" . htmlspecialchars($item['quantity']) . "' min='1' onchange='autoSubmit()'>
                    </td>
                    <td>" . htmlspecialchars($total) . " грн</td>
                    <td><a href='remove_from_cart.php?index={$index}'>Видалити</a></td>
                </tr>";
        }
    }

    echo "</table>
          <noscript><input type='submit' value='Оновити кошик'></noscript>
          </form>";
} else {
    echo "Кошик порожній!";
}
?>

<br><a href="index.php">⬅ Повернутися до каталогу</a>

<?php if (!empty($_SESSION['cart'])): ?>
    <br><a href="checkout.php"><strong>Оформити замовлення</strong></a>
<?php endif; ?>

</body>
</html>
