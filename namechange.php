<?php

// セッションをチェック
session_start();
if ($_SESSION['authenticated']) {
    echo "<p>Welcome, " . $_SESSION['new_username'] . "!</p>";

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



$new_username = $_POST['new_username'];
$password = $_POST['password'];
$hashedUsername = hash('sha256', $new_username);
$hashedPassword = hash('sha256', $password);

echo $_POST['new_username'];

// 接続
$mysqli = new mysqli('localhost', 'root', 'root', 'User authentication');

//接続状況の確認
if (mysqli_connect_errno()) {
    echo "データベース接続失敗" . PHP_EOL;
    echo "errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "error: " . mysqli_connect_error() . PHP_EOL;
    exit();
}

// データベースを更新する
$sql = "UPDATE User SET username='$new_username' WHERE password='$password'";

$result = $mysqli->query($sql);

if ($result) {
    echo "Username updated successfully";
    $_SESSION['username'] = $new_username;
} else {
    echo "Error updating username: " . $conn->error;
}

// データベース接続を閉じる
$conn->close();
?>