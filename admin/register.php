<?php
session_start();
require_once '../includes/db.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем все необходимые поля из формы
    $surname = trim($_POST["surname"]);
    $name = trim($_POST["name"]);
    $patronymic = trim($_POST["patronymic"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $password = $_POST["password"];
    $password_confirm = $_POST["password_confirm"];

    // Проверка, чтобы пароли совпадали
    if ($password !== $password_confirm) {
        $error = "Пароли не совпадают.";
    } else {
        // Проверяем, если email уже зарегистрирован
        $stmt = $mysqli->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Пользователь с таким email уже существует.";
        } else {
            // Вставляем нового пользователя в базу данных с обычным паролем
            $stmt = $mysqli->prepare("INSERT INTO users (surname, name, patronymic, email, phone, password) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $surname, $name, $patronymic, $email, $phone, $password);
            $stmt->execute();
            $stmt->close();

            // Уведомление о успешной регистрации
            $success = "Вы успешно зарегистрированы. Можете войти в систему.";
            // Перенаправляем пользователя на страницу входа
            header("Location: login.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>

<link rel="stylesheet" href="../style.css">




<link rel="stylesheet" href="../style.css">



    <meta charset="UTF-8">
    <title>Реєстрація</title>
</head>
<body>
    <h2>Реєстрація</h2>

    <?php if ($error): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p style="color:green;"><?php echo $success; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Призвище:</label><br>
        <input type="text" name="surname" required><br><br>

        <label>Ім'я:</label><br>
        <input type="text" name="name" required><br><br>

        <label>По батькові:</label><br>
        <input type="text" name="patronymic" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Телефон:</label><br>
        <input type="text" name="phone" required><br><br>

        <label>Пароль:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Підтвердження пароля:</label><br>
        <input type="password" name="password_confirm" required><br><br>

        <button type="submit">Зареєструватися</button>
    </form>

    <p>Вже є акаунт? <a href="login.php">Увійти</a></p>
</body>
</html>
