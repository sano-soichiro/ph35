<?php
/**
* PH35 サンプル7 継承 Src06/10
* オーバーライド
*
* @author Shinzo SAITO
*
* ファイル名=Goods.php
* フォルダ=/ph35/extends/ex2/
*/

/**
* 商品を表すクラス。
*/
class Goods{
    /**
    * @var string 商品名。
    */
    private string $name = "";
    /**
    * @var integer 商品価格。
    */
    private int $price = 0;

    /**
    * コンストラクタ。
    * 商品名と商品価格を設定する。
    *
    * @param string $name 商品名。
    * @param integer $price 商品価格。
    */
    public function __construct(string $name, int $price){
        $this->name = $name;
        $this->price = $price;
    }

    /**
    * 商品名と価格を表示するメソッド。
    */
    public function printPrice(): void{
        print($this->name."の価格: ￥".$this->price."<br>");
    }

    /**
    * 商品名のゲッタ。
    *
    * @return string 商品名。
    */
    public function getName(): string{
        return $this->name;
    }

    /**
    * 商品価格のゲッタ。
    *
    * @return integer 商品価格。
    */
    public function getPrice(): int{
        return $this->price;
    }
}