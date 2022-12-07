<?php
/**
 * PH35 サンプル3 マスターテーブル管理　Src11/18
 * 部門情報編集画面表示処理。
 *
 * @author Shinzo SAITO
 *
 * ファイル名=preparedeptEdit.php
 * フォルダ=/ph35/scottadmvc/public/dept/
 */
namespace LocalHalPH35\ScottAdminMVC\exec\dept;

require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadminmvc/vendor/autoload.php");

use PDO;
use PDOException;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use LocalHalPH35\ScottAdminMVC\Classes\Conf;
use LocalHalPH35\ScottAdminMVC\Classes\dao\DeptDAO;

$loader = new FilesystemLoader($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadminmvc/templates");
$twig = new Environment($loader);

$templatePath = "dept/deptEdit.html";
$assign = [];

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

$html = $twig->render($templatePath , $assign);
print($html);

