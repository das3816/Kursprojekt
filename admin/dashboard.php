<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
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
    <h2>Добро пожаловать, <?php echo $_SESSION['user_name']; ?>!</h2>
    <nav>
        <ul>
            <li><a href="add_product.php">Добавить товар</a></li>
            <li><a href="manage_orders.php">Управление заказами</a></li>
            <li><a href="logout.php">Выйти</a></li>
        </ul>
    </nav>
</body>
</html>
