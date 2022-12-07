<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css" type="text/css">
    <title>ReportsList</title>
</head>
<body>
    <header>
        <h1>レポートリスト</h1>
        <p>ログインユーザー: {{$loginUser['name']}}</p>
        <p><a href="/logout">ログアウト</a></p>
    </header>
    <nav id="breadcrumbs">
        <ul>
            <li>レポートリスト</li>
        </ul>
    </nav>
    @if(session("flashMsg"))
    <section id="flashMsg">
        <p>{{session("flashMsg")}}</p>
    </section>
    @endif
    <section>
        <p>
            新規登録は<a href="/reports/goAdd">こちら</a>から
        </p>
    </section>
    <section>
        <table>
            <thead>
                <tr>
                    <th>レポートID</th>
                    <th>作業日</th>
                    <th>報告者名</th>
                    <th>作業内容</th>
                    <th colspan="1">操作</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reportList as $rpId => $report)
                <tr>
                    <td>{{$rpId}}</td>
                    <td>{{$report['report']->getRpDate()}}</td>
                    <td>{{$report['user']->getUsName()}}</td>
                    <td>{{$report['report']->getRpContent()}}</td>
                    <td>
                        <a href="/reports/detail/{{$rpId}}">詳細</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">該当レポートは存在しません。</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </section>
    <section>
        <ul class="page">
            <li>
                <a class="{{$firstPage}}" href="/reports/showList/{{$nowPage-1}}">前へ</a>
            </li>
            @for($i=0; $i<$maxPage; $i++)
            <li>
                <a class="{{$nowPage == $i ? 'now' : 'another'}}" href="/reports/showList/{{$i}}">{{$i+1}}</a>
            </li>
            @endfor
            <li>
                <a class="{{$lastPage}}" href="/reports/showList/{{$nowPage+1}}">次へ</a>
            </li>
        </ul>
    </section>
</body>
</html>