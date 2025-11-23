<?php
$page_title = 'Đăng nhập - Laptop Shop';
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

    if (empty($email) || empty($password)) {
        $error = 'Vui lòng điền email và mật khẩu';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['is_admin'] = ($user['id'] == 1);
            setFlash('success', 'Đăng nhập thành công!');
            redirect('/');
        } else {
            $error = 'Email hoặc mật khẩu không chính xác';
        }
    }
}

require 'includes/header.php';
?>

<section style="max-width: 400px; margin: 3rem auto;">
    <h1 style="font-size: 1.8rem; margin-bottom: 2rem; text-align: center;">Đăng nhập</h1>

    <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <?php if ($error): ?>
            <div class="alert alert-error" style="margin-bottom: 1rem;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php $success = getFlash('success'); ?>
        <?php if ($success): ?>
            <div class="alert alert-success" style="margin-bottom: 1rem;">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Email</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Mật khẩu</label>
                <input type="password" name="password" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
            </div>

            <button type="submit" style="width: 100%; padding: 0.75rem; background: #3498db; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; margin-bottom: 1rem;">
                Đăng nhập
            </button>
        </form>

        <p style="text-align: center; color: #666;">
            Chưa có tài khoản? <a href="/register.php" style="color: #3498db; text-decoration: none;">Đăng ký ngay</a>
        </p>
    </div>
</section>

<?php require 'includes/footer.php'; ?>
