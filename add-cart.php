<?php
session_start();
require 'db-connect.php';

// ログインチェック
if (!isset($_SESSION['member_id'])) {
    header("Location: Login.php");
    exit;
}

$member_id = $_SESSION['member_id'];

if (!isset($_POST['product_id'])) {
    exit("商品が指定されていません。");
}

$product_id = intval($_POST['product_id']);

// ▼ カートに既に存在するか確認（数量は扱わない）
$sql = $pdo->prepare("SELECT cart_id FROM cart WHERE member_id = ? AND product_id = ?");
$sql->execute([$member_id, $product_id]);
$cart = $sql->fetch(PDO::FETCH_ASSOC);

if ($cart) {
    // すでに存在する → 何もしない（数量は常に1）
} else {
    // 新規追加（quantity カラムなし）
    $sql = $pdo->prepare("INSERT INTO cart (member_id, product_id) VALUES (?, ?)");
    $sql->execute([$member_id, $product_id]);
}

// カート一覧へ
header("Location: cart-list.php");
exit;
