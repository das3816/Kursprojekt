<?php
session_start();
require_once '../includes/db.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];  // Обычный пароль, без хеширования

    $stmt = $mysqli->prepare("SELECT id, name, email, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $name, $email_db, $stored_password, $role);
        $stmt->fetch();

        // Сравниваем обычный пароль с тем, что хранится в базе данных
        if ($password === $stored_password) {
            $_SESSION["user_id"] = $id;
            $_SESSION["user_name"] = $name;
            $_SESSION["user_email"] = $email_db;
            $_SESSION["user_role"] = $role;
            $_SESSION['last_activity'] = time(); // для авто-логаута

            // Перенаправляем на index.php в корневой папке проекта
            header("Location: /grizetka_project/index.php");
            exit;
        } else {
            $error = "Невірний пароль.";
        }
    } else {
        $error = "Користувача з таким email не існує.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Вхід</title>
</head>
<body>
    <h2>Вхід до системи</h2>

    <?php if ($error): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Пароль:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Увійти</button>
    </form>

    <p>Ще не маєте облікового запису? <a href="register.php">Зареєструватися</a></p>
</body>
</html>
