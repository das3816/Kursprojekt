<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

$order_id = $_GET['id'] ?? null;

if (!$order_id) {
    echo "ID замовлення не вказано.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = $_POST['customer_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $quantity = $_POST['quantity'];
    $status = $_POST['status'];
    $product_id = $_POST['product_id'];

    $stmt = $mysqli->prepare("UPDATE orders 
        SET customer_name = ?, email = ?, phone = ?, address = ?, quantity = ?, status = ?, product_id = ? 
        WHERE id = ?");
    $stmt->bind_param("ssssissi", $customer_name, $email, $phone, $address, $quantity, $status, $product_id, $order_id);
    $stmt->execute();

    header("Location: view_orders.php");
    exit;
}

$stmt = $mysqli->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Замовлення не знайдено.";
    exit;
}

$order = $result->fetch_assoc();

$products = $mysqli->query("SELECT id, name FROM products");
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Редагування замовлення</title>
</head>
<body>
    <h2>Редагування замовлення №<?= $order['id'] ?></h2>

    <form method="POST">
        <label>Ім'я замовника:<br>
            <input type="text" name="customer_name" value="<?= htmlspecialchars($order['customer_name']) ?>" required>
        </label><br><br>

        <label>Електронна адреса:<br>
            <input type="email" name="email" value="<?= htmlspecialchars($order['email']) ?>" required>
        </label><br><br>

        <label>Телефон:<br>
            <input type="text" name="phone" value="<?= htmlspecialchars($order['phone']) ?>" required>
        </label><br><br>

        <label>Адреса доставки:<br>
            <textarea name="address" required><?= htmlspecialchars($order['address']) ?></textarea>
        </label><br><br>

        <label>Товар:<br>
            <select name="product_id" required>
                <?php while ($product = $products->fetch_assoc()): ?>
                    <option value="<?= $product['id'] ?>" <?= $product['id'] == $order['product_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($product['name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </label><br><br>

        <label>Кількість:<br>
            <input type="number" name="quantity" value="<?= htmlspecialchars($order['quantity']) ?>" min="1" required>
        </label><br><br>

        <label>Статус:<br>
            <select name="status">
                <option value="очікує" <?= $order['status'] === 'очікує' ? 'selected' : '' ?>>очікує</option>
                <option value="виконується" <?= $order['status'] === 'виконується' ? 'selected' : '' ?>>виконується</option>
                <option value="доставлено" <?= $order['status'] === 'доставлено' ? 'selected' : '' ?>>доставлено</option>
                <option value="скасовано" <?= $order['status'] === 'скасовано' ? 'selected' : '' ?>>скасовано</option>
            </select>
        </label><br><br>

        <button type="submit">Зберегти зміни</button>
    </form>

    <br><a href="view_orders.php">⬅ Повернутися до списку замовлень</a>
</body>
</html>
