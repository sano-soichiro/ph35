<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css" type="text/css">
    <title>reportDetail</title>
</head>
<body>
    <header>
        <h1>レポート詳細</h1>
        <p>ログインユーザー: {{$loginUser['name']}}</p>
        <p><a href="/logout">ログアウト</a></p>
    </header>
    <nav id="breadcrumbs">
        <ul>
            <li><a href="/reports/showList/{{0}}">レポートリスト</a></li>
            <li>レポート詳細</li>
        </ul>
    </nav>
    @if(session("flashMsg"))
    <section id="flashMsg">
        <p>{{session("flashMsg")}}</p>
    </section>
    @endif
    <section>
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
                <td><a href="/reports/prepareEdit/{{$reportDetail['report']->getId()}}">編集</a></td>
                <td><a href="/reports/confirmDelete/{{$reportDetail['report']->getId()}}">削除</a></td>
        </section>
    </body>
</html>