<?php
/**
* PH35 サンプル7 継承 Src10/10
* 親クラスのメソッド実行
* 実行ファイル
*
* @author Shinzo SAITO
*
* ファイル名=useGoods2.php
* フォルダ=/ph35/extends/ex3/
*/
require_once("../ex2/Goods.php");
require_once("GoodsWithTax2.php");

$goods = new GoodsWithTax2("リップクリーム", 200);
$goods->printPrice();