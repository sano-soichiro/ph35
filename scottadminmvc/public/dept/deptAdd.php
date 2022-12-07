<?php
/**
 * PH35 サンプル5 マスターテーブル管理MVC版　Src01018
 * 部門情報登録。
 *
 * @author Shinzo SAITO
 *
 * ファイル名=deptAdd.php
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
use LocalHalPH35\ScottAdminMVC\Classes\entity\Dept;

$loader = new FilesystemLoader($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadminmvc/templates");
$twig = new Environment($loader);

$templatePath = "dept/deptAdd.html";
$isRedirect = false;
$assign = [];

$addDpNo = $_POST["addDpNo"];
$addDpName = $_POST["addDpName"];
$addDpLoc = $_POST["addDpLoc"];
$addDpName = str_replace(" " , " " , $addDpName);
$addDpLoc = str_replace(" " , " " , $addDpLoc);
$addDpName = trim($addDpName);
$addDpLoc = trim($addDpLoc);

$dept = new Dept();
$dept->setDpNo($addDpNo);
$dept->setDpName($addDpName);
$dept->setDpLoc($addDpLoc);

$validationMsgs = [];

if(empty($addDpName)){
    $validationMsgs = "部門名の入力は必須です。";
}

try{
    $db = new PDO(Conf::DB_DNS , Conf::DB_USERNAME , Conf::DB_PASSWORD);
    $deptDAO = new DeptDAO($db);
    $deptDB = $deptDAO->findByDpNo($dept->getDpNo());
    if(!empty($deptDB)){
        $validationMsgs[] = "その部門番号はすでに使われています。別のものを指定してください。";
    }
    if(empty($validationMsgs)){
        $dpId = $deptDAO->insert($dept);
        if($dpId === -1){
            $assign["errorMsg"] = "情報登録に失敗しました。もう一度はじめからやり直してください。";
            $templatePath = "error.html";
        }
        else{
            $isRedirect = true;
            $_SESSION["flashMsg"] = "部門ID" . $dpId . "で部門情報を登録しました。";
        }
    }
    else{
        $assign["dept"] = $dept;
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

if($isRedirect){
    header("Location: /ph35/scottadminmvc/public/dept/showDeptList.php");
}
else{
    $html = $twig->render($templatePath , $assign);
    print($html);
}
