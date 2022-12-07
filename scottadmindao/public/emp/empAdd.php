<?php
/**
 * PH35 サンプル3 マスターテーブル管理　Src08/12
 * 部門情報登録。
 *
 * @author Shinzo SAITO
 *
 * ファイル名=deptAdd.php
 * フォルダ=/ph35/scottadmin/public/dept/
 */
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmindao/classes/Conf.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmindao/classes/entity/Emp.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmindao/classes/dao/EmpDAO.php");

$addEmpNo = $_POST["addEmpNo"];
$addEmpName = $_POST["addEmpName"];
$addEmpJob = $_POST["addEmpJob"];
$addEmpMgr = $_POST["addEmpMgr"];
$addEmpHiredate = $_POST["year"] . "-" . $_POST["month"] . "-" . $_POST["day"];
$addEmpSal = $_POST["addEmpSal"];
$addDeptId = $_POST["addDeptId"];
$addEmpName = str_replace("　" , " " , $addEmpName);
$addEmpJob = str_replace("　" , " " , $addEmpJob);
$addEmpHiredate = str_replace("　" , " " , $addEmpHiredate);
$addEmpName = trim($addEmpName);
$addEmpJob = trim($addEmpJob);
$addEmpHiredate = trim($addEmpHiredate);

$emp = new Emp();
$emp->setEmNo($addEmpNo);
$emp->setEmName($addEmpName);
$emp->setEmJob($addEmpJob);
$emp->setEmMgr($addEmpMgr);
$emp->setEmHiredate($addEmpHiredate);
$emp->setEmSal($addEmpSal);
$emp->setDeptId($addDeptId);

$validationMsgs = [];

if(empty($addEmpName)){
    $validationMsgs[] = "従業員名の入力は必須です。";
}
if(empty($addEmpJob)){
    $validationMsgs[] = "役職の入力は必須です。";
}

try{
    $db = new PDO(Conf::DB_DNS , Conf::DB_USERNAME , Conf::DB_PASSWORD);
    $empDAO = new EmpDAO($db);
    $count = $empDAO->duplicate($emp->getEmNo());
    if($count > 0){
        $validationMsgs[] = "その従業員番号はすでに使われています。別のものを指定してください。";
    }

    if(empty($validationMsgs)){
        $empId = $empDAO->insert($emp);
        if($empId == -1){
            $_SESSION["errorMsg"] = "情報登録に失敗しました。もう一度はじめからやり直してください。";
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
    header("Location: /ph35/scottadmindao/public/emp/goEmpAdd.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Shinzo sAITO">
    <title>従業員情報追加完了 | ScottAdmin Sample</title>
    <link rel="stylesheet" href="/ph35/scottadmindao/public/css/main.css" type="text/css">
</head>
<body>
    <h1>従業員情報追加完了</h1>
    <nav id="breadcrumbs">
        <ul>
            <li><a href="/ph35/scottadmindao/">TOP</a></li>
            <li><a href="/ph35/scottadmindao/public/emp/showEmpList.php">従業員リスト</a></li>
            <li>従業員報報追加</li>
            <li>従業員情報追加完了</li>
        </ul>
    </nav>
    <section>
        <p>以下の従業員情報を登録しました。</p>
        <dl>
            <dt>ID(自動生成)</dt>
            <dd><?= $empId ?></dd>
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