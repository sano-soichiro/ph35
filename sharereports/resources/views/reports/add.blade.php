<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css" type="text/css">
    <title>addReport</title>
</head>
<body>
    <header>
        <h1>レポート新規作成</h1>
        <p>ログインユーザー: {{$loginUser['name']}}</p>
        <p><a href="/logout">ログアウト</a></p>
    </header>
    <nav id="breadcrumbs">
        <ul>
            <li><a href="/reports/showList/{{0}}">レポートリスト</a></li>
            <li>レポート新規登録</li>
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
            情報を入力し、作成ボタンをクリックしてください。
        </p>
        <form action="/reports/add" method="post" class="box">
            @csrf
            <label for="addRpDate">
                作業日&nbsp;<span class="required">必須</span>
                <select name="addRpDateYear" id="addRpDateYear" required>
                    <option value="" selected>--</option>
                    @for($year = 2022; $year > 1980; $year--)
                        @if($report->getRpDateYear() == $year)
                    <option value="{{$year}}" selected>{{$year}}</option>
                        @else
                    <option value="{{$year}}">{{$year}}</option>
                        @endif
                    @endfor
                </select>
                <select name="addRpDateMonth" id="addRpDateMonth" required>
                    <option value="" selected>--</option>
                    @for($month = 01; $month <= 12; $month++)
                        @if($report->getRpDateMonth() == $month)
                    <option value="{{$month}}" selected>{{$month}}</option>
                        @else
                    <option value="{{$month}}">{{$month}}</option>
                        @endif
                    @endfor
                </select>
                <select name="addRpDateDay" id="addRpDateDay" required>
                    <option value="" selected>--</option>
                    @for($day = 01; $day <= 31; $day++)
                        @if($report->getRpDateDay() == $day)
                    <option value="{{$day}}" selected>{{$day}}</option>
                        @else
                    <option value="{{$day}}">{{$day}}</option>
                        @endif
                    @endfor
                </select>
            </label><br>
            <label for="addRpTimeFrom">
                作業開始時刻&nbsp;<span class="required">必須</span>
                <input type="time" id="addRpTimeFrom" name="addRpTimeFrom" value="{{$report->getRpTimeFrom()}}" required>
            </label><br>
            <label for="addRpTimeTo">
                作業終了時刻&nbsp;<span class="required">必須</span>
                <input type="time" id="addRpTimeTo" name="addRpTimeTo" value="{{$report->getRpTimeTo()}}" required>
            </label><br>
            <label for="addReportcateId">
                作業種類&nbsp;<span class="required">必須</span>
                <select id="addReportcateId" name="addReportcateId" required>
                <option value="" selected>--</option>
                @foreach($reportcate as $cateId => $repocate)
                @if($repocate->getId() != 0 && $repocate->getId() == $report->getReportcateId())
                <option value="{{$repocate->getId()}}" selected>{{$repocate->getRcName()}}</option>
                @else
                <option value="{{$repocate->getId()}}">{{$repocate->getRcName()}}</option>
                @endif
                @endforeach
                </select>
            </label><br>
            <label for="addRpContent">
                作業内容&nbsp;<span class="required">必須</span>
                <textarea id="addRpContent" name="addRpContent" cols="50" rows="20" required>{{$report->getRpContent()}}</textarea>
            </label><br>
            <button type="submit">作成</button>
        </form>
    </section>
</body>
</html>