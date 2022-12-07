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


$loader = new FilesystemLoader($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadminkan/templates");
$twig = new Environment($loader);

$validationMsgs = [];
$templatePath  = "emp/empAdd.html";
$isRedirect = false;

if(Functions::loginCheck()){

    $validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。";
    $assign["validationMsgs"] = $validationMsgs;
    $templatePath  ="login.html";

}else{

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

    if(is_null($_POST["year"]) || is_null($_POST["month"]) || is_null($_POST["day"])){
        $addEmpHiredate = null;
    }
    
    $emp = new Emp();
    $emp->setEmNo($addEmpNo);
    $emp->setEmName($addEmpName);
    $emp->setEmJob($addEmpJob);
    $emp->setEmMgr($addEmpMgr);
    $emp->setEmHiredate($addEmpHiredate);
    $emp->setEmSal($addEmpSal);
    $emp->setDeptId($addDeptId);
    

    
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
    
        $empMgrList = $empDAO->findMgr();
        $assign["empMgrList"] = $empMgrList;
    
        $deptDAO = new DeptDAO($db);
        $deptList = $deptDAO->findAll();
        $assign["deptList"] = $deptList;
    
        if($count > 0){
            $validationMsgs[] = "その従業員番号はすでに使われています。別のものを指定してください。";
        }
    
        if(empty($validationMsgs)){
            $empId = $empDAO->insert($emp);
            if($empId == -1){
                $assign["errorMsg"] = "情報登録に失敗しました。もう一度はじめからやり直してください。";
                $templatePath = "error.html";
            }else{
                $isRedirect = true;
                $_SESSION["flashMsg"] = "従業員情報の登録が完了しました。";
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
        $templatePath = "error.html";
    }
    finally{
        $db = null;
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
