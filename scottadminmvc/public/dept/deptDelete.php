<?php
/**
 * PH35 サンプル5 マスターテーブル管理MVC版　Src14/18
 * 部門情報削除処理。
 *
 * @author Shinzo SAITO
 *
 * ファイル名=deptDelete.php
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

$templatePath = "error.html";
$isRedirect = false;
$assign = [];

$deleteDeptId = $_POST["deleteDeptId"];

try{
    $db = new PDO(Conf::DB_DNS , Conf::DB_USERNAME , Conf::DB_PASSWORD);
    $deptDAO = new DeptDAO($db);
    $result = $deptDAO->delete($deleteDeptId);
    if($result){
        $isRedirect = true;
        $_SESSION["flashMsg"] = "部門ID" . $deleteDeptId . "の部門情報を削除しました。";
    }
    else{
        $assign["errorMsg"] = "情報削除に失敗しました。もう一度はじめからやり直してください。";
    }
}
catch(PDOException $ex){
    var_dump($ex);
    $assign["errorMsg"] = "DB接続に失敗しました。";
}
finally{
    $db = null;
}

if($isRedirect){
    header("Location: /ph35/scottadminmvc/public/dept/showDeptList.php");
}
else{
    $html = $twig->render($templatePath , $assign);
    print($html);
}
