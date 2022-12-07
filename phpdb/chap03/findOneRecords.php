<?php
/**
 * PH35 サンプル2 PHP DB Access Src09/14
 * Chap3-2 一行のデータ取得。
 *  *
 * @author Shinzo SAITO
 *  *
 * ファイル名=findOneRecords.php
 * フォルダ=.ph35/phpdb/chap03/
 */

$dsn = "mysql:host=localhost;dbname=ph35sql;charset=utf8";
$username = "ph35sqlusr";
$password = "hogehoge";
// $password = "bowbow";

$orderIdInput = 2376;
// $orderIdInput = 100000;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Shinzo SAITO">
    <title>PH35 サンプル2 | PHP DB Access | Ch3-2 一行のデータ取得</title>
</head>
<body>
    <h1>PHP DB Access: Chap3-2 一行のデータ取得</h1>
    <ul>
        <?php
            try{
                $db = new PDO($dsn , $username , $password);
                $db->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
                $db->setAttribute(PDO::ATTR_EMULATE_PREPARES , false);

                $sql = "SELECT * FROM orders WHERE order_id=:order_id";
                $stmt = $db->prepare($sql);
                $stmt->bindValue(":order_id" , $orderIdInput , PDO::PARAM_INT);
                $result = $stmt->execute();

                if($row = $stmt->fetch()){
                    $orderId = $row["order_id"];
                    $orderDate = $row["order_date"];
                    $orderMode = $row["order_mode"];
                    $customerId = $row["customer_id"];
                    $orderStatus = $row["order_status"];
                    $orderTotal = $row["order_total"];

                    $orderDateStr = date("Y年n月j日 H時i分s秒" , strtotime($orderDate));
                    $orderTotalStr = number_format($orderTotal , 2);
        ?>
        <li>注文ID: <?= $orderId ?></li>
        <li>注文日時: <?= $orderDateStr ?></li>
        <li>注文種類: <?= $orderMode ?></li>
        <li>顧客ID: <?= $customerId ?></li>
        <li>注文状況: <?= $orderStatus ?></li>
        <li>注文合計: $ <?= $orderTotalStr ?></li>
        <?php
                }
                else{
        ?>
        <li>該当データは存在しません。</li>
        <?php
                }
            }
            catch(PDOException $ex){
        ?>
        <li>DB接続に失敗しました。</li>
        <?php
            }
            finally{
                $db = null;
            }
        ?>
    </ul>
    <p>
        <a href="/ph35/phpdb/index.html">戻る</a>
    </p>
</body>
</html>