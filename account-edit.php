<?php
require 'db-connect.php';
session_start();

// 未ログインなら止める
if (!isset($_SESSION['member_id'])) {
    exit("ログインしてください。");
}

$member_id = $_SESSION['member_id'];

// -------------------------
// ① 現在のユーザー情報を取得
// -------------------------
$sql = $pdo->prepare("SELECT * FROM member WHERE member_id = ?");
$sql->execute([$member_id]);
$user = $sql->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    exit("ユーザー情報が見つかりません。");
}

// -------------------------
// ② 更新処理（POST時）
// -------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name        = $_POST['name'] ?? '';
    $namekana    = $_POST['namekana'] ?? '';
    $mailaddress = $_POST['email'] ?? '';
    $tel         = $_POST['tel'] ?? '';
    $login_id    = $_POST['login_id'] ?? '';
    $password    = $_POST['password'] ?? '';
    $confirm_pw  = $_POST['password_confirm'] ?? '';
    $postalcode  = $_POST['postal'] ?? '';
    $address     = $_POST['address'] ?? '';

_    if (!empty($password) && $password !== $confirm_pw) {
        $error = "パスワードが一致しません。";
    } else {

        // ---------- ログインIDの重複チェック ----------
        $check = $pdo->prepare("SELECT 1 FROM member WHERE login_id = ? AND member_id != ?");
        $check->execute([$login_id, $member_id]);
        if ($check->fetch()) {
            $error = "このログインIDは既に使われています。";
        }

        // ---------- メールアドレスの重複チェック ----------
        if (empty($error)) {
            $check = $pdo->prepare("SELECT 1 FROM member WHERE mailaddress = ? AND member_id != ?");
            $check->execute([$mailaddress, $member_id]);
            if ($check->fetch()) {
                $error = "このメールアドレスは既に登録されています。";
            }
        }

        // ---------- 電話番号の重複チェック ----------
        if (empty($error)) {
            $check = $pdo->prepare("SELECT 1 FROM member WHERE tel = ? AND member_id != ?");
            $check->execute([$tel, $member_id]);
            if ($check->fetch()) {
                $error = "この電話番号は既に登録されています。";
            }
        }

        // ---------- 問題なければ UPDATE ----------
        if (empty($error)) {

            // SQL作成（パスワード入力時だけ更新）
            $sql_str = "
                UPDATE member
                SET name = ?, namekana = ?, postalcode = ?, address = ?,
                    mailaddress = ?, tel = ?, login_id = ?
            ";

            $params = [
                $name, $namekana, $postalcode, $address,
                $mailaddress, $tel, $login_id
            ];

            if (!empty($password)) {
                $sql_str .= ", password = ?";
                $params[] = $password;
            }

            $sql_str .= " WHERE member_id = ?";
            $params[] = $member_id;

            $update = $pdo->prepare($sql_str);
            $update->execute($params);

            header("Location: account-info.php?updated=1");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>会員情報編集</title>
<link rel="stylesheet" href="css/entry.css">
</head>
<body>

<button class="back"><a href="./mypage.php">←</a></button>
<div class="container">
    <h2>会員情報編集</h2>

    <?php if (!empty($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form action="" method="post">

        <div class="row">
            <div class="form-group">
                <label>名前</label>
                <input type="text" id="name" name="name"
                       value="<?= htmlspecialchars($user['name']) ?>" required>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <label>ふりがな</label>
                <input type="text" id="namekana" name="namekana"
                       value="<?= htmlspecialchars($user['namekana']) ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label>ログインID</label>
            <input type="text" id="login_id" name="login_id"
                   value="<?= htmlspecialchars($user['login_id']) ?>" required>
        </div>

        <div class="form-group">
            <label>メールアドレス</label>
            <input type="text" id="email" name="email"
                   value="<?= htmlspecialchars($user['mailaddress']) ?>" required>
        </div>

        <div class="form-group">
            <label>電話番号</label>
            <input type="tel" id="tel" name="tel"
                   value="<?= htmlspecialchars($user['tel']) ?>" required>
        </div>

        <div class="form-group">
            <label>パスワード（変更する場合のみ入力）</label>
            <input type="password" id="password" name="password">
        </div>

        <div class="form-group">
            <label>パスワード再確認</label>
            <input type="password" id="password_confirm" name="password_confirm">
        </div>

        <div class="form-group">
            <label>郵便番号</label>
            <input type="text" id="postal" name="postal"
                   value="<?= htmlspecialchars($user['postalcode']) ?>">
        </div>

        <div class="form-group">
            <label>住所</label>
            <input type="text" id="address" name="address"
                   value="<?= htmlspecialchars($user['address']) ?>">
        </div>

        <button type="submit">更新する</button>
    </form>
</div>

</body>
</html>
