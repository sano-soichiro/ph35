<?php

namespace App;

use Illuminate\Http\Request;

/**
* 共通処理が書かれたクラス。
*/
class Functions{
    /**
    * ログイン済かどうかをチェックする関数。
    * セッションからログイン情報が見つからない場合はログアウト状態と判定する。
    *
    * @param Request $request リクエストオブジェクト
    * @return boolean ログアウト状態の場合はtrue、ログイン状態の場合はfalse。
    */
    public static function loginCheck(Request $request): bool{
        $result = false;
        $session = $request->session();
        if(!$session->has("loginFlg") || $session->get("loginFlg") == false || !$session->has("id") || !$session->has("name") || !$session->has("auth")) {
            $result = true;
        }
        return $result;
    }

    /**
    * ログインユーザー表示関数。
    * セッションからログイン情報が見つからない場合はログアウト状態と判定する。
    *
    * @param Request $request リクエストオブジェクト
    * @return array ログインユーザーの情報配列。
    */
    public static function loginUser(Request $request): array{
        $loginUser = null;
        $session = $request->session();
        $loginUser = $session->all();
        return $loginUser;
    }

}