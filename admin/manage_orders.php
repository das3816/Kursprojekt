<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require_once '../includes/db.php';

// Получаем список заказов
$sql = "SELECT * FROM orders";
$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление заказами</title>
</head>
<body>
    <h2>Управление заказами</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Пользователь</th>
                <th>Товар</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($order = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $order['id']; ?></td>
                <td><?php echo $order['user_id']; ?></td>
                <td><?php echo $order['product_id']; ?></td>
                <td><?php echo $order['status']; ?></td>
                <td>
                    <a href="edit_order.php?id=<?php echo $order['id']; ?>">Редактировать</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
