<?php
// ===== 商品情報（洋服用） =====
$product_name = "デニムジャケット";
$product_price = 8900;
$shipping_fee = 600;
$total = $product_price + $shipping_fee;

// ===== ユーザー情報（初期値） =====
$payment_method = "クレジットカード";
$user_name = "田中 太郎";
$user_address = "福岡県福岡市中央区1-2-3";
$user_phone = "090-1234-5678";

// ===== フォーム送信時の処理 =====
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!empty($_POST['payment_method'])) {
    $payment_method = htmlspecialchars($_POST['payment_method'], ENT_QUOTES, 'UTF-8');
  }
  if (!empty($_POST['user_name'])) {
    $user_name = htmlspecialchars($_POST['user_name'], ENT_QUOTES, 'UTF-8');
  }
  if (!empty($_POST['user_address'])) {
    $user_address = htmlspecialchars($_POST['user_address'], ENT_QUOTES, 'UTF-8');
  }
  if (!empty($_POST['user_phone'])) {
    $user_phone = htmlspecialchars($_POST['user_phone'], ENT_QUOTES, 'UTF-8');
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>購入画面</title>
  <link rel="stylesheet" href="css/purchase-screen.css">
</head>
<body>
  <div class="main">
    <a href="javascript:history.back();" class="back-btn">←</a>
    <h1>購入画面</h1>

    <div class="product">
      <img src="images/denim_jacket.jpg" alt="商品画像">
      <div>
        <p>商品名：<?php echo htmlspecialchars($product_name); ?></p>
        <p>価格：￥<?php echo number_format($product_price); ?></p>
      </div>
    </div>

    <!-- 支払い方法 -->
    <div class="section">
      <h2>支払い方法</h2>
      <div class="info-box">
        <?php echo $payment_method; ?>
        <form action="" method="post" class="edit-form">
          <select name="payment_method">
            <option value="クレジットカード">クレジットカード</option>
            <option value="コンビニ払い">コンビニ払い</option>
            <option value="銀行振込">銀行振込</option>
          </select>
          <button type="submit" class="save-btn">保存</button>
        </form>
      </div>
    </div>

    <!-- 配送先 -->
    <div class="section">
      <h2>配送先</h2>
      <div class="info-box">
        <?php echo $user_name; ?><br>
        <?php echo $user_address; ?><br>
        <?php echo $user_phone; ?>

        <form action="" method="post" class="edit-form">
          <input type="text" name="user_name" placeholder="氏名" value="<?php echo $user_name; ?>"><br>
          <input type="text" name="user_address" placeholder="住所" value="<?php echo $user_address; ?>"><br>
          <input type="text" name="user_phone" placeholder="電話番号" value="<?php echo $user_phone; ?>"><br>
          <button type="submit" class="save-btn">保存</button>
        </form>
      </div>
    </div>

    <!-- 注文金額 -->
    <div class="section">
      <h2>注文金額</h2>
      <div class="info-box">
        商品価格：￥<?php echo number_format($product_price); ?><br>
        送料：￥<?php echo number_format($shipping_fee); ?><br>
        <p class="total">合計金額：￥<?php echo number_format($total); ?></p>
      </div>
    </div>

    <!-- 購入確定ボタン（purchase-completed.phpへ遷移） -->
    <form action="purchase-completed.php" method="post">
      <input type="hidden" name="product_name" value="<?php echo $product_name; ?>">
      <input type="hidden" name="product_price" value="<?php echo $product_price; ?>">
      <input type="hidden" name="shipping_fee" value="<?php echo $shipping_fee; ?>">
      <input type="hidden" name="total" value="<?php echo $total; ?>">
      <input type="hidden" name="payment_method" value="<?php echo $payment_method; ?>">
      <input type="hidden" name="user_name" value="<?php echo $user_name; ?>">
      <input type="hidden" name="user_address" value="<?php echo $user_address; ?>">
      <input type="hidden" name="user_phone" value="<?php echo $user_phone; ?>">

      <button type="submit" class="confirm-btn">購入を確定する</button>
    </form>
  </div>
</body>
</html>
