<?php
/**
 * PH35 サンプル5 マスターテーブル管理MVC版　Src09/18
 * 部門情報登録画面表示処理。
 *
 * @author Shinzo SAITO
 *
 * ファイル名=goDeptAdd.php
 * フォルダ=/ph35/scottadminmvc/public/dept/
 */
namespace LocalHalPH35\ScottAdminMVC\exec\dept;

require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadminmvc/vendor/autoload.php");

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

$loader = new FilesystemLoader($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadminmvc/templates");
$twig = new Environment($loader);

$html = $twig->render("dept/deptAdd.html");
print($html);
