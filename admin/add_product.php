<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    // Вставка товара в базу данных
    $sql = "INSERT INTO products (name, price, category, description) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ssss', $name, $price, $category, $description);
    $stmt->execute();

    echo "Товар добавлен успешно!";
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить товар</title>
</head>
<body>
    <h2>Добавить товар</h2>

    <form method="POST" action="add_product.php">
        <label for="name">Название товара:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="price">Цена:</label>
        <input type="text" id="price" name="price" required><br><br>

        <label for="category">Категория:</label>
        <input type="text" id="category" name="category" required><br><br>

        <label for="description">Описание:</label>
        <textarea id="description" name="description" required></textarea><br><br>

        <button type="submit">Добавить товар</button>
    </form>
</body>
</html>
