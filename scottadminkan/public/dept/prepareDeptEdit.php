<?php
/**
 * PH35 サンプル3 マスターテーブル管理完版　Src19/20
 * 部門情報編集画面表示処理。
 *
 * @author Shinzo SAITO
 *
 * ファイル名=preparedeptEdit.php
 * フォルダ=/ph35/scottadkan/public/dept/
 */
namespace LocalHalPH35\ScottAdminKan\exec\dept;

require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadminkan/vendor/autoload.php");

use PDO;
use PDOException;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use LocalHalPH35\ScottAdminKan\Classes\Conf;
use LocalHalPH35\ScottAdminKan\Classes\dao\DeptDAO;
use LocalHalPH35\ScottAdminKan\Classes\Functions;

$loader = new FilesystemLoader($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadminkan/templates");
$twig = new Environment($loader);

$templatePath = "dept/deptEdit.html";
$assign = [];
if(Functions::loginCheck()){
    $validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。";
    $assign["validationMsgs"] = $validationMsgs;
    $templatePath = "login.html";
}else{
    $editDeptId =$_POST["editDeptId"];
    try{
        $db = new PDO(Conf::DB_DNS , Conf::DB_USERNAME , Conf::DB_PASSWORD);
        $deptDAO = new DeptDAO($db);
        $dept = $deptDAO->findByPK($editDeptId);
        if(empty($dept)){
            $assign["errorMsg"] = "部門情報の取得に失敗しました。";
            $templatePath = "error.html";
        }
        else{
            $assign["dept"] = $dept;
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

$html = $twig->render($templatePath , $assign);
print($html);

