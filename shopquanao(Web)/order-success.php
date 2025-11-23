<?php
require 'config.php';
$pageTitle = 'Đơn hàng thành công';

// Kiểm tra có đơn hàng vừa tạo không
if (!isset($_SESSION['last_order'])) {
    header('Location: index.php');
    exit;
}

$order = $_SESSION['last_order'];
include 'templates/header.php';
?>

<div style="text-align: center; padding: 40px 20px;">
    <h1 style="color: #28a745; margin-bottom: 20px;">✓ Đơn hàng thành công!</h1>
    <p style="font-size: 18px; margin-bottom: 30px;">Cảm ơn bạn đã mua hàng tại MODA.vn</p>

    <div style="background-color: white; padding: 30px; border-radius: 8px; max-width: 600px; margin: 0 auto; text-align: left;">
        <h2>Thông tin đơn hàng</h2>
        <div style="margin-bottom: 20px;">
            <strong>Mã đơn hàng:</strong> <?php echo htmlspecialchars($order['order_id']); ?>
        </div>
        <div style="margin-bottom: 20px;">
            <strong>Ngày đặt hàng:</strong> <?php echo $order['date']; ?>
        </div>

        <h2 style="margin-top: 30px;">Thông tin khách hàng</h2>
        <div style="margin-bottom: 10px;">
            <strong>Họ tên:</strong> <?php echo htmlspecialchars($order['customer']['fullname']); ?>
        </div>
        <div style="margin-bottom: 10px;">
            <strong>Email:</strong> <?php echo htmlspecialchars($order['customer']['email']); ?>
        </div>
        <div style="margin-bottom: 10px;">
            <strong>Điện thoại:</strong> <?php echo htmlspecialchars($order['customer']['phone']); ?>
        </div>
        <div style="margin-bottom: 10px;">
            <strong>Địa chỉ:</strong> <?php echo htmlspecialchars($order['customer']['address']); ?>
        </div>

        <h2 style="margin-top: 30px;">Chi tiết đơn hàng</h2>
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
                <?php foreach ($order['items'] as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td><?php echo formatPrice($item['price']); ?></td>
                    <td><?php echo formatPrice($item['price'] * $item['quantity']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div style="background-color: #f5f5f5; padding: 15px; margin-top: 20px; border-radius: 4px; text-align: right;">
            <div style="font-size: 18px; font-weight: bold;">
                Tổng cộng: <span style="color: #d32f2f;"><?php echo formatPrice($order['total']); ?></span>
            </div>
        </div>

        <div style="background-color: #e3f2fd; padding: 15px; margin-top: 20px; border-radius: 4px;">
            <strong>Phương thức thanh toán:</strong> 
            <?php 
            $methods = [
                'cash' => 'Thanh toán khi nhận hàng (COD)',
                'bank' => 'Chuyển khoản ngân hàng',
                'card' => 'Thẻ tín dụng'
            ];
            echo isset($methods[$order['payment_method']]) ? $methods[$order['payment_method']] : $order['payment_method'];
            ?>
        </div>

        <div style="margin-top: 30px;">
            <p><strong>Trạng thái đơn hàng:</strong> <span style="color: #ff9800;">Chờ xác nhận</span></p>
            <p>Chúng tôi sẽ xác nhận đơn hàng của bạn trong vòng 24 giờ.</p>
        </div>
    </div>

    <div style="margin-top: 30px;">
        <a href="/" class="btn">Quay lại trang chủ</a>
    </div>
</div>

<?php include 'templates/footer.php'; ?>
