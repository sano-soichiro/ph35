<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css" type="text/css">
    <title>deleteReport</title>
</head>
<body>
    <header>
        <h1>レポート削除</h1>
        <p>ログインユーザー: {{$loginUser['name']}}</p>
        <p><a href="/logout">ログアウト</a></p>
    </header>
    <nav id="breadcrumbs">
        <ul>
            <li><a href="/reports/showList/{{0}}">レポートリスト</a></li>
            <li><a href="/reports/detail/{{$reportDetail['report']->getId()}}">レポート詳細</a></li>
            <li>レポート削除確認</li>
        </ul>
    </nav>
    <section>
        <p>
            以下の部門情報を削除します。<br>
            よろしければ、削除ボタンをクリックしてください。
        </p>
        <dl>
        <dt>レポートID</dt>
            <dd>{{$reportDetail['report']->getId()}}</dd>
            <dt>報告者名 : 報告者メールアドレス</dt>
            <dd>{{$reportDetail['user']->getUsName() . " : " . $reportDetail['user']->getUsMail()}}</dd>
            <dt>作業日</dt>
            <dd>{{$reportDetail['report']->getRpDate()}}</dd>
            <dt>作業開始時刻</dt>
            <dd>{{$reportDetail['report']->getRpTimeFrom()}}</dd>
            <dt>作業終了時刻</dt>
            <dd>{{$reportDetail['report']->getRpTimeTo()}}</dd>
            <dt>作業種類</dt>
            <dd>{{$reportDetail['reportcate']->getRcName()}}</dd>
            <dt>作業内容</dt>
            <dd>{!!nl2br(e($reportDetail['report']->getRpContent()))!!}</dd>
            <dt>レポート登録日時</dt>
            <dd>{{$reportDetail['report']->getRpCreatedAt()}}</dd>
        </dl>
        <form action="/reports/delete" method="post">
            @csrf
            <input type="hidden" id="deleteRpId" name="deleteRpId" value="{{$reportDetail['report']->getId()}}">
            <button type="submit">削除</button>
        </form>
    </section>
</body>
</html>