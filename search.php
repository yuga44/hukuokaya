<?php
// 仮の商品データ（DBは使わない）
$items = [
  ['name' => '赤い帽子', 'category' => 'category'],
  ['name' => '青い帽子', 'category' => 'category'],
  ['name' => 'GUシャツ', 'category' => 'brand'],
  ['name' => 'ナイキスニーカー', 'category' => 'popular'],
  ['name' => '新作バッグ', 'category' => 'new'],
];

// パラメータ取得
$keyword = isset($_GET['q']) ? $_GET['q'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : 'category';

// フィルタリング処理（部分一致 + カテゴリ一致）
$results = array_filter($items, function($item) use ($keyword, $category) {
  $matchCategory = ($item['category'] === $category);
  $matchKeyword = ($keyword === '' || mb_strpos($item['name'], $keyword) !== false);
  return $matchCategory && $matchKeyword;
});
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>検索ページ</title>
  <link rel="stylesheet" href="css/search.css">
  <link rel="stylesheet" href="css/template.css">
</head>
<body>

  <nav class="navigation-rail">
    <div class="nav-item">
      <img src="img/icon-3.svg" alt="メインページ" />
      <span>メインページ</span>
    </div>
    <div class="nav-item">
      <img src="img/icon-8.svg" alt="マイページ" />
      <span>マイページ</span>
    </div>
    <div class="nav-item">
      <img src="img/icon-8.svg" alt="カート" />
      <span>カート</span>
    </div>
    <div class="nav-item">
      <img src="img/icon-8.svg" alt="出品" />
      <span>出品</span>
    </div>
  </nav>

  <h1>検索ページ</h1>

  <!-- 検索フォーム -->
  <form method="GET" action="">
    <div>
      <input type="search" name="q" placeholder="キーワードを入力..." value="<?= htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8') ?>">
      <input type="hidden" name="category" value="<?= htmlspecialchars($category, ENT_QUOTES, 'UTF-8') ?>">
      <button type="submit">検索</button>
    </div>
  </form>

  <hr>

  <!-- メニュー -->
  <div class="menu-buttons">
    <form method="GET" action="">
      <input type="hidden" name="q" value="<?= htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8') ?>">
      <button name="category" value="category">カテゴリ</button>
      <button name="category" value="brand">ブランド</button>
      <button name="category" value="new">新着順</button>
      <button name="category" value="popular">人気順</button>
    </form>
  </div>

  <hr>

  <!-- 結果表示 -->
  <div id="<?= htmlspecialchars($category, ENT_QUOTES, 'UTF-8') ?>">
    <h2><?= htmlspecialchars($category, ENT_QUOTES, 'UTF-8') ?></h2>

    <?php if (empty($results)): ?>
      <p>該当する商品が見つかりませんでした。</p>
    <?php else: ?>
      <?php foreach ($results as $item): ?>
        <div class="item-card">
          <img src="img/icon-10.svg" alt="">
          <?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

</body>
</html>
