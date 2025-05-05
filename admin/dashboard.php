<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Если пользователь не авторизован или не администратор, перенаправляем на страницу входа
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора</title>
</head>
<body>
    <h2>Добро пожаловать, <?php echo $_SESSION['username']; ?>!</h2>
    <nav>
        <ul>
            <li><a href="add_product.php">Добавить товар</a></li>
            <li><a href="manage_orders.php">Управление заказами</a></li>
            <li><a href="logout.php">Выйти</a></li>
        </ul>
    </nav>
</body>
</html>
