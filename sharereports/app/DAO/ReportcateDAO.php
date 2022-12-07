<?php
/**
* PH35 サンプル5 マスタテーブル管理完版 Src06/20
*
* @author Shinzo SAITO
*
* ファイル名=Dept.php
* フォルダ=/ph35/scottadminkan/classes/dao/
*/
namespace App\DAO;

use PDO;
use App\Entity\Reportcate;

/**
* deptテーブルへのデータ操作クラス。
*/
class ReportcateDAO{
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
    * 主キーidによる検索。
    *
    * @param integer $id 主キーであるid。
    * @return Reportcate 該当するDeptオブジェクト。ただし、該当データがない場合はnull。
    */
    public function findByPK(int $id): ?Reportcate{
        $sql = "SELECT * FROM reportcates WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        $report = null;
        if($result && $row = $stmt->fetch()){
            $id = $row["id"];
            $rcName = $row["rc_name"];
            $rcNote = $row["rc_note"];
            $rcListFlg = $row["rc_list_flg"];
            $rcOrder = $row["rc_order"];
        
            $reportcate = new Reportcate();
            $reportcate->setId($id);
            $reportcate->setRcName($rcName);
            $reportcate->setRcNote($rcNote);
            $reportcate->setRcListFlg($rcListFlg);
            $reportcate->setRcOrder($rcOrder);
            $reportList[$id] = $reportcate;
        }
        return $report;
    }
    
    /**
    * 全部門情報検索。
    *
    * @return array
    * 部門情報が格納された連想配列。キーは部門番号、値はReportエンティティオブジェクト。
    */
    public function findAll(): array{
        $sql = "SELECT * FROM reportcates ORDER BY rc_order";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute();
        $reportList = [];
        while($row = $stmt->fetch()){
            $id = $row["id"];
            $rcName = $row["rc_name"];
            $rcNote = $row["rc_note"];
            $rcListFlg = $row["rc_list_flg"];
            $rcOrder = $row["rc_order"];
        
            $reportcate = new Reportcate();
            $reportcate->setId($id);
            $reportcate->setRcName($rcName);
            $reportcate->setRcNote($rcNote);
            $reportcate->setRcListFlg($rcListFlg);
            $reportcate->setRcOrder($rcOrder);
            $reportList[$id] = $reportcate;
        }
        return $reportList;
    }
}