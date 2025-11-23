<?php
require 'config.php';
$pageTitle = 'Thanh toán';

$cart = getCart();

// Xử lý form thanh toán
if ($_SERVER['REQUEST_METHOD'] === 'POST' && count($cart) > 0) {
    $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $address = isset($_POST['address']) ? trim($_POST['address']) : '';
    $payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : 'cash';

    if ($fullname && $email && $phone && $address) {
        // Tính tổng tiền
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Lưu đơn hàng vào session (tạm thời - sẽ thay bằng database)
        if (!isset($_SESSION['orders'])) {
            $_SESSION['orders'] = [];
        }

        $order = [
            'order_id' => 'ORD-' . time() . '-' . rand(1000, 9999),
            'date' => date('d/m/Y H:i:s'),
            'customer' => [
                'fullname' => $fullname,
                'email' => $email,
                'phone' => $phone,
                'address' => $address
            ],
            'items' => $cart,
            'total' => $total,
            'payment_method' => $payment_method,
            'status' => 'pending'
        ];

        $_SESSION['orders'][] = $order;
        $_SESSION['last_order'] = $order;

        // Xóa giỏ hàng
        saveCart([]);

        // Chuyển hướng đến trang xác nhận
        header('Location: order-success.php');
        exit;
    } else {
        $error = 'Vui lòng điền đầy đủ thông tin!';
    }
}

// Kiểm tra giỏ hàng có sản phẩm không
if (count($cart) === 0) {
    header('Location: cart.php');
    exit;
}

include 'templates/header.php';

// Tính tổng tiền
$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<h1>Thanh toán</h1>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-top: 20px;">
    <!-- Form thanh toán -->
    <div>
        <h2>Thông tin khách hàng</h2>
        <?php if (isset($error)): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="checkout.php">
            <div class="form-group">
                <label for="fullname">Họ và tên</label>
                <input type="text" id="fullname" name="fullname" required value="<?php echo isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="phone">Số điện thoại</label>
                <input type="tel" id="phone" name="phone" required value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="address">Địa chỉ giao hàng</label>
                <textarea id="address" name="address" required><?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?></textarea>
            </div>

            <div class="form-group">
                <label for="payment_method">Phương thức thanh toán</label>
                <select id="payment_method" name="payment_method">
                    <option value="cash">Thanh toán khi nhận hàng (COD)</option>
                    <option value="bank">Chuyển khoản ngân hàng</option>
                    <option value="card">Thẻ tín dụng</option>
                </select>
            </div>

            <button type="submit" class="btn" style="width: 100%; padding: 12px;">Hoàn tất đơn hàng</button>
        </form>
    </div>

    <!-- Tóm tắt đơn hàng -->
    <div>
        <h2>Tóm tắt đơn hàng</h2>
        <table style="margin-top: 10px;">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td><?php echo formatPrice($item['price']); ?></td>
                    <td><?php echo formatPrice($item['price'] * $item['quantity']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div style="background-color: #f5f5f5; padding: 15px; margin-top: 20px; border-radius: 4px;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                <span>Tạm tính:</span>
                <span><?php echo formatPrice($total); ?></span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                <span>Phí vận chuyển:</span>
                <span>Miễn phí</span>
            </div>
            <hr>
            <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 18px;">
                <span>Tổng cộng:</span>
                <span style="color: #d32f2f;"><?php echo formatPrice($total); ?></span>
            </div>
        </div>

        <a href="cart.php" class="btn btn-secondary" style="display: block; text-align: center; margin-top: 20px;">← Quay lại giỏ hàng</a>
    </div>
</div>

<?php include 'templates/footer.php'; ?>
