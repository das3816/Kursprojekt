<?php
session_start();
require_once 'includes/db.php';

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    header("Location: admin/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$customer_name = $_SESSION['user_name']; // можно взять из name+surname
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

if (empty($cart)) {
    echo "Корзина пуста!";
    exit;
}

foreach ($cart as $item) {
    $product_id = $item['id'];
    $quantity = $item['quantity'];

    $stmt = $mysqli->prepare("INSERT INTO orders (customer_name, product_id, quantity, status, order_date, user_id) VALUES (?, ?, ?, 'очікує', NOW(), ?)");
    $stmt->bind_param("siii", $customer_name, $product_id, $quantity, $user_id);
    $stmt->execute();
}

// Очищаем корзину
unset($_SESSION['cart']);
$_SESSION['success_message'] = "Замовлення успішно створено!";
header("Location: index.php");
exit;
