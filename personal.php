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

// 接続
$mysqli = new mysqli('localhost', 'root', 'root', 'music_data');
 
//接続状況の確認
if (mysqli_connect_errno()) {
    echo "データベース接続失敗" . PHP_EOL;
    echo "errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "error: " . mysqli_connect_error() . PHP_EOL;
    exit();
}

$hashedUserName = hash('sha256', $_SESSION['username']); 


// クエリを実行して結果を取得
$sql = "SELECT * FROM `SongList` WHERE `UserName` LIKE '" .$hashedUserName. "'";
$result = $mysqli->query($sql);


// 結果を表示
if (mysqli_num_rows($result) > 0) {
	while ($row = mysqli_fetch_assoc($result)) {
		echo $row['SongName'] . ', ' . $row['SongPart'] . ', ' . $row['SongTempo'] . ', ' . $row['SongUrl']. '<br>';
	}
} else {
	echo 'No results found.';
}

// 切断
$mysqli->close();

if (!empty($_SERVER['QUERY_STRING'])) {
    $url = strtok($_SERVER["REQUEST_URI"], '?');
    header("Location: $url");
    exit();
}


?>