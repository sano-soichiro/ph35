<?php
/**
 * PH35 サンプル5 マスターテーブル管理MVC版　Src12/18
 * 部門情報編集処理。
 *
 * @author Shinzo SAITO
 *
 * ファイル名=deptEdit.php
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

$templatePath = "dept/deptEdit.html";
$isRedirect = false;
$assign = [];

$editDpId = $_POST["editDpId"];
$editDpNo = $_POST["editDpNo"];
$editDpName = $_POST["editDpName"];
$editDpLoc = $_POST["editDpLoc"];
$editDpName = str_replace(" " , " " , $editDpName);
$editDpLoc = str_replace(" " , " " , $editDpLoc);
$editDpName = trim($editDpName);
$editDpLoc = trim($editDpLoc);

$dept = new Dept();
$dept->setId($editDpId);
$dept->setDpNo($editDpNo);
$dept->setDpName($editDpName);
$dept->setDpLoc($editDpLoc);

$validationMsgs = [];

if(empty($editDpName)){
    $validationMsgs[] = "部門名の入力は必須です。";
}

try{
    $db = new PDO(Conf::DB_DNS , Conf::DB_USERNAME , Conf::DB_PASSWORD);
    $deptDAO = new DeptDAO($db);
    $deptDB = $deptDAO->findByDpNo($dept->getDpNo());
    if(!empty($deptDB) && $deptDB->getId() != $editDpId){
        $validationMsgs[] = "その部門番号はすでに使われています。別のものを指定してください。";
    }

    if(empty($validationMsgs)){
        $result = $deptDAO->update($dept);
        if($result){
            $isRedirect = true;
            $_SESSION["flashMsg"] = "部門ID" . $editDpId . "の部門情報を更新しました。";
        }
        else{
            $assign["errorMsg"] = "情報登録に失敗しました。もう一度はじめからやり直してください。";
            $templatePath = "error.html";
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
