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
 
// $username = hash_hmac('sha512', $_POST['username'] , 'secret', false);
// $passward = hash_hmac('sha512', $_POST['passward'] , 'secret', false);
$username = $_POST['username'];
$password = $_POST['password'];
$hashedUsername = hash('sha256', $username);
$hashedPassword = hash('sha256', $password);


// データを挿入する
$sql = "INSERT INTO User (`username`, `password`) VALUES ('" .$hashedUsername. "', '" .$hashedPassword. "');";//クエリ
 
$result = $mysqli->query($sql);

if (!$result) {
    echo 'INSERTが失敗しました。'.mysqli_error();
}else{
    echo 'INSERTが成功しました';
}

if(isset($_POST['back'])) {
    header("location: login.html");
}
 
// 切断
$mysqli->close();
 
?>

<form action="login.php" method="post">
    <input type="submit" name="back" value="ホームに戻る" />
</form>