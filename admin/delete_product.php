<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require_once '../includes/db.php';

// Проверяем, если передан id товара
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Удаляем товар по ID
    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $product_id);
    
    if ($stmt->execute()) {
        echo "Товар удален успешно!";
    } else {
        echo "Ошибка при удалении товара!";
    }

    $stmt->close();
    
    // Перенаправляем обратно на страницу управления товарами
    header('Location: manage_orders.php');
    exit;
} else {
    echo "Неверный запрос!";
}
?>
