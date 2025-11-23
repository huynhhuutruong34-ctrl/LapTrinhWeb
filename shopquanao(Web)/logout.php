<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

session_destroy();
setFlash('success', 'Đã đăng xuất thành công');
redirect('/');
