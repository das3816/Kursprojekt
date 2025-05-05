<?php
session_start();

// Проверяем, если корзина существует
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    // Проверяем, что переданы изменения количества товаров
    if (isset($_POST['quantity'])) {
        foreach ($_POST['quantity'] as $index => $quantity) {
            // Обновляем количество товара в корзине
            if (isset($_SESSION['cart'][$index])) {
                $_SESSION['cart'][$index]['quantity'] = max(1, intval($quantity)); // Устанавливаем минимальное количество 1
            }
        }
    }

    // Перенаправляем обратно в корзину
    header("Location: cart.php");
    exit;
} else {
    echo "Корзина пуста!";
}
