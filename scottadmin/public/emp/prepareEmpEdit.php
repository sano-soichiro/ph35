<?php
/**
 *
 * @author Shinzo SAITO
 *
 * ファイル名=prepareEmpEdit.php
 * フォルダ=/ph35/scottadmin/public/emp/
 */
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmin/classes/Conf.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmin/classes/entity/Emp.php");

$emp = new Emp();
$validationMsgs = null;

if(isset($_POST["editEmpId"])){
    $editEmpId = $_POST["editEmpId"];
    try{
        $db = new PDO(Conf::DB_DNS , Conf::DB_USERNAME , Conf::DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES , false);

        $sql = "SELECT * FROM emps WHERE id = :id";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(":id" , $editEmpId , PDO::PARAM_INT);
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
        header("Location: ph35/scottadmin/public/error.php");
        exit;
    }
}
else{
    if(isset($_SESSION["emp"])){
        $emp = $_SESSION["emp"];
        $emp = unserialize($emp);
        unset($_SESSION["emp"]);
    }
    if(isset($_SESSION["validationMsgs"])){
        $validationMsgs = $_SESSION["validationMsgs"];
        unset($_SESSION["validationMsgs"]);
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Shinzo SAITO">
    <title>従業員情報編集 | ScottAdmin Sample</title>
    <link rel="stylesheet" href="/ph35/scottadmin/public/css/main.css" type="text/css">
</head>
<body>
    <h1>従業員情報編集</h1>
    <nav id="breadcrumbs">
        <ul>
            <li><a href="/ph35/scottadmin/public/">TOP</a></li>
            <li><a href="/ph35/scottadmin/public/emp/showEmpList.php">従業員リスト</a></li>
            <li>従業員情報編集</li>
        </ul>
    </nav>
    <?php
        if(!is_null($validationMsgs)){
    ?>
    <section id="errorMsg">
        <p>以下のメッセージをご確認ください。</p>
        <ul>
        <?php
            foreach($validationMsgs as $msg){
        ?>
            <li><?= $msg ?></li>
        <?php
            }
        ?>
        </ul>
    </section>
    <?php
        }
    ?>
    <section>
        <p>情報を入力し、更新ボタンをクリックしてください。</p>
        <form action="/ph35/scottadmin/public/emp/empEdit.php" method="post" class="box">
            従業員ID:&nbsp;<?= $emp->getId() ?><br>
            <input type="hidden" name="editEmpId" value="<?= $emp->getId() ?>">
            <label for="editEmpNo">
                従業員番号&nbsp;<span class="required">必須</span>
                <input type="number" min=1000 max=9999 id="editEmpNo" name="editEmpNo" value="<?= $emp->getEmNo() ?>" required>
            </label><br>
            <label for="editEmpName">
                従業員名&nbsp;<span class="required">必須</span>
                <input type="text" id="editEmpName" name="editEmpName" value="<?= $emp->getEmName() ?>" required>
            </label><br>
            <label for="editEmpJob">
                役職&nbsp;<span class="required">必須</span>
                <input type="text" id="editEmpJob" name="editEmpJob" value="<?= $emp->getEmJob() ?>" required>
            </label><br>
            <label for="editEmpMgr">
                上司番号&nbsp;<span class="required">必須</span>
                <input type="number" id="editEmpMgr" name="editEmpMgr" value="<?= $emp->getEmMgr() ?>" required>
            </label><br>
            <label for="editEmpHiredate">
                雇用日&nbsp;<span class="required">必須</span>
                <input type="text" id="editEmpHiredate" name="editEmpHiredate" value="<?= $emp->getEmHiredate() ?>" required>
            </label><br>
            <label for="editEmpSal">
                給与&nbsp;<span class="required">必須</span>
                <input type="number" min=0 id="editEmpSal" name="editEmpSal" value="<?= $emp->getEmSal() ?>" required>
            </label><br>
            <label for="editDpId">
                所属部門ID&nbsp;<span class="required">必須</span>
                <input type="text" id="editDpId" name="editDpId" value="<?= $emp->getDeptId() ?>" required>
            </label><br>
            <button type="submit">更新</button>
        </form>
    </section>
</body>
</html>