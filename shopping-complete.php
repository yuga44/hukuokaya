<?php
require 'db-connect.php';
session_start();
 
if (!isset($_SESSION['member'])) {
    header('Location: Login.php?error=not_logged_in');
    exit;
}

try {
    // DB接続
    $pdo = new PDO('mysql:host='.SERVER.';dbname='.DBNAME.';charset=utf8', USER, PASS);

    $product_name = $_POST['product_name'] ?? '';
    $category = $_POST['category'] ?? '';
    $price = $_POST['price'] ?? 0;
    $description = $_POST['description'] ?? '';
    $member_id = $_SESSION['member']['member_id']; // ログイン中のユーザーID

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

} catch (Exception $e) {
    exit("エラー：" . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>出品完了</title>
  <link rel="stylesheet" href="css/shopping-complete.css">
</head>
<body>

  <nav class="navigation-rail">
    <div class="nav-item"><img src="img/icon-upload.svg" alt="出品"><span>出品</span></div>
    <div class="nav-item"><img src="img/icon-home.svg" alt="メインページ"><span>メインページ</span></div>
    <div class="nav-item"><img src="img/icon-user.svg" alt="マイページ"><span>マイページ</span></div>
    <div class="nav-item"><img src="img/icon-cart.svg" alt="カート"><span>カート</span></div>
  </nav>

  <main class="content">
    <header class="app-bar">
      <div class="back">←</div>
      <h1 class="headline">出品完了</h1>
    </header>

    <section class="complete-box">
      <h2>出品が完了しました！</h2>
      <p class="description">
        商品が公開されました<br>購入されるのをお待ちください
      </p>

      <div class="item-info">
        <img src="<?= htmlspecialchars($image_path ?? 'img/no-image.svg') ?>" alt="商品画像" style="width:200px;">
        <div class="item-text">
          <p><?= htmlspecialchars($product_name) ?></p>
          <p>¥<?= number_format($price) ?></p>
        </div>
      </div>

      <div class="actions">
        <a href="listing-completed.php">出品一覧を見る</a>
        <a href="mainpage.php">メインページへ戻る</a>
      </div>
    </section>
  </main>
</body>
</html>
