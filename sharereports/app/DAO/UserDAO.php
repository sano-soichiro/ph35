<?php
namespace App\DAO;

use PDO;
use App\Entity\User;

/**
* usersテーブルへのデータ操作クラス。
*/
class UserDAO{
    /**
    * @var PDO DB接続オブジェクト
    */
    private $db;

    /**
    * コンストラクタ
    *
    * @param PDO $db DB接続オブジェクト
    */
    public function __construct(PDO $db){
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->db = $db;
    }

    /**
    * ログインIDによる検索。
    *
    * @param string $loginId ログインID。
    * @return User 該当するUserオブジェクト。ただし、該当データがない場合はnull。
    */
    public function findByEmail(string $usMail): ?User{
        $sql = "SELECT * FROM users WHERE us_mail = :us_mail";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":us_mail", $usMail, PDO::PARAM_INT);
        $result = $stmt->execute();
        $user = null;
        if($result && $row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $id = $row["id"];
            $usMail = $row["us_mail"];
            $usName = $row["us_name"];
            $usPassword = $row["us_password"];
            $usAuth = $row["us_auth"];
            
            $user = new User();
            $user->setId($id);
            $user->setUsMail($usMail);
            $user->setUsName($usName);
            $user->setUsPassword($usPassword);
            $user->setUsAuth($usAuth);
        }
        return $user;
    }

    /**
    * ログイン中ユーザーのID検索。
    *
    * @param integer $id ログインID。
    * @return integer ログイン中ユーザーのID。
    */
    public function findByLoginUser(int $id): ?int{
        $sql = "SELECT id FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        $userId = null;
        if($result && $row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $userId = $row["id"];
        }
        return $userId;
    }
}
