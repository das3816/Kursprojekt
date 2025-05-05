<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['full_name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // В реальных проектах здесь можно сохранить заказ в БД

    // Очищаем корзину
    unset($_SESSION['cart']);

    echo "<h2>Спасибо за заказ, " . htmlspecialchars($name) . "!</h2>";
    echo "<p>Мы свяжемся с вами по номеру " . htmlspecialchars($phone) . " и доставим заказ по адресу: " . nl2br(htmlspecialchars($address)) . ".</p>";
    echo "<a href='index.php'>Вернуться в магазин</a>";
} else {
    header("Location: index.php");
    exit;
}
