<?php
/**
* PH35 サンプル7 継承 Src05/10
* 継承とは
* 実行ファイル
*
* @author Shinzo SAITO
*
* ファイル名=callAnimals.php
* フォルダ=/ph35/extends/ex1/
*/
require_once("Animal.php");
require_once("Dog.php");
require_once("Pig.php");

$animal1 = new Dog();
$animal1->setName("ぽち");
print($animal1->getName()."が走ると".$animal1->run());
print("<br>");
$animal2 = new Pig();
$animal2->setName("とんこ");
print($animal2->getName()."を食べると".$animal2->eat());