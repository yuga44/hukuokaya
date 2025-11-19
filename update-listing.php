<?php
require 'db-connect.php';
session_start();

// POSTデータ受け取り
$product_id = $_POST['product_id'] ?? '';
$product_name = $_POST['product_name'] ?? '';
$category = $_POST['category'] ?? '';
$price = $_POST['price'] ?? '';
$product_detail = $_POST['product_detail'] ?? '';
$member_id = $_SESSION['member_id'] ?? '';

if (!$product_id || !$product_name || !$category || !$price || !$product_detail) {
    exit('未入力の項目があります。');
}

// 画像アップロード処理（任意）
$image_path = null;
if (!empty($_FILES['image']['name'])) {
    $upload_dir = 'uploads/'; // ロリポップ上にこのフォルダを用意
    if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);

    $filename = uniqid() . '_' . basename($_FILES['image']['name']);
    $target = $upload_dir . $filename;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $image_path = $target; // 保存成功
    } else {
        exit('画像のアップロードに失敗しました。');
    }
}

try {
    if ($image_path) {
        // 画像あり更新
        $sql = "UPDATE listing_product 
                SET product_name = ?, category = ?, price = ?, product_detail = ?, image = ?, date = NOW()
                WHERE product_id = ? AND member_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$product_name, $category, $price, $product_detail, $image_path, $product_id, $member_id]);
    } else {
        // 画像なし更新
        $sql = "UPDATE listing_product 
                SET product_name = ?, category = ?, price = ?, product_detail = ?, date = NOW()
                WHERE product_id = ? AND member_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$product_name, $category, $price, $product_detail, $product_id, $member_id]);
    }

    header('Location: mainpage.php?msg=updated');
    exit;
} catch (PDOException $e) {
    exit('更新に失敗しました: ' . $e->getMessage());
}
?>
