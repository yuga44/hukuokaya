<?php
require 'db-connect.php';
session_start();

// ログイン確認
if (!isset($_SESSION['member_id'])) {
    header('Location: Login.php?error=not_logged_in');
    exit;
}

try {
    // DB接続
    $pdo = new PDO(
        'mysql:host=' . SERVER . ';dbname=' . DBNAME . ';charset=utf8mb4',
        USER,
        PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // 入力データ取得
    $product_name = $_POST['product_name'] ?? '';
    $category = $_POST['category'] ?? '';
    $price = $_POST['price'] ?? 0;
    $description = $_POST['description'] ?? '';
    $member_id = $_SESSION['member_id'] ?? 1; // 仮ログイン中のユーザー

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

    // 出品情報を表示用に変数へ
    $uploaded_product = [
        'image' => $image_path,
        'name' => $product_name,
        'price' => $price
    ];

} catch (Exception $e) {
    exit('エラー：' . $e->getMessage());
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

  <!-- ナビゲーション -->
  <nav class="navigation-rail">
    <div class="nav-item">
      <img src="img/icon-upload.svg" alt="出品">
      <span>出品</span>
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
      <img src="img/icon-cart.svg" alt="カート">
      <span>カート</span>
    </div>
  </nav>

  <!-- メインコンテンツ -->
  <main class="content">
    <header class="app-bar">
      <div class="back">←</div>
      <h1 class="headline">出品完了</h1>
      <div></div>
    </header>

    <section class="complete-box">
      <h2>出品が完了しました！</h2>
      <p class="description">
        商品が公開されました<br>
        購入されるのをお待ちください
      </p>

      <div class="item-info">
        <img src="<?= htmlspecialchars($uploaded_product['image'] ?? 'img/no-image.svg') ?>" alt="商品画像">
        <div class="item-text">
          <p><?= htmlspecialchars($uploaded_product['name'] ?? '') ?></p>
          <p>¥<?= number_format($uploaded_product['price'] ?? 0) ?></p>
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
