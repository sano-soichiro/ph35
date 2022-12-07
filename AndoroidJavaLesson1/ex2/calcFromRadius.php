<?php

require_once("CalcCircleAndBall.php");

$rList = [1, 3, 5, 7, 9];

foreach($rList as $radius) {
    print("<p>■■■■ 半径".$radius."の計算結果<br>");
    $calc = new CalcCircleAndBall($radius);
    print("円周：　".$calc->getCircle());
    print(" | 円面積：　".$calc->getArea());
    print(" | 球面積：　".$calc->getSurface());
    print(" | 球体積：　".$calc->getVolume());
    print("</p>");
}