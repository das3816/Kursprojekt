<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require_once '../includes/db.php';

// Перевірка, чи передано ID товару
if (!isset($_GET['id'])) {
    echo "ID товару не вказано.";
    exit;
}

$product_id = $_GET['id'];

// Обробка форми після надсилання
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    $sql = "UPDATE products SET name = ?, price = ?, category = ?, description = ? WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ssssi', $name, $price, $category, $description, $product_id);

    if ($stmt->execute()) {
        header("Location: manage_orders.php");
        exit;
    } else {
        echo "Помилка під час оновлення товару.";
    }
}

// Отримання поточних даних товару
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo "Товар не знайдено.";
    exit;
}

$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Редагування товару</title>
</head>
<body>
    <h2>Редагувати товар</h2>

    <form method="POST" action="">
        <label>Назва товару:</label><br>
        <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required><br><br>

        <label>Ціна:</label><br>
        <input type="text" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required><br><br>

        <label>Категорія:</label><br>
        <input type="text" name="category" value="<?php echo htmlspecialchars($product['category']); ?>" required><br><br>

        <label>Опис:</label><br>
        <textarea name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea><br><br>

        <button type="submit">Зберегти зміни</button>
    </form>

    <br>
    <a href="manage_orders.php">← Назад до списку товарів</a>
</body>
</html>
