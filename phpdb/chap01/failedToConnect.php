<?php
/**
 * PH35 サンプル2 PHP DB Access Src03/14
 * Chap1-2 DB接続失敗。
 *  *
 * @author Shinzo SAITO
 *  *
 * ファイル名=failedToConnect.php
 * フォルダ=.ph35/phpdb/chap01/
 */

$dsn = "mysql:host=localhost;dbname=ph35sql;charset=utf8";
$username = "ph35sqlusr";
$password = "bowbow"; //わざと間違ったパスワードにしてみる
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Shinzo SAITO">
    <title>PH35 サンプル2 | PHP DB Access | Ch1-2 DB接続失敗</title>
</head>
<body>
    <h1>PHP DB Access: Chap1-2 DB接続失敗</h1>
    <?php
        $db = new PDO($dsn , $username , $password);
        $db->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    ?>
    <p>DBに接続しました</p>
    <?php
        $db = null;
    ?>
    <p>DBを切断しました</p>
    <p>
        <a href="/ph35/phpdb/index.html">戻る</a>
    </p>
</body>
</html>