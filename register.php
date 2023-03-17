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
 
$username = $_POST['username'];
$password = $_POST['password'];
$hashedUsername = hash('sha256', $username);
$hashedPassword = hash('sha256', $password);


// データを挿入する
$sql = "INSERT INTO `User` (`username`, `password`) VALUES ('" .$username. "', '" .$hashedPassword. "');";//クエリ
 
$result = $mysqli->query($sql);
 
if (!$result) {
    echo '登録に失敗しました。'.mysqli_error();
}else{
    echo '登録に成功しました';
    echo $username;
}

if(isset($_POST['back'])) {
    header("location: defult.php");
}
 
// 切断
$mysqli->close();
 
?>

<form action="register.php" method="post">
    <input type="submit" name="back" value="最初に戻る" />
</form>