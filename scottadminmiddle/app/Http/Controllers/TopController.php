<?php
/**
* PH35 Sample13 マスタテーブル管理ミドルウェア版 Src11/19
*
* @author Shinzo SAITO
*
* ファイル名=TopController.php
* フォルダ=/scottadminmiddle/app/Http/Controllers/
*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Functions;
use App\Http\Controllers\Controller;

/**
* Topに関するコントローラクラス。
*/
class TopController extends Controller {
    /**
    * Top画面表示処理。
    */
    public function goTop(Request $request) {
        return view("top");
    }
}