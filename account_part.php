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

if (!empty($_SERVER['QUERY_STRING'])) {
    $url = strtok($_SERVER["REQUEST_URI"], '?');
    header("Location: $url");
    exit();
}



?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>タイトルタブ</title>
    <style>
    </style>
    <script>
        //IFrame Player API の読み込み
        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        var ytPlayer = [];
        var ytData = [];

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

        $hashedUserName = hash('sha256', $_SESSION['username']);

        // クエリを実行して結果を取得
        $sql = "SELECT * FROM `SongList` WHERE `UserName` LIKE '" . $hashedUserName . "'";
        $result = $mysqli->query($sql);

        // PHPでURLが入った配列を生成する
        $urlArray = array();

        // 結果を配列に格納する
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($urlArray, $row["SongUrl"]);
            }
        } else {
            //echo "0 results";
        }

        // 切断
        $mysqli->close();

        // URLが入った配列からytDataを生成する
        for ($i = 0; $i < count($urlArray); $i++) {
            $videoId = explode("=", parse_url($urlArray[$i], PHP_URL_QUERY))[1];
            $area = $i + 1;
            echo "ytData.push({id: '$videoId', area: '$area'});";
        }
        ?>

        //YouTubeの埋め込みとdivの生成
        function onYouTubeIframeAPIReady() {
            var container = document.getElementById('player-container');
            for (var i = 0; i < ytData.length; i++) {
                // divの生成
                var div = document.createElement('div');
                div.id = ytData[i]['area'];
                div.style.position = 'relative';
                div.style.display = 'inline';
                div.style.marginLeft = '12px';
                container.appendChild(div);

                // YouTubeの埋め込み
                ytPlayer[i] = new YT.Player(ytData[i]['area'], {
                    width: 640,
                    height: 360,
                    videoId: ytData[i]['id'],
                    playerVars: {
                        rel: 0, //再生動画と同じチャンネルから関連動画を選択
                        modestbranding: 1 //YouTubeロゴを表示しない
                    }
                });
            }
        }
    </script>


</head>

<body style="background-color: gray;">
<section>
        <div id="upper-bar" style="background-color: blanchedalmond; padding: 10px 10px; border-radius: 10px; border-style:solid; border-color: red;">
            <button id="button" aria-pressed="false" style="font-size: 20px; border-radius: 5px;">
                三
            </button>
            <a href="/home.php">Bander</a>
            <a href="/account.php">
                <img class="account" src="account.png" style="width: 40px; height: 40px; display: block; float:right; position: relative;">
            </a>
            <!-- <a href="/.php">
                <img class="bell-mark" src="bell.png" style="width: 30px; height: 30px; display: block; float:right; position: relative; margin-right: 5px; margin-top: 5px;">
            </a> -->
            <a href="/upload.php">
                <img class="upload" src="upload.png" style="width: 45px; height: 45px; display: block; float:right; position: relative; margin-right: 6px;">
            </a>
        </div>
    </section>

    <div style="background-color: bisque; border-radius: 10px; margin: 50px 50px;">
        <section style="display: flex;">
            <img class="account" src="account.png" style="width: 150px; height: 150px; padding: 50px 50px;">
            <div style="display: inline-block; padding: 50px 0px; font-size: 25px;">
                <p><?php echo $_SESSION['username']; ?></p>
                <!-- <p>フォロワー:200</p> -->
            </div>
            <div style="margin: 0 0 0 auto; padding:  10px;">
                <button onclick="location.href='change.php';" id="change_name" style="width: 100%; height: 50px; font-size: 1.3em; margin-top: 70px; border-radius: 10px; display: block;">
                    名前変更
                </button>
                <button onclick="location.href='logout.php';" id="change_icon" style="width: 100%; height: 50px; font-size: 1.3em; margin-top: 10px; border-radius: 10px;">
                    ログアウト
                </button>
            </div>
        </section>
        <section>
            <div style="display: flex; justify-content: center; margin-bottom: 30px;">
                <!-- <button style="margin-left: auto;" onclick="location.href='account_part.php';">
                    パート動画
                </button> -->
                <!-- <button style="margin: 0 30px; " onclick="location.href='account_session.php';">
                    セッション動画
                </button>
                <button style="margin-right: auto; " onclick="location.href='account_follow.php';">
                    フォロー
                </button> -->
            </div>
        </section>

        <hr>

        <section style="margin-top: 50px;">
            <div id="player-container"></div>
        </section>
    </div>
</body>

</html>