<?php
// ===== 商品情報（洋服用） =====
$product_name = "デニムジャケット";
$product_price = 8900;
$shipping_fee = 600;
$total = $product_price + $shipping_fee;

// ===== ユーザー情報 =====
$payment_method = "クレジットカード";
$user_name = "田中 太郎";
$user_address = "福岡県福岡市中央区1-2-3";
$user_phone = "090-1234-5678";
?>

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
    <a href="javascript:history.back();" class="back-btn">←</a>

    <h1>購入画面</h1>

    <div class="product">
      <img src="images/denim_jacket.jpg" alt="商品画像">
      <div>
        <p>商品名：<?php echo htmlspecialchars($product_name); ?></p>
        <p>価格：￥<?php echo number_format($product_price); ?></p>
      </div>
    </div>

    <div class="section">
      <h2>支払い方法</h2>
      <div class="info-box">
        <?php echo htmlspecialchars($payment_method); ?>
        <button class="change-btn" type="button">変更する</button>
      </div>
    </div>

    <div class="section">
      <h2>配送先</h2>
      <div class="info-box">
        <?php echo htmlspecialchars($user_name); ?><br>
        <?php echo htmlspecialchars($user_address); ?><br>
        <?php echo htmlspecialchars($user_phone); ?>
        <button class="change-btn" type="button">変更する</button>
      </div>
    </div>

    <div class="section">
      <h2>注文金額</h2>
      <div class="info-box">
        商品価格：￥<?php echo number_format($product_price); ?><br>
        送料：￥<?php echo number_format($shipping_fee); ?><br>
        <p class="total">合計金額：￥<?php echo number_format($total); ?></p>
      </div>
    </div>

    <!-- ✅ 購入確定ボタン -->
    <form action="purchase-completed.php" method="post">
      <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product_name); ?>">
      <input type="hidden" name="product_price" value="<?php echo $product_price; ?>">
      <input type="hidden" name="shipping_fee" value="<?php echo $shipping_fee; ?>">
      <input type="hidden" name="total" value="<?php echo $total; ?>">
      <input type="hidden" name="payment_method" value="<?php echo htmlspecialchars($payment_method); ?>">
      <input type="hidden" name="user_name" value="<?php echo htmlspecialchars($user_name); ?>">
      <input type="hidden" name="user_address" value="<?php echo htmlspecialchars($user_address); ?>">
      <input type="hidden" name="user_phone" value="<?php echo htmlspecialchars($user_phone); ?>">

      <button class="confirm-btn" type="submit">購入を確定する</button>
    </form>
  </div>
</body>
</html>
