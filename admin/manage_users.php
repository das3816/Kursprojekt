<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

// Призначення адміністратора
if (isset($_GET['make_admin'])) {
    $user_id = intval($_GET['make_admin']);
    $mysqli->query("UPDATE users SET role = 'admin' WHERE id = $user_id");
    header("Location: manage_users.php");
    exit;
}

$query = "SELECT id, surname, name, patronymic, email, role FROM users";
$result = $mysqli->query($query);
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Керування користувачами</title>
</head>
<body>
    <h2>Користувачі</h2>
    <a href="dashboard.php">⬅ Повернутися до панелі</a>

    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>ПІБ</th>
            <th>Email</th>
            <th>Роль</th>
            <th>Дія</th>
        </tr>
        <?php while ($user = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= htmlspecialchars($user['surname'] . ' ' . $user['name'] . ' ' . $user['patronymic']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['role']) ?></td>
                <td>
                    <?php if ($user['role'] !== 'admin'): ?>
                        <a href="?make_admin=<?= $user['id'] ?>" onclick="return confirm('Призначити адміністратора?')">Зробити адміністратором</a>
                    <?php else: ?>
                        Адміністратор
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
