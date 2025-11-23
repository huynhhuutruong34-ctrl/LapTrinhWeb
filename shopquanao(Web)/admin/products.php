<?php
require '../config.php';
requireAdminLogin();
$pageTitle = 'Quản lý sản phẩm';

// Lưu sản phẩm vào session cho quản lý
if (!isset($_SESSION['admin_products'])) {
    $_SESSION['admin_products'] = $products;
}

$admin_products = &$_SESSION['admin_products'];
$message = '';

// Xử lý các hành động
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : null;

    if ($action === 'add') {
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $price = isset($_POST['price']) ? intval($_POST['price']) : 0;
        $description = isset($_POST['description']) ? trim($_POST['description']) : '';
        $category = isset($_POST['category']) ? $_POST['category'] : 'nam';
        $image = isset($_POST['image']) ? trim($_POST['image']) : 'https://via.placeholder.com/500x500?text=Product';

        if ($name && $price > 0) {
            $newId = max(array_keys($admin_products)) + 1;
            $admin_products[$newId] = [
                'id' => $newId,
                'name' => $name,
                'price' => $price,
                'description' => $description,
                'category' => $category,
                'image' => $image
            ];
            $message = '✓ Sản phẩm đã được thêm thành công!';
        } else {
            $message = '✗ Vui lòng điền đầy đủ thông tin!';
        }
    } elseif ($action === 'edit') {
        $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
        if (isset($admin_products[$product_id])) {
            $admin_products[$product_id]['name'] = isset($_POST['name']) ? trim($_POST['name']) : '';
            $admin_products[$product_id]['price'] = isset($_POST['price']) ? intval($_POST['price']) : 0;
            $admin_products[$product_id]['description'] = isset($_POST['description']) ? trim($_POST['description']) : '';
            $admin_products[$product_id]['category'] = isset($_POST['category']) ? $_POST['category'] : 'nam';
            $admin_products[$product_id]['image'] = isset($_POST['image']) ? trim($_POST['image']) : '';
            $message = '✓ Sản phẩm đã được cập nhật thành công!';
        }
    } elseif ($action === 'delete') {
        $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
        if (isset($admin_products[$product_id])) {
            unset($admin_products[$product_id]);
            $message = '✓ Sản phẩm đã được xóa!';
        }
    }

    header('Location: products.php');
    exit;
}

// Lấy ID sản phẩm cần chỉnh sửa
$edit_id = isset($_GET['edit']) ? intval($_GET['edit']) : null;
$edit_product = ($edit_id && isset($admin_products[$edit_id])) ? $admin_products[$edit_id] : null;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SHOP_NAME; ?> - Quản lý sản phẩm</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        .admin-header {
            background-color: #333;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .admin-header h1 {
            font-size: 24px;
        }

        .admin-header a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            background-color: #d32f2f;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .admin-header a:hover {
            background-color: #b71c1c;
        }

        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .admin-menu {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .admin-menu a {
            padding: 10px 15px;
            background-color: #666;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .admin-menu a:hover {
            background-color: #d32f2f;
        }

        .alert {
            padding: 12px 20px;
            margin-bottom: 20px;
            border-radius: 4px;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .btn {
            padding: 10px 20px;
            background-color: #d32f2f;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #b71c1c;
        }

        .btn-secondary {
            background-color: #666;
        }

        .btn-secondary:hover {
            background-color: #444;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        table th {
            background-color: #f5f5f5;
            padding: 12px;
            text-align: left;
            font-weight: bold;
            border-bottom: 2px solid #ddd;
        }

        table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        table tr:hover {
            background-color: #f9f9f9;
        }

        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .actions a, .actions button {
            padding: 6px 12px;
            font-size: 12px;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .actions a {
            background-color: #667eea;
            color: white;
        }

        .actions a:hover {
            background-color: #5568d3;
        }

        .actions button {
            background-color: #d32f2f;
            color: white;
        }

        .actions button:hover {
            background-color: #b71c1c;
        }
    </style>
</head>
<body>
    <div class="admin-header">
        <h1>MODA.vn - Quản lý sản phẩm</h1>
        <a href="logout.php">Đăng xuất</a>
    </div>

    <div class="admin-container">
        <div class="admin-menu">
            <a href="dashboard.php">← Quay lại Dashboard</a>
            <a href="orders.php">Quản lý đơn hàng</a>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
        <div class="alert"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <div class="form-container">
            <h2><?php echo $edit_product ? 'Chỉnh sửa sản phẩm' : 'Thêm sản phẩm mới'; ?></h2>

            <form method="POST" action="products.php">
                <input type="hidden" name="action" value="<?php echo $edit_product ? 'edit' : 'add'; ?>">
                <?php if ($edit_product): ?>
                <input type="hidden" name="product_id" value="<?php echo $edit_product['id']; ?>">
                <?php endif; ?>

                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Tên sản phẩm</label>
                        <input type="text" id="name" name="name" required value="<?php echo $edit_product ? htmlspecialchars($edit_product['name']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="price">Giá (VNĐ)</label>
                        <input type="number" id="price" name="price" required min="0" value="<?php echo $edit_product ? $edit_product['price'] : ''; ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="category">Danh mục</label>
                        <select id="category" name="category">
                            <option value="nam" <?php echo ($edit_product && $edit_product['category'] === 'nam') ? 'selected' : ''; ?>>Áo nam</option>
                            <option value="nu" <?php echo ($edit_product && $edit_product['category'] === 'nu') ? 'selected' : ''; ?>>Áo nữ</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="image">URL hình ảnh</label>
                        <input type="text" id="image" name="image" value="<?php echo $edit_product ? htmlspecialchars($edit_product['image']) : ''; ?>" placeholder="https://...">
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Mô tả sản phẩm</label>
                    <textarea id="description" name="description"><?php echo $edit_product ? htmlspecialchars($edit_product['description']) : ''; ?></textarea>
                </div>

                <div style="margin-top: 20px;">
                    <button type="submit" class="btn"><?php echo $edit_product ? 'Cập nhật' : 'Thêm'; ?></button>
                    <?php if ($edit_product): ?>
                    <a href="products.php" class="btn btn-secondary">Hủy</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <h2>Danh sách sản phẩm (<?php echo count($admin_products); ?>)</h2>
        <table>
            <thead>
                <tr>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Giá</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($admin_products as $product): ?>
                <tr>
                    <td><img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image"></td>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td><?php echo $product['category'] === 'nam' ? 'Áo nam' : 'Áo nữ'; ?></td>
                    <td><?php echo formatPrice($product['price']); ?></td>
                    <td>
                        <div class="actions">
                            <a href="products.php?edit=<?php echo $product['id']; ?>">Sửa</a>
                            <form method="POST" action="products.php" style="display: inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <button type="submit" onclick="return confirm('Bạn chắc chứ?')">Xóa</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
