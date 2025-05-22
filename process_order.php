<?php
session_start();
require_once 'includes/db.php'; // підключення до бази даних

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['full_name'];
    $email = $_POST['email']; 
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $user_id = $_SESSION['user_id'] ?? null;

    if (!isset($_SESSION['cart']) || count($_SESSION['cart']) === 0) {
        echo "<h2>Кошик порожній!</h2>";
        echo "<a href='index.php'>Повернутися до магазину</a>";
        exit;
    }

    foreach ($_SESSION['cart'] as $item) {
        $product_id = $item['id'];
        $quantity = $item['quantity'];

        $stmt = $mysqli->prepare("
            INSERT INTO orders 
            (customer_name, email, product_id, quantity, status, order_date, user_id, phone, address) 
            VALUES (?, ?, ?, ?, 'очікує', NOW(), ?, ?, ?)
        ");

        // s - string, i - integer (соответствует: string, string, int, int, int, string, string)
        $stmt->bind_param("ssiisss", $name, $email, $product_id, $quantity, $user_id, $phone, $address);
        $stmt->execute();
    }

    unset($_SESSION['cart']);

    echo "<h2>Дякуємо за замовлення, " . htmlspecialchars($name) . "!</h2>";
    echo "<p>Ми зв'яжемося з вами за номером " . htmlspecialchars($phone) . " і доставимо замовлення на адресу: " . nl2br(htmlspecialchars($address)) . ".</p>";
    echo "<a href='index.php'>Повернутися до магазину</a>";
} else {
    header("Location: index.php");
    exit;
}
