<?php
/**
* PH35 Sample10 マスタテーブル管理完版 Src13/20
* TOP画面表示処理。
*
* @author Shinzo SAITO
*
* ファイル名=goTop.php
* フォルダ=/ph35/scottadminkan/public/
*/
namespace LocalHalPH35\ScottAdminKan\exec;

require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadminkan/vendor/autoload.php");

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use LocalHalPH35\ScottAdminKan\Classes\Functions;

$loader = new FilesystemLoader($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadminkan/templates");
$twig = new Environment($loader);

$assign = [];
if(Functions::loginCheck()){
    $validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。";
    $assign["validationMsgs"] = $validationMsgs;
    $templatePath = "login.html";
}
else{
    Functions::cleanSession();
    $templatePath = "top.html";
}
$html = $twig->render($templatePath, $assign);
print($html);