<?php
/**
* PH35 Sample13 マスタテーブル管理ミドルウェア版 Src02/19
* ルーティング情報記述ファイル。
*
* @author Shinzo SAITO
*
* ファイル名=web.php
* フォルダ=/scottadminmiddle/routes/
*/

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TopController;
use App\Http\Controllers\DeptController;

Route::get("/", [LoginController::class, "goLogin"]);
Route::post("/login", [LoginController::class, "login"]);
Route::get("/logout", [LoginController::class, "logout"]);
Route::get("/goTop", [TopController::class, "goTop"])->middleware("logincheck");
Route::get("/dept/showDeptList", [DeptController::class, "showDeptList"])->middleware("logincheck");
Route::get("/dept/goDeptAdd", [DeptController::class, "goDeptAdd"])->middleware("logincheck");
Route::post("/dept/deptAdd", [DeptController::class, "deptAdd"])->middleware("logincheck");
Route::get("/dept/prepareDeptEdit/{dpId}", [DeptController::class, "prepareDeptEdit"])->middleware("logincheck");
Route::post("/dept/deptEdit", [DeptController::class, "deptEdit"])->middleware("logincheck");
Route::get("/dept/confirmDeptDelete/{dpId}", [DeptController::class, "confirmDeptDelete"])->middleware("logincheck");
Route::post("/dept/deptDelete", [DeptController::class, "deptDelete"])->middleware("logincheck");