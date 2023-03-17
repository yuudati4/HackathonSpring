<?php
// セッションをチェック
session_start();
if ($_SESSION['authenticated']) {
    echo "<p>Welcome, " . $_SESSION['username'] . "!</p>";

    // セッションが有効期限切れになったかどうかをチェック
    if (time() > $_SESSION['expire_time']) {
        // セッションを終了して、login.htmlにリダイレクト
        session_unset();
        session_destroy();
        header('Location: defult.php?l=1');
        exit();
    }
} else {
    // セッションが開始されていない場合、login.htmlにリダイレクト
    header('Location: defult.php?l=2');
    exit();
}
?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <title>Bander</title>
    <link rel="stylesheet" href="upload.css" type="text/css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
    </style>
</head>

<body style="background-color: gray;">
    <section>
    <div id="upper-bar" style="background-color: blanchedalmond; padding: 10px 10px; border-radius: 10px; border-style:solid; border-color: red;">
            <button id="button" aria-pressed="false" style="font-size: 20px; border-radius: 5px;">
                三
            </button>
            <a href="home.php">Bander</a>
            <a href="account.php">
                <img class="account" src="account.png" style="width: 40px; height: 40px; display: block; float:right; position: relative;">
            </a>
            <a href="/serch.html">
                <img class="bell-mark" src="bell.png" style="width: 30px; height: 30px; display: block; float:right; position: relative; margin-right: 5px; margin-top: 5px;">
            </a>
            <a href="upload.php">
                <img class="upload" src="upload.png" style="width: 45px; height: 45px; display: block; float:right; position: relative; margin-right: 6px;">
            </a>
        </div>
    </section>

    <div style="background-color: bisque; border-radius: 10px; margin: 50px 50px;">
        <hgroup>
            <br>
            <h1>アカウント名変更</h1>
            <!-- <h3>By Josh Adamous</h3> -->
        </hgroup>
        <form action="http://localhost/upload.php?" method="POST" onsubmit="return checkForm();">
            <div class="group">
                <input name="new_username" value="" /><span class="highlight"></span><span class="bar"></span>
                <label>新しい名前</label>
            </div>
            <div class="group">
                <input name="password" value="" /><span class="highlight"></span><span class="bar"></span>
                <label>パスワード（確認用）</label>
            </div>

            <button type="submit" onclick="hashFields()" class="button buttonBlue">Upload
                <div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>
            </button>
            <br>
        </form>
        <br>
    </div>
</body>

</html>

<script>
    function checkForm() {
        var username = document.getElementById('username').value;
        var password = document.getElementById('password').value;

        // ユーザー名が15文字以上の場合
        if (username.length > 15) {
            alert("ユーザー名は15文字以下で入力してください。");
            return false;
        }
        // パスワードが15文字以上の場合
        if (password.length > 15) {
            alert("パスワードは15文字以下で入力してください。");
            return false;
        }
        // ユーザー名に日本語が含まれている場合
        if (/[\u3000-\u30FF]/.test(username)) {
            alert("ユーザー名は半角英数字のみしか使用できません。");
            return false;
        }
        // パスワードに日本語が含まれている場合
        if (/[\u3000-\u30FF]/.test(password)) {
            alert("パスワードは半角英数字のみしか使用できません。");
            return false;
        }
        return true;
    }

    async function hashFields() {
        const encoder = new TextEncoder();
        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;
        const usernameData = encoder.encode(username);
        const passwordData = encoder.encode(password);
        const usernameHash = await crypto.subtle.digest("SHA-256", usernameData);
        const passwordHash = await crypto.subtle.digest("SHA-256", passwordData);
        const usernameHashArray = Array.from(new Uint8Array(usernameHash));
        const passwordHashArray = Array.from(new Uint8Array(passwordHash));
        const usernameHashHex = usernameHashArray.map(b => b.toString(16).padStart(2, '0')).join('');
        const passwordHashHex = passwordHashArray.map(b => b.toString(16).padStart(2, '0')).join('');
        document.getElementById("hash_username").value = usernameHashHex;
        document.getElementById("hash_password").value = passwordHashHex;
    }
</script>

<?php

// 接続
$mysqli = new mysqli('localhost', 'root', 'root', 'User authentication');

//接続状況の確認
if (mysqli_connect_errno()) {
    echo "データベース接続失敗" . PHP_EOL;
    echo "errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "error: " . mysqli_connect_error() . PHP_EOL;
    exit();
}


$UserName = $_SESSION['username'];
$New_UserName = $_POST[''];
$password = $_POST['password'];
$hashedPassword = hash('sha256', $password);

// データベース内のユーザー名とパスワードを検証する
$sql = "SELECT * FROM `User` WHERE `username` LIKE '" .$UserName. "' AND `password` LIKE '" .$hashedPassword."'";
$result = mysqli_query($mysqli, $sql);

if (mysqli_num_rows($result) == 1) {
  // ユーザー名を更新する
  $sql = "UPDATE `User` SET `username` = 'mutou' WHERE `User`.`username` = 'satou';'";
  mysqli_query($conn, $sql);
  echo "ユーザー名が更新されました。";
}else {
    echo "ユーザー名とパスワードが一致するユーザーはいません。";
}


// 切断
$mysqli->close();

?>