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

//itoo先輩に渡す時に使うよう
// $mysqli = new mysqli('localhost', 'admin', 'password', 'music_data');

//接続状況の確認
if (mysqli_connect_errno()) {
    echo "データベース接続失敗" . PHP_EOL;
    echo "errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "error: " . mysqli_connect_error() . PHP_EOL;
    exit();
}

$SongName = $_GET['SongName'];
$SongPart = $_GET['SongPart'];

// データを挿入する
$sql = "SELECT * FROM `SongList` WHERE `SongName` LIKE '" .$SongName. "' AND `SongPart` LIKE '" .$SongPart. "'";
$result = $mysqli->query($sql);


// クエリの結果をチェックする
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Tempo: " .$row['SongTempo'] . ", URL: " . $row['SongUrl'] . "<br>";
        echo "<form action='show_video.php' method='GET'>";
        echo "<input type='hidden' name='SongName' value='" . $row['SongName'] . "'/>";
        echo "<input type='hidden' name='SongPart' value='" . $row["SongPart"] . "'/>";
        echo "<input type='hidden' name='SongTempo' value='" . $row["SongTempo"] . "'/>";
        echo "<input type='hidden' name='SongUrl' value='" . $row["SongUrl"] . "'/>";
        echo "<input type='hidden' name='UzerName' value='" . $row["UserName"] . "'/>";
        echo "<button type='submit'>ボタン</button>";
        echo "</form><br>";
    }
} else {
    echo "0 results";
}

// 切断
$mysqli->close();

?>
