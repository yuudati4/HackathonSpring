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
        header('Location: defult.html');
        exit();
    }
} else {
    // セッションが開始されていない場合、login.htmlにリダイレクト
    header('Location: defult.html');
    exit();
}
?>



<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="upload.css" type="text/css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>

<body>
    <hgroup>
        <h1>楽曲アップロードページ</h1>
        <!-- <h3>By Josh Adamous</h3> -->
    </hgroup>
    <form action="http://localhost/upload.php?" method="get">
        <div class="group">
        <input name="SongName" value="" /><span class="highlight"></span><span class="bar"></span>
            <label>曲名</label>
        </div>
        <div class="group">
        <input name="SongPart" value="" /><span class="highlight"></span><span class="bar"></span>
            <label>演奏パート</label>
        </div>
        <div class="group">
        <input name="SongTempo" value="" /><span class="highlight"></span><span class="bar"></span>
            <label>設定テンポ</label>
        </div>
        <div class="group">
        <input name="SongUrl" value="" /><span class="highlight"></span><span class="bar"></span>
            <label>Url</label>
        </div>
        <button type="submit" class="button buttonBlue">Upload
            <div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>
        </button>
    </form>
    <footer><a href="http://www.polymer-project.org/" target="_blank"><img src="https://www.polymer-project.org/images/logos/p-logo.svg"></a>
        <p>You Gotta Love <a href="http://www.polymer-project.org/" target="_blank">Google</a></p>
    </footer>
</body>

</html>

<script>
    $(window, document, undefined).ready(function() {

        $('input').blur(function() {
            var $this = $(this);
            if ($this.val())
                $this.addClass('used');
            else
                $this.removeClass('used');
        });

        var $ripples = $('.ripples');

        $ripples.on('click.Ripples', function(e) {

            var $this = $(this);
            var $offset = $this.parent().offset();
            var $circle = $this.find('.ripplesCircle');

            var x = e.pageX - $offset.left;
            var y = e.pageY - $offset.top;

            $circle.css({
                top: y + 'px',
                left: x + 'px'
            });

            $this.addClass('is-active');

        });

        $ripples.on('animationend webkitAnimationEnd mozAnimationEnd oanimationend MSAnimationEnd', function(e) {
            $(this).removeClass('is-active');
        });

    });
</script>



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
$sql = "INSERT INTO `SongList` (`SongName`, `SongPart`, `SongTempo`, `SongUrl`, `UserName`) VALUES ('" . $SongName . "', '" . $SongPart . "', '" . $SongTempo . "', '" . $SongUrl . "', '" . $UserName . "');"; //クエリ

$result = $mysqli->query($sql);

if (!$result) {
    //echo 'INSERTが失敗しました。' . mysqli_error();
} else {
    //echo 'INSERTが成功しました。';
    header("Location: home.php?s=1");
}

// 切断
$mysqli->close();

// if (!empty($_SERVER['QUERY_STRING'])) {
//     $url = strtok($_SERVER["REQUEST_URI"], '?');
//     header("Location: $url");
//     exit();
// }

?>