<?php
require '../config.php';

if (isAdminLoggedIn()) {
    header('Location: dashboard.php');
} else {
    header('Location: login.php');
}
exit;
?>
