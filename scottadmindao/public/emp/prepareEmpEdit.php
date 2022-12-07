<?php
/**
 *
 * @author Shinzo SAITO
 *
 * ファイル名=prepareEmpEdit.php
 * フォルダ=/ph35/scottadmin/public/emp/
 */
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmindao/classes/Conf.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmindao/classes/entity/Emp.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmindao/classes/entity/Dept.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmindao/classes/dao/EmpDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmindao/classes/dao/DeptDAO.php");

$emp = new Emp();
$empList = null;
$deptList = null;
$validationMsgs = null;
$empMgrList = null;

try{
    $db = new PDO(Conf::DB_DNS , Conf::DB_USERNAME , Conf::DB_PASSWORD);

    $empDAO = new EmpDAO($db);
    $empMgrList = $empDAO->findMgr();
    $deptDAO = new DeptDAO($db);
    $deptList = $deptDAO->findAll();
}
catch(PDOException $ex){
    var_dump($ex);
    $_SESSION["errorMsg"] = "DB接続に失敗しました。";
}
finally{
    $db = null;
}

if(isset($_POST["editEmpId"])){
    $editEmpId = $_POST["editEmpId"];
    try{
        $db = new PDO(Conf::DB_DNS , Conf::DB_USERNAME , Conf::DB_PASSWORD);

        $empDAO = new EmpDAO($db);
        $emp = $empDAO->findByPK($editEmpId);
        if(empty($emp)){
            $_SESSION["errorMsg"] = "部門情報の取得に失敗しました。";
        }

        $empMgrList = $empDAO->findMgr();

        $deptDAO = new DeptDAO($db);
        $deptList = $deptDAO->findAll();
    }
    catch(PDOException $ex){
        var_dump($ex);
        $_SESSION["errorMsg"] = "DB接続に失敗しました。";
    }
    finally{
        $db = null;
    }
    if(isset($_SESSION["errorMsg"])){
        header("Location: ph35/scottadmindao/public/error.php");
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
    <link rel="stylesheet" href="/ph35/scottadmindao/public/css/main.css" type="text/css">
</head>
<body>
    <h1>従業員情報編集</h1>
    <nav id="breadcrumbs">
        <ul>
            <li><a href="/ph35/scottadmindao/public/">TOP</a></li>
            <li><a href="/ph35/scottadmindao/public/emp/showEmpList.php">従業員リスト</a></li>
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
        <form action="/ph35/scottadmindao/public/emp/empEdit.php" method="post" class="box">
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
                上司&nbsp;<span class="required">必須</span>
                <select name="editEmpMgr" id="editEmpMgr" required>
                    <?php if($emp->getEmMgr() === 0){ ?>
                    <option value="0" selected>0：上司なし</option>
                    <?php }else{ ?>
                    <option value="0">0：上司なし</option>
                    <?php } ?>
                    <?php foreach($empMgrList as $key => $mgr){ ?>
                        <?php if($emp->getEmMgr() != 0 && $emp->getEmMgr() == $mgr[0]){ ?>
                    <option value="<?= $mgr[0] ?>" selected><?= $mgr[1] . "：" . $mgr[0] ?></option>
                        <?php }else{ ?>
                    <option value="<?= $mgr[0] ?>"><?= $mgr[1] . "：" . $mgr[0] ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </label><br>
            <label for="editEmpHiredate">
                雇用日&nbsp;<span class="required">必須</span>
                <select name="year" id="year" required>
                    <?php for($year = 2022;$year >= 1980; $year--){ ?>
                        <?php if(explode("-" , $emp->getEmHiredate())[0] == $year){?>
                    <option value="<?= $year ?>" selected><?= $year ?></option>
                        <?php }else{ ?>
                    <option value="<?= $year ?>"><?= $year ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <select name="month" id="month" required>
                    <?php for($month = 01;$month <= 12; $month++){ ?>
                        <?php if(explode("-" , $emp->getEmHiredate())[1] == $month){?>
                    <option value="<?= $month ?>" selected><?= $month ?></option>
                        <?php }else{ ?>
                    <option value="<?= $month ?>"><?= $month ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <select name="day" id="day" required>
                    <?php for($day = 01;$day <= 31; $day++){ ?>
                        <?php if(explode("-" , $emp->getEmHiredate())[2] == $day){?>
                    <option value="<?= $day ?>" selected><?= $day ?></option>
                        <?php }else{ ?>
                    <option value="<?= $day ?>"><?= $day ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </label><br>
            <label for="editEmpSal">
                給与&nbsp;<span class="required">必須</span>
                <input type="number" min=0 id="editEmpSal" name="editEmpSal" value="<?= $emp->getEmSal() ?>" required>
            </label><br>
            <label for="editDpId">
                所属部門&nbsp;<span class="required">必須</span>
                <select name="editDeptId" id="editDeptId" required>
                    <?php foreach($deptList as $id => $dept){ ?>
                        <?php if($emp->getDeptId ()== $dept->getId()){ ?>
                    <option value="<?= $dept->getId() ?>" selected><?= $dept->getDpNo() . "：" . $dept->getDpName() ?></option>
                        <?php }else{ ?>
                    <option value="<?= $dept->getId() ?>"><?= $dept->getDpNo() . "：" . $dept->getDpName() ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </label><br>
            <button type="submit">更新</button>
        </form>
    </section>
</body>
</html>