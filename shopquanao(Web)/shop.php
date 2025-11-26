<?php
$page_title = 'Sản phẩm - Laptop Shop';
require_once 'config/database.php';
require_once 'includes/functions.php';

$stmt = $pdo->query('SELECT * FROM products ORDER BY created_at DESC');
$products = $stmt->fetchAll();

require 'includes/header.php';
?>
yg'n
<section style="padding: 2rem 0;">
    <h1 style="font-size: 2rem; margin-bottom: 2rem;">Tất cả sản phẩm</h1>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 2rem;">
        <?php if (empty($products)): ?>
            <p style="grid-column: 1/-1; text-align: center; color: #666;">Chưa có sản phẩm nào</p>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: transform 0.3s;">
                    <div style="height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                        💻
                    </div>
                    <div style="padding: 1.5rem;">
                        <h3 style="font-size: 1.1rem; margin-bottom: 0.5rem;"><?php echo htmlspecialchars($product['name']); ?></h3>
                        <div style="font-size: 0.9rem; color: #666; margin-bottom: 0.5rem;">
                            <p>Brand: <?php echo htmlspecialchars($product['brand']); ?></p>
                            <p>Processor: <?php echo htmlspecialchars($product['processor']); ?></p>
                            <p>RAM: <?php echo htmlspecialchars($product['ram']); ?></p>
                            <p>Screen: <?php echo htmlspecialchars($product['screen_size']); ?></p>
                        </div>
                        <p style="color: #2c3e50; font-weight: bold; font-size: 1.3rem; margin-bottom: 1rem;">
                            <?php echo formatPrice($product['price']); ?>
                        </p>
                        <p style="color: #27ae60; font-size: 0.9rem; margin-bottom: 1rem;">
                            Còn lại: <?php echo $product['stock']; ?> chiếc
                        </p>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="/product.php?id=<?php echo $product['id']; ?>" style="flex: 1; padding: 0.75rem; background: #3498db; color: white; text-decoration: none; border-radius: 4px; text-align: center; transition: background 0.3s;">
                                Chi tiết
                            </a>
                            <?php if ($product['stock'] > 0): ?>
                                <form method="POST" action="/api/add-to-cart.php" style="flex: 1;">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" style="width: 100%; padding: 0.75rem; background: #27ae60; color: white; border: none; border-radius: 4px; cursor: pointer; transition: background 0.3s;">
                                        Thêm vào giỏ
                                    </button>
                                </form>
                            <?php else: ?>
                                <button disabled style="flex: 1; padding: 0.75rem; background: #95a5a6; color: white; border: none; border-radius: 4px; cursor: not-allowed;">
                                    Hết hàng
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<?php require 'includes/footer.php'; ?>
