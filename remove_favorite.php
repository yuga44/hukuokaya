<?php
session_start();
require 'db-connect.php';

// ★ ログイン必須
if (!isset($_SESSION['member_id'])) {
    http_response_code(401);
    echo "ログインが必要です";
    exit;
}

$member_id = $_SESSION['member_id'];

// ★ favorite_id が POST で来ているか確認
if (!isset($_POST['favorite_id'])) {
    http_response_code(400);
    echo "favorite_id がありません";
    exit;
}

$favorite_id = (int)$_POST['favorite_id'];

try {
    // ★ favorite_flag を 0 にする
    $sql = "
        UPDATE favorite
        SET favorite_flag = 0
        WHERE favorite_id = ?
          AND member_id = ?
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$favorite_id, $member_id]);

    echo "success"; // JS側の確認用
} catch (PDOException $e) {
    http_response_code(500);
    echo "DBエラー: " . $e->getMessage();
}
