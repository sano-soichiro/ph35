<?php
/**
* PH35 サンプル7 継承 Src08/10
* オーバーライド
* 実行ファイル
*
* @author Shinzo SAITO
*
* ファイル名=useGoods.php
* フォルダ=/ph35/extends/ex2/
*/
require_once("Goods.php");
require_once("GoodsWithTax.php");

$goods = new Goods("ハンドクリーム", 350);
$goods->printPrice();

$goodsWithTax = new GoodsWithTax("日焼け止め", 500);
$goodsWithTax->printPrice();