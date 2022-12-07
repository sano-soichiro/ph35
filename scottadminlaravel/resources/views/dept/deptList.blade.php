<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Shinzo SAITO">
    <title>部門情報リスト | ScottAdminLaravel Sample</title>
    <link rel="stylesheet" href="/css/main.css" type="text/css">
</head>
<body>
    <header>
        <h1>部門情報リスト</h1>
        <p><a href="/logout">ログアウト</a></p>
    </header>
    <nav id="breadcrumbs">
        <ul>
            <li><a href="/goTop">TOP</a></li>
            <li>部門情報リスト</li>
        </ul>
    </nav>
    @if(session("flashMsg"))
    <section id="flashMsg">
        <p>{{session("flashMsg")}}</p>
    </section>
    @endif
    <section>
        <p>
            新規登録は<a href="/dept/goDeptAdd">こちら</a>から
        </p>
    </section>
    <section>
        <table>
            <thead>
                <tr>
                    <th>部門ID</th>
                    <th>部門番号</th>
                    <th>部門名</th>
                    <th>所在地</th>
                    <th colspan="2">操作</th>
                </tr>
            </thead>
            <tbody>
                @forelse($deptList as $dpId => $dept)
                <tr>
                    <td>{{$dpId}}</td>
                    <td>{{$dept->getDpNo()}}</td>
                    <td>{{$dept->getDpName()}}</td>
                    <td>{{$dept->getDpLoc()}}</td>
                    <td>
                        <a href="/dept/prepareDeptEdit/{{$dpId}}">編集</a>
                    </td>
                    <td>
                        <a href="/dept/confirmDeptDelete/{{$dpId}}">削除</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">該当部門は存在しません。</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </section>
</body>
</html>