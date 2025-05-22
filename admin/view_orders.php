<?php
session_start();
require_once '../includes/db.php';

// Проверка роли администратора
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

$query = "
    SELECT 
        orders.id,
        orders.customer_name,
        orders.email,
        orders.user_id,
        orders.product_id,
        orders.quantity,
        orders.status,
        orders.order_date,
        orders.phone,
        orders.address,
        products.name AS product_name
    FROM orders
    JOIN products ON orders.product_id = products.id
    ORDER BY orders.order_date DESC
";


$result = $mysqli->query($query);
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Усі замовлення</title>
</head>
<body>
    <h2>Список усіх замовлень</h2>
    <a href="dashboard.php">⬅ Повернутись до панелі</a>
    <table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>ID замовлення</th>
        <th>Ім'я замовника</th>
        <th>Електронна адреса</th>
        <th>Телефон</th>
        <th>Адреса</th>
        <th>Товар</th>
        <th>Кількість</th>
        <th>Статус</th>
        <th>Дата замовлення</th>
        <th>Дія</th> 
        <th>Дія</th> 
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['customer_name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td><?= htmlspecialchars($row['address']) ?></td>
            <td><?= htmlspecialchars($row['product_name']) ?></td>
            <td><?= $row['quantity'] ?></td>
            <td><?= htmlspecialchars($row['status']) ?></td>
            <td><?= $row['order_date'] ?></td>
            <td><a href="edit_order.php?id=<?= $row['id'] ?>">Редагувати</a></td>
            <td>
                <a href="delete_order.php?id=<?= $row['id'] ?>" onclick="return confirm('Ви впевнені, що хочете видалити це замовлення?');">Видалити</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
</body>
</html>
