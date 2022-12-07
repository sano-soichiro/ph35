<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Shinzo SAITO">
    <title>従業員情報削除 | ScottAdmin Sample</title>
    <link rel="stylesheet" href="/css/main.css" type="text/css">
</head>
<body>
    <header>
        <h1>従業員情報削除</h1>
        <p><a href="/logout">ログアウト</a></p>
    </header>
    <nav id="breadcrumbs">
        <ul>
            <li><a href="/">TOP</a></li>
            <li><a href="/emp/showEmpList">従業員リスト</a></li>
            <li>従業員情報削除確認</li>
        </ul>
    </nav>
    <section>
        <p>以下の従業員情報を削除します。</p>
        <dl>
            <dt>従業員ID</dt>
            <dd>{{$emp->getId()}}</dd>
            <dt>従業員番号</dt>
            <dd>{{$emp->getEmNo()}}</dd>
            <dt>従業員名</dt>
            <dd>{{$emp->getEmName()}}</dd>
            <dt>役職</dt>
            <dd>{{$emp->getEmJob()}}</dd>
            <dt>上司番号</dt>
            <dd>{{$emp->getEmMgr()}}</dd>
            <dt>雇用日</dt>
            <dd>{{$emp->getEmHiredate()}}</dd>
            <dt>給与</dt>
            <dd>{{$emp->getEmSal()}}</dd>
            <dt>所属部門ID</dt>
            <dd>{{$emp->getDeptId()}}</dd>
        </dl>
        <form action="/emp/empDelete" method="post">
        @csrf
            <input type="hidden" id="deleteEmpId" name="deleteEmpId" value="{{$emp->getId()}}">
            <button type="submit">削除</button>
        </form>
    </section>
</body>
</html>