<?php

//l=1:タイムアウト、l=2:ログインしてない
if (isset($_GET['l']) && $_GET['l'] == 1) {
    echo '<script>alert("セッションがタイムアウトしました。再びログインを行なってください");</script>';
}
if (isset($_GET['l']) && $_GET['l'] == 2) {
    echo '<script>alert("まずはログインまたは新規登録を行なってください");</script>';
}

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Bander</title>
    <style>
        h1 {
            text-align: center;
        }
    </style>
</head>

<body style="background-color: gray;">
    <div style="margin: 50px 0px 0px 50px;">
        <h1>Bander</h1>
    </div>
    <br>
    <p
        style="text-align: center; background-color: bisque; border-radius: 30px; margin: 0px 150px; padding: 100px 0px;">
        Banderはパートごとに演奏した動画をアップロードすることで、オンライン上でのセッションを可能にします。<br>
        アップロードされた動画を任意の数選び一つのボタンで同時再生ができるため、それらに合わせて演奏することができます。
    </p>
    <div style="text-align: center;">
        <button onclick="location.href='login.html'" id="Login"
            style="position: relative; top: 50px; background-color: bisque; border-radius: 10px; font-size: 30px">ログイン</button>
        <button onclick="location.href='register.html'" id="Register"
            style="position: relative; top: 50px; background-color: bisque; border-radius: 10px; font-size: 30px">新規会員登録</button>
    </div>
</body>

</html>