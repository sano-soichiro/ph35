<?php
/**
 * PH35 サンプル3 マスターテーブル管理　Src11/12
 * 部門情報削除確認画面表示。
 *
 * @author Shinzo SAITO
 *
 * ファイル名=confirmDeptDelete.php
 * フォルダ=/ph35/scottadmin/public/dept/
 */
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmin/classes/Conf.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmin/classes/entity/Emp.php");

$deleteEmpId = $_POST["deleteEmpId"];

try{
    $db = new PDO(Conf::DB_DNS , Conf::DB_USERNAME , Conf::DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES , false);

    $sql = "SELECT * FROM emps WHERE id = :id";

    $stmt = $db->prepare($sql);
    $stmt->bindValue(":id" , $deleteEmpId , PDO::PARAM_INT);
    $result = $stmt->execute();
    if($result && $row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $id = $row["id"];
        $emNo = $row["em_no"];
        $emName = $row["em_name"];
        $emJob = $row["em_job"];
        $emMgr = $row["em_mgr"];
        $emHiredate = $row["em_hiredate"];
        $emSal = $row["em_sal"];
        $deptId = $row["dept_id"];

        $emp = new Emp();
        $emp->setId($id);
        $emp->setEmNo($emNo);
        $emp->setEmName($emName);
        $emp->setEmJob($emJob);
        $emp->setEmMgr($emMgr);
        $emp->setEmHiredate($emHiredate);
        $emp->setEmSal($emSal);
        $emp->setDeptId($deptId);
        $empList[$id] = $emp;
    }
    else{
        $_SESSION["errorMsg"] = "部門情報の取得に失敗しました。";
    }
}
catch(PDOException $ex){
    var_dump($ex);
    $_SESSION["errorMsg"] = "DB接続に失敗しました。";
}
finally{
    $db = null;
}
if(isset($_SESSION["errorMsg"])){
    header("Location: /ph35/scottadmin/public/error.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Shinzo SAITO">
    <title>従業員情報削除 | ScottAdmin Sample</title>
    <link rel="stylesheet" href="/ph35/scottadmin/public/css/main.css" type="text/css">
</head>
<body>
    <h1>従業員情報削除</h1>
    <nav id="breadcrumbs">
        <ul>
            <li><a href="/ph35/scottadmin/">TOP</a></li>
            <li><a href="/ph35/scottadmin/public/emp/showEmpList.php">従業員リスト</a></li>
            <li>従業員情報削除確認</li>
        </ul>
    </nav>
    <section>
        <p>以下の従業員情報を削除します。</p>
        <dl>
            <dt>従業員ID</dt>
            <dd><?= $emp->getId() ?></dd>
            <dt>従業員番号</dt>
            <dd><?= $emp->getEmNo() ?></dd>
            <dt>従業員名</dt>
            <dd><?= $emp->getEmName() ?></dd>
            <dt>役職</dt>
            <dd><?= $emp->getEmJob() ?></dd>
            <dt>上司番号</dt>
            <dd><?= $emp->getEmMgr() ?></dd>
            <dt>雇用日</dt>
            <dd><?= $emp->getEmHiredate() ?></dd>
            <dt>給与</dt>
            <dd><?= $emp->getEmSal() ?></dd>
            <dt>所属部門ID</dt>
            <dd><?= $emp->getDeptId() ?></dd>
        </dl>
        <form action="/ph35/scottadmin/public/emp/empDelete.php" method="post">
            <input type="hidden" id="deleteEmpId" name="deleteEmpId" value="<?= $emp->getId() ?>">
            <button type="submit">削除</button>
        </form>
    </section>
</body>
</html>
