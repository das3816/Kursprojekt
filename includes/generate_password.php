<?php
// Генерация хэшированного пароля
$hashed_password = password_hash('admin123', PASSWORD_DEFAULT);

// Вывод хэша пароля, который нужно вставить в базу данных
echo "Хэшированный пароль: " . $hashed_password;
?>