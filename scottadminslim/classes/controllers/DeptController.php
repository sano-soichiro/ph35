<?php
/**
* PH35 Sample14 マスタテーブル管理Slim版 Src18
*
* @author Shinzo SAITO
*
* ファイル名=DeptController.php
* フォルダ=/ph35/scottadminslim/classes/controllers/
*/
namespace LocalHalPH35\ScottAdminSlim\Classes\controllers;

use PDO;
use PDOException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use LocalHalPH35\ScottAdminSlim\Classes\Conf;
use LocalHalPH35\ScottAdminSlim\Classes\exceptions\DataAccessException;
use LocalHalPH35\ScottAdminSlim\Classes\entities\Dept;
use LocalHalPH35\ScottAdminSlim\Classes\daos\DeptDAO;
use LocalHalPH35\ScottAdminSlim\Classes\controllers\ParentController;

/**
* 部門情報管理に関するコントローラクラス。
*/
class DeptController extends ParentController {
    /**
    * 部門情報リスト画面表示処理。
    */
    public function showDeptList(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $flashMessages = $this->flash->getMessages();
        if(isset($flashMessages)) {
            $assign["flashMsg"] = $this->flash->getFirstMessage("flashMsg");
        }
        $this->cleanSession();
        try {
            $db = new PDO(Conf::DB_DNS, Conf::DB_USERNAME, Conf::DB_PASSWORD);
            $deptDAO = new DeptDAO($db);
            $deptList = $deptDAO->findAll();
            $assign["deptList"] = $deptList;
        }
        catch(PDOException $ex) {
            $exCode = $ex->getCode();
            throw new DataAccessException("DB接続に失敗しました。", $exCode, $ex);
        }
        finally {
            $db = null;
        }
        $returnResponse = $this->view->render($response, "dept/deptList.html", $assign);
        return $returnResponse;
    }

    /**
    * 部門情報登録画面表示処理。
    */
    public function goDeptAdd(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $returnResponse = $this->view->render($response, "dept/deptAdd.html");
        return $returnResponse;
    }

    /**
    * 部門情報登録処理。
    */
    public function deptAdd(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $templatePath = "dept/deptAdd.html";
        $isRedirect = false;
        $assign = [];

        $postParams = $request->getParsedBody();
        $addDpNo = $postParams["addDpNo"];
        $addDpName = $postParams["addDpName"];
        $addDpLoc = $postParams["addDpLoc"];
        $addDpName = str_replace("　", " ", $addDpName);
        $addDpLoc = str_replace("　", " ", $addDpLoc);
        $addDpName = trim($addDpName);
        $addDpLoc = trim($addDpLoc);

        $dept = new Dept();
        $dept->setDpNo($addDpNo);
        $dept->setDpName($addDpName);
        $dept->setDpLoc($addDpLoc);

        $validationMsgs = [];

        if(empty($addDpName)) {
            $validationMsgs[] = "部門名の入力は必須です。";
        }

        try {
            $db = new PDO(Conf::DB_DNS, Conf::DB_USERNAME, Conf::DB_PASSWORD);
            $deptDAO = new DeptDAO($db);
            $deptDB = $deptDAO->findByDpNo($dept->getDpNo());
            if(!empty($deptDB)) {
                $validationMsgs[] = "その部門番号はすでに使われています。別のものを指定してください。";
            }
            if(empty($validationMsgs)) {
                $dpId = $deptDAO->insert($dept);
                if($dpId === -1) {
                    throw new DataAccessException("情報登録に失敗しました。もう一度はじめからやり直してください。");
                }
                else {
                    $isRedirect = true;
                    $this->flash->addMessage("flashMsg", "部門ID".$dpId."で部門情報を登録しました。");
                }
            }
            else {
                $assign["dept"] = $dept;
                $assign["validationMsgs"] = $validationMsgs;
            }
        }
        catch(PDOException $ex) {
            $exCode = $ex->getCode();
            throw new DataAccessException("DB接続に失敗しました。", $exCode, $ex);
        }
        finally {
            $db = null;
        }

        if($isRedirect) {
            $returnResponse = $response->withStatus(302)->withHeader("Location", "/ph35/scottadminslim/public/dept/showDeptList");
        }
        else {
            $returnResponse = $this->view->render($response, $templatePath, $assign);
        }
        return $returnResponse;
    }

    /**
    * 部門情報更新画面表示処理。
    */
    public function prepareDeptEdit(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $templatePath = "dept/deptEdit.html";
        $assign = [];

        $editDeptId = $args["dpId"];
        try {
            $db = new PDO(Conf::DB_DNS, Conf::DB_USERNAME, Conf::DB_PASSWORD);
            $deptDAO = new DeptDAO($db);
            $dept = $deptDAO->findByPK($editDeptId);
            if(empty($dept)) {
                throw new DataAccessException("部門情報の取得に失敗しました。");
            }
            else {
                $assign["dept"] = $dept;
            }
        }
        catch(PDOException $ex) {
            $exCode = $ex->getCode();
            throw new DataAccessException("DB接続に失敗しました。", $exCode, $ex);
        }
        finally {
            $db = null;
        }
        $returnResponse = $this->view->render($response, $templatePath, $assign);
        return $returnResponse;
    }

    /**
    * 部門情報編集処理。
    */
    public function deptEdit(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $templatePath = "dept/deptEdit.html";
        $isRedirect = false;
        $assign = [];

        $postParams = $request->getParsedBody();
        $editDpId = $postParams["editDpId"];
        $editDpNo = $postParams["editDpNo"];
        $editDpName = $postParams["editDpName"];
        $editDpLoc = $postParams["editDpLoc"];
        $editDpName = str_replace("　", " ", $editDpName);
        $editDpLoc = str_replace("　", " ", $editDpLoc);
        $editDpName = trim($editDpName);
        $editDpLoc = trim($editDpLoc);

        $dept = new Dept();
        $dept->setId($editDpId);
        $dept->setDpNo($editDpNo);
        $dept->setDpName($editDpName);
        $dept->setDpLoc($editDpLoc);

        $validationMsgs = [];

        if(empty($editDpName)) {
            $validationMsgs[] = "部門名の入力は必須です。";
        }

        try {
            $db = new PDO(Conf::DB_DNS, Conf::DB_USERNAME, Conf::DB_PASSWORD);
            $deptDAO = new DeptDAO($db);
            $deptDB = $deptDAO->findByDpNo($dept->getDpNo());
            if(!empty($deptDB) && $deptDB->getId() != $editDpId) {
                $validationMsgs[] = "その部門番号はすでに使われています。別のものを指定してください。";
            }
            if(empty($validationMsgs)) {
                $result = $deptDAO->update($dept);
                if($result) {
                    $isRedirect = true;
                    $this->flash->addMessage("flashMsg", "部門ID".$editDpId."で部門情報を更新しました。");
                }
                else {
                    throw new DataAccessException("情報更新に失敗しました。もう一度はじめからやり直してください。");
                }
            }
            else {
                $assign["dept"] = $dept;
                $assign["validationMsgs"] = $validationMsgs;
            }
        }
        catch(PDOException $ex) {
            $exCode = $ex->getCode();
            throw new DataAccessException("DB接続に失敗しました。", $exCode, $ex);
        }
        finally {
            $db = null;
        }

        if($isRedirect) {
            $returnResponse = $response->withStatus(302)->withHeader("Location", "/ph35/scottadminslim/public/dept/showDeptList");
        }
        else {
            $returnResponse = $this->view->render($response, $templatePath, $assign);
        }
        return $returnResponse;
    }

    /**
    * 部門情報削除確認画面表示処理。
    */
    public function confirmDeptDelete(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $templatePath = "dept/deptConfirmDelete.html";
        $assign = [];

        $editDeptId = $args["dpId"];
        try {
            $db = new PDO(Conf::DB_DNS, Conf::DB_USERNAME, Conf::DB_PASSWORD);
            $deptDAO = new DeptDAO($db);
            $dept = $deptDAO->findByPK($editDeptId);
            if(empty($dept)) {
                throw new DataAccessException("部門情報の取得に失敗しました。");
            }
            else {
                $assign["dept"] = $dept;
            }
        }
        catch(PDOException $ex) {
            $exCode = $ex->getCode();
            throw new DataAccessException("DB接続に失敗しました。", $exCode, $ex);
        }
        finally {
            $db = null;
        }
        $returnResponse = $this->view->render($response, $templatePath, $assign);
        return $returnResponse;
    }

    /**
    * 部門情報削除処理。
    */
    public function deptDelete(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $postParams = $request->getParsedBody();
        $deleteDeptId = $postParams["deleteDeptId"];
        try {
            $db = new PDO(Conf::DB_DNS, Conf::DB_USERNAME, Conf::DB_PASSWORD);
            $deptDAO = new DeptDAO($db);
            $result = $deptDAO->delete($deleteDeptId);
            if($result) {
                $this->flash->addMessage("flashMsg", "部門ID".$deleteDeptId."の部門情報を削除しました。");
            }
            else {
                throw new DataAccessException("情報削除に失敗しました。もう一度はじめからやり直してください。");
            }
        }
        catch(PDOException $ex) {
            $exCode = $ex->getCode();
            throw new DataAccessException("DB接続に失敗しました。", $exCode, $ex);
        }
        finally {
            $db = null;
        }
        $returnResponse = $response->withStatus(302)->withHeader("Location", "/ph35/scottadminslim/public/dept/showDeptList");
        return $returnResponse;
    }
}
