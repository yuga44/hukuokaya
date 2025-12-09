<?php
// ribbon.php（ナビゲーション + レイアウト枠）
echo '
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Bulma（レイアウト） -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">

<!-- Font Awesome（アイコン復活用） -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- 共通レイアウトCSS -->
<link rel="stylesheet" href="css/template.css">

<title>Market</title>
</head>

<body>

<div class="page-wrapper">

    <nav class="navigation-rail">

        <div class="nav-item">
            <a href="mainpage.php">
                <span class="icon"><i class="fa-solid fa-house"></i></span>
                <span>メイン</span>
            </a>
        </div>

        <div class="nav-item">
            <a href="mypage.php">
                <span class="icon"><i class="fa-solid fa-user"></i></span>
                <span>マイページ</span>
            </a>
        </div>

        <div class="nav-item">
            <a href="cart-list.php">
                <span class="icon"><i class="fa-solid fa-cart-shopping"></i></span>
                <span>カート</span>
            </a>
        </div>

        <div class="nav-item">
            <a href="listing.php">
                <span class="icon"><i class="fa-solid fa-pen-to-square"></i></span>
                <span>出品</span>
            </a>
        </div>

    </nav>

    <div class="page-content">
';
?>
