<?php
$page_title = 'Thêm sản phẩm - Laptop Shop';
require_once '../../config/database.php';
require_once '../../includes/functions.php';

requireAdmin();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitizeInput($_POST['name'] ?? '');
    $description = sanitizeInput($_POST['description'] ?? '');
    $price = (float)($_POST['price'] ?? 0);
    $stock = (int)($_POST['stock'] ?? 0);
    $brand = sanitizeInput($_POST['brand'] ?? '');
    $processor = sanitizeInput($_POST['processor'] ?? '');
    $ram = sanitizeInput($_POST['ram'] ?? '');
    $storage = sanitizeInput($_POST['storage'] ?? '');
    $screen_size = sanitizeInput($_POST['screen_size'] ?? '');

    if (empty($name) || $price <= 0 || $stock < 0) {
        $error = 'Vui lòng điền đầy đủ thông tin hợp lệ';
    } else {
        try {
            $stmt = $pdo->prepare('INSERT INTO products (name, description, price, stock, brand, processor, ram, storage, screen_size) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([$name, $description, $price, $stock, $brand, $processor, $ram, $storage, $screen_size]);
            setFlash('success', 'Thêm sản phẩm thành công');
            redirect('/admin/products.php');
        } catch (Exception $e) {
            $error = 'Lỗi khi thêm sản phẩm: ' . $e->getMessage();
        }
    }
}

require '../../includes/header.php';
?>

<section style="padding: 2rem 0;">
    <h1 style="font-size: 2rem; margin-bottom: 2rem;">Thêm sản phẩm</h1>

    <div style="max-width: 600px; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <?php if ($error): ?>
            <div class="alert alert-error" style="margin-bottom: 1rem;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Tên sản phẩm *</label>
                <input type="text" name="name" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Mô tả</label>
                <textarea name="description" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; min-height: 100px;"></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Giá *</label>
                    <input type="number" name="price" step="0.01" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Kho *</label>
                    <input type="number" name="stock" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                </div>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Thương hiệu</label>
                <input type="text" name="brand" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Processor</label>
                <input type="text" name="processor" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">RAM</label>
                <input type="text" name="ram" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Lưu trữ</label>
                <input type="text" name="storage" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Kích thước màn hình</label>
                <input type="text" name="screen_size" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" style="flex: 1; padding: 0.75rem; background: #27ae60; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
                    Thêm sản phẩm
                </button>
                <a href="/admin/products.php" style="flex: 1; padding: 0.75rem; background: #95a5a6; color: white; text-decoration: none; border-radius: 4px; text-align: center; font-weight: bold;">
                    Hủy
                </a>
            </div>
        </form>
    </div>
</section>

<?php require '../../includes/footer.php'; ?>
