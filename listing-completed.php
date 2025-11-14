<?php
require 'db-connect.php';
session_start();

// ログイン確認
if (!isset($_SESSION['member_id'])) {
  exit('ログインしてください。');
}

// ログイン中のユーザーIDを取得
$member_id = $_SESSION['member_id'];
?>

<?php
  // listing_productから出品情報を取得
  $sql = $pdo->prepare('SELECT * FROM listing_product WHERE member_id = ? AND buy_flag = 0');
  $sql->execute([$member_id]);
  $listings = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>出品一覧</title>
  <link rel="stylesheet" href="css/listing-completed.css">
</head>
<body>
  <!-- ナビゲーションバー -->
  <nav class="navigation-rail">
    <div class="nav-item">
      <img src="img/icon-cart.svg" alt="カート">
      <span>カート</span>
    </div>
    <div class="nav-item">
      <img src="img/icon-home.svg" alt="メインページ">
      <span>メインページ</span>
    </div>
    <div class="nav-item">
      <img src="img/icon-user.svg" alt="マイページ">
      <span>マイページ</span>
    </div>
    <div class="nav-item">
      <img src="img/icon-upload.svg" alt="出品">
      <span>出品</span>
    </div>
  </nav>

  <!-- タイトル・ボタン -->
  <button class="back" onclick="location.href='mainpage.php'">←</button>
  <button class="cancel">×</button>
  <h1>ページタイトル</h1>

  <div class="content">
    <h1 class="page-title">出品一覧</h1>
    <p class="count"><?= count($listings) ?>件</p>
    <h2 class="section-title">出品リスト</h2>

<?php

  if (count($listings) === 0) {
      echo '<p>出品中の商品はありません。</p>';
  } else {
      echo '<div class="item-list">';
      foreach ($listings as $row) {
          echo '<div class="item-card">';
          echo '<img src="' . htmlspecialchars($row['image']) . '" alt="商品画像">';
          echo '<p>' . htmlspecialchars($row['product_name']) . '<br>￥' . htmlspecialchars($row['price']) . '</p>';
          echo '</div>';
      }
      echo '</div>';
  }
?>
  </div>
</body>
</html>
