<?php
require 'config.php';
$pageTitle = 'Danh mục';
include 'templates/header.php';

// Lọc sản phẩm theo danh mục
$category = isset($_GET['category']) ? $_GET['category'] : null;
$filteredProducts = $products;

if ($category) {
    $filteredProducts = array_filter($products, function($p) use ($category) {
        return $p['category'] === $category;
    });
}
?>

<h1>Danh mục sản phẩm</h1>

<div style="margin-bottom: 20px;">
    <a href="catalog.php" class="btn <?php echo !$category ? 'btn-active' : 'btn-secondary'; ?>" style="margin-right: 10px;">Tất cả</a>
    <a href="catalog.php?category=nam" class="btn <?php echo $category === 'nam' ? 'btn-active' : 'btn-secondary'; ?>" style="margin-right: 10px;">Áo nam</a>
    <a href="catalog.php?category=nu" class="btn <?php echo $category === 'nu' ? 'btn-active' : 'btn-secondary'; ?>">Áo n��</a>
</div>

<div class="product-grid">
    <?php 
    if (count($filteredProducts) > 0) {
        foreach ($filteredProducts as $product):
    ?>
    <div class="product-card">
        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
        <div class="product-info">
            <div class="product-name"><?php echo htmlspecialchars($product['name']); ?></div>
            <p style="font-size: 13px; color: #666; margin-bottom: 8px;"><?php echo htmlspecialchars(substr($product['description'], 0, 50) . '...'); ?></p>
            <div class="product-price"><?php echo formatPrice($product['price']); ?></div>
            <form method="POST" action="cart.php" class="product-actions">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <input type="number" name="quantity" value="1" min="1">
                <button type="submit" class="btn">Thêm vào giỏ</button>
            </form>
        </div>
    </div>
    <?php 
        endforeach;
    } else {
        echo '<p>Không có sản phẩm nào trong danh mục này.</p>';
    }
    ?>
</div>

<?php include 'templates/footer.php'; ?>
