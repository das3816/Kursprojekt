<?php
session_start();
require_once '../includes/db.php';

// Перевірка ролі адміністратора
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $order_id = (int) $_GET['id'];

    $stmt = $mysqli->prepare("DELETE FROM orders WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();

    header("Location: view_orders.php");
    exit;
} else {
    echo "Невірний ID замовлення.";
}
