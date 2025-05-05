<?php
session_start();

// Проверяем, если корзина существует
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    // Проверяем, что индекс товара передан через GET
    if (isset($_GET['index']) && is_numeric($_GET['index'])) {
        $index = $_GET['index'];

        // Удаляем товар из корзины
        if (isset($_SESSION['cart'][$index])) {
            unset($_SESSION['cart'][$index]);
            $_SESSION['cart'] = array_values($_SESSION['cart']); // Пересчитываем индексы массива
        }
    }

    // Перенаправляем обратно в корзину
    header("Location: cart.php");
    exit;
} else {
    echo "Корзина пуста!";
}
