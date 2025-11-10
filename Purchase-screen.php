<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>購入画面</title>
  <link rel="stylesheet" href="purchase-screen.css">
</head>
<body>
  <div class="main">
    <!-- ←戻る矢印 -->
    <a href="#" class="back-btn">←</a>
 
    <h1>購入画面</h1>
 
    <div class="product">
      <img src="#" alt="商品画像">
      <div>
        <p>商品名：<?php echo "〇〇〇〇"; ?></p>
        <p>価格：￥<?php echo "〇〇〇〇"; ?></p>
      </div>
    </div>
 
    <div class="section">
      <h2>支払い方法</h2>
      <div class="info-box">
        <?php echo "クレジットカード"; ?>
        <button class="change-btn">変更する</button>
      </div>
    </div>
 
    <div class="section">
      <h2>配送先</h2>
      <div class="info-box">
        <?php echo "○○ ○○"; ?><br>
        <?php echo "福岡県福岡市 1-2-3"; ?><br>
        <?php echo "090-○○○○-○○○○"; ?>
        <button class="change-btn">変更する</button>
      </div>
    </div>
 
    <div class="section">
      <h2>注文金額</h2>
      <div class="info-box">
        商品価格：￥<?php echo "〇〇〇〇"; ?><br>
        送料：￥<?php echo "〇〇〇"; ?><br>
        <p class="total">合計金額：￥<?php echo "〇〇〇〇"; ?></p>
      </div>
    </div>
 
    <button class="confirm-btn">購入を確定する</button>
  </div>
</body>
</html>
