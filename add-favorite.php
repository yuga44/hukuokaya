<?php
session_start();
require 'db-connect.php';

// ログイン必須
if (!isset($_SESSION['member_id'])) {
    header("Location: Login.php");
    exit;
}

$member_id  = (int)$_SESSION['member_id'];
$product_id = (int)($_POST['product_id'] ?? 0);

if ($product_id <= 0) {
    exit("商品IDが不正です");
}

try {

    // すでに登録されているか確認
    $sql = $pdo->prepare("
        SELECT favorite_id
        FROM favorite
        WHERE member_id = ?
          AND product_id = ?
    ");
    $sql->execute([$member_id, $product_id]);
    $exists = $sql->fetch();

    if ($exists) {
        // 登録済み → フラグだけON
        $sql = $pdo->prepare("
            UPDATE favorite
               SET favorite_flag = 1
             WHERE member_id = ?
               AND product_id = ?
        ");
        $sql->execute([$member_id, $product_id]);

    } else {
        // 新規登録
        $sql = $pdo->prepare("
            INSERT INTO favorite
                (member_id, product_id, favorite_flag)
            VALUES
                (?, ?, 1)
        ");
        $sql->execute([$member_id, $product_id]);
    }

} catch (PDOException $e) {
    exit("お気に入り登録エラー：" . htmlspecialchars($e->getMessage()));
}

// 元のページへ戻す
header("Location: product-detail.php?product_id={$product_id}");
exit;
