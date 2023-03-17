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
        var ytData = [
            {
                id: 'ZRCdORJiUgU', //youtubeのID
                area: 'sample', //youtubeを表示する場所
            },
            {
                id: '6aFdEhEZQjE',
                area: 'sample2',
            }
        ];

        //YouTubeの埋め込み
        function onYouTubeIframeAPIReady() {
            for (var i = 0; i < ytData.length; i++) {
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
            <a href="/home.php">タイトル</a>
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
                <button onclick="location.href='change.php';" id="change_name"
                    style="width: 100%; height: 50px; font-size: 1.3em; margin-top: 70px; border-radius: 10px; display: block;">
                    名前変更
                </button>
                <button id="change_icon"
                    style="width: 100%; height: 50px; font-size: 1.3em; margin-top: 10px; border-radius: 10px;">
                    画像変更
                </button>
            </div>
        </section>
        <section>
            <div style="display: flex; margin-bottom: 30px;">
                <button style="margin-left: auto;" onclick="location.href='account_part.php';">
                    パート動画
                </button>
                <button style="margin: 0 30px; " onclick="location.href='account_session.php';">
                    セッション動画
                </button>
                <button style="margin-right: auto; " onclick="location.href='account_follow.php';">
                    フォロー
                </button>
            </div>
        </section>

        <hr>

        <section style="margin-top: 50px;">
            <div style="display: flex;">
                <img class="follow_account" src="account.png" style="width: 100px; height: 100px; padding: 50px 100px;">
                <div style="display: inline-block; padding: 50px 0px; font-size: 16px;">
                    <p>山田太郎</p>
                    <p>フォロワー:200</p>
                </div>
            </div>
            <div style="display: flex;">
                <img class="follow_account" src="account.png" style="width: 100px; height: 100px; padding: 50px 100px;">
                <div style="display: inline-block; padding: 50px 0px; font-size: 16px;">
                    <p>伊藤大樹</p>
                    <p>フォロワー:1</p>
                </div>
            </div>
            <div style="display: flex;">
                <img class="follow_account" src="account.png" style="width: 100px; height: 100px; padding: 50px 100px;">
                <div style="display: inline-block; padding: 50px 0px; font-size: 16px;">
                    <p>牧野遥斗</p>
                    <p>フォロワー:15000</p>
                </div>
            </div>
        </section>
    </div>
</body>

</html>