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

//アップロードが成功したかのチェック
if (isset($_GET['s']) && $_GET['s'] == 1) {
    echo '<script>alert("アップロードが成功しました");</script>';
    // $url = strtok($_SERVER["REQUEST_URI"], '?');
    // header("Location: $url");
    // exit();

}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>ホーム画面</title>
    <style>
        .parent {
            display: flex;
        }

        .child {
            color: black;
            border: double;
            border-radius: 10px;
            border-color: gray;
            text-align: center;
            width: 300px;
            height: 200px;
            background-color: bisque;
            position: relative;
            margin: 100px auto;
            padding: auto;
            font-size: large;
            cursor: pointer;
        }

        .child:hover {
            background-color: lightblue;
        }
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
            <a href="/serch.html">
                <img class="bell-mark" src="bell.png" style="width: 30px; height: 30px; display: block; float:right; position: relative; margin-right: 5px; margin-top: 5px;">
            </a>
            <a href="/upload.php">
                    <img class="upload" src="upload.png" style="width: 45px; height: 45px; display: block; float:right; position: relative; margin-right: 6px;">
            </a>
        </div>
    </section>

    <section>
        <!-- <div id="search-bar">
            <form action="serch.php" method="get" id="searchform" align="center" style="position: relative; top: 50px">
                <input type="search" name="search" id="search" placeholder="検索" style="padding: 10px; width: 250px; font-size: 1.1em; height: 10px; border-radius: 5px;">
                <button type="submit" id="search-button" style="font-size: 20px; padding: 2px; border-radius: 5px;">
                    search
                </button>
            </form>
        </div> -->
    </section>

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
    $sql = "SELECT SongName, COUNT(*) as count FROM SongList GROUP BY SongName ORDER BY count DESC LIMIT 10";
    $result = $mysqli->query($sql);
    $n = 1;
    ?>

    <section>
        <div class="parent">
        <form action="keyword.php" method="GET">
                <div class="child" onclick="this.parentNode.submit();"> <!-- submit関数を追加 -->
                    <p>
                        <?php
                        // 結果の1位のレコードを取得
                        $row = $result->fetch_assoc();
                        $name = $row['SongName'];
                        $count = $row['count'];
                        echo "<p>第" . $n . "位" . "<br>" . "<br>" . "「" . $name . "」" . "<br>" . "<br>" . $count . "件</p>";
                        $n += 1;
                        ?>
                    </p>
                    </p>
                    <input type="hidden" name="search" value="<?php echo $name; ?>"> <!-- hidden inputフィールドを追加 -->
                </div>
            </form>
            <form action="keyword.php" method="GET">
                <div class="child" onclick="this.parentNode.submit();"> <!-- submit関数を追加 -->
                    <p>
                        <?php
                        // 2位を表示
                        $row = $result->fetch_assoc();
                        $name = $row['SongName'];
                        $count = $row['count'];
                        echo "<p>第" . $n . "位" . "<br>" . "<br>" . "「" . $name . "」" . "<br>" . "<br>" . $count . "件</p>";
                        $n += 1;
                        ?>
                    </p>
                    </p>
                    <input type="hidden" name="search" value="<?php echo $name; ?>"> <!-- hidden inputフィールドを追加 -->
                </div>
            </form>
            <form action="keyword.php" method="GET">
                <div class="child" onclick="this.parentNode.submit();"> <!-- submit関数を追加 -->
                    <p>
                        <?php
                        // 3位を表示
                        $row = $result->fetch_assoc();
                        $name = $row['SongName'];
                        $count = $row['count'];
                        echo "<p>第" . $n . "位" . "<br>" . "<br>" . "「" . $name . "」" . "<br>" . "<br>" . $count . "件</p>";
                        $n += 1;
                        ?>
                    </p>
                    </p>
                    <input type="hidden" name="search" value="<?php echo $name; ?>"> <!-- hidden inputフィールドを追加 -->
                </div>
            </form>
            <form action="keyword.php" method="GET">
                <div class="child" onclick="this.parentNode.submit();"> <!-- submit関数を追加 -->
                    <p>
                        <?php
                        // 4位を表示
                        $row = $result->fetch_assoc();
                        $name = $row['SongName'];
                        $count = $row['count'];
                        echo "<p>第" . $n . "位" . "<br>" . "<br>" . "「" . $name . "」" . "<br>" . "<br>" . $count . "件</p>";
                        $n += 1;
                        ?>
                    </p>
                    </p>
                    <input type="hidden" name="search" value="<?php echo $name; ?>"> <!-- hidden inputフィールドを追加 -->
                </div>
            </form>
            <form action="keyword.php" method="GET">
                <div class="child" onclick="this.parentNode.submit();"> <!-- submit関数を追加 -->
                    <p>
                        <?php
                        // 5位を表示
                        $row = $result->fetch_assoc();
                        $name = $row['SongName'];
                        $count = $row['count'];
                        echo "<p>第" . $n . "位" . "<br>" . "<br>" . "「" . $name . "」" . "<br>" . "<br>" . $count . "件</p>";
                        $n += 1;
                        ?>
                    </p>
                    </p>
                    <input type="hidden" name="search" value="<?php echo $name; ?>"> <!-- hidden inputフィールドを追加 -->
                </div>
            </form>
        </div>
    </section>
    <section>
        <div class="parent">
            <form action="keyword.php" method="GET">
                <div class="child" onclick="this.parentNode.submit();"> <!-- submit関数を追加 -->
                    <p>
                        <?php
                        // 6位を表示
                        $row = $result->fetch_assoc();
                        $name = $row['SongName'];
                        $count = $row['count'];
                        echo "<p>第" . $n . "位" . "<br>" . "<br>" . "「" . $name . "」" . "<br>" . "<br>" . $count . "件</p>";
                        $n += 1;
                        ?>
                    </p>
                    </p>
                    <input type="hidden" name="search" value="<?php echo $name; ?>"> <!-- hidden inputフィールドを追加 -->
                </div>
            </form>
            <form action="keyword.php" method="GET">
                <div class="child" onclick="this.parentNode.submit();"> <!-- submit関数を追加 -->
                    <p>
                        <?php
                        // 7位を表示
                        $row = $result->fetch_assoc();
                        $name = $row['SongName'];
                        $count = $row['count'];
                        echo "<p>第" . $n . "位" . "<br>" . "<br>" . "「" . $name . "」" . "<br>" . "<br>" . $count . "件</p>";
                        $n += 1;
                        ?>
                    </p>
                    </p>
                    <input type="hidden" name="search" value="<?php echo $name; ?>"> <!-- hidden inputフィールドを追加 -->
                </div>
            </form>
            <form action="keyword.php" method="GET">
                <div class="child" onclick="this.parentNode.submit();"> <!-- submit関数を追加 -->
                    <p>
                        <?php
                        // 8位を表示
                        $row = $result->fetch_assoc();
                        $name = $row['SongName'];
                        $count = $row['count'];
                        echo "<p>第" . $n . "位" . "<br>" . "<br>" . "「" . $name . "」" . "<br>" . "<br>" . $count . "件</p>";
                        $n += 1;
                        ?>
                    </p>
                    </p>
                    <input type="hidden" name="search" value="<?php echo $name; ?>"> <!-- hidden inputフィールドを追加 -->
                </div>
            </form>
            <form action="keyword.php" method="GET">
                <div class="child" onclick="this.parentNode.submit();"> <!-- submit関数を追加 -->
                    <p>
                        <?php
                        // 9位を表示
                        $row = $result->fetch_assoc();
                        $name = $row['SongName'];
                        $count = $row['count'];
                        echo "<p>第" . $n . "位" . "<br>" . "<br>" . "「" . $name . "」" . "<br>" . "<br>" . $count . "件</p>";
                        $n += 1;
                        ?>
                    </p>
                    </p>
                    <input type="hidden" name="search" value="<?php echo $name; ?>"> <!-- hidden inputフィールドを追加 -->
                </div>
            </form>
            <form action="keyword.php" method="GET">
                <div class="child" onclick="this.parentNode.submit();"> <!-- submit関数を追加 -->
                    <p>
                        <?php
                        // 10位を表示
                        $row = $result->fetch_assoc();
                        $name = $row['SongName'];
                        $count = $row['count'];
                        echo "<p>第" . $n . "位" . "<br>" . "<br>" . "「" . $name . "」" . "<br>" . "<br>" . $count . "件</p>";
                        $n += 1;
                        ?>
                    </p>
                    </p>
                    <input type="hidden" name="search" value="<?php echo $name; ?>"> <!-- hidden inputフィールドを追加 -->
                </div>
            </form>
        </div>
    </section>
</body>

</html>

<?php  // 切断 
$mysqli->close();
?>