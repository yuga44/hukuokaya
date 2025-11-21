<?php
session_start();
require 'db-connect.php';

// ▼ ログインチェック（ログインしてない場合はログイン画面へ）
if (!isset($_SESSION['member_id'])) {
    header('Location: Login.php');
    exit;
}

$member_id = (int)$_SESSION['member_id'];

// ▼ 1. カート画面から送られてきた product_id を受け取る
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
} else {
    // 直接URLで来たとき用（例：purchase-screen.php?product_id=3）
    $product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;
}

if ($product_id <= 0) {
    echo '商品が正しく指定されていません。';
    exit;
}

// ▼ 2. listing_product テーブルから商品情報を取得
try {
    $sql = "SELECT product_id, product_name, price, image, product_detail
              FROM listing_product
             WHERE product_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        echo '指定された商品が存在しません。';
        exit;
    }
} catch (PDOException $e) {
    echo '商品取得時のデータベースエラー: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    exit;
}

// ▼ 3. 商品情報
$product_name   = $product['product_name'];
$product_price  = (int)$product['price'];
$product_image  = $product['image'];          // 画像パス
$product_detail = $product['product_detail'];

$shipping_fee = 600;
$total = $product_price + $shipping_fee;

// ▼ 4. member テーブルからユーザー情報を取得（name, address, tel）
try {
    $sql = "SELECT name, address, tel
              FROM member
             WHERE member_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$member_id]);
    $member = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$member) {
        echo '会員情報が取得できませんでした。';
        exit;
    }
} catch (PDOException $e) {
    echo '会員情報取得時のデータベースエラー: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    exit;
}

// ▼ 5. ユーザー情報（DBの値）
$user_name    = $member['name'];
$user_address = $member['address'];
$user_phone   = $member['tel'];

// ▼ 6. 画面から一時的に編集されたときに上書き（DB更新はしていない）
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['user_name'])) {
        $user_name = htmlspecialchars($_POST['user_name'], ENT_QUOTES, 'UTF-8');
    }
    if (isset($_POST['user_address'])) {
        $user_address = htmlspecialchars($_POST['user_address'], ENT_QUOTES, 'UTF-8');
    }
    if (isset($_POST['user_phone'])) {
        $user_phone = htmlspecialchars($_POST['user_phone'], ENT_QUOTES, 'UTF-8');
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>購入画面</title>
  <link rel="stylesheet" href="css/purchase-screen.css">
</head>
<body>
  <div class="main">
    <a href="javascript:history.back();" class="back-btn">←</a>
    <h1>購入画面</h1>

    <!-- 商品情報 -->
    <div class="product">
      <?php if (!empty($product_image)): ?>
        <img src="<?php echo htmlspecialchars($product_image, ENT_QUOTES, 'UTF-8'); ?>" alt="商品画像">
      <?php else: ?>
        <div class="no-image">画像なし</div>
      <?php endif; ?>

      <div>
        <p>商品名：<?php echo htmlspecialchars($product_name, ENT_QUOTES, 'UTF-8'); ?></p>
        <p>価格：￥<?php echo number_format($product_price); ?></p>
        <p><?php echo nl2br(htmlspecialchars($product_detail, ENT_QUOTES, 'UTF-8')); ?></p>
      </div>
    </div>

    <!-- 配送先 -->
    <div class="section">
      <h2>配送先</h2>
      <div class="info-box">
        <?php echo htmlspecialchars($user_name, ENT_QUOTES, 'UTF-8'); ?><br>
        <?php echo htmlspecialchars($user_address, ENT_QUOTES, 'UTF-8'); ?><br>
        <?php echo htmlspecialchars($user_phone, ENT_QUOTES, 'UTF-8'); ?>

        <!-- 表示を一時的に変更したい用（DBにはまだ反映しない） -->
        <form action="" method="post" class="edit-form">
          <input type="hidden" name="product_id" value="<?php echo (int)$product_id; ?>">
          <input type="text" name="user_name" placeholder="氏名" value="<?php echo htmlspecialchars($user_name, ENT_QUOTES, 'UTF-8'); ?>"><br>
          <input type="text" name="user_address" placeholder="住所" value="<?php echo htmlspecialchars($user_address, ENT_QUOTES, 'UTF-8'); ?>"><br>
          <input type="text" name="user_phone" placeholder="電話番号" value="<?php echo htmlspecialchars($user_phone, ENT_QUOTES, 'UTF-8'); ?>"><br>
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

    <!-- 購入確定ボタン -->
    <form action="purchase-completed.php" method="post">
      <input type="hidden" name="product_id" value="<?php echo (int)$product_id; ?>">
      <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product_name, ENT_QUOTES, 'UTF-8'); ?>">
      <input type="hidden" name="product_price" value="<?php echo (int)$product_price; ?>">
      <input type="hidden" name="shipping_fee" value="<?php echo (int)$shipping_fee; ?>">
      <input type="hidden" name="total" value="<?php echo (int)$total; ?>">

      <input type="hidden" name="user_name" value="<?php echo htmlspecialchars($user_name, ENT_QUOTES, 'UTF-8'); ?>">
      <input type="hidden" name="user_address" value="<?php echo htmlspecialchars($user_address, ENT_QUOTES, 'UTF-8'); ?>">
      <input type="hidden" name="user_phone" value="<?php echo htmlspecialchars($user_phone, ENT_QUOTES, 'UTF-8'); ?>">

      <button type="submit" class="confirm-btn">購入を確定する</button>
    </form>
  </div>
</body>
</html>
