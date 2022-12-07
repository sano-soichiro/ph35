<?php
/**
 * PH35 サンプル1　クラスの復習 Src6/7
 * コンストラクタ
 * クラス記述ファイル
 * 
 * @author Shinzo SAITO
 * 
 * ファイル名=TestScoreConstructor.php
 * フォルダ=/ph35/classes/constructor/
 */

/**
 * テストの得点を表すクラス
 */
class TestScoreConstructor {
    /**
     * @var string 生徒名。
     */
    private string $name = "";
    /**
     * @var integer 英語の点数。
     */
    private int $english = 0;
        /**
     * @var integer 数学の点数。
     */
    private int $math = 0;
        /**
     * @var integer 国語の点数。
     */
    private int $japanese = 0;

    /**
     * コンストラクタ。
     * 
     * @param string $name 生徒名。
     * @param integer $english 英語の点数。
     * @param integer $math 数学の点数。
     * @param integer $japanese 国語の点数。
     */
    public function __construct(string $name , int $english , int $math , int $japanese){
        $this->name = $name;
        $this->english = $english;
        $this->math = $math;
        $this->japanese = $japanese;
    }
    /**
     * 英国数3教科の合計を計算するメソッド。
     * 
     * @return integer 3教科の合計点。
     */
    public function getSum(): int {
        return $this->english + $this->math + $this->japanese;
    }

    /**
     * 英国数3教科の平均を計算するメソッド。
     * 
     * @return float 3教科の平均点。小数点以下1桁の数値に四捨五入されている。
     */
    public function getAve(): float {
        $ave = $this->getSum() / 3;
        $ave = round($ave , 1);
        return $ave;
    }

    //以下アクセサメソッド

    public function getName(): string {
        return $this->name;
    }
    public function setName(string $name): void {
        $this->name = $name;
    }
    public function getEnglish(): int {
        return $this->english;
    }
    public function setEnglish(int $english): void {
        $this->english = $english;
    }
    public function getMath(): int {
        return $this->math;
    }
    public function setMath(int $math): void {
        $this->math = $math;
    }
    public function getJapanese(): int {
        return $this->japanese;
    }
    public function setJapanese(int $japanese): void {
        $this->japanese = $japanese;
    }
}
?>