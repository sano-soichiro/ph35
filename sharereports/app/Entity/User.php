<?php
namespace App\Entity;

/**
*ユーザエンティティクラス。
*/
class User{
    /**
    * 主キーのid。
    */
    private ?int $id = null;
    /**
    * メールアドレス。
    */
    private ?string $usMail = "";
    /**
    * パスワード。
    */
    private ?string $usPassword = "";
    /**
    * 氏名。
    */
    private ?string $usName = "";
    /**
    * 権限。
    */
    private ?int $usAuth = null;

    //以下アクセサメソッド。

    public function getId(): ?int{
        return $this->id;
    }
    public function setId(int $id): void{
        $this->id = $id;
    }
    public function getUsMail(): ?string{
        return $this->usMail;
    }
    public function setUsMail(string $usMail): void{
        $this->usMail = $usMail;
    }
    public function getUsPassword(): ?string{
        return $this->usPassword;
    }
    public function setUsPassword(string $usPassword): void{
        $this->usPassword = $usPassword;
    }
    public function getUsName(): ?string{
        return $this->usName;
    }
    public function setUsName(?string $usName): void{
        $this->usName = $usName;
    }
    public function getUsAuth(): ?int{
        return $this->usAuth;
    }
    public function setUsAuth(?int $usAuth): void{
        $this->usAuth = $usAuth;
    }
}