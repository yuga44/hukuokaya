<?php
  $require 'db-connect.php';
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
  <button class="back">←</button>
  <button class="cancel">×</button>
  <h1>ページタイトル</h1>
  <!--ここまでテンプレ-->

  <div class="content"><!---ここにコンテンツ-->
    <h1 class="page-title">出品一覧</h1>
<p class="count">？件</p>
<h2 class="section-title">Section title</h2>

<div class="item-list">
  <div class="item-card">
    <img src="img/sample1.png" alt="商品画像">
    <p>ベルト<br>¥2000</p>
  </div>
  <div class="item-card">
    <img src="img/sample2.png" alt="商品画像">
    <p>靴下<br>¥500</p>
  </div>
  <div class="item-card">
    <img src="img/sample3.png" alt="商品画像">
    <p>Artist<br>Song</p>
  </div>
  <div class="item-card">
    <img src="img/sample3.png" alt="商品画像">
    <p>Artist<br>Song</p>
  </div>
  <div class="item-card">
    <img src="img/sample3.png" alt="商品画像">
    <p>Artist<br>Song</p>
  </div>
</div>
  </div>
</body>
</html>
