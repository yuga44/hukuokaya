<?php
session_start();
require 'db-connect.php';

// ログインしているか確認
if (!isset($_SESSION['member_id'])) {
    header("Location: Login.php");
    exit;
}

$member_id = $_SESSION['member_id'];
$product_id = (int)($_POST['product_id'] ?? 0);

if ($product_id <= 0) {
    exit("商品が指定されていません。");
}

// ▼ 商品フラグを0にして「販売終了」にする
try {
    $sql = $pdo->prepare("UPDATE listing_product SET buy_flag = 0 WHERE product_id = ?");
    $sql->execute([$product_id]);
} catch (PDOException $e) {
    exit("商品更新エラー：" . htmlspecialchars($e->getMessage()));
}

// ▼ 必要ならカートから削除
$sql = $pdo->prepare("DELETE FROM cart WHERE product_id = ? AND member_id = ?");
$sql->execute([$product_id, $member_id]);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>購入完了</title>
  <link rel="stylesheet" href="css/purchase-completed.css">
</head>
<body>
  <div class="main">
    <a href="#" class="back">←</a>
    <h1>購入完了</h1>
    <div class="message">
      ご購入ありがとうございます
    </div>
    <div class="links">
      <a href="purchase-history.php">購入履歴を見る</a>
      <a href="mainpage.php">メインページへ戻る</a>
    </div>
  </div>
</body>
</html>
