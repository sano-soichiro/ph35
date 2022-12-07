<?php
/**
 * PH35 サンプル7 継承 Src04/10
 * 継承とは
 *
 * @author Shinzo SAITO
 *
 * ファイル名=Pig.php
 * フォルダ=/ph35/extends/ex1/
*/

/**
 * 豚を表すクラス。
 */
class Pig extends Animal{
    public function eat(): string{
        return"うまい!";
    }
}

