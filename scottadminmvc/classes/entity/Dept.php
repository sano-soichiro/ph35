<?php
/**
 * PH35 サンプル5 マスターテーブル管理MVC版　Src06/18
 *
 * @author Shinzo SAITO
 *
 * ファイル名=Dept.php
 * フォルダ=/ph35/scottadminmvc/classes/entity/
 */
namespace LocalHalPH35\ScottAdminMVC\Classes\entity;

/**
 * 部門エンティティクラス
 */
class Dept{
    /**
     * ID。
     */
    private ?int $id = null;
    /**
     * 部門番号。
     */
    private ?int $dpNo = null;
    /**
     * 部門名。
     */
    private ?string $dpName = "";
    /**
     * 所在地。
     */
    private ?string $dpLoc = "";

    //以下アクセサメソッド。

    public function getId(): ?int{
        return $this->id;
    }
    public function setId(int $id): void{
        $this->id = $id;
    }
    public function getDpNo(): ?int{
        return $this->dpNo;
    }
    public function setDpNo(int $dpNo): void{
        $this->dpNo = $dpNo;
    }
    public function getDpName(): ?string{
        return $this->dpName;
    }
    public function setDpName(string $dpName): void{
        $this->dpName = $dpName;
    }
    public function getDpLoc(): ?string{
        return $this->dpLoc;
    }
    public function setDpLoc(?string $dpLoc): void{
        $this->dpLoc = $dpLoc;
    }
}