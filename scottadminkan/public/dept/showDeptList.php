<?php
/**
 * PH35 サンプル5 マスターテーブル管理完版　Src15/20
 *  部門情報リスト表示処理。
 * 
 * @author Shinzo SAITO
 *
 * ファイル名=showDeptList.php
 * フォルダ=/ph35/scottadminkan/public/dept/
 */
namespace LocalHalPH35\ScottAdminKan\exec\dept;

require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadminkan/vendor/autoload.php");

use PDO;
use PDOException;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use LocalHalPH35\ScottAdminKan\Classes\Conf;
use LocalHalPH35\ScottAdminKan\Classes\Functions;
use LocalHalPH35\ScottAdminKan\Classes\dao\DeptDAO;

$loader = new FilesystemLoader($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadminkan/templates");
$twig = new Environment($loader);

$templatePath = "dept/deptList.html";
$assign = [];

if(Functions::loginCheck()){
    $validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。";
    $assign["validationMsgs"] = $validationMsgs;
    $templatePath = "login.html";
}
else{
    if(isset($_SESSION["flashMsg"])){
        $assign["flashMsg"] = $_SESSION["flashMsg"];
        unset($_SESSION["flashMsg"]);
    }
    
    Functions::cleanSession();

    try{
        $db = new PDO(Conf::DB_DNS , Conf::DB_USERNAME , Conf::DB_PASSWORD);
        $deptDAO = new DeptDAO($db);
        $deptList = $deptDAO->findALL();
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
}

$html = $twig->render($templatePath , $assign);
print($html);
