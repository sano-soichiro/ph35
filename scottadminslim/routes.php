<?php

use LocalHalPH35\ScottAdminSlim\Classes\middlewares\LoginCheck;
use LocalHalPH35\ScottAdminSlim\Classes\controllers\LoginController;
use LocalHalPH35\ScottAdminSlim\Classes\controllers\TopController;
use LocalHalPH35\ScottAdminSlim\Classes\controllers\DeptController;

$app->setBasePath("/ph35/scottadminslim/public");
$app->get("/", LoginController::class.":goLogin");
$app->post("/login", LoginController::class.":login");
$app->get("/logout", LoginController::class.":logout");
$app->get("/goTop", TopController::class.":goTop")->add(new LoginCheck());
$app->get("/dept/showDeptList", DeptController::class.":showDeptList")->add(new LoginCheck());
$app->get("/dept/goDeptAdd", DeptController::class.":goDeptAdd")->add(new LoginCheck());
$app->post("/dept/deptAdd", DeptController::class.":deptAdd")->add(new LoginCheck());
$app->get("/dept/prepareDeptEdit/{dpId}", DeptController::class.":prepareDeptEdit")->add(new LoginCheck());
$app->post("/dept/deptEdit", DeptController::class.":deptEdit")->add(new LoginCheck());
$app->get("/dept/confirmDeptDelete/{dpId}", DeptController::class.":confirmDeptDelete")->add(new LoginCheck());
$app->post("/dept/deptDelete", DeptController::class.":deptDelete")->add(new LoginCheck());
