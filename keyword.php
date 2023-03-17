
<?php

// セッションをチェック
session_start();
if ($_SESSION['authenticated']) {
    //echo "<p>Welcome, " . $_SESSION['username'] . "!</p>";

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

$search = $_GET['search'];

// データを挿入する
$sql = "SELECT * FROM `SongList` WHERE `SongName` LIKE '" . $search . "'";
$result = $mysqli->query($sql);


// クエリの結果をチェックする
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        parse_str(parse_url($row['SongUrl'], PHP_URL_QUERY), $params);
        $id  = $params['v'];
        echo $id . "," . $row["SongPart"] . "," . $row["SongTempo"] . "," . $row["UserName"] . ",";
    }
} else {
    echo "0 results";
}

// 切断
$mysqli->close();

?>
