<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Functions;
use App\DAO\UserDAO;
use App\Entity\Report;
use App\DAO\ReportDAO;
use App\DAO\ReportcateDAO;
use App\Http\Controllers\Controller;
use App\Exceptions\DataAccessException;

/**
* 部門情報管理に関するコントローラクラス。
*/
class reportsController extends Controller {
    /**
    * 部門リスト画面表示処理。
    */
    public function showList(Request $request, int $pageCount) {
        $templatePath = "reports.list";
        $assign = [];
        $nowPage = 0;
        $firstPage = 'on';
        $lastPage = 'on';
/*         if(Functions::loginCheck($request)) {
            $validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください";
            $assign["validationMsgs"] = $validationMsgs;
            $templatePath = "login";
        }
        else { */
            $loginUser = Functions::loginUser($request);
            $assign['loginUser'] = $loginUser;

            $db = DB::connection()->getPdo();
            $reportDAO = new ReportDAO($db);

            $nowPage = $pageCount;
            $reportCount = $reportDAO->reportCount();
            $maxPage = ceil($reportCount / 10);
            if($nowPage == 0) {
                $firstPage = 'off';
            }
            if($nowPage == $maxPage - 1) {
                $lastPage = 'off';
            }

            $reportList = $reportDAO->findListAll(10, $nowPage * 10);

            $assign["reportList"] = $reportList;
            $assign["maxPage"] = $maxPage;
            $assign['nowPage'] = $nowPage;
            $assign['firstPage'] = $firstPage;
            $assign['lastPage'] = $lastPage;
/*         } */
        return view($templatePath, $assign);
    }
    
    /**
    * 部門情報登録画面表示処理。
    */
    public function goAdd(Request $request) {
            $templatePath = "reports.add";
            $assign = [];
/* 
        if(Functions::loginCheck($request)) {
            $validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください";
            $assign["validationMsgs"] = $validationMsgs;
            $templatePath = "login";
        }
        else { */
            $loginUser = Functions::loginUser($request);
            $assign['loginUser'] = $loginUser;

            $db = DB::connection()->getPdo();
            $reportcateDAO = new ReportcateDAO($db);

            $reportcate = $reportcateDAO->findAll();

            $assign["report"] = new Report();
            $assign["reportcate"] = $reportcate;
/*         } */
        return view($templatePath, $assign);
    }
    
    /**
    * 部門情報登録処理。
    */
    public function add(Request $request) {
        $templatePath = "reports.add";
        $isRedirect = false;
        $assign = [];
/*         if(Functions::loginCheck($request)) {
            $validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください";
            $assign["validationMsgs"] = $validationMsgs;
            $templatePath = "login";
        }
        else { */
            $loginUser = Functions::loginUser($request);
            $assign['loginUser'] = $loginUser;

            $db = DB::connection()->getPdo();
            $userDAO = new UserDAO($db);
            $reportcateDAO = new ReportcateDAO($db);

            $reportcate = $reportcateDAO->findAll();

            $addRpDate = $request->input("addRpDateYear") . '-' . $request->input("addRpDateMonth") . '-' . $request->input("addRpDateDay");
            $addRpTimeFrom = $request->input("addRpTimeFrom");
            $addRpTimeTo = $request->input("addRpTimeTo");
            $addRpContent = $request->input("addRpContent");
            $addRpCreatedAt = date("Y-m-d H:i:s");
            $addReportcateId = $request->input("addReportcateId");
            $addUserId = $userDAO->findByLoginUser($loginUser['id']);

            $addRpContent = str_replace(" ", "　", $addRpContent);
            $addRpContent = trim($addRpContent);
            
            $report = new Report();
            $report->setRpDate($addRpDate);
            $report->setRpTimeFrom($addRpTimeFrom);
            $report->setRpTimeTo($addRpTimeTo);
            $report->setRpContent($addRpContent);
            $report->setRpCreatedAt($addRpCreatedAt);
            $report->setReportcateId($addReportcateId);
            $report->setUserId($addUserId);
            
            $validationMsgs = [];

            if(empty($addRpContent)) {
                $validationMsgs[] = '作業内容は必須項目です';
            }

            if(!checkdate(explode('-', $addRpDate)[1], explode('-', $addRpDate)[2], explode('-', $addRpDate)[0])) {
                $validationMsgs[] = '作業日が不正です';
            }

            if(!preg_match('/^(0[0-9]{1}|1{1}[0-9]{1}|2{1}[0-3]{1}):(0[0-9]{1}|[1-5]{1}[0-9]{1})$/', $addRpTimeFrom)) {
                $validationMsgs[] = '正しい作業開始時刻が入力されていません';
            }
            if(!preg_match('/^(0[0-9]{1}|1{1}[0-9]{1}|2{1}[0-3]{1}):(0[0-9]{1}|[1-5]{1}[0-9]{1})$/', $addRpTimeTo)) {
                $validationMsgs[] = '正しい作業終了時刻が入力されていません';
            }

            if($addRpTimeFrom > $addRpTimeTo) {
                $validationMsgs[] = '作業開始時刻・作業終了時刻が不正です';
            }
            
            $reportDAO = new ReportDAO($db);
            if(empty($validationMsgs)) {
                $rpId = $reportDAO->insert($report);
                if($rpId === -1) { 
                    $assign["errorMsg"] ="情報登録に失敗しました。もう一度はじめからやり直してください。";
                    $templatePath = "error";
                }
                else {
                    $isRedirect = true;
                }
            }
            else {
                $assign["report"] = $report;
                $assign["reportcate"] = $reportcate;
                $assign["validationMsgs"] = $validationMsgs;
            }
/*         } */
        if($isRedirect) { 
            $response = redirect("/reports/showList/0")->with("flashMsg","レポートID".$rpId."でレポートを登録しました。");
        }
        else {
            $response = view($templatePath, $assign);
        }
        return $response;
    }
    
    /**
    * 部門情報編集画面表示処理。
    */
    public function prepareEdit(Request $request, int $rpId) {
        $templatePath = "reports.edit";
        $assign = [];
/*         if(Functions::loginCheck($request)) { 
            $validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください";
            $assign["validationMsgs"] = $validationMsgs;
            $templatePath = "login";
        }
        else { */
            $loginUser = Functions::loginUser($request);
            $assign['loginUser'] = $loginUser;

            $db = DB::connection()->getPdo();
            $reportDAO = new ReportDAO($db);
            $reportcateDAO = new ReportcateDAO($db);
            
            $report = $reportDAO->findByPK($rpId);
            $reportcate = $reportcateDAO->findAll();
            if(empty($report)) {
                $assign["errorMsg"] = "部門情報の取得に失敗しました。";
                $templatePath = "error";
            }
            else {
            $assign["report"] = $report;
            $assign["reportcate"] = $reportcate;
            }
/*         } */
        return view($templatePath, $assign);
    }
    
    /**
    * 部門情報編集処理。
    */
    public function edit(Request $request) {
        $templatePath = "reports.edit";
        $isRedirect = false;
        $assign = [];
/*         if(Functions::loginCheck($request)) { 
            $validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください";
            $assign["validationMsgs"] = $validationMsgs;
            $templatePath = "login";
        }
        else { */
            $loginUser = Functions::loginUser($request);
            $assign['loginUser'] = $loginUser;
            
            $db = DB::connection()->getPdo();
            $userDAO = new UserDAO($db);
            $reportcateDAO = new ReportcateDAO($db);

            $editId = $request->input("editId");
            $editRpDate = $request->input("editRpDateYear") . '-' . $request->input("editRpDateMonth") . '-' . $request->input("editRpDateDay");
            $editRpTimeFrom = $request->input("editRpTimeFrom");
            $editRpTimeTo = $request->input("editRpTimeTo");
            $editRpContent = $request->input("editRpContent");
            $editRpCreatedAt = date('Y-m-d H:i:s');
            $editReportcateId = $request->input("editReportcateId");
            $editUserId = $userDAO->findByLoginUser($loginUser['id']);

            $editRpContent = str_replace(" ", "　", $editRpContent);
            $editRpContent = trim($editRpContent);
            
            $report = new Report();
            $report->setId($editId);
            $report->setRpDate($editRpDate);
            $report->setRpTimeFrom($editRpTimeFrom);
            $report->setRpTimeTo($editRpTimeTo);
            $report->setRpContent($editRpContent);
            $report->setRpCreatedAt($editRpCreatedAt);
            $report->setReportcateId($editReportcateId);
            $report->setUserId($editUserId);

            $reportcate = $reportcateDAO->findAll();
            
            $validationMsgs = [];

            if(empty($editRpContent)) {
                $validationMsgs[] = '作業内容は必須項目です';
            }

            if(!checkdate(explode('-', $editRpDate)[1], explode('-', $editRpDate)[2], explode('-', $editRpDate)[0])) {
                $validationMsgs[] = '作業日が不正です';
            }

            if(strlen($editRpTimeFrom) != 5){
                if(!preg_match('/^(0[0-9]{1}|1{1}[0-9]{1}|2{1}[0-3]{1}):(0[0-9]{1}|[1-5]{1}[0-9]{1}):(0[0-9]{1}|[1-5]{1}[0-9]{1})$/', $editRpTimeFrom)) {
                    $validationMsgs[] = '正しい作業開始時刻が入力されていません';
                }
            }else{
                if(!preg_match('/^(0[0-9]{1}|1{1}[0-9]{1}|2{1}[0-3]{1}):(0[0-9]{1}|[1-5]{1}[0-9]{1})$/', $editRpTimeFrom)) {
                    $validationMsgs[] = '正しい作業開始時刻が入力されていません';
                }
            }
            if(strlen($editRpTimeTo) != 5){
                if(!preg_match('/^(0[0-9]{1}|1{1}[0-9]{1}|2{1}[0-3]{1}):(0[0-9]{1}|[1-5]{1}[0-9]{1}):(0[0-9]{1}|[1-5]{1}[0-9]{1})$/', $editRpTimeTo)) {
                    $validationMsgs[] = '正しい作業終了時刻が入力されていません';
                }
            }else{
                if(!preg_match('/^(0[0-9]{1}|1{1}[0-9]{1}|2{1}[0-3]{1}):(0[0-9]{1}|[1-5]{1}[0-9]{1})$/', $editRpTimeTo)) {
                    $validationMsgs[] = '正しい作業終了時刻が入力されていません';
                }
            }

            if($editRpTimeFrom > $editRpTimeTo) {
                $validationMsgs[] = '作業開始時刻・作業終了時刻が不正です';
            }
            
            $reportDAO = new ReportDAO($db);
            if(empty($validationMsgs)) {
                $result = $reportDAO->update($report);
                if($result) {
                    $isRedirect = true;
                }
                else {
                    $assign["errorMsg"] ="情報更新に失敗しました。もう一度はじめからやり直してください。";
                    $templatePath = "error";
                }
            }
            else {
                $assign["report"] = $report;
                $assign["reportcate"] = $reportcate;
                $assign["validationMsgs"] = $validationMsgs;
            }
/*         } */
        if($isRedirect) { 
            $response = redirect("/reports/detail/" . $editId)->with("flashMsg","レポートID" . $editId . "のレポートを更新しました。");
        }
        else {
            $response = view($templatePath, $assign);
        }
        return $response;
    }
    
    /**
    * 部門情報削除確認画面表示処理。
    */
    public function confirmDelete(Request $request, int $rpId) {
        $templatePath = "reports.confirmDelete";
        $assign = [];
/*         if(Functions::loginCheck($request)) { 
            $validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください";
            $assign["validationMsgs"] = $validationMsgs;
            $templatePath = "login";
        }
        else { */
            $loginUser = Functions::loginUser($request);
            $assign['loginUser'] = $loginUser;

            $db = DB::connection()->getPdo();
            $reportDAO = new ReportDAO($db);
            $reportDetail = $reportDAO->findDetail($rpId);
            if(empty($reportDetail)) {
                $assign["errorMsg"] = "部門情報の取得に失敗しました。";
                $templatePath = "error";
            }
            else {
                $assign["reportDetail"] = $reportDetail;
            }
/*         } */
        return view($templatePath, $assign);
    }
    
    /**
    * 部門情報削除処理。
    */
    public function delete(Request $request) {
        $templatePath = "error";
        $isRedirect = false;
        $assign = [];
/*         if(Functions::loginCheck($request)) { 
            $validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください";
            $assign["validationMsgs"] = $validationMsgs;
            $templatePath = "login";
        }
        else { */
            $loginUser = Functions::loginUser($request);
            $assign['loginUser'] = $loginUser;

            $deleteRpId = $request->input("deleteRpId");
            $db = DB::connection()->getPdo();
            $reportDAO = new ReportDAO($db);
            $result = $reportDAO->delete($deleteRpId);
            if($result) {
                $isRedirect = true;
            }
            else { 
                $assign["errorMsg"] ="情報削除に失敗しました。もう一度はじめからやり直してください。";
            }
/*         } */
        if($isRedirect) { 
            $response = redirect("/reports/showList/0")->with("flashMsg","レポートID".$deleteRpId."のレポートを削除しました。");
        }
        else {
            $response = view($templatePath, $assign);
        }
       return $response;
    }

    /**
    * 部門情報削除処理。
    */
    public function showDetail(Request $request, int $rpId) {
        $templatePath = "reports.detail";
        $assign = [];
/*         if(Functions::loginCheck($request)) {
            $validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください";
            $assign["validationMsgs"] = $validationMsgs;
            $templatePath = "login";
        }
        else { */
            $loginUser = Functions::loginUser($request);
            $assign['loginUser'] = $loginUser;

            $db = DB::connection()->getPdo();
            $reportDAO = new ReportDAO($db);
            $reportcateDAO = new ReportcateDAO($db);

            $reportDetail = $reportDAO->findDetail($rpId);
            if(empty($reportDetail)) {
                $assign["errorMsg"] = "部門情報の取得に失敗しました。";
                $templatePath = "error";
            }
            else {
                $assign["reportDetail"] = $reportDetail;
            }
/*         } */
        return view($templatePath, $assign);
    }
}