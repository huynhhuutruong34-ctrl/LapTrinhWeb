<?php
require 'config.php';
$pageTitle = 'Trang chủ';
include 'templates/header.php';
?>

<h1>MODA.vn - Trang chủ</h1>
<p>Chào mừng đến với cửa hàng quần áo online MODA.vn. Chúng tôi cung cấp các sản phẩm thời trang chất lượng cao.</p>

<h2 style="margin-top: 40px; margin-bottom: 20px;">Sản phẩm nổi bật</h2>

<div class="product-grid">
    <?php foreach ($products as $product): ?>
    <div class="product-card">
        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
        <div class="product-info">
            <div class="product-name"><?php echo htmlspecialchars($product['name']); ?></div>
            <div class="product-price"><?php echo formatPrice($product['price']); ?></div>
            <form method="POST" action="cart.php" class="product-actions">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <input type="number" name="quantity" value="1" min="1">
                <button type="submit" class="btn">Thêm vào giỏ</button>
            </form>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php include 'templates/footer.php'; ?>
