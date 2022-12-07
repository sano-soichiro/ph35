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
namespace LocalHalPH35\ScottAdminKan\exec\emp;

require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadminkan/vendor/autoload.php");

use PDO;
use PDOException;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use LocalHalPH35\ScottAdminKan\Classes\Functions;
use LocalHalPH35\ScottAdminKan\Classes\entity\Emp;
use LocalHalPH35\ScottAdminKan\Classes\dao\EmpDAO;
use LocalHalPH35\ScottAdminKan\Classes\dao\DeptDAO;
use LocalHalPH35\ScottAdminKan\Classes\Conf;

use function PHPUnit\Framework\isNull;

$loader = new FilesystemLoader($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadminkan/templates");
$twig = new Environment($loader);

$validationMsgs = [];
$assign = [];
$templatePath = "emp/empEdit.html";
$isRedirect = false;

if(Functions::loginCheck()){

    $validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。";
    $assign["validationMsgs"] = $validationMsgs;
    $templatePath  ="login.html";

}else{

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

    if(is_null($_POST["year"]) || is_null($_POST["month"]) || is_null($_POST["day"])){
        $addEmpHiredate = null;
    }
    
    $emp = new Emp();
    $emp->setId($editEmpId);
    $emp->setEmNo($editEmpNo);
    $emp->setEmName($editEmpName);
    $emp->setEmJob($editEmpJob);
    $emp->setEmMgr($editEmpMgr);
    $emp->setEmHiredate($editEmpHiredate);
    $emp->setEmSal($editEmpSal);
    $emp->setDeptId($editDeptId);
    

    
    if(empty($editEmpName)){
        $validationMsgs[] = "従業員名の入力は必須です。";
    }
    if(empty($editEmpJob)){
        $validationMsgs[] = "役職の入力は必須です。";
    }
    try{
        $db = new PDO(Conf::DB_DNS , Conf::DB_USERNAME , Conf::DB_PASSWORD);
    
        $deptDAO = new DeptDAO($db);
        $deptList = $deptDAO->findAll();
        $assign["deptList"] = $deptList;
    
        $empDAO = new EmpDAO($db);
        $empDB = $empDAO->findByEmpNo($editEmpNo);
        if(!empty($empDB) && $empDB->getId() != $editEmpId){
            $validationMsgs[] = "その部門番号はすでに使われています。別のものを指定してください。";
        }
    
        $empMgrList = $empDAO->findMgr();
        $assign["empMgrList"] = $empMgrList;
        
        if(empty($validationMsgs)){
            $result = $empDAO->update($emp);
            if(!$result){
                $assign["errorMsg"] = "情報更新に失敗しました。もう一度はじめからやり直してください。";
            }else{
                $isRedirect = true;
                $_SESSION["flashMsg"] = "従業員情報の変更が完了しました。";
            }
        }
        else{
            $assign["emp"] = $emp;
            $assign["validationMsgs"] = $validationMsgs;
        }
    }
    catch(PDOException $ex){
        var_dump($ex);
        $assign["errorMsg"] = "DB接続に失敗しました。";
    }
    finally{
        $db = null;
    }
    
    if(isset($assign["errorMsg"])){
        $templatePath = "error.html";
    }
}

if($isRedirect){
    header("Location: ./showEmpList.php");
    exit;
}else{
    $html = $twig->render($templatePath , $assign);
    print($html);
}
?>