<?php
/**
 * PH35 サンプル3 マスターテーブル管理　Src12/12
 * 部門情報削除。
 *
 * @author Shinzo SAITO
 *
 * ファイル名=DeptDelete.php
 * フォルダ=/ph35/scottadmin/public/emp/
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

$deleteEmpId = $_POST["deleteEmpId"];
$assign = [];
$templatePath = "error.html";
$isRedirect = false;

if(Functions::loginCheck()){

    $validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。";
    $assign["validationMsgs"] = $validationMsgs;
    $templatePath  ="login.html";

}else{

    try{
        $db = new PDO(Conf::DB_DNS , Conf::DB_USERNAME , Conf::DB_PASSWORD);
        $empDAO = new EmpDAO($db);
    
        $result = $empDAO->delete($deleteEmpId);
        if(!$result){
            $assign["errorMsg"] = "情報削除に失敗しました。もう一度はじめからやり直してください。";
        }else{
            $isRedirect = true;
            $_SESSION["flashMsg"] = "従業員情報の削除が完了しました。";
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