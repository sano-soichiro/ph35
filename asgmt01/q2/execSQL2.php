<?php
/**
 * @author Soichiro SANO
 * 
 * ファイル名=execSQL1.php
 * フォルダ=.ph35/asgmt01/q1/
 */
require_once("department.php");

$dsn = "mysql:host=localhost;dbname=ph35sql;charset=utf8";
$username = "ph35sqlusr";
$password = "hogehoge";

$setSalesName = 'Sales';

$departmentList = [];
try{
    $db = new PDO($dsn , $username , $password);
    $db->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES , false);

    $sql = "SELECT * FROM departments WHERE department_name LIKE :salesName";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(":salesName" , '%' . $setSalesName . '%' , PDO::PARAM_STR);
    $result = $stmt->execute();

    while($row = $stmt->fetch()){
        $departmentId = $row["department_id"];
        $departmentName = $row["department_name"];
        $managerId = $row["manager_id"];
        $locationId = $row["location_id"];

        $department = new Department();
        $department->setDepartmentID($departmentId);
        $department->setDepartmentName($departmentName);
        $department->setManagerId($managerId);
        $department->setLocationId($locationId);

        $departmentList[$departmentId] = $department;
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
    <h2>SELECT * FROM departments WHERE department_name LIKE %Sales%;</h2>
    <table border="1">
        <thead>
            <tr>
                <th>部門ID</th>
                <th>部門名</th>
                <th>マネージャーID</th>
                <th>所在地ID</th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach($departmentList as $departmentId => $department){
        ?>
        <tr>
            <td><?= $department->getDepartmentID() ?></td>
            <td><?= $department->getDepartmentName() ?></td>
            <td><?= $department->getManagerId() ?></td>
            <td><?= $department->getLocationId() ?></td>
        </tr>
        <?php
            }
        ?>
        </tbody>
    </table>
</body>
</html>