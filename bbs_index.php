<?php
session_start();
unset($_SESSION['user_id']);

/* ID生成 */
//IPアドレスを取得して変数にセットする
$ipAddress = $_SERVER["REMOTE_ADDR"];

//日付け取得
$day = date("(Y/m/d)");    

//合わせて暗号化
$userkid = md5($ipAddress.$day);

//頭から10までをIDとして扱う
$userid = substr($userkid, 0, 10);

$_SESSION['user_id'] = $userid;

$res_com = $_SESSION['res'];
//初期化
$_SESSION['res'] = "";

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>みんなの掲示板</title>
    </head>
    <script type="text/javascript">
    </script>
    <body>
        <h1>みんなの掲示板！</h1>
        <br /><strong>あなたのIDは<a href="search.php?id=<?php print($userid);?>"><?php print($userid);?></a>です。<br />(※日付が変わるとIDも変わります。その場合、前のIDでのコメントが削除できなくなります)</strong>
        <br />
        <form action="write_file.php" method="post"> 
        <br />名前<input type="text" name="name" value="名無しさん＠掲示板">
        <br />コメント
        <br /><textarea name="txt" cols="50" rows="7"><?php print($_SESSION['comment']); ?></textarea>
        <input type="hidden" name="wid" value="<?php print($userid);?>">
        <br /><input type="submit" value="書き込む！" style="width:130px; height: 30px"> 　　<input type="reset" value="リセットする！" style="width:130px; height: 30px"></form>
	</form>
        <p><b><?php print($res_com); ?></b></p>
        <hr />
        <h2>みんなの書き込み</h2>
        <?php
            $fp = fopen("bbs_log.txt", "r");  //rで読み込む
            /* 以下ファイルの中身チェック */
            $memotxt = file("bbs_log.txt");   //ファイルの中身を変数へ
            if($memotxt != NULL)
            {
                /* データがあればデータ数分繰り返して表示 */
                while ($line = fgets($fp))  //fgets・・・ファイルから1行分だけテキストを読み込む　その後変数へ代入
                {
                    print($line);
                    print("<br /><br />");
                }
            }
            else
            {
                /* データがないときの文表示 */
                print("<font color='#ff0000'>現在書込み情報がありません。</font><br>");
            }
            fclose($fp);    //ファイルを閉じる
        ?>
    </body>
</html>
