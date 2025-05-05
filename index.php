<?php
session_start();
require_once 'includes/db.php';

$result = $mysqli->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Grizetka — Каталог товаров</title>
	<style>
	.toast {
	    visibility: hidden;
	    min-width: 250px;
	    background-color: #4CAF50;
	    color: white;
	    text-align: center;
	    border-radius: 8px;
	    padding: 16px;
	    position: fixed;
	    z-index: 1000;
	    left: 50%;
	    bottom: 30px;
	    transform: translateX(-50%);
	    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
	    font-family: sans-serif;
	}
	.toast.show {
	    visibility: visible;
	    animation: fadein 0.5s, fadeout 0.5s 2.5s;
	}
	@keyframes fadein {
	    from {bottom: 0; opacity: 0;}
	    to {bottom: 30px; opacity: 1;}
	}
	@keyframes fadeout {
	    from {bottom: 30px; opacity: 1;}
	    to {bottom: 0; opacity: 0;}
	}
	</style>
	
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
<h2>Каталог товаров</h2>
<a href="admin/login.php">
            <button style="padding: 8px 16px; font-size: 14px;">Авторизироваться</button>
</a>

<?php if (isset($_SESSION['success_message'])): ?>
    <div id="toast" class="toast"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
<?php endif; ?>


<?php while ($row = $result->fetch_assoc()): ?>
    <div style="border: 1px solid #ccc; margin: 10px; padding: 10px;">
        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
        <p>Цена: <?php echo htmlspecialchars($row['price']); ?> грн</p>
        <p><?php echo htmlspecialchars($row['description']); ?></p>
        <form method="POST" action="add_to_cart.php">
            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
            <a href="add_to_cart.php?product_id=<?= $row['id'] ?>&product_name=<?= urlencode($row['name']) ?>&product_price=<?= $row['price'] ?>"><button type="button">Добавить в корзину</button></a>
        </form>
    </div>
<?php endwhile; ?>

<a href="cart.php">Перейти в корзину</a>

</body>
</html>
