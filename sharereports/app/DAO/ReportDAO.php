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
use App\Entity\Report;
use App\Entity\User;
use App\Entity\Reportcate;

/**
* deptテーブルへのデータ操作クラス。
*/
class ReportDAO{
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
    * @return Report 該当するDeptオブジェクト。ただし、該当データがない場合はnull。
    */
    public function findByPK(int $id): ?Report{
        $sql = "SELECT * FROM reports WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        $report = null;
        if($result && $row = $stmt->fetch()){
            $id = $row["id"];
            $rpDate = $row["rp_date"];
            $rpTimeFrom = $row["rp_time_from"];
            $rpTimeTo = $row["rp_time_to"];
            $rpContent = $row["rp_content"];
            $rpCreatedAt = $row["rp_created_at"];
            $reportcateId = $row["reportcate_id"];
            $userId = $row["user_id"];
        
            $report = new Report();
            $report->setId($id);
            $report->setRpDate($rpDate);
            $report->setRpTimeFrom($rpTimeFrom);
            $report->setRpTimeTo($rpTimeTo);
            $report->setRpContent($rpContent);
            $report->setRpCreatedAt($rpCreatedAt);
            $report->setReportcateId($reportcateId);
            $report->setUserId($userId);
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
        $sql = "SELECT * FROM reports ORDER BY rp_date";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute();
        $reportList = [];
        while($row = $stmt->fetch()){
            $id = $row["id"];
            $rpDate = $row["rp_date"];
            $rpTimeFrom = $row["rp_time_from"];
            $rpTimeTo = $row["rp_time_to"];
            $rpContent = $row["rp_content"];
            $rpCreatedAt = $row["rp_created_at"];
            $reportcateId = $row["reportcate_id"];
            $userId = $row["user_id"];
        
            $report = new Report();
            $report->setId($id);
            $report->setRpDate($rpDate);
            $report->setRpTimeFrom($rpTimeFrom);
            $report->setRpTimeTo($rpTimeTo);
            $report->setRpContent($rpContent);
            $report->setRpCreatedAt($rpCreatedAt);
            $report->setReportcateId($reportcateId);
            $report->setUserId($userId);
            $reportList[$id] = $report;
        }
        return $reportList;
    }

    /**
    * 全部門情報検索。
    *
    * @param int $limit
    * @param int $offset
    * @return array
    * 部門情報が格納された連想配列。キーは部門番号、値はReportエンティティオブジェクト。
    */
    public function findListAll(int $limit, int $offset): array{
        $sql = "SELECT r.id, r.rp_date, r.rp_content, u.us_name FROM reports AS r INNER JOIN users AS u ON r.user_id = u.id ORDER BY rp_date DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
        $result = $stmt->execute();
        $reportList = [];
        while($row = $stmt->fetch()){
            $id = $row["id"];
            $rpDate = $row["rp_date"];
            $rpContent = $row["rp_content"];
            $usName = $row["us_name"];
        
            $report = new Report();
            $report->setId($id);
            $report->setRpDate($rpDate);
            $report->setRpContent(mb_substr($rpContent, 0, 10));
            $user = new User();
            $user->setUsName($usName);
            $reportList[$id]['report'] = $report;
            $reportList[$id]['user'] = $user;
        }
        return $reportList;
    }

    /**
    * レポートの総数検出。
    *
    * @return int
    * レポートの総数。
    */
    public function reportCount(): int{
        $sql = "SELECT COUNT(*) AS 'count' FROM reports";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute();
        $reportCount = 0;
        if($row = $stmt->fetch()){
            $reportCount = $row['count'];
        }
        return $reportCount;
    }

    /**
    * 全部門情報検索。
    *
    * @return array
    * 部門情報が格納された連想配列。キーは部門番号、値はReportエンティティオブジェクト。
    */
    public function findDetail(int $id): array{
        $sql = "SELECT r.id, r.rp_date, r.rp_content, r.rp_time_from, r.rp_time_to, r.rp_created_at, u.us_name, u.us_mail, c.rc_name FROM reports AS r INNER JOIN users AS u on r.user_id = u.id INNER JOIN reportcates AS c on r.reportcate_id = c.id WHERE r.id = :id;";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        $reportList = [];
        if($result && $row = $stmt->fetch()){
            $id = $row["id"];
            $rpDate = $row["rp_date"];
            $rpContent = $row["rp_content"];
            $rpTimeFrom = $row["rp_time_from"];
            $rpTimeTo = $row["rp_time_to"];
            $rpCreatedAt = $row["rp_created_at"];
            $usName = $row["us_name"];
            $usMail = $row["us_mail"];
            $rcName = $row["rc_name"];
        
            $report = new Report();
            $report->setId($id);
            $report->setRpDate($rpDate);
            $report->setRpContent($rpContent);
            $report->setRpTimeFrom($rpTimeFrom);
            $report->setRpTimeTo($rpTimeTo);
            $report->setRpCreatedAt($rpCreatedAt);
            $reportcate = new Reportcate();
            $reportcate->setRcName($rcName);
            $user = new User();
            $user->setUsName($usName);
            $user->setUsMail($usMail);

            $reportList['report'] = $report;
            $reportList['reportcate'] = $reportcate;
            $reportList['user'] = $user;
        }
        return $reportList;
    }
    
    /**
    * 部門情報登録。
    *
    * @param Dept $dept 登録情報が格納されたDeptオブジェクト。
    * @return integer 登録情報の連番主キーの値。登録に失敗した場合は-1。
    */
    public function insert(Report $report): int{
        $sqlInsert = "INSERT INTO reports (rp_date , rp_time_from , rp_time_to , rp_content , rp_created_at , reportcate_id , user_id) VALUES (:rp_date , :rp_time_from , :rp_time_to , :rp_content , :rp_created_at , :reportcate_id , :user_id)";
        $stmt = $this->db->prepare($sqlInsert);
        $stmt->bindValue(":rp_date", $report->getRpDate(), PDO::PARAM_INT);
        $stmt->bindValue(":rp_time_from", $report->getRpTimeFrom(), PDO::PARAM_INT);
        $stmt->bindValue(":rp_time_to", $report->getRpTimeTo(), PDO::PARAM_INT);
        $stmt->bindValue(":rp_content", $report->getRpContent(), PDO::PARAM_STR);
        $stmt->bindValue(":rp_created_at", $report->getRpCreatedAt(), PDO::PARAM_INT);
        $stmt->bindValue(":reportcate_id", $report->getReportcateId(), PDO::PARAM_INT);
        $stmt->bindValue(":user_id", $report->getUserId(), PDO::PARAM_INT);
        $result = $stmt->execute();
        if($result){
            $rpId = $this->db->lastInsertId();
        }
        else{
            $rpId = -1;
        }
        return $rpId;
    }
    
    /**
    * 部門情報更新。更新対象は1レコードのみ。
    *
    * @param Report $dept
    * 新情報が格納されたReportオブジェクト。主キーがこのオブジェクトのidの値のレコードを更新する。
    * @return boolean 登録が成功したかどうかを表す値。
    */
    public function update(Report $report): bool{
        $sqlUpdate = "UPDATE reports SET rp_date = :rp_date, rp_time_from = :rp_time_from, rp_time_to = :rp_time_to, rp_content = :rp_content, rp_created_at = :rp_created_at, reportcate_id = :reportcate_id, user_id = :user_id  WHERE id = :id;";
        $stmt = $this->db->prepare($sqlUpdate);
        $stmt->bindValue(":rp_date", $report->getRpDate(), PDO::PARAM_INT);
        $stmt->bindValue(":rp_time_from", $report->getRpTimeFrom(), PDO::PARAM_INT);
        $stmt->bindValue(":rp_time_to", $report->getRpTimeTo(), PDO::PARAM_INT);
        $stmt->bindValue(":rp_content", $report->getRpContent(), PDO::PARAM_STR);
        $stmt->bindValue(":rp_created_at", $report->getRpCreatedAt(), PDO::PARAM_INT);
        $stmt->bindValue(":reportcate_id", $report->getReportcateId(), PDO::PARAM_INT);
        $stmt->bindValue(":user_id", $report->getUserId(), PDO::PARAM_INT);
        $stmt->bindValue(":id", $report->getId(), PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }
    
    /**
    * 部門情報削除。削除対象は1レコードのみ。
    *
    * @param integer $id 削除対象の主キー。
    * @return boolean 登録が成功したかどうかを表す値。
    */
    public function delete(int $id): bool{
        $sql = "DELETE FROM reports WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }


}