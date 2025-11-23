<?php
$page_title = 'Chi tiết sản phẩm - Laptop Shop';
require_once 'config/database.php';
require_once 'includes/functions.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    redirect('/shop.php');
}

$product_id = (int)$_GET['id'];
$stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
$stmt->execute([$product_id]);
$product = $stmt->fetch();

if (!$product) {
    redirect('/shop.php');
}

require 'includes/header.php';
?>

<section style="padding: 2rem 0;">
    <a href="/shop.php" style="color: #3498db; text-decoration: none; margin-bottom: 1rem; display: inline-block;">← Quay lại</a>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; margin-top: 2rem;">
        <div>
            <div style="height: 400px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 5rem;">
                💻
            </div>
        </div>
        
        <div>
            <h1 style="font-size: 2rem; margin-bottom: 1rem;"><?php echo htmlspecialchars($product['name']); ?></h1>
            
            <div style="background: #f0f0f0; padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
                <p style="font-size: 2rem; color: #27ae60; font-weight: bold;">
                    <?php echo formatPrice($product['price']); ?>
                </p>
            </div>

            <div style="margin-bottom: 2rem;">
                <h3 style="margin-bottom: 1rem;">Thông số kỹ thuật</h3>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 0.75rem 0; font-weight: bold;">Thương hiệu:</td>
                        <td style="padding: 0.75rem 0;"><?php echo htmlspecialchars($product['brand']); ?></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 0.75rem 0; font-weight: bold;">Processor:</td>
                        <td style="padding: 0.75rem 0;"><?php echo htmlspecialchars($product['processor']); ?></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 0.75rem 0; font-weight: bold;">RAM:</td>
                        <td style="padding: 0.75rem 0;"><?php echo htmlspecialchars($product['ram']); ?></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 0.75rem 0; font-weight: bold;">Lưu trữ:</td>
                        <td style="padding: 0.75rem 0;"><?php echo htmlspecialchars($product['storage']); ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 0.75rem 0; font-weight: bold;">Kích thước màn hình:</td>
                        <td style="padding: 0.75rem 0;"><?php echo htmlspecialchars($product['screen_size']); ?></td>
                    </tr>
                </table>
            </div>

            <div style="margin-bottom: 2rem;">
                <h3 style="margin-bottom: 1rem;">Mô tả</h3>
                <p style="line-height: 1.6; color: #666;">
                    <?php echo htmlspecialchars($product['description']); ?>
                </p>
            </div>

            <div style="margin-bottom: 2rem;">
                <p style="color: #27ae60; font-weight: bold; margin-bottom: 1rem;">
                    Còn lại: <?php echo $product['stock']; ?> chiếc
                </p>
            </div>

            <?php if ($product['stock'] > 0): ?>
                <form method="POST" action="/api/add-to-cart.php" style="margin-bottom: 1rem;">
                    <div style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="number" name="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>" style="width: 100px; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                        <button type="submit" style="flex: 1; padding: 0.75rem; background: #27ae60; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; transition: background 0.3s;">
                            🛒 Thêm vào giỏ hàng
                        </button>
                    </div>
                </form>
                <a href="/cart.php" style="display: inline-block; padding: 0.75rem 1.5rem; background: #3498db; color: white; text-decoration: none; border-radius: 4px; transition: background 0.3s;">
                    Xem giỏ hàng
                </a>
            <?php else: ?>
                <button disabled style="padding: 0.75rem 1.5rem; background: #95a5a6; color: white; border: none; border-radius: 4px; cursor: not-allowed; font-weight: bold;">
                    Hết hàng
                </button>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require 'includes/footer.php'; ?>
