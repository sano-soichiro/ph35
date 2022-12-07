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
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmindao/classes/Conf.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmindao/classes/entity/Emp.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmindao/classes/dao/EmpDAO.php");

$editEmpId = $_POST["editEmpId"];
$editEmpNo = $_POST["editEmpNo"];
$editEmpName = $_POST["editEmpName"];
$editEmpJob = $_POST["editEmpJob"];
$editEmpMgr = $_POST["editEmpMgr"];
$editEmpHiredate = $_POST["year"] . "-" . $_POST["month"] . "-" . $_POST["day"];
$editEmpSal = $_POST["editEmpSal"];
$editDeptId = $_POST["editDeptId"];
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
$emp->setDeptId($editDeptId);

$validationMsgs = [];

if(empty($editEmpName)){
    $validationMsgs[] = "従業員名の入力は必須です。";
}
if(empty($editEmpJob)){
    $validationMsgs[] = "役職の入力は必須です。";
}
try{
    $db = new PDO(Conf::DB_DNS , Conf::DB_USERNAME , Conf::DB_PASSWORD);

    $empDAO = new EmpDAO($db);
    $empDB = $empDAO->findByEmpNo($editEmpNo);
    if(!empty($empDB) && $empDB->getId() != $editEmpId){
        $validationMsgs[] = "その部門番号はすでに使われています。別のものを指定してください。";
    }
    
    if(empty($validationMsgs)){
        $result = $empDAO->update($emp);
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
    header("Location: /ph35/scottadmindao/public/error.php");
    exit;
}
elseif(!empty($validationMsgs)){
    header("Location: /ph35/scottadmindao/public/emp/prepareEmpEdit.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Shinzo SAITO">
    <title>従業員情報編集完了 | ScottAdmin Sample</title>
    <link rel="stylesheet" href="/ph35/scottadmindao/public/css/main.css" type="text/css">
</head>
<body>
    <h1>従業員情報編集完了</h1>
    <nav id="breadcrumbs">
        <ul>
            <li><a href="/ph35/scottadmindao/"></a>TOP</li>
            <li><a href="/ph35/scottadmindao/public/emp/showEmpList.php">従業員リスト</a></li>
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
        <p>従業員リストに<a href="/ph35/scottadmindao/public/emp/showEmpList.php">戻る</a></p>
    </section>
</body>
</html>
