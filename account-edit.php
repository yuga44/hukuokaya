<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>アカウント編集</title>
<link rel="stylesheet" href="css/edit.css">
</head>
<body>

<div class="container">
    <h2>アカウント編集</h2>

    <form action="acount-info.php" method="post">
        <div class="row">
            <div class="form-group">
                <label for="sei">姓</label>
                <input type="text" id="sei" name="sei" required>
            </div>
            <div class="form-group">
                <label for="mei">名</label>
                <input type="text" id="mei" name="mei" required>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <label for="seikana">セイ</label>
                <input type="text" id="seikana" name="seikana" required>
            </div>
            <div class="form-group">
                <label for="meikana">メイ</label>
                <input type="text" id="meikana" name="meikana" required>
            </div>
        </div>
        <div class="form-group">
            <label for="email">メールアドレスまたは電話番号</label>
            <input type="text" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password">パスワード</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="password_confirm">パスワード再確認</label>
            <input type="password" id="password_confirm" name="password_confirm" required>
        </div>

        <div class="form-group">
            <label for="postal">郵便番号</label>
            <input type="text" id="postal" name="postal">
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" id="address" name="address">
        </div>

        <button type="submit">変更を保存</button>
    </form>
</div>

</body>
</html>
