<?php
$page_title = 'Thay đổi mật khẩu - Laptop Shop';
require_once 'config/database.php';
require_once 'includes/functions.php';

requireLogin();

$user = getCurrentUser($pdo);
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_password = $_POST['old_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
        $error = 'Vui lòng điền tất cả các trường';
    } elseif (!password_verify($old_password, $user['password'])) {
        $error = 'Mật khẩu cũ không chính xác';
    } elseif (strlen($new_password) < 6) {
        $error = 'Mật khẩu mới phải có ít nhất 6 ký tự';
    } elseif ($new_password !== $confirm_password) {
        $error = 'Mật khẩu không khớp';
    } else {
        try {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
            $stmt->execute([$hashed_password, $user['id']]);
            $success = 'Thay đổi mật khẩu thành công';
        } catch (Exception $e) {
            $error = 'Lỗi khi thay đổi mật khẩu: ' . $e->getMessage();
        }
    }
}

require 'includes/header.php';
?>

<section style="padding: 2rem 0;">
    <h1 style="font-size: 2rem; margin-bottom: 2rem;">Thay đổi mật khẩu</h1>

    <div style="max-width: 500px; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
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
                <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Mật khẩu cũ *</label>
                <input type="password" name="old_password" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Mật khẩu mới *</label>
                <input type="password" name="new_password" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Xác nhận mật khẩu mới *</label>
                <input type="password" name="confirm_password" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" style="flex: 1; padding: 0.75rem; background: #3498db; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
                    Thay đổi mật khẩu
                </button>
                <a href="/profile.php" style="flex: 1; padding: 0.75rem; background: #95a5a6; color: white; text-decoration: none; border-radius: 4px; text-align: center; font-weight: bold;">
                    Quay lại
                </a>
            </div>
        </form>
    </div>
</section>

<?php require 'includes/footer.php'; ?>
