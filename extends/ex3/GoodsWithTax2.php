<?php
/**
* PH35 サンプル7 継承 Src09/10
* 親クラスのメソッド実行
*
* @author Shinzo SAITO
*
* ファイル名=GoodsWithTax2.php
* フォルダ=/ph35/extends/ex3/
*/

/**
* 税込みの商品を表すクラス2。
*/
class GoodsWithTax2 extends Goods{
    public function printPrice(): void{
        parent::printPrice();
        $priceWithTax = round($this->getPrice() * 1.1);
        print($this->getName()."の税込み価格: ￥".$priceWithTax."<br>");
    }
}