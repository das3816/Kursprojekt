<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: admin/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $mysqli->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $surname = $_POST['surname'];
    $name = $_POST['name'];
    $patronymic = $_POST['patronymic'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password && $password !== $confirm_password) {
        $errors[] = "Паролі не співпадають.";
    }

    if (empty($errors)) {
        if ($password) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $mysqli->prepare("UPDATE users SET surname=?, name=?, patronymic=?, email=?, phone=?, password=? WHERE id=?");
            $stmt->bind_param("ssssssi", $surname, $name, $patronymic, $email, $phone, $hashed_password, $user_id);
        } else {
            $stmt = $mysqli->prepare("UPDATE users SET surname=?, name=?, patronymic=?, email=?, phone=? WHERE id=?");
            $stmt->bind_param("sssssi", $surname, $name, $patronymic, $email, $phone, $user_id);
        }

        if ($stmt->execute()) {
            $success = true;
            $user['surname'] = $surname;
            $user['name'] = $name;
            $user['patronymic'] = $patronymic;
            $user['email'] = $email;
            $user['phone'] = $phone;
        } else {
            $errors[] = "Помилка при оновленні профілю.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
<link rel="stylesheet" href="style.css">

<link rel="stylesheet" href="style.css">

    <meta charset="UTF-8">
    <title>Редагування профілю</title>
</head>
<body>
    <h2>Редагування профілю</h2>

    <?php if ($success): ?>
        <p style="color: green;">Профіль оновлено!</p>
    <?php endif; ?>

    <?php foreach ($errors as $error): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endforeach; ?>

    <form method="POST">
        <label>Прізвище: <input type="text" name="surname" value="<?= htmlspecialchars($user['surname']) ?>"></label><br>
        <label>Ім'я: <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>"></label><br>
        <label>По батькові: <input type="text" name="patronymic" value="<?= htmlspecialchars($user['patronymic']) ?>"></label><br>
        <label>Email: <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>"></label><br>
        <label>Номер телефону: <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>"></label><br>
        <label>Новий пароль: <input type="password" name="password"></label><br>
        <label>Підтвердження пароля: <input type="password" name="confirm_password"></label><br><br>
        <button type="submit">Зберегти</button>
    </form>

    <br>
    <a href="profile.php">← Назад до профілю</a>
</body>
</html>
