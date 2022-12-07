<?php
/**
 * PH35 サンプル6 ドロップダウンリスト生成 Src1/2
 *
 * @author Shinzo SAITO
 *
 * ファイル名=Airport.php
 * フォルダ=/ph35/dropdown/
 */

/**
 * 空港エンティティクラス。
 */
class Airport{
    /**
     * @var 空港コード。
     */
    private ?string $apCode = "";
    /**
     * @var 空港名(アルファベット)。
     */
    private ?string $apName = "";
    /**
     * @var 空港名(漢字)。
     */
    private ?string $apNameKanji = "";

    //以下アクセサメソッド。

    public function getApCode(): ?string{
        return $this->apCode;
    }
    public function setApCode(?string $apCode): void{
        $this->apCode = $apCode;
    }
    public function getApName(): ?string{
        return $this->apName;
    }
    public function setApName(?string $apName): void{
        $this->apName = $apName;
    }
    public function getApNameKanji(): ?string{
        return $this->apNameKanji;
    }
    public function setApNameKanji(?string $apNameKanji): void{
        $this->apNameKanji = $apNameKanji;
    }
}