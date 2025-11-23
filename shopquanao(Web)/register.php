<?php
$page_title = 'Đăng ký - Laptop Shop';
require_once 'config/database.php';
require_once 'includes/functions.php';

if (isLoggedIn()) {
    redirect('/');
}

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    $full_name = sanitizeInput($_POST['full_name'] ?? '');

    if (empty($email) || empty($password) || empty($full_name)) {
        $error = 'Vui lòng điền tất cả các trường';
    } elseif (!validateEmail($email)) {
        $error = 'Email không hợp lệ';
    } elseif (strlen($password) < 6) {
        $error = 'Mật khẩu phải có ít nhất 6 ký tự';
    } elseif ($password !== $password_confirm) {
        $error = 'Mật khẩu không khớp';
    } else {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = 'Email đã được đăng ký';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO users (email, password, full_name) VALUES (?, ?, ?)');
            try {
                $stmt->execute([$email, $hashed_password, $full_name]);
                setFlash('success', 'Đăng ký thành công! Vui lòng đăng nhập');
                redirect('/login.php');
            } catch (Exception $e) {
                $error = 'Lỗi khi đăng ký: ' . $e->getMessage();
            }
        }
    }
}

require 'includes/header.php';
?>

<section style="max-width: 400px; margin: 3rem auto;">
    <h1 style="font-size: 1.8rem; margin-bottom: 2rem; text-align: center;">Đăng ký tài khoản</h1>

    <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <?php if ($error): ?>
            <div class="alert alert-error" style="margin-bottom: 1rem;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Họ tên</label>
                <input type="text" name="full_name" value="<?php echo htmlspecialchars($email); ?>" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Email</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Mật khẩu</label>
                <input type="password" name="password" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Xác nhận mật khẩu</label>
                <input type="password" name="password_confirm" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
            </div>

            <button type="submit" style="width: 100%; padding: 0.75rem; background: #3498db; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; margin-bottom: 1rem;">
                Đăng ký
            </button>
        </form>

        <p style="text-align: center; color: #666;">
            Đã có tài khoản? <a href="/login.php" style="color: #3498db; text-decoration: none;">Đăng nhập ngay</a>
        </p>
    </div>
</section>

<?php require 'includes/footer.php'; ?>
