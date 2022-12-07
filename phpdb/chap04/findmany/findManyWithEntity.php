<?php
/**
 * PH35 サンプル2 PHP DB Access Src12/14
 * Chap4-2 エンティティを使って複数行のデータ取得。
 *  *
 * @author Shinzo SAITO
 *  *
 * ファイル名=findManyWithEntity.php
 * フォルダ=.ph35/phpdb/findmany/
 */

require_once("order.php");

$dsn = "mysql:host=localhost;dbname=ph35sql;charset=utf8";
$username = "ph35sqlusr";
$password = "hogehoge";

$orderTotalInput = 100000;

$orderList = [];
try{
    $db = new PDO($dsn , $username , $password);
    $db->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES , false);

    $sql = "SELECT * FROM orders WHERE order_total >= :order_total";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(":order_total" , $orderTotalInput , PDO::PARAM_INT);
    $result = $stmt->execute();

    $rowCount = $stmt->rowCount();

    while($row = $stmt->fetch()){
        $orderId = $row["order_id"];
        $orderDate = $row["order_date"];
        $orderMode = $row["order_mode"];
        $customerId = $row["customer_id"];
        $orderStatus = $row["order_status"];
        $orderTotal = $row["order_total"];

        $order = new Order();
        $order->setOrderId($orderId);
        $order->setOrderDate($orderDate);
        $order->setOrderMode($orderMode);
        $order->setCustomerId($customerId);
        $order->setOrderStatus($orderStatus);
        $order->setOrderTotal($orderTotal);

        $orderList[$orderId] = $order;
    }
}
catch(PDOException $ex){
    print("DB接続に失敗しました。");
}
finally{
    $db = null;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Shinzo SAITO">
    <title>PH35 サンプル2 | PHP DB Access | Ch4-2 エンティティを使って複数行のデータ取得</title>
    <style type="text/css">
        table{
            border-collapse: collapse;
        }
        th , td{
            border: solid 1px black;
        }
    </style>
</head>
<body>
    <h1>PHP DB Access: Chap4-2 エンティティを使って複数行のデータ取得</h1>
    <?php
        if(empty($orderList)){
    ?>
    <p>
        該当データはありません。
    </p>
    <?php
        }
        else{
    ?>
    <p>
        全部で<?= $rowCount ?>件あります。
    </p>
    <table>
        <thead>
            <tr>
                <th>注文ID</th>
                <th>注文日時</th>
                <th>注文種類</th>
                <th>顧客ID</th>
                <th>注文状況</th>
                <th>注文合計</th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach($orderList as $orderId=>$order){
        ?>
        <tr>
            <td><?= $orderId ?></td>
            <td><?= $order->getOrderDateStr() ?></td>
            <td><?= $order->getorderMode() ?></td>
            <td><?= $order->getCustomerId() ?></td>
            <td><?= $order->getorderStatus() ?></td>
            <td>$<?= $order->getOrderTotalStr() ?></td>
        </tr>
        <?php
            }
        ?>
        </tbody>
    </table>
    <?php
        }
    ?>
    <p>
        <a href="/ph35/phpdb/index.html">戻る</a>
    </p>
</body>
</html>