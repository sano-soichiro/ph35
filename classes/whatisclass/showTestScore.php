<?php
/**
 * PH35 サンプル1　クラスの復習 Src3/7
 * クラスとは
 * 実行ファイル
 * 
 * @author Shinzo SAITO
 * 
 * ファイル名=showTestScore.php
 * フォルダ=/ph35/classes/whatisclass
 */
require_once("TestScore.php");

$taro = new TestSCore();
$taro->setData("たろう" , rand(0 , 100) , rand(0 , 100) , rand(0 , 100));

$hanako = new TestSCore();
$hanako->setData("はなこ" , rand(0 , 100) , rand(0 , 100) , rand(0 , 100));
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Shinzo SAITO">
    <title>PH35 サンプル1 | クラスの復習 | クラスとは</title>
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
    <h1>クラス: クラスとは</h1>
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
                <td><?= $taro->name ?></td>
                <td><?= $taro->english ?></td>
                <td><?= $taro->math ?></td>
                <td><?= $taro->japanese ?></td>
                <td><?= $taro->getSum() ?></td>
                <td><?= $taro->getAve() ?></td>
            </tr>
            <tr>
                <td><?= $hanako->name ?></td>
                <td><?= $hanako->english ?></td>
                <td><?= $hanako->math ?></td>
                <td><?= $hanako->japanese ?></td>
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