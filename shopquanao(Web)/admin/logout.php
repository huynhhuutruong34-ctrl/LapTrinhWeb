<?php
require '../config.php';

// Xóa session admin
unset($_SESSION['admin_logged_in']);

// Chuyển hướng về trang chủ
header('Location: /');
exit;
?>
