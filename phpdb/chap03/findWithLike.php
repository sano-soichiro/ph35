<?php
/**
 * PH35 サンプル2 PHP DB Access Src10/14
 * Chap3-3 LIKE検索。
 *  *
 * @author Shinzo SAITO
 *  *
 * ファイル名=findWithLike.php
 * フォルダ=.ph35/phpdb/chap03/
 */

$dsn = "mysql:host=localhost;dbname=ph35sql;charset=utf8";
$username = "ph35sqlusr";
$password = "hogehoge";

$keyword = "ar";
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Shinzo SAITO">
    <title>PH35 サンプル2 | PHP DB Access | Ch3-3 LIKE検索</title>
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
    <h1>PHP DB Access: Chap3-3 LIKE検索</h1>
    <table>
        <thead>
            <tr>
                <th>顧客ID</th>
                <th>顧客氏名</th>
            </tr>
        </thead>
        <tbody>
            <?php
                try{
                    $db = new PDO($dsn , $username , $password);
                    $db->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
                    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES , false);

                    $sql = "SELECT customer_id , cust_first_name , cust_last_name FROM customers WHERE cust_first_name LIKE :cust_first_name";
                    $stmt = $db->prepare($sql);
                    $stmt->bindValue(":cust_first_name" , "%".$keyword."%" , PDO::PARAM_STR);
                    $result = $stmt->execute();

                    while($row = $stmt->fetch()){
                        $customerId = $row["customer_id"];
                        $custFirstName = $row["cust_first_name"];
                        $custLastName = $row["cust_last_name"];
                        $fullname = $custFirstName." ".$custLastName;
            ?>
            <tr>
                <td><?= $customerId ?></td>
                <td><?= $fullname ?></td>
            </tr>
            <?php
                    }
                }
                catch(PDOException $ex){
                    print("DB接続に失敗しました。");
                }
                finally{
                    $db = null;
                }
            ?>
        </tbody>
    </table>
    <p>
        <a href="/ph35/phpdb/index.html">戻る</a>
    </p>
</body>
</html>