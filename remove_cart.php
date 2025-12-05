<?php
session_start();
require 'db-connect.php';

if (!isset($_SESSION['member_id'])) {
    exit('ログインしてください');
}

$member_id = $_SESSION['member_id'];
$cart_id = $_POST['cart_id'] ?? '';

if (!$cart_id) {
    exit('cart_id がありません');
}

$stmt = $pdo->prepare("DELETE FROM cart WHERE cart_id = ? AND member_id = ?");
$stmt->execute([$cart_id, $member_id]);

header('Location: cart-list.php');
exit;
