<?php
require_once '../../config/database.php';
require_once '../../includes/functions.php';

requireAdmin();

$user_id = (int)($_GET['id'] ?? 0);

if ($user_id <= 0 || $user_id === 1) {
    setFlash('error', 'Không thể xóa người dùng này');
    redirect('/admin/users.php');
}

try {
    $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
    $stmt->execute([$user_id]);
    setFlash('success', 'Xóa người dùng thành công');
} catch (Exception $e) {
    setFlash('error', 'Lỗi khi xóa người dùng: ' . $e->getMessage());
}

redirect('/admin/users.php');
