<?php
/**
 * PH35 サンプル5 マスターテーブル管理完版　Src17/20
 * 部門情報登録画面表示処理。
 *
 * @author Shinzo SAITO
 *
 * ファイル名=goDeptAdd.php
 * フォルダ=/ph35/scottadminkan/public/dept/
 */
namespace LocalHalPH35\ScottAdminKan\exec\dept;

require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadminkan/vendor/autoload.php");

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use LocalHalPH35\ScottAdminKan\Classes\Functions;

$loader = new FilesystemLoader($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadminkan/templates");
$twig = new Environment($loader);

$templatePath = "dept/deptAdd.html";
$assign = [];
if(Functions::loginCheck()){
    $validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。";
    $assign["validationMsgs"] = $validationMsgs;
    $templatePath  ="login.html";
}

$html = $twig->render($templatePath , $assign);
print($html);
