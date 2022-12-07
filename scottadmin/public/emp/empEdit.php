<?php
/**
 * PH35 サンプル3 マスターテーブル管理　Src10/12
 * 部門情報編集。
 *
 * @author Shinzo SAITO
 *
 * ファイル名=deptEdit.php
 * フォルダ=/ph35/scottadmin/public/dept/
 */
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmin/classes/Conf.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmin/classes/entity/Emp.php");

$editEmpId = $_POST["editEmpId"];
$editEmpNo = $_POST["editEmpNo"];
$editEmpName = $_POST["editEmpName"];
$editEmpJob = $_POST["editEmpJob"];
$editEmpMgr = $_POST["editEmpMgr"];
$editEmpHiredate = $_POST["editEmpHiredate"];
$editEmpSal = $_POST["editEmpSal"];
$editDpId = $_POST["editDpId"];
$editEmpName = str_replace("　" , " " , $editEmpName);
$editEmpJob = str_replace("　" , " " , $editEmpJob);
$editEmpHiredate = str_replace("　" , " " , $editEmpHiredate);
$editEmpName = trim($editEmpName);
$editEmpJob = trim($editEmpJob);
$editEmpHiredate = trim($editEmpHiredate);

$emp = new Emp();
$emp->setId($editEmpId);
$emp->setEmNo($editEmpNo);
$emp->setEmName($editEmpName);
$emp->setEmJob($editEmpJob);
$emp->setEmMgr($editEmpMgr);
$emp->setEmHiredate($editEmpHiredate);
$emp->setEmSal($editEmpSal);
$emp->setDeptId($editDpId);

$validationMsgs = [];

if(empty($editEmpName)){
    $validationMsgs[] = "従業員名の入力は必須です。";
}
if(empty($editEmpJob)){
    $validationMsgs[] = "役職の入力は必須です。";
}
try{
    $db = new PDO(Conf::DB_DNS , Conf::DB_USERNAME , Conf::DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES , false);

    $sqlSelect = "SELECT id FROM emps WHERE em_no = :em_no";
    $sqlUpdate = "UPDATE emps SET em_no = :em_no , em_name = :em_name , em_job = :em_job , em_mgr = :em_mgr , em_hiredate = :em_hiredate , em_sal = :em_sal , dept_id = :dept_id WHERE id = :id";

    $stmt = $db->prepare($sqlSelect);
    $stmt->bindValue(":em_no" , $emp->getEmNo() , PDO::PARAM_INT);
    $result = $stmt->execute();
    $idInDB = 0;
    if($result && $row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $idInDB = $row["id"];
    }
    if($idInDB > 0 && $idInDB != $editEmpId){
        $validationMsgs[] = "その従業員番号はすでに使われています。別のものを指定してください。";
    }

    if(empty($validationMsgs)){
        $stmt = $db->prepare($sqlUpdate);
        $stmt->bindValue(":em_no" , $emp->getEmNo() , PDO::PARAM_INT);
        $stmt->bindValue(":em_name" , $emp->getEmName() , PDO::PARAM_STR);
        $stmt->bindValue(":em_job" , $emp->getEmJob() , PDO::PARAM_STR);
        $stmt->bindValue(":em_mgr" , $emp->getEmMgr() , PDO::PARAM_INT);
        $stmt->bindValue(":em_hiredate" , $emp->getEmHiredate() , PDO::PARAM_STR);
        $stmt->bindValue(":em_sal" , $emp->getEmSal() , PDO::PARAM_INT);
        $stmt->bindValue(":dept_id" , $emp->getDeptId() , PDO::PARAM_INT);
        $stmt->bindValue(":id" , $emp->getId() , PDO::PARAM_INT);
        $result = $stmt->execute();
        if(!$result){
            $_SESSION["errorMsg"] = "情報更新に失敗しました。もう一度はじめからやり直してください。";
        }
    }
    else{
        $_SESSION["emp"] = serialize($emp);
        $_SESSION["validationMsgs"] = $validationMsgs;
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
elseif(!empty($validationMsgs)){
    header("Location: /ph35/scottadmin/public/emp/prepareEmpEdit.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Shinzo SAITO">
    <title>従業員情報編集完了 | ScottAdmin Sample</title>
    <link rel="stylesheet" href="/ph35/scottadmin/public/css/main.css" type="text/css">
</head>
<body>
    <h1>従業員情報編集完了</h1>
    <nav id="breadcrumbs">
        <ul>
            <li><a href="/ph35/scottadmin/"></a>TOP</li>
            <li><a href="/ph35/scottadmin/public/emp/showEmpList.php">従業員リスト</a></li>
            <li>従業員情報編集</li>
            <li>従業員情報編集完了</li>
        </ul>
    </nav>
    <section>
        <p>以下の従業員情報を更新しました。</p>
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
        <p>従業員リストに<a href="/ph35/scottadmin/public/emp/showEmpList.php">戻る</a></p>
    </section>
</body>
</html>
