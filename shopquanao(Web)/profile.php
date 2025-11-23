<?php
$page_title = 'Hồ sơ cá nhân - Laptop Shop';
require_once 'config/database.php';
require_once 'includes/functions.php';

requireLogin();

$user = getCurrentUser($pdo);
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = sanitizeInput($_POST['full_name'] ?? '');
    $phone = sanitizeInput($_POST['phone'] ?? '');
    $address = sanitizeInput($_POST['address'] ?? '');
    $city = sanitizeInput($_POST['city'] ?? '');

    if (empty($full_name)) {
        $error = 'Vui lòng điền tên';
    } else {
        try {
            $stmt = $pdo->prepare('UPDATE users SET full_name = ?, phone = ?, address = ?, city = ? WHERE id = ?');
            $stmt->execute([$full_name, $phone, $address, $city, $user['id']]);
            $success = 'Cập nhật hồ sơ thành công';
            $user = getCurrentUser($pdo);
        } catch (Exception $e) {
            $error = 'Lỗi khi cập nhật: ' . $e->getMessage();
        }
    }
}

require 'includes/header.php';
?>

<section style="padding: 2rem 0;">
    <h1 style="font-size: 2rem; margin-bottom: 2rem;">Hồ sơ cá nhân</h1>

    <div style="max-width: 600px; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <?php if ($error): ?>
            <div class="alert alert-error" style="margin-bottom: 1rem;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success" style="margin-bottom: 1rem;">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Email</label>
                <input type="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; background: #f5f5f5; color: #666;">
                <p style="font-size: 0.9rem; color: #666; margin-top: 0.25rem;">Email không thể thay đổi</p>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Họ tên</label>
                <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Số điện thoại</label>
                <input type="tel" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Địa chỉ</label>
                <textarea name="address" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; min-height: 100px;"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Tỉnh/Thành phố</label>
                <input type="text" name="city" value="<?php echo htmlspecialchars($user['city'] ?? ''); ?>" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" style="flex: 1; padding: 0.75rem; background: #3498db; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
                    Lưu thay đổi
                </button>
                <a href="/" style="flex: 1; padding: 0.75rem; background: #95a5a6; color: white; text-decoration: none; border-radius: 4px; text-align: center; font-weight: bold;">
                    Quay lại
                </a>
            </div>
        </form>

        <hr style="border: none; border-top: 1px solid #ddd; margin: 2rem 0;">

        <h3 style="margin-bottom: 1rem;">Thay đổi mật khẩu</h3>
        <a href="/change-password.php" style="display: inline-block; padding: 0.75rem 1.5rem; background: #e74c3c; color: white; text-decoration: none; border-radius: 4px;">
            Thay đổi mật khẩu
        </a>
    </div>
</section>

<?php require 'includes/footer.php'; ?>
