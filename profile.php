<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: admin/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $mysqli->prepare("SELECT surname, name, patronymic, email, phone, role, created_at FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="uk">
<head>
<link rel="stylesheet" href="style.css">

<link rel="stylesheet" href="style.css">

    <meta charset="UTF-8">
    <title>Мій профіль</title>
</head>
<body>
    <h2>Мій профіль</h2>

    <p><strong>Прізвище:</strong> <?= htmlspecialchars($user['surname']) ?></p>
    <p><strong>Ім'я:</strong> <?= htmlspecialchars($user['name']) ?></p>
    <p><strong>По батькові:</strong> <?= htmlspecialchars($user['patronymic']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    <p><strong>Телефон:</strong> <?= htmlspecialchars($user['phone']) ?></p>
    <p><strong>Роль:</strong> <?= htmlspecialchars($user['role']) ?></p>
    <p><strong>Дата створення:</strong> <?= htmlspecialchars($user['created_at']) ?></p>

    <a href="edit_profile.php">Редагувати профіль</a><br>
    <a href="index.php">← Назад на головну</a>
</body>
</html>
