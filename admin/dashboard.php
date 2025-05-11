<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    // Якщо користувач не авторизований або не адміністратор, перенаправляємо на сторінку входу
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Адміністративна панель</title>
</head>
<body>
    <h2>Ласкаво просимо, <?php echo $_SESSION['user_name']; ?>!</h2>
    <nav>
        <ul>
            <li><a href="add_product.php">Додати товар</a></li>
            <li><a href="manage_orders.php">Управління замовленнями</a></li>
            <li><a href="logout.php">Вийти</a></li>
        </ul>
        <a href="../index.php">
            <button type="button">← На головну сторінку</button>
        </a>
    </nav>
</body>
</html>
