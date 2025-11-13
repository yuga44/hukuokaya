<?php
// 仮のお気に入りデータ
$favorites = [
  ["name" => "デニムジャケット", "img" => "img/denim.jpg"],
  ["name" => "スウェットシャツ", "img" => "img/sweat.jpg"],
  ["name" => "レザーバッグ", "img" => "img/bag.jpg"],
  ["name" => "スニーカー", "img" => "img/shoes.jpg"],
  ["name" => "キャップ", "img" => "img/cap.jpg"],
  ["name" => "シャツ", "img" => "img/shirt.jpg"]
];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>お気に入り</title>
  <link rel="stylesheet" href="css/favorite.css">
</head>
<body>
  <!-- ナビゲーションバー -->
  <nav class="navigation-rail">
    <a href="main.php" class="nav-item">
      <img src="img/icon-3.svg" alt="メインページ">
      <span>メインページ</span>
    </a>
    <a href="mypage.php" class="nav-item">
      <img src="img/icon-8.svg" alt="マイページ">
      <span>マイページ</span>
    </a>
    <a href="cart.php" class="nav-item">
      <img src="img/icon-8.svg" alt="カート">
      <span>カート</span>
    </a>
    <a href="sell.php" class="nav-item">
      <img src="img/icon-8.svg" alt="出品">
      <span>出品</span>
    </a>
  </nav>

  <main class="content">
    <header class="app-bar">
      <div class="headline">お気に入り</div>
      <div class="trailing-icons">
        <img src="img/icon-2.svg" alt="検索">
        <img src="img/icon-7.svg" alt="設定">
      </div>
    </header>

    <section class="section">
      <div class="section-header">
        <div class="title">お気に入りアイテム</div>
      </div>

      <div class="items">
        <?php foreach ($favorites as $item): ?>
          <div class="item-card">
            <img src="<?php echo htmlspecialchars($item['img']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
            <p><?php echo htmlspecialchars($item['name']); ?></p>
            <button type="button" class="remove-btn" data-item-name="<?php echo htmlspecialchars($item['name']); ?>" data-action="remove_favorite.php">削除</button>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  </main>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      document.querySelectorAll(".remove-btn").forEach(button => {
        button.addEventListener("click", async e => {
          const card = e.target.closest(".item-card");
          const itemName = button.dataset.itemName;
          const action = button.dataset.action;

          if (!confirm("削除しますか？")) return;

          // 画面上から即削除
          card.remove();

          // サーバーにも削除リクエスト送信
          try {
            const formData = new FormData();
            formData.append("item_name", itemName);

            await fetch(action, {
              method: "POST",
              body: formData
            });
          } catch (err) {
            console.error("削除通信エラー:", err);
          }
        });
      });
    });
  </script>
</body>
</html>
