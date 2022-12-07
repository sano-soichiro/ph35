<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Soichiro SANO">
    <title>従業員情報リスト | ScottAdmin Sample</title>
    <link rel="stylesheet" href="/css/main.css" type="text/css">
</head>
<body>
    <header>
        <h1>従業員情報リスト</h1>
        <p><a href="/logout">ログアウト</a></p>
    </header>
    <nav id="breadcrumbs">
        <ul>
            <li><a href="/">TOP</a></li>
            <li>従業員情報リスト</li>
        </ul>
    </nav>
    @if(session("flashMsg"))
    <section id="flashMsg">
        <p>{{session("flashMsg")}}</p>
    </section>
    @endif
    <section>
        <p>
            新規登録は<a href="/emp/goEmpAdd">こちら</a>から
        </p>
    </section>
    <section>
        <table>
            <thead>
                <tr>
                    <th>従業員ID</th>
                    <th>従業員番号</th>
                    <th>従業員名</th>
                    <th>役職</th>
                    <th>上司番号</th>
                    <th>雇用日</th>
                    <th>給与</th>
                    <th>所属部門ID</th>
                    <th colspan="2">操作</th>
                </tr>
            </thead>
            <tbody>
                @forelse($empList as $emp)
                <tr>
                    <td>{{$emp->getId()}}</td>
                    <td>{{$emp->getEmNo()}}</td>
                    <td>{{$emp->getEmName()}}</td>
                    <td>{{$emp->getEmJob()}}</td>
                    <td>{{$emp->getEmMgr()}}</td>
                    <td>{{$emp->getEmHiredate()}}</td>
                    <td>{{$emp->getEmSal()}}</td>
                    <td>{{$emp->getDeptId()}}</td>
                    <td>
                        <a href="/emp/prepareEmpEdit/{{$emp->getId()}}">編集</a>
                    </td>
                    <td>
                        <a href="/emp/confirmEmpDelete/{{$emp->getId()}}">削除</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10">該当部門は存在しません。</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </section>
</body>
</html>