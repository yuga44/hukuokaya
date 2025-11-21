<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION['member_id'])) {
    // ログインしていなければリダイレクト
    header('Location: Login.php?error=not_logged_in');
    exit;
}
?>

<?php
    // --- DB接続 ---
    require_once 'db-connect.php';

    // --- 会員ID ---
    $member_id = $_SESSION['member_id']; // セッションから会員IDを取得

    // --- 購入履歴を取得 ---
    $sql = "
    SELECT 
      p.product_name,
      p.image,
      p.price,
      b.date AS purchase_date,
      m.address
    FROM buy b
    JOIN detail d ON b.buy_id = d.buy_id
    JOIN listing_product p ON d.product_id = p.product_id
    JOIN member m ON b.member_id = m.member_id
    WHERE b.member_id = :member_id
    ORDER BY b.date DESC;
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
    $stmt->execute();
    $history = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>購入履歴</title>
  <link rel="stylesheet" href="css/cart-list.css"> 
</head>
<body>
    <nav class="navigation-rail">
      <div class="nav-item">
        <a href="mainpage.php">
        <img src="img/icon-3.svg" alt="メインページ" />
        <span>メインページ</span>
        </a>
      </div>
      <div class="nav-item">
        <a href="account-info.php">
        <img src="img/icon-8.svg" alt="マイページ" />
        <span>マイページ</span>
        </a>
      </div>
      <div class="nav-item">
        <a href="cart-list.php">
        <img src="img/icon-8.svg" alt="カート" />
        <span>カート</span>
        </a>
      </div>
      <div class="nav-item">
        <a href="listing.php">
        <img src="img/icon-8.svg" alt="出品" />
        <span>出品</span>
        </a>
      </div>
    </nav>

  <button class="back"><a href="./mypage.php">←</a></button>
  <h1>購入履歴</h1>

  <div class="content">
    <?php if (empty($history)): ?>
      <p>購入履歴はありません。</p>
    <?php else: ?>
      <?php foreach ($history as $item): ?>
        <div class="cart-item">
          <img src="<?= htmlspecialchars($item['image'] ?? 'img/noimage.png') ?>" alt="商品画像">
          <div class="cart-info">
            <h2><?= htmlspecialchars($item['product_name']) ?></h2>
            <p>
              購入日：<?= htmlspecialchars($item['purchase_date']) ?><br>
              お支払額：¥<?= number_format($item['price']) ?><br>
              お届け先：<?= htmlspecialchars($item['address']) ?>
            </p>
            <button><a href="./Purchace-screen.php">再び購入</a></button>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</body>
</html>