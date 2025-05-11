<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require_once '../includes/db.php';

// Отримуємо список товарів
$sql = "SELECT * FROM products";
$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Керування товарами</title>
</head>
<body>
    <h2>Керування товарами</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Назва</th>
                <th>Ціна</th>
                <th>Категорія</th>
                <th>Опис</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($product = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $product['price']; ?></td>
                    <td><?php echo $product['category']; ?></td>
                    <td><?php echo $product['description']; ?></td>
                    <td>
                        <a href="../view_product.php?id=<?php echo $product['id']; ?>&return=admin/manage_orders.php">Переглянути</a>
                        <a href="edit_product.php?id=<?php echo $product['id']; ?>">Редагувати</a>
                        <a href="delete_product.php?id=<?php echo $product['id']; ?>" onclick="return confirm('Ви впевнені, що хочете видалити цей товар?')">Видалити</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <div style="margin-top: 20px;">
        <a href="dashboard.php">
            <button type="button">← Повернутися в кабінет</button>
        </a>
    </div>
</body>
</html>
