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

// クエリを実行して結果を取得
$sql = "SELECT musicname, COUNT(*) as count FROM music GROUP BY musicname ORDER BY count DESC LIMIT 1";
$result = $mysqli->query($sql);

// 結果を表示
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "最も多い件数のデータ名は " . $row["musicname"] . " で、件数は " . $row["count"] . " 件です。";
} else {
    echo "該当するデータがありません。";
}

// 接続を閉じる
$mysqli->close();

?>