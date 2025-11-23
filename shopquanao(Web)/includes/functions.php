<?php

function formatPrice($price) {
    return number_format($price, 0, ',', '.') . '₫';
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getCurrentUser($pdo) {
    if (!isLoggedIn()) {
        return null;
    }
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch();
}

function redirect($path) {
    header("Location: $path");
    exit;
}

function getFlash($key) {
    $value = $_SESSION['flash'][$key] ?? null;
    unset($_SESSION['flash'][$key]);
    return $value;
}

function setFlash($key, $value) {
    $_SESSION['flash'][$key] = $value;
}

function isAdmin() {
    return isset($_SESSION['user_id']) && isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
}

function requireLogin() {
    if (!isLoggedIn()) {
        setFlash('error', 'Bạn cần đăng nhập');
        redirect('/login.php');
    }
}

function requireAdmin() {
    if (!isAdmin()) {
        setFlash('error', 'Bạn không có quyền truy cập');
        redirect('/');
    }
}

function getCart() {
    return $_SESSION['cart'] ?? [];
}

function setCart($cart) {
    $_SESSION['cart'] = $cart;
}

function addToCart($product_id, $quantity = 1) {
    $cart = getCart();
    if (isset($cart[$product_id])) {
        $cart[$product_id] += $quantity;
    } else {
        $cart[$product_id] = $quantity;
    }
    setCart($cart);
}

function removeFromCart($product_id) {
    $cart = getCart();
    unset($cart[$product_id]);
    setCart($cart);
}

function updateCartItem($product_id, $quantity) {
    $cart = getCart();
    if ($quantity <= 0) {
        removeFromCart($product_id);
    } else {
        $cart[$product_id] = $quantity;
        setCart($cart);
    }
}

function clearCart() {
    setCart([]);
}

function getCartTotal($pdo) {
    $cart = getCart();
    $total = 0;
    foreach ($cart as $product_id => $quantity) {
        $stmt = $pdo->prepare('SELECT price FROM products WHERE id = ?');
        $stmt->execute([$product_id]);
        $product = $stmt->fetch();
        if ($product) {
            $total += $product['price'] * $quantity;
        }
    }
    return $total;
}

function getCartItems($pdo) {
    $cart = getCart();
    $items = [];
    foreach ($cart as $product_id => $quantity) {
        $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
        $stmt->execute([$product_id]);
        $product = $stmt->fetch();
        if ($product) {
            $product['quantity'] = $quantity;
            $product['subtotal'] = $product['price'] * $quantity;
            $items[] = $product;
        }
    }
    return $items;
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function sanitizeInput($input) {
    return htmlspecialchars(strip_tags(trim($input)));
}
