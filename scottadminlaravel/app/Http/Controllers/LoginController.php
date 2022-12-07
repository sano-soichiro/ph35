<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\DAO\UserDAO;
use App\Http\Controllers\Controller;

/**
 * ログイン・ログアウトに関するコントローラクラス。
 */
class LoginController extends Controller{
    /**
     * ログイン画面表示処理。
     */
    public function goLogin() {
        return view("login");
    }

    /**
     * ログイン処理。
     */
    public function login(Request $request) {
        $isReirect = false;
        $templatePath = "login";
        $assign = [];

        $loginId = $request->input("loginId");
        $loginPw = $request->input("loginPw");

        $validationMsgs = [];
        if(empty($validationMsgs)) {
            $db = DB::connection()->getPdo();
            $userDAO = new UserDAO($db);

            $user = $userDAO->findByLoginid($loginId);
            if($user == null) {
                $validationMsgs[] = "存在しないIDです。正しいIDを入力してください。";
            }
            else{
                $userPw = $user->getPasswd();
                if(password_verify($loginPw, $userPw)) {
                    $id = $user->getId();
                    $nameLast = $user->getNameLast();
                    $nameFirst = $user->getNameFirst();

                    $session = $request->session();
                    $session->put("loginFlg" , true);
                    $session->put("id" , $id);
                    $session->put("name" , $nameLast." ".$nameFirst);
                    $session->put("auth" , 1);
                    $isReirect = true;
                }
                else {
                    $validationMsgs[] = "パスワードが違います。正しいパスワードを入力してください。";
                }
            }
        }

        if($isReirect) {
            $response = redirect("/goTop");
        }
        else {
            if(!empty($validationMsgs)) {
                $assign["validationMsgs"] = $validationMsgs;
                $assign["loginId"] = $loginId;
            }
            $response = view("login" , $assign);
        }
        return $response;
    }

    /**
     * ログアウト処理。
     */
    public function logout(Request $request) {
        $session = $request->session();
        $session->flush();
        $session->regenerate();
        return redirect("/");
    }
}