<?php
/**
* PH35 Sample10 マスタテーブル管理完版 Src11/20
* ログイン処理。
*
* @author Shinzo SAITO
*
* ファイル名=login.php
* フォルダ=/ph35/scottadminkan/public/
*/
namespace LocalHalPH35\ScottAdminKan\exec;

require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadminkan/vendor/autoload.php");

use PDO;
use PDOException;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use LocalHalPH35\ScottAdminKan\Classes\Conf;
use LocalHalPH35\ScottAdminKan\Classes\dao\UserDAO;
use LocalHalPH35\ScottAdminKan\Classes\entity\User;

$loader = new FilesystemLoader($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadminkan/templates");
$twig = new Environment($loader);

$isRedirect = false;
$templatePath = "login.html";
$assign = [];

$loginId = $_POST["loginId"];
$loginPw = $_POST["loginPw"];
$loginId = trim($loginId);
$loginPw = trim($loginPw);

$validationMsgs = [];
try{
    $db = new PDO(Conf::DB_DNS, Conf::DB_USERNAME, Conf::DB_PASSWORD);
    $userDAO = new UserDAO($db);

    $user = $userDAO->findByLoginid($loginId);
    if($user == null){
        $validationMsgs[] = "存在しないIDです。正しいIDを入力してください。";
    }
    else{
        $userPw = $user->getPasswd();
        if(password_verify($loginPw, $userPw)){
            $id = $user->getId();
            $nameLast = $user->getNameLast();
            $nameFirst = $user->getNameFirst();

            $_SESSION["loginFlg"] = true;
            $_SESSION["id"] = $id;
            $_SESSION["name"] = $nameLast." ".$nameFirst;
            $_SESSION["auth"] = 1;
            $isRedirect = true;
        }
        else{
            $validationMsgs[] = "パスワードが違います。正しいパスワードを入力してください。";
        }
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
    header("Location: /ph35/scottadminkan/public/goTop.php");
    exit;
}
else{
    if(!isset($assign["errorMsg"])){
        $assign["validationMsgs"] = $validationMsgs;
        $assign["loginId"] = $loginId;
    }
    $html = $twig->render($templatePath, $assign);
    print($html);
}