<?php
session_start();
require_once 'includes/db.php';

if (!isset($_GET['id'])) {
    echo "Товар не знайдено.";
    exit;
}

$product_id = intval($_GET['id']);
$stmt = $mysqli->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Товар не знайдено.";
    exit;
}

$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="uk">
<head>
<link rel="stylesheet" href="style.css">

<link rel="stylesheet" href="style.css">

    <meta charset="UTF-8">
    <title>Перегляд товару</title>
</head>
<body>
    <h2>Інформація про товар</h2>

    <p><strong>Назва:</strong> <?php echo htmlspecialchars($product['name']); ?></p>
    <p><strong>Ціна:</strong> <?php echo htmlspecialchars($product['price']); ?> грн</p>
    <p><strong>Категорія:</strong> <?php echo htmlspecialchars($product['category']); ?></p>
    <p><strong>Опис:</strong><br><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>

    <div style="margin-top: 20px;">
        <?php
        $return_page = isset($_GET['return']) ? $_GET['return'] : 'index.php';
        ?>
        <a href="<?php echo htmlspecialchars($return_page); ?>">
            <button type="button">← Назад до списку товарів</button>
        </a>
    </div>
</body>
</html>
