<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>購入画面</title>
  <link rel="stylesheet" href="css/chase.css">
</head>
<body>
  <div class="main">
    <!-- ←戻る矢印 -->
    <a href="mainpage.php" class="back-btn">←</a>

    <h1>購入画面</h1>
    <form action="purchase-completed.php" method="post">
    <div class="product">
      <img src="#" alt="商品画像">
      <div>
        <p>商品名：〇〇〇〇</p>
        <p>価格：￥〇〇〇〇</p>
      </div>
    </div>

    <div class="section">
      <h2>支払い方法</h2>
      <div class="info-box">
        クレジットカード
        <button class="change-btn">変更する</button>
      </div>
    </div>

    <div class="section">
      <h2>配送先</h2>
      <div class="info-box">
        ○○ ○○<br>
        福岡県福岡市 1-2-3<br>
        090-○○○○-○○○○
        <button class="change-btn">変更する</button>
      </div>
    </div>

    <div class="section">
      <h2>注文金額</h2>
      <div class="info-box">
        商品価格：￥〇〇〇〇<br>
        送料：￥〇〇〇<br>
        <p class="total">合計金額：￥〇〇〇〇</p>
      </div>
    </div>

    <button type="submit" class="confirm-btn">購入を確定する</button>
    </form>
  </div>
</body>
</html>
