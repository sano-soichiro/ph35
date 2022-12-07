<?php
/**
* PH35 サンプル6 ドロップダウンリスト生成 Src2/2
* 運航路線登録画面表示。
*
* @author Shinzo SAITO
*
* ファイル名=inputAirroute.php
* フォルダ=/ph35/dropdown/
*/

require_once("Airport.php");

$dsn = "mysql:host=localhost;dbname=ph35sql;charset=utf8";
$username = "ph35sqlusr";
$password = "hogehoge";

$apList = [];
try{
    $db = new PDO($dsn, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $sql = "SELECT * FROM airports ORDER BY ap_name";
    $stmt = $db->prepare($sql);
    $result = $stmt->execute();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $apCode = $row["ap_code"];
        $apName = $row["ap_name"];
        $apNameKanji = $row["ap_name_kanji"];

        $airport = new Airport();
        $airport->setApCode($apCode);
        $airport->setApName($apName);
        $airport->setApNameKanji($apNameKanji);

        $apList[$apCode] = $airport;
    }
}
catch(PDOException $ex){
    var_dump($ex);
    print("DB接続に失敗しました。");
}
finally{
    $db = null;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Shinzo SAITO">
    <title>PH35 サンプル6 | ドロップダウンリスト | 運航路線登録</title>
    <style type="text/css">
    table{
        border-collapse: collapse;
    }
    table th{
        border: solid 1px black;
        text-align: left;
    }
    table td{
        border: solid 1px black;
    }
    .submit{
        text-align:center;
    }
    </style>
</head>
<body>
    <h1>運航路線登録</h1>
    <section>
        <p>情報を入力し、登録ボタンをクリックしてください。</p>
        <form action="#" method="post">
            <table>
                <tbody>
                    <tr>
                        <th><label for="addAirrouteName">便名</label></th>
                        <td>
                            <input type="text" id="addAirrouteName" name="addAirrouteName" value="" required>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="addAirrouteFromAirport">出発空港</label></th>
                        <td>
                        <select name="addAirrouteFromAirport" id="addAirrouteFromAirport" required>
                        <option value="">選択してください</option>
                        <?php
                            foreach($apList as $apCode => $airport){
                        ?>
                        <option value="<?= $apCode ?>"><?= $apCode ?>: <?= $airport->getApName() ?></option>
                        <?php
                            }
                        ?>
                        </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="addAirrouteToAirport">到着空港</label></th>
                        <td>
                        <select name="addAirrouteToAirport" id="addAirrouteToAirport" required>
                        <option value="">選択してください</option>
                        <?php
                            foreach($apList as $apCode => $airport){
                        ?>
                        <option value="<?= $apCode ?>"><?= $apCode ?>: <?= $airport->getApName() ?></option>
                        <?php
                            }
                        ?>
                        </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="addAirrouteFromTimeHour">出発時刻</label></th>
                        <td>
                        <select name="addAirrouteFromTimeHour" id="addAirrouteFromTimeHour">
                        <?php
                            for($hour = 0; $hour <= 23; $hour++){
                        ?>
                        <option value="<?= $hour ?>"><?= $hour ?></option>
                        <?php
                            }
                        ?>
                        </select>
                        :
                        <select name="addAirrouteFromTimeMinute" id="addAirrouteFromTimeMinute">
                        <?php
                            for($minute = 0; $minute <= 59; $minute++){
                        ?>
                        <option value="<?= $minute ?>"><?= $minute ?></option>
                        <?php
                            }
                        ?>
                        </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="addAirrouteToTimeHour">到着時刻</label></th>
                        <td>
                        <select name="addAirrouteToTimeHour" id="addAirrouteToTimeHour">
                        <?php
                            for($hour = 0; $hour <= 23; $hour++){
                        ?>
                        <option value="<?= $hour ?>"><?= $hour ?></option>
                        <?php
                            }
                        ?>
                        </select>
                        :
                        <select name="addAirrouteToTimeMinute" id="addAirrouteToTimeMinute">
                        <?php
                            for($minute = 0; $minute <= 59; $minute++){
                        ?>
                        <option value="<?= $minute ?>"><?= $minute ?></option>
                        <?php
                            }
                        ?>
                        </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="submit">
                            <input type="submit" value="登録">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </section>
</body>
</html>