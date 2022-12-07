<?php
/**
 * PH35 サンプル5 マスターテーブル管理MVC版　Src01/18
 * TOP画面表示処理。
 *
 * @author Shinzo SAITO
 *
 * ファイル名=index.php
 * フォルダ=/ph35/scottadminmvc/public/
 */
namespace LocalHalPH35\ScottAdminMVC\exec;

require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadminmvc/vendor/autoload.php");

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

$loader = new FilesystemLoader($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadminmvc/templates");
$twig = new Environment($loader);

$html = $twig->render("index.html");
print($html);

