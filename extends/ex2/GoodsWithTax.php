<?php
/**
* PH35 サンプル7 継承 Src07/10
* オーバーライド
*
* @author Shinzo SAITO
*
* ファイル名=GoodsWithTax.php
* フォルダ=/ph35/extends/ex2/
*/

/**
* 税込みの商品を表すクラス。
*/
class GoodsWithTax extends Goods{
    public function printPrice(): void{
        $priceWithTax = round($this->getPrice() * 1.1);
        print($this->getName()."の税込み価格: ￥".$priceWithTax."<br>");
    }
}