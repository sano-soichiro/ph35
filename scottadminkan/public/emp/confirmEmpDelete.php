<?php
/**
 * PH35 サンプル3 マスターテーブル管理　Src11/12
 * 部門情報削除確認画面表示。
 *
 * @author Shinzo SAITO
 *
 * ファイル名=confirmDeptDelete.php
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

$templatePath = "emp/empDelete.html";
$assign = [];

if(Functions::loginCheck()){

    $validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。";
    $assign["validationMsgs"] = $validationMsgs;
    $templatePath  ="login.html";

}else{

    $deleteEmpId = $_POST["deleteEmpId"];
    try{
        $db = new PDO(Conf::DB_DNS , Conf::DB_USERNAME , Conf::DB_PASSWORD);
        $empDAO = new EmpDAO($db);
        $emp = $empDAO->findByPK($deleteEmpId);
        $assign["emp"] = $emp;
    
        if(empty($emp)){
            $assign["errorMsg"] = "部門情報の取得に失敗しました。";
        }
    }
    catch(PDOException $ex){
        var_dump($ex);
        $assign["errorMsg"] = "DB接続に失敗しました。";
    }
    finally{
        $db = null;
    }

}
if(isset($assign["errorMsg"])){
    $templatePath = "error.html";
}

$html = $twig->render($templatePath , $assign);
print($html);

?>