<?php
/**
 * PH35 サンプル5 マスターテーブル管理完版　Src09/20
 * TOP画面表示処理。
 *
 * @author Shinzo SAITO
 *
 * ファイル名=index.php
 * フォルダ=/ph35/scottadminkan/public/
 */
use Slim\Factory\AppFactory;

require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadminslim/vendor/autoload.php");

$app = AppFactory::create();

require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadminslim/bootstrappers.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadminslim/routes.php");

$app->run();
