<?php
$page_title = 'Liên hệ - Laptop Shop';
require_once 'config/database.php';
require_once 'includes/functions.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitizeInput($_POST['name'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    $subject = sanitizeInput($_POST['subject'] ?? '');
    $message = sanitizeInput($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = 'Vui lòng điền tất cả các trường';
    } elseif (!validateEmail($email)) {
        $error = 'Email không hợp lệ';
    } else {
        $success = 'Cảm ơn bạn! Chúng tôi sẽ liên hệ với bạn sớm.';
    }
}

require 'includes/header.php';
?>

<section style="padding: 2rem 0;">
    <h1 style="font-size: 2rem; margin-bottom: 2rem;">Liên hệ với chúng tôi</h1>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem;">
        <div>
            <h2 style="font-size: 1.3rem; margin-bottom: 1.5rem;">Thông tin liên hệ</h2>
            
            <div style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <div style="margin-bottom: 2rem;">
                    <h3 style="margin-bottom: 0.5rem;">📍 Địa chỉ</h3>
                    <p style="color: #666;">Hà Nội, Việt Nam</p>
                </div>

                <div style="margin-bottom: 2rem;">
                    <h3 style="margin-bottom: 0.5rem;">📞 Điện thoại</h3>
                    <p style="color: #666;"><a href="tel:0123456789" style="color: #3498db; text-decoration: none;">0123 456 789</a></p>
                </div>

                <div style="margin-bottom: 2rem;">
                    <h3 style="margin-bottom: 0.5rem;">✉️ Email</h3>
                    <p style="color: #666;"><a href="mailto:info@laptopshop.vn" style="color: #3498db; text-decoration: none;">info@laptopshop.vn</a></p>
                </div>

                <div>
                    <h3 style="margin-bottom: 0.5rem;">⏰ Giờ làm việc</h3>
                    <p style="color: #666;">Thứ 2 - Thứ 6: 8:00 - 17:00</p>
                    <p style="color: #666;">Thứ 7 - Chủ nhật: 9:00 - 16:00</p>
                </div>
            </div>
        </div>

        <div>
            <h2 style="font-size: 1.3rem; margin-bottom: 1.5rem;">Gửi tin nhắn</h2>

            <div style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
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
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Tên của bạn *</label>
                        <input type="text" name="name" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Email *</label>
                        <input type="email" name="email" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Chủ đề *</label>
                        <input type="text" name="subject" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                    </div>

                    <div style="margin-bottom: 2rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Nội dung *</label>
                        <textarea name="message" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; min-height: 150px;"></textarea>
                    </div>

                    <button type="submit" style="width: 100%; padding: 0.75rem; background: #3498db; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
                        Gửi tin nhắn
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require 'includes/footer.php'; ?>
