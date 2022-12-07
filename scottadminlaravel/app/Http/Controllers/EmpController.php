<?php
/**
* PH35 Sample12 マスタテーブル管理Laravel版 Src10/17
*
* @author Shinzo SAITO
*
* ファイル名=DeptController.php
* フォルダ=/scottadminlaravel/app/Http/Controllers/
*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Functions;
use App\Entity\Emp;
use App\DAO\EmpDAO;
use App\DAO\DeptDAO;
use App\Http\Controllers\Controller;

/**
* 部門情報管理に関するコントローラクラス。
*/
class EmpController extends Controller {
    /**
    * 部門リスト画面表示処理。
    */
    public function showEmpList(Request $request) {
        $templatePath = "emp.empList";
        $assign = [];
        if(Functions::loginCheck($request)) {$validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください";
            $assign["validationMsgs"] = $validationMsgs;
            $templatePath = "login";
        }
        else {
            $db = DB::connection()->getPdo();
            $empDAO = new EmpDAO($db);
            $empList = $empDAO->findAll();
            $assign["empList"] = $empList;
        }
        return view($templatePath, $assign);
    }
    
    /**
    * 部門情報登録画面表示処理。
    */
    public function goEmpAdd(Request $request) {
        $templatePath = "emp.empAdd";
        $assign = [];
        if(Functions::loginCheck($request)) {$validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください";
            $assign["validationMsgs"] = $validationMsgs;
            $templatePath = "login";
        }
        else {
            $assign["emp"] = new Emp();
        }
        
        $db = DB::connection()->getPdo();
        $empDAO = new EmpDAO($db);
        $empMgrList = $empDAO->findMgr();
        $assign["empMgrList"] = $empMgrList;
    
        $deptDAO = new DeptDAO($db);
        $deptList = $deptDAO->findAll();
        $assign["deptList"] = $deptList;

        return view($templatePath, $assign);
    }
    
    /**
    * 部門情報登録処理。
    */
    public function empAdd(Request $request) {
        $templatePath = "emp.empAdd";
        $isRedirect = false;
        $assign = [];
        if(Functions::loginCheck($request)) {$validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください";
            $assign["validationMsgs"] = $validationMsgs;
            $templatePath = "login";
        }
        else {
            $addEmpNo = $_POST["addEmpNo"];
            $addEmpName = $_POST["addEmpName"];
            $addEmpJob = $_POST["addEmpJob"];
            $addEmpMgr = $_POST["addEmpMgr"];
            $addEmpHiredate = $_POST["year"] . "-" . $_POST["month"] . "-" . $_POST["day"];
            $addEmpSal = $_POST["addEmpSal"];
            $addDeptId = $_POST["addDeptId"];
            $addEmpName = str_replace("　" , " " , $addEmpName);
            $addEmpJob = str_replace("　" , " " , $addEmpJob);
            $addEmpHiredate = str_replace("　" , " " , $addEmpHiredate);
            $addEmpName = trim($addEmpName);
            $addEmpJob = trim($addEmpJob);
            $addEmpHiredate = trim($addEmpHiredate);

            if(is_null($_POST["year"]) || is_null($_POST["month"]) || is_null($_POST["day"])){
                $addEmpHiredate = null;
            }
            
            $emp = new Emp();
            $emp->setEmNo($addEmpNo);
            $emp->setEmName($addEmpName);
            $emp->setEmJob($addEmpJob);
            $emp->setEmMgr($addEmpMgr);
            $emp->setEmHiredate($addEmpHiredate);
            $emp->setEmSal($addEmpSal);
            $emp->setDeptId($addDeptId);
            
            $validationMsgs = [];
            
            if(empty($addEmpName)){
                $validationMsgs[] = "従業員名の入力は必須です。";
            }
            if(empty($addEmpJob)){
                $validationMsgs[] = "役職の入力は必須です。";
            }

            $db = DB::connection()->getPdo();
            $empDAO = new EmpDAO($db);
            $count = $empDAO->duplicate($emp->getEmNo());
    
            $empMgrList = $empDAO->findMgr();
            $assign["empMgrList"] = $empMgrList;
        
            $deptDAO = new DeptDAO($db);
            $deptList = $deptDAO->findAll();
            $assign["deptList"] = $deptList;
            if($count > 0) {
                $validationMsgs[] ="その従業員番号はすでに使われています。別のものを指定してください。";
            }
            if(empty($validationMsgs)) {
                $empId = $empDAO->insert($emp);
                if($empId === -1) { 
                    $assign["errorMsg"] ="情報登録に失敗しました。もう一度はじめからやり直してください。";
                    $templatePath = "error";
                }
                else {
                    $isRedirect = true;
                }
            }
            else {
                $assign["emp"] = $emp;
                $assign["validationMsgs"] = $validationMsgs;
            }
        }
        if($isRedirect) { 
            $response = redirect("/emp/showEmpList")->with("flashMsg","従業員ID".$empId."で従業員情報を登録しました。");
        }
        else {
            $response = view($templatePath, $assign);
        }
        return $response;
    }
    
    /**
    * 部門情報編集画面表示処理。
    */
    public function prepareEmpEdit(Request $request, int $empId) {
        $templatePath = "emp.empEdit";
        $assign = [];
        if(Functions::loginCheck($request)) { $validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください";
            $assign["validationMsgs"] = $validationMsgs;
            $templatePath = "login";
        }
        else {
            $db = DB::connection()->getPdo();
            $empDAO = new EmpDAO($db);
            $emp = $empDAO->findByPK($empId);
            if(empty($emp)) {
                $assign["errorMsg"] = "従業員情報の取得に失敗しました。";
                $templatePath = "error";
            }
            else {
            $assign["emp"] = $emp;
            }

            $empMgrList = $empDAO->findMgr();
            $assign["empMgrList"] = $empMgrList;
    
            $deptDAO = new DeptDAO($db);
            $deptList = $deptDAO->findAll();
            $assign["deptList"] = $deptList;
        }
        return view($templatePath, $assign);
    }
    
    /**
    * 部門情報編集処理。
    */
    public function empEdit(Request $request) {
        $templatePath = "emp.empEdit";
        $isRedirect = false;
        $assign = [];
        if(Functions::loginCheck($request)) { 
            $validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください";
            $assign["validationMsgs"] = $validationMsgs;
            $templatePath = "login";
        }
        else {
            $editEmpId = $_POST["editEmpId"];
            $editEmpNo = $_POST["editEmpNo"];
            $editEmpName = $_POST["editEmpName"];
            $editEmpJob = $_POST["editEmpJob"];
            $editEmpMgr = $_POST["editEmpMgr"];
            $editEmpHiredate = $_POST["year"] . "-" . $_POST["month"] . "-" . $_POST["day"];
            $editEmpSal = $_POST["editEmpSal"];
            $editDeptId = $_POST["editDeptId"];
            $editEmpName = str_replace("　" , " " , $editEmpName);
            $editEmpJob = str_replace("　" , " " , $editEmpJob);
            $editEmpHiredate = str_replace("　" , " " , $editEmpHiredate);
            $editEmpName = trim($editEmpName);
            $editEmpJob = trim($editEmpJob);
            $editEmpHiredate = trim($editEmpHiredate);
            
            if(is_null($_POST["year"]) || is_null($_POST["month"]) || is_null($_POST["day"])){
                $editEmpHiredate = null;
            }

            $emp = new Emp();
            $emp->setId($editEmpId);
            $emp->setEmNo($editEmpNo);
            $emp->setEmName($editEmpName);
            $emp->setEmJob($editEmpJob);
            $emp->setEmMgr($editEmpMgr);
            $emp->setEmHiredate($editEmpHiredate);
            $emp->setEmSal($editEmpSal);
            $emp->setDeptId($editDeptId);
            
            $validationMsgs = [];

            if(empty($editEmpName)){
                $validationMsgs[] = "従業員名の入力は必須です。";
            }
            if(empty($editEmpJob)){
                $validationMsgs[] = "役職の入力は必須です。";
            }
            $db = DB::connection()->getPdo();
            $empDAO = new EmpDAO($db);
            $empDB = $empDAO->findByEmpNo($emp->getEmNo());
            if(!empty($empDB) && $empDB->getId() != $editEmpId) { 
                $validationMsgs[] ="その従業員番号はすでに使われています。別のものを指定してください。";
            }
            if(empty($validationMsgs)) {
                $result = $empDAO->update($emp);
                if($result) {
                    $isRedirect = true;
                }
                else {
                    $assign["errorMsg"] ="従業員更新に失敗しました。もう一度はじめからやり直してください。";
                    $templatePath = "error";
                }
            }
            else {
                $assign["emp"] = $emp;
                $assign["validationMsgs"] = $validationMsgs;
            }

            $empMgrList = $empDAO->findMgr();
            $assign["empMgrList"] = $empMgrList;

            $deptDAO = new DeptDAO($db);
            $deptList = $deptDAO->findAll();
            $assign["deptList"] = $deptList;
        }
        if($isRedirect) { 
            $response = redirect("/emp/showEmpList")->with("flashMsg","部門ID".$editEmpId."の従業員情報を更新しました。");
        }
        else {
            $response = view($templatePath, $assign);
        }
        return $response;
    }
    
    /**
    * 部門情報削除確認画面表示処理。
    */
    public function confirmEmpDelete(Request $request, int $empId) {
        $templatePath = "emp.empConfirmDelete";
        $assign = [];
        if(Functions::loginCheck($request)) { 
            $validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください";
            $assign["validationMsgs"] = $validationMsgs;
            $templatePath = "login";
        }
        else {
            $db = DB::connection()->getPdo();
            $empDAO = new EmpDAO($db);
            $emp = $empDAO->findByPK($empId);
            if(empty($emp)) {
                $assign["errorMsg"] = "従業員情報の取得に失敗しました。";
                $templatePath = "error";
            }
            else {
                $assign["emp"] = $emp;
            }
        }
        return view($templatePath, $assign);
    }
    
    /**
    * 部門情報削除処理。
    */
    public function empDelete(Request $request) {
        $templatePath = "error";
        $isRedirect = false;
        $assign = [];
        if(Functions::loginCheck($request)) { 
            $validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください";
            $assign["validationMsgs"] = $validationMsgs;
            $templatePath = "login";
        }
        else {
            $deleteEmpId = $request->input("deleteEmpId");
            $db = DB::connection()->getPdo();
            $empDAO = new EmpDAO($db);
            $result = $empDAO->delete($deleteEmpId);
            if($result) {
                $isRedirect = true;
            }
            else { 
                $assign["errorMsg"] ="情報削除に失敗しました。もう一度はじめからやり直してください。";
            }
        }
        if($isRedirect) { 
            $response = redirect("/emp/showEmpList")->with("flashMsg","従業員ID".$deleteEmpId."の従業員情報を削除しました。");
        }
        else {
            $response = view($templatePath, $assign);
        }
       return $response;
    }
}