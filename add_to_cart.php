<?php
session_start();
require_once 'includes/db.php';

// Проверяем, что параметры переданы через GET
if (isset($_GET['product_id']) && isset($_GET['product_name']) && isset($_GET['product_price'])) {
    // Получаем параметры товара из URL
    $product_id = $_GET['product_id'];
    $product_name = $_GET['product_name']; // Название товара
    $product_price = $_GET['product_price']; // Цена товара
    $product_quantity = 1; // Количество товара, по умолчанию 1

    // Отладочная информация: выводим параметры, полученные через GET
    var_dump($_GET); // Это покажет, что именно мы получаем

    // Если корзина не существует в сессии, создаём её
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Отладочная информация: проверяем содержимое корзины
    var_dump($_SESSION['cart']); // Это покажет текущие товары в корзине

    // Проверяем, что корзина — это массив
    if (!is_array($_SESSION['cart'])) {
        $_SESSION['cart'] = []; // Если корзина не массив, инициализируем её
    }

    // Проверяем, есть ли уже товар в корзине
    $product_found = false;
    foreach ($_SESSION['cart'] as &$item) {
        // Проверяем, чтобы элемент был массивом и содержал ключ 'id'
        if (is_array($item) && isset($item['id']) && $item['id'] == $product_id) {
            $item['quantity'] += 1; // Увеличиваем количество товара
            $product_found = true;
            break;
        }
    }

    // Если товара нет в корзине, добавляем новый
    if (!$product_found) {
        $_SESSION['cart'][] = [
            'id' => $product_id,
            'name' => $product_name,
            'price' => $product_price,
            'quantity' => $product_quantity
        ];
    }

    // Уведомление о добавлении товара
    $_SESSION['success_message'] = "Товар добавлен в корзину!";
    header("Location: index.php");
    exit;
} else {
    // Если параметры не переданы
    echo "Ошибка: Параметры товара не переданы!";
}
