<?php
/**
 * PH35 サンプル2 PHP DB Access Src06/14
 * Chap2-2 データ更新。
 *  *
 * @author Shinzo SAITO
 *  *
 * ファイル名=updateData.php
 * フォルダ=.ph35/phpdb/chap02/
 */

$dsn = "mysql:host=localhost;dbname=ph35sql;charset=utf8";
$username = "ph35sqlusr";
$password = "hogehoge";
try{
    $db = new PDO($dsn , $username , $password);
    $db->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES , false);

    $sql = "UPDATE orders SET sales_rep_id = :sales_rep_id , promotion_id = :promotion_id WHERE order_id = :order_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(":sales_rep_id" , 10 , PDO::PARAM_INT);
    $stmt->bindValue(":promotion_id" , 20 , PDO::PARAM_INT);
    $stmt->bindValue(":order_id" , 8000 , PDO::PARAM_INT);
    $result = $stmt->execute();
}
catch(PDOException $ex){
    print("DB接続に失敗しました。");
}
finally{
    $db = null;
}
if($result){
    $msg = "SQL文の実行が成功しました。";
}
else{
    $msg = "SQL文の実行が失敗しました。";
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Shinzo SAITO">
    <title>PH35 サンプル2 | PHP DB Access | Ch2-2 データ更新</title>
</head>
<body>
    <h1>PHP DB Access: Chap2-2 データ更新</h1>
    <p>
        結果: <?= $msg ?>
    </p>
    <p>
        <a href="/ph35/phpdb/index.html">戻る</a>
    </p>
</body>
</html>