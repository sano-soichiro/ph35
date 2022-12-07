<?php
/**
* PH35 Sample10 マスタテーブル管理完版 Src03/20
*
* @author Shinzo SAITO
*
* ファイル名=Functions.php
* フォルダ=/ph35/scottadminkan/classes/
*/
namespace LocalHalPH35\ScottAdminKan\Classes;

/**
* 共通処理が書かれたクラス。
*/
class Functions{
/**
* ログイン済かどうかをチェックする関数。
* セッションからログイン情報が見つからない場合はログアウト状態と判定する。
*
* @return boolean ログアウト状態の場合はtrue、ログイン状態の場合はfalse。
*/
    public static function loginCheck(): bool{
        $result = false;
        if(!isset($_SESSION["loginFlg"]) || $_SESSION["loginFlg"] == false || !isset($_SESSION["id"]) || !isset($_SESSION["name"]) || !isset($_SESSION["auth"])) {
            $result = true;
        }
        return $result;
    }

    /**
    * Session情報の掃除関数。
    * ログイン情報以外のセッション中の情報を一度破棄する。
    * 各ユースケース最初の実行phpでこの関数を実行する。
    */
    public static function cleanSession(): void{
        $loginFlg = $_SESSION["loginFlg"];
        $id = $_SESSION["id"];
        $name = $_SESSION["name"];
        $auth = $_SESSION["auth"];
        
        session_unset();
        
        $_SESSION["loginFlg"] = $loginFlg;
        $_SESSION["id"] = $id;
        $_SESSION["name"] = $name;
        $_SESSION["auth"] = $auth;
    }
}