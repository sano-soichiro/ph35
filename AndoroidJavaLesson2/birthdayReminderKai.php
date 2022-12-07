<?php
require_once('class/girlfriend.php');

$girlFriends = [
    new GirlFriend("まゆみ", 1999, 1, 5),
    new GirlFriend("ちさこ", 2004, 5, 15),
    new GirlFriend("まい", 1997, 5, 25),
    new GirlFriend("なみ", 2000, 8, 3),
    new GirlFriend("えり", 2002, 11, 19),
    new GirlFriend("りえ", 1998, 12, 23)
];

for ($i = 1; $i <= 12; $i++) {
    $flg = true;
    print("■■■■". $i ."月です。<br>");
    foreach ($girlFriends as $girlFriend) {
        if ($girlFriend->isBirthMonth(($i))) {
            print($girlFriend->getName()."ちゃんが".$girlFriend->getBirthDay()."日に誕生日です。".$girlFriend->getAge(2022)."歳になります。メッセージを送りましょう！<br>");
            $flg = false;
        }
    }
    if ($flg) {
        print("誕生日を迎える女性はいません。安心してください。<br>");
    }
}