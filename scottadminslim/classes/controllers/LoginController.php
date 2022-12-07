<?php
/**
* PH35 Sample14 マスタテーブル管理Slim版 Src16
*
* @author Shinzo SAITO
*
* ファイル名=LoginController.php
* フォルダ=/ph35/scottadminslim/classes/controllers/
*/
namespace LocalHalPH35\ScottAdminSlim\Classes\controllers;

use PDO;
use PDOException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use LocalHalPH35\ScottAdminSlim\Classes\Conf;
use LocalHalPH35\ScottAdminSlim\Classes\exceptions\DataAccessException;
use LocalHalPH35\ScottAdminSlim\Classes\daos\UserDAO;
use LocalHalPH35\ScottAdminSlim\Classes\entities\User;
use LocalHalPH35\ScottAdminSlim\Classes\controllers\ParentController;

/**
* ログイン・ログアウトに関するコントローラクラス。
*/
class LoginController extends ParentController {
    /**
    * ログイン画面表示処理。
    */
    public function goLogin(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $returnResponse = $this->view->render($response, "login.html");
        return $returnResponse;
    }

    /**
    * ログイン処理。
    */
    public function login(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $isRedirect = false;
        $templatePath = "login.html";
        $assign = [];

        $postParams = $request->getParsedBody();
        $loginId = $postParams["loginId"];
        $loginPw = $postParams["loginPw"];

        $loginId = trim($loginId);
        $loginPw = trim($loginPw);

        $validationMsgs = [];
        if(empty($validationMsgs)) {
            try {
                $db = new PDO(Conf::DB_DNS, Conf::DB_USERNAME, Conf::DB_PASSWORD);
                $userDAO = new UserDAO($db);

                $user = $userDAO->findByLoginid($loginId);
                if($user == null) {
                    $validationMsgs[] = "存在しないIDです。正しいIDを入力してください。";
                }
                else {
                    $userPw = $user->getPasswd();
                    if(password_verify($loginPw, $userPw)) {
                        $id = $user->getId();
                        $nameLast = $user->getNameLast();
                        $nameFirst = $user->getNameFirst();
                        
                        $_SESSION["loginFlg"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["name"] = $nameLast." ".$nameFirst;
                        $_SESSION["auth"] = 1;
                        $isRedirect = true;
                    }
                    else {
                        $validationMsgs[] = "パスワードが違います。正しいパスワードを入力してください。";
                    }
                }
            }
            catch(PDOException $ex) {
                $exCode = $ex->getCode();
                throw new DataAccessException("DB接続に失敗しました。", $exCode, $ex);
            }
            finally {
                $db = null;
            }
        }

        if($isRedirect) {
        $returnResponse = $response->withStatus(302)->withHeader("Location", "/ph35/scottadminslim/public/goTop");
        }
        else {
        if(!empty($validationMsgs)) {
        $assign["validationMsgs"] = $validationMsgs;
        $assign["loginId"] = $loginId;
        }
        $returnResponse = $this->view->render($response, $templatePath, $assign);
        }
        return $returnResponse;
    }

    /**
    * ログアウト処理。
    */
    public function logout(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        session_destroy();
        $returnResponse = $response->withStatus(302)->withHeader("Location", "/ph35/scottadminslim/public/");
        return $returnResponse;
    }
}
