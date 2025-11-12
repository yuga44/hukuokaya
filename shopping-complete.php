<?php
require 'db-connect.php';
session_start();

// 仮ログイン（本来はログイン処理で $_SESSION['member_id'] がセットされる）
$_SESSION['member_id'] = 1;

// データ送信があったときのみ実行
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  try {
      // DB接続
      $pdo = new PDO(
          'mysql:host=' . SERVER . ';dbname=' . DBNAME . ';charset=utf8mb4',
          USER,
          PASS,
          [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
      );

      $product_name = $_POST['product_name'] ?? '';
      $category = $_POST['category'] ?? '';
      $price = $_POST['price'] ?? 0;
      $description = $_POST['description'] ?? '';
      $member_id = $_SESSION['member_id'];

      // ==== 画像アップロード処理 ====
      $image_path = null;
      if (!empty($_FILES['image_file']['name'])) {
          $upload_dir = __DIR__ . '/uploads/';
          $web_path = 'uploads/';

          if (!is_dir($upload_dir)) {
              mkdir($upload_dir, 0777, true);
          }

          $filename = uniqid() . '_' . basename($_FILES['image_file']['name']);
          $target_path = $upload_dir . $filename;
          $image_path = $web_path . $filename;

          if (!move_uploaded_file($_FILES['image_file']['tmp_name'], $target_path)) {
              throw new Exception('画像のアップロードに失敗しました。');
          }
      }

      // ==== DB登録 ====
      $sql = "INSERT INTO listing_product (member_id, product_name, price, category, image, product_detail, date)
              VALUES (:member_id, :product_name, :price, :category, :image, :detail, NOW())";

      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
      $stmt->bindValue(':product_name', $product_name, PDO::PARAM_STR);
      $stmt->bindValue(':price', $price, PDO::PARAM_INT);
      $stmt->bindValue(':category', $category, PDO::PARAM_STR);
      $stmt->bindValue(':image', $image_path, PDO::PARAM_STR);
      $stmt->bindValue(':detail', $description, PDO::PARAM_STR);
      $stmt->execute();

      // 成功時の表示
      $success = true;
  } catch (Exception $e) {
      $error = $e->getMessage();
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>商品出品</title>
  <link rel="stylesheet" href="css/listing.css">
</head>
<body>

  <?php if (!empty($success)): ?>
    <!-- 出品完了画面 -->
    <h1>出品が完了しました！</h1>
    <p>商品が公開されました。購入をお待ちください。</p>

    <div class="item-info">
      <img src="<?= htmlspecialchars($image_path) ?>" alt="商品画像" style="width:200px;">
      <div class="item-text">
        <p><?= htmlspecialchars($product_name) ?></p>
        <p>¥<?= number_format($price) ?></p>
      </div>
    </div>

    <a href="listing.php">もう一度出品する</a>
    <a href="mainpage.php">メインページに戻る</a>

  <?php elseif (!empty($error)): ?>
    <!--  エラー表示 -->
    <p style="color:red;">エラー：<?= htmlspecialchars($error) ?></p>

  <?php else: ?>
    <!--  出品フォーム -->
    <h1>商品を出品する</h1>

    <form action="listing.php" method="POST" enctype="multipart/form-data">
      <label>商品名：</label>
      <input type="text" name="product_name" required><br><br>

      <label>カテゴリ：</label>
      <input type="text" name="category"><br><br>

      <label>価格：</label>
      <input type="number" name="price" required><br><br>

      <label>商品説明：</label><br>
      <textarea name="description" rows="4" cols="40"></textarea><br><br>

      <label>商品画像：</label>
      <input type="file" name="image_file" accept="image/*"><br><br>

      <button type="submit">出品する</button>
    </form>
  <?php endif; ?>

</body>
</html>
