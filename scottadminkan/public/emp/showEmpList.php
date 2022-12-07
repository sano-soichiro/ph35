<?php
/**
 * PH35 サンプル3 マスターテーブル管理　Src06/12
 *  部門情報リスト表示。
 * 
 * @author Shinzo SAITO
 *
 * ファイル名=showDeptList.php
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

$templatePath = "emp/empList.html";
$assign = [];

$empList = [];

if(Functions::loginCheck()){
    $validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。";
    $assign["validationMsgs"] = $validationMsgs;
    $templatePath = "login.html";
}else{
    if(isset($_SESSION["flashMsg"])){
        $assign["flashMsg"] = $_SESSION["flashMsg"];
        unset($_SESSION["flashMsg"]);
    }

    Functions::cleanSession();

    try{
        $db = new PDO(Conf::DB_DNS , Conf::DB_USERNAME , Conf::DB_PASSWORD);

        $empDAO = new EmpDAO($db);
        $empList = $empDAO->findAll();
        $assign["empList"] = $empList;
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

$html = $twig->render($templatePath , $assign);
print($html);

/* if(isset($_SESSION["errorMsg"])){
    header("Location: /ph35/scottadminkan/public/error.php");
    exit;
} */
?>

