<?php
/**
 * PH35 サンプル5 マスターテーブル管理DAO版　Src08/18
 *  部門情報リスト表示処理。
 * 
 * @author Shinzo SAITO
 *
 * ファイル名=showDeptList.php
 * フォルダ=/ph35/scottadminmvc/public/dept/
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

$templatePath = "dept/deptList.html";
$assign = [];

if(isset($_SESSION["flashMsg"])){
    $assign["flashMsg"] = $_SESSION["flashMsg"];
    unset($_SESSION["flashMsg"]);
}

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

$html = $twig->render($templatePath , $assign);
print($html);
