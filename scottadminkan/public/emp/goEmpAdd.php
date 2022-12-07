<?php
/**
 *
 * @author Shinzo SAITO
 *
 * ファイル名=goDeptAdd.php
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

$templatePath = "emp/empAdd.html";
$assign = [];
if(Functions::loginCheck()){
    $validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。";
    $assign["validationMsgs"] = $validationMsgs;
    $templatePath  ="login.html";
}else{
    
    $empMgrList = null;
    
    /* $emp = new Emp();
    if(isset($_SESSION["emp"])){
        $emp = $_SESSION["emp"];
        $emp = unserialize($emp);
        unset($_SESSION["emp"]);
    }
    $assign["emp"] = $emp; */
    
    try{
        $db = new PDO(Conf::DB_DNS , Conf::DB_USERNAME , Conf::DB_PASSWORD);
    
        $empDAO = new EmpDAO($db);
        $empMgrList = $empDAO->findMgr();
        $assign["empMgrList"] = $empMgrList;
    
        $deptDAO = new DeptDAO($db);
        $deptList = $deptDAO->findAll();
        $assign["deptList"] = $deptList;
    }
    catch(PDOException $ex){
        var_dump($ex);
        $assign["errorMsg"] = "DB接続に失敗しました。";
        $templatePath = "error.html";
    }
    finally{
        $db = null;
    }
    
    /* $validationMsgs = null;
    if(isset($_SESSION["validationMsgs"])){
        $validationMsgs = $_SESSION["validationMsgs"];
        unset($_SESSION["validationMsgs"]);
    } */
}

$html = $twig->render($templatePath , $assign);
print($html);
?>

