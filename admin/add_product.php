<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    // Додавання товару до бази даних
    $sql = "INSERT INTO products (name, price, category, description) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ssss', $name, $price, $category, $description);
    $stmt->execute();

    echo "Товар успішно додано!";
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>

<link rel="stylesheet" href="../style.css">




<link rel="stylesheet" href="../style.css">



    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Додати товар</title>
</head>
<body>
    <h2>Додати товар</h2>

    <form method="POST" action="add_product.php">
        <label for="name">Назва товару:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="price">Ціна:</label>
        <input type="text" id="price" name="price" required><br><br>

        <label for="category">Категорія:</label>
        <input type="text" id="category" name="category" required><br><br>

        <label for="description">Опис:</label>
        <textarea id="description" name="description" required></textarea><br><br>

        <button type="submit">Додати товар</button>
    </form>

    <div style="margin-top: 20px;">
        <a href="dashboard.php">
            <button type="button">← Повернутися в кабінет</button>
        </a>
    </div>
</body>
</html>
