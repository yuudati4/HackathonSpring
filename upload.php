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

<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <title>Bander</title>
    <link rel="stylesheet" href="upload.css" type="text/css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
    </style>
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
            <a href="/.php">
                <img class="bell-mark" src="bell.png" style="width: 30px; height: 30px; display: block; float:right; position: relative; margin-right: 5px; margin-top: 5px;">
            </a>
            <a href="/upload.php">
                <img class="upload" src="upload.png" style="width: 45px; height: 45px; display: block; float:right; position: relative; margin-right: 6px;">
            </a>
        </div>
    </section>

    <div style="background-color: bisque; border-radius: 10px; margin: 50px 50px;">
        <!-- <section style="display: flex;">
            <form method="post" action="namechange.php" onsubmit="return checkForm();">
                <h1>ユーザー名変更 <i class="material-icons help-icon" id="question-icon"></i></h1>
                <input type="text" placeholder="New_username" id="username" name="new_username">
                <input type="password" placeholder="Password" id="password" name="password">
                <input type="hidden" id="hash_username" name="hash_username">
                <input type="hidden" id="hash_password" name="hash_password">
                <button type="submit" onclick="hashFields()">Change_Request</button>
            </form>
        </section> -->

        <hgroup>
            <br>
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
            <br>
        </form>
        <br>
    </div>
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