<?php
session_start();
require 'db-connect.php';

// POSTデータを取得
$login_id = $_POST['login_id'] ?? '';
$password = $_POST['password'] ?? '';

// 空欄チェック
if (empty($login_id) || empty($password)) {
    header('Location: Login.php?error=empty');
    exit;
}

try {
    $sql = "SELECT * FROM member WHERE login_id = ? AND password = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$login_id, $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // ✅ ログイン成功
        $_SESSION['member_id'] = $user['member_id'];
        $_SESSION['name'] = $user['name'];
        header('Location: mainpage.php');
        exit;
    } else {
        // ❌ ログイン失敗
        header('Location: Login.php?error=invalid');
        exit;
    }
} catch (PDOException $e) {
    header('Location: Login.php?error=db');
    exit;
}
?>
