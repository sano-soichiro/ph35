<?php
/**
 * @author Soichiro SANO
 * 
 * ファイル名=execSQL1.php
 * フォルダ=.ph35/asgmt01/q1/
 */
require_once("salary.php");

$dsn = "mysql:host=localhost;dbname=ph35sql;charset=utf8";
$username = "ph35sqlusr";
$password = "hogehoge";

$setSalary = 10000;

$salaryList = [];
try{
    $db = new PDO($dsn , $username , $password);
    $db->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES , false);

    $sql = "SELECT employee_id , first_name , last_name , salary FROM employees WHERE salary >= :salary";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(":salary" , $setSalary , PDO::PARAM_INT);
    $result = $stmt->execute();

    while($row = $stmt->fetch()){
        $employeeId = $row["employee_id"];
        $firstName = $row["first_name"];
        $lastName = $row["last_name"];
        $salaryData = $row["salary"];

        $salary = new Salary();
        $salary->setEmployeeId($employeeId);
        $salary->setFirstName($firstName);
        $salary->setLastName($lastName);
        $salary->setSalary($salaryData);

        $salaryList[$employeeId] = $salary;
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
    <meta name="author" content="Soichiro SANO">
    <title>課題1 | PHP-DBの復習</title>
</head>
<body>
    <h1>PHP-DBの復習</h1>
    <h2>SELECT employee_id , first_name , last_name , salary FROM employees WHERE salary >= 10000;</h2>
    <table border="1">
        <thead>
            <tr>
                <th>顧客ID</th>
                <th>顧客名</th>
                <th>顧客姓</th>
                <th>給料</th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach($salaryList as $salaryId => $order){
        ?>
        <tr>
            <td><?= $order->getEmployeeId() ?></td>
            <td><?= $order->getFirstName() ?></td>
            <td><?= $order->getLastName() ?></td>
            <td><?= $order->getSalary() ?></td>
        </tr>
        <?php
            }
        ?>
        </tbody>
    </table>
</body>
</html>