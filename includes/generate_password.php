<?php
// Введённый пользователем пароль
$input_password = 'admin123';

// Хеш, ранее сохранённый в базе данных (пример)
$stored_hash = '$2y$10$8gmy8HAgK/sylKzz6kNJy.8Lgo2psieqllEvnv6nZkKuDHaPLdZeq';

// Проверка соответствия пароля и хэша
if (password_verify($input_password, $stored_hash)) {
    echo "Пароль верный!";
} else {
    echo "Неверный пароль.";
}
?>
