<?php
session_start();  // Убедитесь, что session_start() вызывается только один раз
require_once 'includes/db.php';

$search = isset($_GET['search']) ? $mysqli->real_escape_string($_GET['search']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

$query = "SELECT * FROM products";

// Если задан поиск
if ($search) {
	$query .= " WHERE name LIKE '%$search%' OR description LIKE '%$search%'";
}

// Сортировка
if ($sort === 'price_asc') {
	$query .= " ORDER BY price ASC";
} elseif ($sort === 'price_desc') {
	$query .= " ORDER BY price DESC";
} elseif ($sort === 'name_asc') {
	$query .= " ORDER BY name ASC";
} elseif ($sort === 'name_desc') {
	$query .= " ORDER BY name DESC";
}

$result = $mysqli->query($query);

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    header("Location: /grizetka_project/admin/login.php");  // Если не авторизован, перенаправляем на страницу входа
    exit;
}

// Получаем роль пользователя
$user_role = $_SESSION['user_role'];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Grizetka — Каталог товарів</title>
	<link rel="stylesheet" href="style.css">
	
	<script>
		document.addEventListener("DOMContentLoaded", function () {
			const toast = document.getElementById("toast");
			if (toast) {
				toast.classList.add("show");
				setTimeout(() => {
					toast.classList.remove("show");
				}, 3000);
			}
		});
	</script>
</head>
<body>
	<h2>Каталог товарів</h2>
	<?php
	if (isset($_SESSION["user_name"])): ?>
		<p>Вітаємо, <?php echo htmlspecialchars($_SESSION["user_name"]); ?>! 
			<a href="profile.php">Переглянути профіль</a> | 
			<a href="edit_profile.php">Редагувати профіль</a> | 
			<a href="admin/logout.php">Вийти</a>
		</p>
	<?php else: ?>
		<p><a href="admin/login.php"><button style="padding: 8px 16px; font-size: 14px;">Авторизуватися</button></a></p>
	<?php endif; ?>

	<?php if ($user_role == 'admin'): ?>
		<a href="admin/dashboard.php">
			<button>Перейти до адмін панелі</button>
		</a>
	<?php else: ?>
		<a href="/profile.php">
			<button>Перейти до профілю</button>
		</a>
	<?php endif; ?>

	<form method="GET" style="margin-top: 20px;">
		<input type="text" name="search" placeholder="Пошук товару..." value="<?= htmlspecialchars($search) ?>">

		<select name="sort">
			<option value="">Сортування</option>
			<option value="price_asc" <?= $sort === 'price_asc' ? 'selected' : '' ?>>Ціна: за зростанням</option>
			<option value="price_desc" <?= $sort === 'price_desc' ? 'selected' : '' ?>>Ціна: за спаданням</option>
			<option value="name_asc" <?= $sort === 'name_asc' ? 'selected' : '' ?>>Назва: А–Я</option>
			<option value="name_desc" <?= $sort === 'name_desc' ? 'selected' : '' ?>>Назва: Я–А</option>
		</select>

		<button type="submit">Знайти</button>
	</form>

	<?php while ($row = $result->fetch_assoc()): ?>
		<div style="border: 1px solid #ccc; margin: 10px; padding: 10px;">
			<a href="view_product.php?id=<?php echo $row['id']; ?>&return=index.php " style="text-decoration: none; color: inherit;">
				<h3><?php echo htmlspecialchars($row['name']); ?></h3>
				<p>Ціна: <?php echo htmlspecialchars($row['price']); ?> грн</p>
				<p><?php echo htmlspecialchars($row['description']); ?></p>
			</a>
			<form method="POST" action="add_to_cart.php">
				<input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
				<a href="add_to_cart.php?product_id=<?= $row['id'] ?>&product_name=<?= urlencode($row['name']) ?>&product_price=<?= $row['price'] ?>"><button type="button">Додати до корзини</button></a>
			</form>
		</div>
	<?php endwhile; ?>

	<a href="cart.php">Перейти до корзини</a>

</body>
</html>
