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
 
// $username = hash_hmac('sha512', $_GET['username'] , 'secret', false);
// $passward = hash_hmac('sha512', $_GET['passward'] , 'secret', false);
$username = $_POST['username'];
$password = $_POST['password'];
$hashedUsername = hash('sha256', $username);
$hashedPassword = hash('sha256', $password);

// データを認証する
$sql = "SELECT * FROM `User` WHERE `username` LIKE '" .$hashedUsername. "' AND `password` LIKE '" .$hashedPassword. "'";//クエリ
 
$result = $mysqli->query($sql);
//echo $result -> num_rows;
 
if (!$result -> num_rows) {
    echo '認証に失敗しました。'.mysqli_error();
}else{
    echo '認証に成功しました';
    header("location: index.html");
}
 
// 切断
$mysqli->close();
 
?>
