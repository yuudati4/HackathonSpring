<?php

session_start();
 
// 接続
$mysqli = new mysqli('localhost', 'root', 'root', 'User authentication');
 
//接続状況の確認
if (mysqli_connect_errno()) {
    echo "データベース接続失敗" . PHP_EOL;
    echo "errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "error: " . mysqli_connect_error() . PHP_EOL;
    exit();
}
 
// $username = hash_hmac('sha512', $_GET['username'] , 'secret', false);
// $passward = hash_hmac('sha512', $_GET['passward'] , 'secret', false);
$username = $_POST['username'];
$password = $_POST['password'];
$hashedUsername = hash('sha256', $username);
$hashedPassword = hash('sha256', $password);

// データを認証する
$sql = "SELECT * FROM `User` WHERE `username` LIKE '" .$username. "' AND `password` LIKE '" .$hashedPassword. "'";//クエリ
 
$result = $mysqli->query($sql);
//echo $result -> num_rows;
 
if (!$result -> num_rows) {
    echo '認証に失敗しました。'.mysqli_error();
}else{
    echo '認証に成功しました';

    // パスワードが正しい場合、セッションを開始
    $_SESSION['authenticated'] = true;
    $_SESSION['username'] = $username;
    
    // 10秒後にセッションを終了するためにタイマーを設定
    $_SESSION['expire_time'] = time() + 3600;
    
    // index.htmlにリダイレクト
    header('Location: home.php');
    exit();
    //header("location: music.php?n=" .$hashedUsername. "&p=" .$hashedPassword. "");
}

if(isset($_POST['back'])) {
    header("location: defult.php");
}
 
// 切断
$mysqli->close();
 
?>

<form action="login.php" method="post">
    <input type="submit" name="back" value="最初に戻る" />
</form>
