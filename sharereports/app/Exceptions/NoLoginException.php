<?php
/**
* PH35 Sample13 マスタテーブル管理ミドルウェア版 Src03/19
*
* @author Shinzo SAITO
*
* ファイル名=NoLoginException.php
* フォルダ=/scottadminmiddle/app/Exceptions/
*/
namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

/**
* 未ログイン状態を検知した時に発生させる例外クラス。
*/
class NoLoginException extends Exception {
    /**
    * 例外発生時に行う画面表示処理。
    *
    * @param Request $request リクエストオブジェクト。
    * @return レスポンスオブジェクト。
    */
    public function render(Request $request) {
        $validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。";
        $assign["validationMsgs"] = $validationMsgs;
        return view("login", $assign);
    }
}
