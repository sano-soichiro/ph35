<?php
/**
* PH35 Sample13 マスタテーブル管理ミドルウェア版 Src12/19
*
* @author Shinzo SAITO
*
* ファイル名=DeptController.php
* フォルダ=/scottadminmiddle/app/Http/Controllers/
*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Functions;
use App\Entity\Dept;
use App\DAO\DeptDAO;
use App\Exceptions\DataAccessException;
use App\Http\Controllers\Controller;

/**
* 部門情報管理に関するコントローラクラス。
*/
class DeptController extends Controller {
    /**
    * 部門リスト画面表示処理。
    */
    public function showDeptList(Request $request) {
        $templatePath = "dept.deptList";
        $assign = [];
        $db = DB::connection()->getPdo();
        $deptDAO = new DeptDAO($db);
        $deptList = $deptDAO->findAll();
        $assign["deptList"] = $deptList;
        return view($templatePath, $assign);
    }

    /**
    * 部門情報登録画面表示処理。
    */
    public function goDeptAdd(Request $request) {
        $templatePath = "dept.deptAdd";
        $assign = [];
        $assign["dept"] = new Dept();
        return view($templatePath, $assign);
    }

    /**
    * 部門情報登録処理。
    */
    public function deptAdd(Request $request) {
        $templatePath = "dept.deptAdd";
        $isRedirect = false;
        $assign = [];
        $addDpNo = $request->input("addDpNo");
        $addDpName = $request->input("addDpName");
        $addDpLoc = $request->input("addDpLoc");

        $dept = new Dept();
        $dept->setDpNo($addDpNo);
        $dept->setDpName($addDpName);
        $dept->setDpLoc($addDpLoc);

        $validationMsgs = [];

        if(empty($addDpName)) {
            $validationMsgs[] = "部門名の入力は必須です。";
        }
        $db = DB::connection()->getPdo();
        $deptDAO = new DeptDAO($db);
        $deptDB = $deptDAO->findByDpNo($dept->getDpNo());
        if(!empty($deptDB)) {
            $validationMsgs[] ="その部門番号はすでに使われています。別のものを指定してください。";
        }
        if(empty($validationMsgs)) {
            $dpId = $deptDAO->insert($dept);
            if($dpId === -1) {
                throw new DataAccessException("情報登録に失敗しました。もう一度はじめからやり直してください。");
            }
            else {
                $isRedirect = true;
            }
        }
        else {
            $assign["dept"] = $dept;
            $assign["validationMsgs"] = $validationMsgs;
        }
        if($isRedirect) {
            $response = redirect("/dept/showDeptList")->with("flashMsg", "部門ID".$dpId."で部門情報を登録しました。");
        }
        else {
            $response = view($templatePath, $assign);
        }
        return $response;
    }

    /**
    * 部門情報編集画面表示処理。
    */
    public function prepareDeptEdit(Request $request, int $dpId) {
        $templatePath = "dept.deptEdit";
        $assign = [];
        $db = DB::connection()->getPdo();
        $deptDAO = new DeptDAO($db);
        $dept = $deptDAO->findByPK($dpId);
        if(empty($dept)) {
            throw new DataAccessException("部門情報の取得に失敗しました。");
        }
        else {
            $assign["dept"] = $dept;
        }
        return view($templatePath, $assign);
    }

    /**
    * 部門情報編集処理。
    */
    public function deptEdit(Request $request) {
        $templatePath = "dept.deptEdit";
        $isRedirect = false;
        $assign = [];
        $editDpId = $request->input("editDpId");
        $editDpNo = $request->input("editDpNo");
        $editDpName = $request->input("editDpName");
        $editDpLoc = $request->input("editDpLoc");

        $dept = new Dept();
        $dept->setId($editDpId);
        $dept->setDpNo($editDpNo);
        $dept->setDpName($editDpName);
        $dept->setDpLoc($editDpLoc);

        $validationMsgs = [];

        if(empty($editDpName)) {
            $validationMsgs[] = "部門名の入力は必須です。";
        }

        $db = DB::connection()->getPdo();
        $deptDAO = new DeptDAO($db);
        $deptDB = $deptDAO->findByDpNo($dept->getDpNo());
        if(!empty($deptDB) && $deptDB->getId() != $editDpId) { 
            $validationMsgs[] = "その部門番号はすでに使われています。別のものを指定してください。";
        }
        if(empty($validationMsgs)) {
            $result = $deptDAO->update($dept);
            if($result) {
                $isRedirect = true;
            }
            else {
                throw new DataAccessException("情報更新に失敗しました。もう一度はじめからやり直してください。");
            }
        }
        else {
            $assign["dept"] = $dept;
            $assign["validationMsgs"] = $validationMsgs;
        }
        if($isRedirect) {
            $response = redirect("/dept/showDeptList")->with("flashMsg", "部門ID".$editDpId."の部門情報を更新しました。");
        }
        else {
            $response = view($templatePath, $assign);
        }
        return $response;
    }

    /**
    * 部門情報削除確認画面表示処理。
    */
    public function confirmDeptDelete(Request $request, int $dpId) {
        $templatePath = "dept.deptConfirmDelete";
        $assign = [];
        $db = DB::connection()->getPdo();
        $deptDAO = new DeptDAO($db);
        $dept = $deptDAO->findByPK($dpId);
        if(empty($dept)) {
            throw new DataAccessException("部門情報の取得に失敗しました。");
        }
        else {
            $assign["dept"] = $dept;
        }
        return view($templatePath, $assign);
    }

    /**
    * 部門情報削除処理。
    */
    public function deptDelete(Request $request) {
        $deleteDeptId = $request->input("deleteDeptId");
        $db = DB::connection()->getPdo();
        $deptDAO = new DeptDAO($db);
        $result = $deptDAO->delete($deleteDeptId);
        if(!$result) {
            throw new DataAccessException("情報削除に失敗しました。もう一度はじめからやり直してください。");
        }
        $response = redirect("/dept/showDeptList")->with("flashMsg", "部門ID".$deleteDeptId."の部門情報を削除しました。");
        return $response;
    }
}