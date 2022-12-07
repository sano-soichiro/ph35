<?php
/**
* PH35 サンプル7 継承 Src03/10
* 継承とは
*
* @author Shinzo SAITO
*
* ファイル名=Dog.php
* フォルダ=/ph35/extends/ex1/
*/

/**
* 犬を表すクラス。
*/
class Dog extends Animal{
    public function run(): string{
        return "わんわん";
    }
}