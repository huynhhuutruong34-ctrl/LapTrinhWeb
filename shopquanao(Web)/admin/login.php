<?php
require '../config.php';

$error = '';

// Nếu đã đăng nhập thì chuyển hướng
if (isAdminLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

// Xử lý form đăng nhập
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($password === ADMIN_PASSWORD) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Mật khẩu không chính xác!';
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Đăng nhập</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        .login-container h1 {
            text-align: center;
            margin-bottom: 10px;
            color: #333;
        }

        .login-container p {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
        }

        .alert {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 4px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #667eea;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        .demo-info {
            background-color: #e3f2fd;
            padding: 15px;
            border-radius: 4px;
            font-size: 13px;
            color: #1565c0;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>MODA.vn</h1>
        <p>Quản lý - Đăng nhập</p>

        <?php if ($error): ?>
        <div class="alert"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="demo-info">
            <strong>Demo:</strong> Mật khẩu là <code>admin123</code>
        </div>

        <form method="POST" action="login.php">
            <div class="form-group">
                <label for="password">Mật khẩu admin</label>
                <input type="password" id="password" name="password" required autofocus>
            </div>

            <button type="submit" class="btn-login">Đăng nhập</button>
        </form>

        <div class="back-link">
            <a href="/">← Quay lại trang chủ</a>
        </div>
    </div>
</body>
</html>
