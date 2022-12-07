<?php
/**
 * PH35 サンプル3 マスターテーブル管理　Src12/12
 * 部門情報削除。
 *
 * @author Shinzo SAITO
 *
 * ファイル名=DeptDelete.php
 * フォルダ=/ph35/scottadmin/public/emp/
 */
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmindao/classes/Conf.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmindao/classes/entity/Emp.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/ph35/scottadmindao/classes/dao/EmpDAO.php");

$deleteEmpId = $_POST["deleteEmpId"];

try{
    $db = new PDO(Conf::DB_DNS , Conf::DB_USERNAME , Conf::DB_PASSWORD);
    $empDAO = new EmpDAO($db);

    $result = $empDAO->delete($deleteEmpId);
    if(!$result){
        $_SESSION["errorMsg"] = "情報削除に失敗しました。もう一度はじめからやり直してください。";
    }
}
catch(PDOException $ex){
    var_dump($ex);
    $_SESSION["errorMsg"] = "DB接続に失敗しました。";
}
finally{
    $db = null;
}
if(isset($_SESSION["errorMsg"])){
    header("Location: /ph35/scottadmindao/public/error.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Shinzo SAITO">
    <title>従業員情報削除完了 | ScottAdmin Sample</title>
    <link rel="stylesheet" href="/ph35/scottadmindao/public/css/main.css" type="text/css">
</head>
<body>
    <h1>従業員情報削除完了</h1>
    <nav id="breadcrumbs">
        <ul>
            <li><a href="/ph35/scottadmindao/">TOP</a></li>
            <li><a href="/ph35/scottadmindao/public/emp/showEmpList.php">従業員リスト</a></li>
            <li>従業員情報削除確認</li>
            <li>従業員情報削除完了</li>
        </ul>
    </nav>
    <section>
        <p>従業員ID<?= $deleteEmpId ?>の情報を削除しました。</p>
        <p>従業員リストに<a href="/ph35/scottadmindao/public/emp/showEmpList.php">戻る</a></p>
        </form>
    </section>
</body>
</html>
