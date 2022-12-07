<?php

$numes = [];
$denomis = [];
for($i = 0; $i <= 5; $i++) {
    $numes[] = rand(0, 9);
    $denomis[] = rand(0, 9);
}
foreach($denomis as $denomi) {
    print("■分母の値：　".$denomi."<br>");
    if($denomi === 0) {
        print("分母が0なので処理を中止します<br>");
        break;
    }
    foreach($numes as $nume) {
        print("--分母の値：　".$nume);
        if($nume === 0) {
            print("→分子が0なので次の分子にスキップします<br>");
            continue;
        }
        $ans = $nume / $denomi;
        print("→分数値：　".$ans."<br>");
    }
}