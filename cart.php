<?php
session_start();

if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    echo "<form action='update_cart.php' method='POST'>
            <table border='1'>
            <tr>
                <th>Название</th>
                <th>Цена</th>
                <th>Количество</th>
                <th>Сумма</th>
                <th>Действие</th>
            </tr>";

    foreach ($_SESSION['cart'] as $index => $item) {
        if (is_array($item) && isset($item['name'], $item['price'], $item['quantity'])) {
            $total = $item['price'] * $item['quantity'];
            echo "<tr>
                    <td>" . htmlspecialchars($item['name']) . "</td>
                    <td>" . htmlspecialchars($item['price']) . "</td>
                    <td><input type='number' name='quantity[{$index}]' value='" . htmlspecialchars($item['quantity']) . "' min='1'></td>
                    <td>" . htmlspecialchars($total) . "</td>
                    <td><a href='remove_from_cart.php?index={$index}'>Удалить</a></td>
                </tr>";
        }
    }

    echo "</table>
          <input type='submit' value='Обновить корзину'>
          </form>";
} else {
    echo "Корзина пуста!";
}
?>

<a href="index.php">Вернуться в каталог</a>

<?php if (!empty($_SESSION['cart'])): ?>
    <br><a href="checkout.php"><strong>Перейти к оформлению заказа</strong></a>
<?php endif; ?>
