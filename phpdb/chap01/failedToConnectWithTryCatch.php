<?php
/**
 * PH35 サンプル2 PHP DB Access Src04/14
 * Chap1-3 DB接続失敗と例外処理。
 *  *
 * @author Shinzo SAITO
 *  *
 * ファイル名=failedToConnectWithTryCatch.php
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
    <title>PH35 サンプル2 | PHP DB Access | Ch1-3 DB接続失敗と例外処理</title>
</head>
<body>
    <h1>PHP DB Access: Chap1-3 DB接続失敗と例外処理</h1>
    <?php
        try{
            $db = new PDO($dsn , $username , $password);
            $db->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    ?>
    <p>DBに接続しました。</p>
    <?php
        }
        catch(PDOException $ex){
    ?>
    <p>DB接続に失敗しました。</p>
    <ul>
        <li>Code=<?= $ex->getCode() ?></li>
        <li>File=<?= $ex->getFile() ?></li>
        <li>Line=<?= $ex->getLine() ?></li>
        <li>Message=<?= $ex->getMessage() ?></li>
        <li>Trace=<?= $ex->getTraceAsString() ?></li>
    </ul>
    <?php
        }
        finally{
            $db = null;
    ?>
    <p>DB接続を切断しました。</p>
    <?php
        }
    ?>
    <p>
        <a href="/ph35/phpdb/index.html">戻る</a>
    </p>
</body>
</html>
