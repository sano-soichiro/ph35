<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Shinzo SAITO">
    <title>従業員情報追加 | ScottAdmin Sample</title>
    <link rel="stylesheet" href="/css/main.css" type="text/css">
</head>
<body>
    <header>
        <h1>従業員情報追加</h1>
        <p><a href="/logout">ログアウト</a></p>
    </header>
    <nav id="breadcrumbs">
        <ul>
            <li><a href="/">TOP</a></li>
            <li><a href="/emp/showEmpList">従業員リスト</a></li>
            <li>従業員情報追加</li>
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
        <p>情報を入力し、登録ボタンをクリックしてください。</p>
        <form action="/emp/empAdd" method="post" class="box">
        @csrf
            <label for="addEmpNo">
                従業員番号&nbsp;<span class="required">必須</span>
                <input type="number" min=1000 max=9999 id="addEmpNo" name="addEmpNo" value="{{$emp->getEmNo()}}" required>
            </label><br>
            <label for="addEmpName">
                従業員名&nbsp;<span class="required">必須</span>
                <input type="text" id="addEmpName" name="addEmpName" value="{{$emp->getEmName()}}" required>
            </label><br>
            <label for="addEmpJob">
                役職&nbsp;<span class="required">必須</span>
                <input type="text" id="addEmpJob" name="addEmpJob" value="{{$emp->getEmJob()}}" required>
            </label><br>
            <label for="addEmpMgr">
                上司&nbsp;<span class="required">必須</span>
                <select name="addEmpMgr" id="addEmpMgr" required>
                    <option value="" selected>--</option>
                    @if($emp->getEmMgr() === 0)
                    <option value="0" selected>0：上司なし</option>
                    @else
                    <option value="0">0：上司なし</option>
                    @endif
                    @foreach($empMgrList as $mgr)
                        @if($emp->getEmMgr() != 0 && $emp->getEmMgr() == $mgr[0])
                    <option value="{{$mgr[0]}}" selected>{{$mgr[1] . "：" . $mgr[0]}}</option>
                        @else
                    <option value="{{$mgr[0]}}">{{$mgr[1] . "：" . $mgr[0]}}</option>
                        @endif
                    @endforeach
                </select>
            </label><br>
            <label for="addEmpHiredate">
                雇用日&nbsp;<span class="required">必須</span>
                <select name="year" id="year" required>
                    <option value="" selected>--</option>
                    @for($year = 2022; $year > 1980; $year--)
                        @if($emp->getEmHiredateYear() == $year)
                    <option value="{{$year}}" selected>{{$year}}</option>
                        @else
                    <option value="{{$year}}">{{$year}}</option>
                        @endif
                    @endfor
                </select>
                <select name="month" id="month" required>
                    <option value="" selected>--</option>
                    @for($month = 01; $month < 12; $month++)
                        @if($emp->getEmHiredateMonth() == $month)
                    <option value="{{$month}}" selected>{{$month}}</option>
                        @else
                    <option value="{{$month}}">{{$month}}</option>
                        @endif
                    @endfor
                </select>
                <select name="day" id="day" required>
                    <option value="" selected>--</option>
                    @for($day = 01; $day < 31; $day++)
                        @if($emp->getEmHiredateDay() == $day)
                    <option value="{{$day}}" selected>{{$day}}</option>
                        @else
                    <option value="{{$day}}">{{$day}}</option>
                        @endif
                    @endfor
                </select>
            </label><br>
            <label for="addEmpSal">
                給与&nbsp;<span class="required">必須</span>
                <input type="number" min=0 id="addEmpSal" name="addEmpSal" value="{{$emp->getEmSal()}}" required>
            </label><br>
            <label for="addDpId">
                所属部門&nbsp;<span class="required">必須</span>
                <select name="addDeptId" id="addDeptId" required>
                    <option value="" selected>--</option>
                    @foreach($deptList as $dept)
                        @if($emp->getDeptId() == $dept->getId())
                    <option value="{{$dept->getId()}}" selected>{{$dept->getDpNo() . ":" . $dept->getDpName()}}</option>
                        @else
                    <option value="{{$dept->getId()}}">{{$dept->getDpNo() . ":" . $dept->getDpName()}}</option>
                        @endif
                    @endforeach
                </select>
            </label><br>
            <button type="submit">登録</button>
        </form>
    </section>
</body>
</html>