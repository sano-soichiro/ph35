<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Shinzo SAITO">
    <title>部門情報編集 | ScottAdminMiddle Sample</title>
    <link rel="stylesheet" href="/css/main.css" type="text/css">
</head>
<body>
    <header>
        <h1>部門情報編集</h1>
        <p><a href="/logout">ログアウト</a></p>
    </header>
    <nav id="breadcrumbs">
        <ul>
            <li><a href="/goTop">TOP</a></li>
            <li><a href="/dept/showDeptList">部門リスト</a></li>
            <li>部門情報編集</li>
        </ul>
    </nav>
    @isset($validationMsgs)
    <section id="errorMsg">
        <p>以下のメッセージをご確認ください。</p>
        <ul>
            @foreach($validationMsgs as $msg)
            <li>{{$msg}}</li>
            @endforeach
        </ul>
    </section>
    @endisset
    <section>
        <p>
            情報を入力し、更新ボタンをクリックしてください。
        </p>
        <form action="/dept/deptEdit" method="post" class="box">
            @csrf
            部門ID:&nbsp;{{$dept->getId()}}<br>
            <input type="hidden" name="editDpId" value="{{$dept->getId()}}">
            <label for="editDpNo">
                部門番号&nbsp;<span class="required">必須</span>
                <input type="number" min="10" max="90" step="10" id="editDpNo" name="editDpNo" value="{{$dept->getDpNo()}}" required>
            </label><br>
            <label for="editDpName">
                部門名&nbsp;<span class="required">必須</span>
                <input type="text" id="editDpName" name="editDpName" value="{{$dept->getDpName()}}" required>
            </label><br>
            <label for="editDpLoc">
                所在地
                <input type="text" id="editDpLoc" name="editDpLoc" value="{{$dept->getDpLoc()}}">
            </label><br>
            <button type="submit">更新</button>
        </form>
    </section>
</body>
</html>