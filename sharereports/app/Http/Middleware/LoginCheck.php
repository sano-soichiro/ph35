<?php
/**
* PH35 Sample13 マスタテーブル管理ミドルウェア版 Src05/19
*
* @author Shinzo SAITO
*
* ファイル名=LoginCheck.php
* フォルダ=/scottadminmiddle/app/Http/Middleware/
*/

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Exceptions\NoLoginException;

/**
* ログインチェックミドルウェアクラス。
*/
class LoginCheck {
    /**
    * ログインチェック処理。
    * ログインされていない状態を検知したらNoLoginExceptionが発生する。
    *
    * @param Request $request リクエストオブジェクト。
    * @param Closure $next コールバック関数。
    * @return レスポンスオブジェクト。
    */
    public function handle(Request $request, Closure $next) {
        $session = $request->session();
        if(!$session->has("loginFlg") || $session->get("loginFlg") == false || !$session->has("id") || !$session->has("name") || !$session->has("auth")) {
            throw new NoLoginException();
        }
        $response = $next($request);
        return $response;
    }
}