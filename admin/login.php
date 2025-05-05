<?php
session_start();  // Для работы с сессиями (сессия нужна для авторизации)

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Подключение к базе данных
        require_once '../includes/db.php';  // Путь к файлу подключения к базе

        // Получаем данные из формы
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Получаем пользователя по имени
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Проверяем, существует ли пользователь с таким логином
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Проверяем, совпадает ли введённый пароль с хэшированным паролем
            if (password_verify($password, $user['password'])) {
                // Успешная авторизация
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                // Перенаправление на страницу администратора или главную
                header('Location: dashboard.php');  // Перенаправляем на главную страницу
                exit;
            } else {
                // Если пароль неверный
                $error = "Неправильный логин или пароль";
            }
        } else {
            // Если пользователя с таким логином не существует
            $error = "Неправильный логин или пароль";
        }
    } else {
        // Если нет данных в POST (не отправлена форма)
        $error = "Заполните все поля.";
    }
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
</head>
<body>

    <h2>Авторизация</h2>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <label for="username">Логин:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Войти</button>
    </form>

</body>
</html>
