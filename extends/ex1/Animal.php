<?php
/**
* PH35 サンプル7 継承 Src02/10
* 継承とは
*
* @author Shinzo SAITO
*
* ファイル名=Animal.php
* フォルダ=/ph35/extends/ex1/
*/

/**
* 動物を表すクラス。
*/
class Animal{
/**
* @var string 名前。
*/
private string $name = "";

/**
* 名前のゲッタ。
*
* @return string 名前。
*/
public function getName(): string{
return $this->name;
}

/**
* 名前のセッタ。
*
* @param string $name 名前。
*/
public function setName(string $name): void{
$this->name = $name;
}
}