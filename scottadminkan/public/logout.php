<?php
/**
* PH35 Sample10 マスタテーブル管理完版 Src12/20
* ログアウト処理。
*
* @author Shinzo SAITO
*
* ファイル名=logout.php
* フォルダ=/ph35/scottadminkan/public/
*/
namespace LocalHalPH35\ScottAdminKan\exec;

require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadminkan/vendor/autoload.php");

session_destroy();

header("Location: /ph35/scottadminkan/public/index.php");
exit;