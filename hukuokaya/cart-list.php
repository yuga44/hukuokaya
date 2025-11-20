<?php
session_start();
require 'db-connect.php';

// ログインチェック
if (!isset($_SESSION['member_id'])) {
    header('Location: Login.php');
    exit;
}

$member_id = $_SESSION['member_id'];

// ▼ カートの中身を取得 ▼
$sql = $pdo->prepare("
    SELECT c.*, p.product_name, p.price, p.image, p.product_detail
    FROM cart c
    JOIN listing_product p ON c.product_id = p.product_id
    WHERE c.member_id = ?
");
$sql->execute([$member_id]);
$cart_items = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
</head>
<body>
    <link rel="stylesheet" href="css/cart-list.css">

  <!-- ナビゲーションバー -->
  <nav class="navigation-rail">
      <div class="nav-item">
        <a href="mainpage.php">
          <img src="img/click_scam.jpg" alt="メインページ" />
        </a>
        <span>メインページ</span>
      </div>
      <div class="nav-item">
        <a href="mypage.php">
          <img src="img/click_scam.jpg" alt="マイページ" />
        </a>
        <span>マイページ</span>
      </div>
      <div class="nav-item">
        <a href="cart-list.php">
          <img src="img/click_scam.jpg" alt="カート" />
        </a>
        <span>カート</span>
      </div>
      <div class="nav-item">
        <a href="listing.php">
          <img src="img/click_scam.jpg" alt="出品" />
        </a>
        <span>出品</span>
      </div>
    </nav>

  <!-- タイトル・ボタン -->
  <a href="mainpage.php">
    <button class="back">←</button>
  </a>
  <h1>カート</h1>

  <div class="content">

<?php if (count($cart_items) === 0): ?>

    <p>カートに商品はありません。</p>

<?php else: ?>

    <?php foreach ($cart_items as $item): ?>
      <div class="cart-item">
        <img src="<?= htmlspecialchars($item['image']) ?>" alt="商品画像">

        <div class="cart-info">
          <h2><?= htmlspecialchars($item['product_name']) ?></h2>
          <p><?= htmlspecialchars($item['product_detail']) ?></p>
          <p>￥<?= htmlspecialchars($item['price']) ?></p>

          <form action="Purchase-screen" method="post">
              <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
              <button>購入</button>
          </form>
        </div>
      </div>
    <?php endforeach; ?>

<?php endif; ?>

  </div>
</body>
</html>
