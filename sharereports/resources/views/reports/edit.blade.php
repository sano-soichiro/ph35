<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css" type="text/css">
    <title>editReport</title>
</head>
<body>
    <header>
        <h1>レポート編集</h1>
        <p>ログインユーザー: {{$loginUser['name']}}</p>
        <p><a href="/logout">ログアウト</a></p>
    </header>
    <nav id="breadcrumbs">
        <ul>
            <li><a href="/reports/showList/{{0}}">レポートリスト</a></li>
            <li><a href="/reports/detail/{{$report->getId()}}">レポート詳細</a></li>
            <li>レポート編集</li>
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
        <form action="/reports/edit" method="post" class="box">
            @csrf
            レポートID:&nbsp;{{$report->getId()}}<br>
            <input type="hidden" name="editId" value="{{$report->getId()}}" required>
            <label for="editRpTimeTo">
                作業日&nbsp;<span class="required">必須</span>
                <select name="editRpDateYear" id="editRpDateYear" required>
                    <option value="" selected>--</option>
                    @for($year = 2022; $year > 1980; $year--)
                        @if($report->getRpDateYear() == $year)
                    <option value="{{$year}}" selected>{{$year}}</option>
                        @else
                    <option value="{{$year}}">{{$year}}</option>
                        @endif
                    @endfor
                </select>
                <select name="editRpDateMonth" id="editRpDateMonth" required>
                    <option value="" selected>--</option>
                    @for($month = 01; $month <= 12; $month++)
                        @if($report->getRpDateMonth() == $month)
                    <option value="{{$month}}" selected>{{$month}}</option>
                        @else
                    <option value="{{$month}}">{{$month}}</option>
                        @endif
                    @endfor
                </select>
                <select name="editRpDateDay" id="editRpDateDay" required>
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
            <label for="editRpTimeFrom">
                作業開始時刻&nbsp;<span class="required">必須</span>
                <input type="time" id="editRpTimeFrom" name="editRpTimeFrom" value="{{$report->getRpTimeFrom()}}" required>
            </label><br>
            <label for="editRpTimeTo">
                作業終了時刻&nbsp;<span class="required">必須</span>
                <input type="time" id="editRpTimeTo" name="editRpTimeTo" value="{{$report->getRpTimeTo()}}" required>
            </label><br>
            <label for="editReportcateId">
                作業種類&nbsp;<span class="required">必須</span>
                <select id="editReportcateId" name="editReportcateId" required>
                @foreach($reportcate as $cateId => $repocate)
                @if($repocate->getId() != 0 && $repocate->getId() == $report->getReportcateId())
                <option value="{{$repocate->getId()}}" selected>{{$repocate->getRcName()}}</option>
                @else
                <option value="{{$repocate->getId()}}">{{$repocate->getRcName()}}</option>
                @endif
                @endforeach
                </select>
            </label><br>
            <label for="editRpContent">
                作業内容&nbsp;<span class="required">必須</span>
                <textarea id="editRpContent" name="editRpContent" cols="50" rows="20" required>{{$report->getRpContent()}}</textarea>
            </label><br>
            <button type="submit">更新</button>
        </form>
    </section>
</body>
</html>
