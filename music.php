<?php

// // 接続
// $mysqli = new mysqli('localhost', 'root', 'root', 'User authentication');
 
// //接続状況の確認
// if (mysqli_connect_errno()) {
//     echo "データベース接続失敗" . PHP_EOL;
//     echo "errno: " . mysqli_connect_errno() . PHP_EOL;
//     echo "error: " . mysqli_connect_error() . PHP_EOL;
//     exit();
// }

// if (isset($_GET['n'])) {
//     $n = $_GET['n'];
//     unset($_GET['n']);
// } else {
//     $n = '';
// }
// if (isset($_GET['p'])) {
//     $p = $_GET['p'];
//     unset($_GET['p']);
// } else {
//     $p = '';
// }

// // データを認証する
// $sql = "SELECT * FROM `User` WHERE `username` LIKE '" .$n. "' AND `password` LIKE '" .$p. "'";//クエリ
 
// $result = $mysqli->query($sql);
// //echo $result -> num_rows;
 
// if (!$result -> num_rows) {
//     echo '認証に失敗しました。'.mysqli_error();

//     // 画面に表示するメッセージの設定
//     $message = 'ログインに失敗しました。';
//     header("Location: login.html");
    

// }else{
//     echo '認証に成功しました';

//     // セッションの開始
//     session_start();

//     // タイムアウト時間の設定（10秒）
//     $_SESSION['timeout'] = time() + 10;
    
//     // 画面に表示するメッセージの設定
//     $message = 'ログインに成功しました。';

// }

//     echo $message;


// // 切断
// $mysqli->close();

?>



<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
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
    
        <h1>HelloWorld!!</h1>
        <form action="http://localhost/music.php?" method="get">
        <p>アップロード</p>
        <p>曲名<input name="SongName" value="" /></p>
        <p>パート<input name="SongPart" value="" /></p>
        <p>テンポ<input name="SongTempo" value="" /></p>
        <p>URL<input name="SongUrl" value="" /></p>
        <p><input type="submit" name="submit" value="送信" /></p>
        </form>
        <br>
        <form action="search.php" method="get">
        <input type="text" name="search" placeholder="検索キーワードを入力してください">
        <button type="submit">検索</button>
        </form>
        <br>
        <button onclick="location.href='personal.php'">Personal Page</button>
    </body>
</html>

<?php

// 接続
$mysqli = new mysqli('localhost', 'root', 'root', 'music_data');
 
//接続状況の確認
if (mysqli_connect_errno()) {
    echo "データベース接続失敗" . PHP_EOL;
    echo "errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "error: " . mysqli_connect_error() . PHP_EOL;
    exit();
}
 

$SongName = $_GET['SongName'];
$SongPart = $_GET['SongPart'];
$SongTempo = $_GET['SongTempo'];
$SongUrl = $_GET['SongUrl'];
$hashedUserName = hash('sha256', $_SESSION['username']); 
$UserName = $_SESSION['username'];



// データを挿入する
$sql = "INSERT INTO `SongList` (`SongName`, `SongPart`, `SongTempo`, `SongUrl`, `UserName`) VALUES ('" .$SongName. "', '" .$SongPart. "', '" .$SongTempo. "', '" .$SongUrl. "', '" .$hashedUserName. "');";//クエリ
 
$result = $mysqli->query($sql);
 
if (!$result) {
   echo 'INSERTが失敗しました。'.mysqli_error();
}else{
   echo 'INSERTが成功しました。';
}

// クエリを実行して結果を取得
$sql = "SELECT SongName, COUNT(*) as count FROM SongList GROUP BY SongName ORDER BY count DESC LIMIT 10";
$result = $mysqli->query($sql);


// // 結果を表示
// if ($result->num_rows > 0) {
//     $row = $result->fetch_assoc();
//     echo "最も多い件数のデータ名は " . $row["musicname"] . " で、件数は " . $row["count"] . " 件です。";
// } else {
//     echo "該当するデータがありません。";
// }

echo "<br/>";
// 結果を表示
$n = 1;
while ($row = mysqli_fetch_assoc($result)) {
    echo $n . "位: " . $row["SongName"] . "(" . $row["count"] . "件）" . "<br>";
    $n += 1;
}

// 切断
$mysqli->close();

if (!empty($_SERVER['QUERY_STRING'])) {
    $url = strtok($_SERVER["REQUEST_URI"], '?');
    header("Location: $url");
    exit();
}


?>


