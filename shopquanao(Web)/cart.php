<?php
require 'config.php';
$pageTitle = 'Giỏ hàng';

// Xử lý các hành động
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : null;
    $cart = getCart();

    if ($action === 'add') {
        $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

        if (isset($products[$product_id]) && $quantity > 0) {
            if (isset($cart[$product_id])) {
                $cart[$product_id]['quantity'] += $quantity;
            } else {
                $cart[$product_id] = [
                    'id' => $product_id,
                    'name' => $products[$product_id]['name'],
                    'price' => $products[$product_id]['price'],
                    'image' => $products[$product_id]['image'],
                    'quantity' => $quantity
                ];
            }
            saveCart($cart);
            $_SESSION['success'] = 'Đã thêm sản phẩm vào giỏ hàng!';
        }
    } elseif ($action === 'remove') {
        $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
        if (isset($cart[$product_id])) {
            unset($cart[$product_id]);
            saveCart($cart);
            $_SESSION['success'] = 'Đã xóa sản phẩm khỏi giỏ hàng!';
        }
    } elseif ($action === 'update') {
        $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

        if (isset($cart[$product_id]) && $quantity > 0) {
            $cart[$product_id]['quantity'] = $quantity;
            saveCart($cart);
            $_SESSION['success'] = 'Đã cập nhật số lượng!';
        }
    }

    // Chuyển hướng để tránh resubmit
    header('Location: cart.php');
    exit;
}

include 'templates/header.php';

$cart = getCart();
?>

<h1>Giỏ hàng của bạn</h1>

<?php if (isset($_SESSION['success'])): ?>
<div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>

<?php if (count($cart) > 0): ?>

<table>
    <thead>
        <tr>
            <th>Sản phẩm</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Thành tiền</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $total = 0;
        foreach ($cart as $item):
            $subtotal = $item['price'] * $item['quantity'];
            $total += $subtotal;
        ?>
        <tr>
            <td>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                    <span><?php echo htmlspecialchars($item['name']); ?></span>
                </div>
            </td>
            <td><?php echo formatPrice($item['price']); ?></td>
            <td>
                <form method="POST" action="cart.php" style="display: flex; gap: 5px;">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" max="999" style="width: 60px;">
                    <button type="submit" class="btn" style="padding: 8px 15px;">Cập nhật</button>
                </form>
            </td>
            <td><?php echo formatPrice($subtotal); ?></td>
            <td>
                <form method="POST" action="cart.php" style="display: inline;">
                    <input type="hidden" name="action" value="remove">
                    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                    <button type="submit" class="btn btn-secondary" style="padding: 8px 15px;">Xóa</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div style="margin-top: 20px; padding: 20px; background-color: white; border-radius: 8px; text-align: right;">
    <h3>Tổng cộng: <span style="color: #d32f2f;"><?php echo formatPrice($total); ?></span></h3>
    <div style="margin-top: 15px;">
        <a href="catalog.php" class="btn btn-secondary" style="margin-right: 10px;">Tiếp tục mua sắm</a>
        <a href="checkout.php" class="btn">Thanh toán</a>
    </div>
</div>

<?php else: ?>

<div style="text-align: center; padding: 40px;">
    <p style="font-size: 18px; margin-bottom: 20px;">Giỏ hàng của bạn trống!</p>
    <a href="catalog.php" class="btn">Tiếp tục mua sắm</a>
</div>

<?php endif; ?>

<?php include 'templates/footer.php'; ?>
