<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReportsController;

Route::get("/",[LoginController::class, "goLogin"]);
Route::post("/login",[LoginController::class, "login"]);
Route::get("/logout",[LoginController::class, "logout"]);
Route::get("/reports/showList/{pageCount}",[ReportsController::class, "showList"])->middleware("logincheck");
Route::get("/reports/goAdd",[ReportsController::class, "goAdd"])->middleware("logincheck");
Route::post("/reports/add",[ReportsController::class, "add"])->middleware("logincheck");
Route::get("/reports/prepareEdit/{rpId}",[ReportsController::class, "prepareEdit"])->middleware("logincheck");
Route::post("/reports/edit",[ReportsController::class, "edit"])->middleware("logincheck")->middleware("logincheck");
Route::get("/reports/confirmDelete/{rpId}",[ReportsController::class, "confirmDelete"])->middleware("logincheck");
Route::post("/reports/delete",[ReportsController::class, "delete"])->middleware("logincheck");
Route::get("/reports/detail/{rpId}",[ReportsController::class, "showDetail"])->middleware("logincheck");
