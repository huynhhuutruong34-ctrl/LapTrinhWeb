<?php
$page_title = 'Quản lý người dùng - Laptop Shop';
require_once '../config/database.php';
require_once '../includes/functions.php';

requireAdmin();

$stmt = $pdo->query('SELECT * FROM users ORDER BY created_at DESC');
$users = $stmt->fetchAll();

require '../includes/header.php';
?>

<section style="padding: 2rem 0;">
    <h1 style="font-size: 2rem; margin-bottom: 2rem;">Quản lý người dùng</h1>

    <?php if (empty($users)): ?>
        <div style="background: white; padding: 2rem; border-radius: 8px; text-align: center;">
            <p style="color: #666;">Chưa có người dùng nào</p>
        </div>
    <?php else: ?>
        <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f5f5f5; border-bottom: 2px solid #ddd;">
                        <th style="padding: 1rem; text-align: left;">ID</th>
                        <th style="padding: 1rem; text-align: left;">Tên</th>
                        <th style="padding: 1rem; text-align: left;">Email</th>
                        <th style="padding: 1rem; text-align: left;">Điện thoại</th>
                        <th style="padding: 1rem; text-align: left;">Tỉnh/Thành phố</th>
                        <th style="padding: 1rem; text-align: left;">Ngày tạo</th>
                        <th style="padding: 1rem; text-align: center;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 1rem;"><?php echo $user['id']; ?></td>
                            <td style="padding: 1rem;"><?php echo htmlspecialchars($user['full_name']); ?></td>
                            <td style="padding: 1rem;"><?php echo htmlspecialchars($user['email']); ?></td>
                            <td style="padding: 1rem;"><?php echo htmlspecialchars($user['phone'] ?? '-'); ?></td>
                            <td style="padding: 1rem;"><?php echo htmlspecialchars($user['city'] ?? '-'); ?></td>
                            <td style="padding: 1rem;"><?php echo date('d/m/Y', strtotime($user['created_at'])); ?></td>
                            <td style="padding: 1rem; text-align: center;">
                                <?php if ($user['id'] != 1): ?>
                                    <a href="/admin/api/delete-user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Bạn chắc chắn muốn xóa người dùng này?');" style="color: #e74c3c; text-decoration: none;">
                                        🗑️ Xóa
                                    </a>
                                <?php else: ?>
                                    <span style="color: #95a5a6;">Admin</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>

<?php require '../includes/footer.php'; ?>
