<?php
/**
 * PH35 サンプル1　クラスの復習 Src7/7
 * コンストラクタ
 * 実行ファイル
 * 
 * @author Shinzo SAITO
 * 
 * ファイル名=showTestScoreWithConstructor.php
 * フォルダ=/ph35/classes/construcor/
 */
require_once("TestScoreConstructor.php");

$taro = new TestScoreConstructor("たろう" , rand(0 , 100) , rand(0 , 100) , rand(0 , 100));
// $jiro = new TestScoreConstructor();
$hanako = new TestScoreConstructor("はなこ" , rand(0 , 100) , rand(0 , 100) , rand(0 , 100));
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Shinzo SAITO">
    <title>PH35 サンプル1 | クラスの復習 | コンストラクタ</title>
    <style>
        table {
            border-collapse: collapse;
        }
        td, th {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <h1>クラス: コンストラクタ</h1>
    <table>
        <thead>
            <tr>
                <th>名前</th>
                <th>英語</th>
                <th>数学</th>
                <th>国語</th>
                <th>合計</th>
                <th>平均</th>
            </tr>
            <tr>
                <td><?= $taro->getname() ?></td>
                <td><?= $taro->getEnglish() ?></td>
                <td><?= $taro->getMath() ?></td>
                <td><?= $taro->getJapanese() ?></td>
                <td><?= $taro->getSum() ?></td>
                <td><?= $taro->getAve() ?></td>
            </tr>
            <tr>
                <td><?= $hanako->getName() ?></td>
                <td><?= $hanako->getEnglish() ?></td>
                <td><?= $hanako->getMath() ?></td>
                <td><?= $hanako->getJapanese() ?></td>
                <td><?= $hanako->getSum() ?></td>
                <td><?= $hanako->getAve() ?></td>
            </tr>
        </thead>
    </table>
    <p>
        <a href="/ph35/classes/index.html">戻る</a>
    </p>
</body>
</html>