<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Shinzo SAITO">
    <title>部門情報削除 | ScottAdminMiddle Sample</title>
    <link rel="stylesheet" href="/css/main.css" type="text/css">
</head>
<body>
    <header>
        <h1>部門情報削除</h1>
        <p><a href="/logout">ログアウト</a></p>
    </header>
    <nav id="breadcrumbs">
        <ul>
            <li><a href="/">TOP</a></li>
            <li><a href="/dept/showDeptList">部門リスト</a></li>
            <li>部門情報削除確認</li>
        </ul>
    </nav>
    <section>
        <p>
            以下の部門情報を削除します。<br>
            よろしければ、削除ボタンをクリックしてください。
        </p>
        <dl>
            <dt>ID</dt>
            <dd>{{$dept->getId()}}</dd>
            <dt>部門番号</dt>
            <dd>{{$dept->getDpNo()}}</dd>
            <dt>部門名</dt>
            <dd>{{$dept->getDpName()}}</dd>
            <dt>所在地</dt>
            <dd>{{$dept->getDpLoc()}}</dd>
        </dl>
        <form action="/dept/deptDelete" method="post">
            @csrf
            <input type="hidden" id="deleteDeptId" name="deleteDeptId" value="{{$dept->getId()}}">
            <button type="submit">削除</button>
        </form>
    </section>
</body>
</html>