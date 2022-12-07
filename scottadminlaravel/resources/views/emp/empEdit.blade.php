<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Shinzo SAITO">
    <title>従業員情報編集 | ScottAdmin Sample</title>
    <link rel="stylesheet" href="/css/main.css" type="text/css">
</head>
<body>
    <header>
        <h1>従業員情報編集</h1>
        <p><a href="/logout">ログアウト</a></p>
    </header>
    <nav id="breadcrumbs">
        <ul>
            <li><a href="/">TOP</a></li>
            <li><a href="/emp/showEmpList">従業員リスト</a></li>
            <li>従業員情報編集</li>
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
        <p>情報を入力し、更新ボタンをクリックしてください。</p>
        <form action="/emp/empEdit" method="post" class="box">
        @csrf
            従業員ID:&nbsp;{{$emp->getId()}}<br>
            <input type="hidden" name="editEmpId" value="{{$emp->getId()}}">
            <label for="editEmpNo">
                従業員番号&nbsp;<span class="required">必須</span>
                <input type="number" min=1000 max=9999 id="editEmpNo" name="editEmpNo" value="{{$emp->getEmNo()}}" required>
            </label><br>
            <label for="editEmpName">
                従業員名&nbsp;<span class="required">必須</span>
                <input type="text" id="editEmpName" name="editEmpName" value="{{$emp->getEmName()}}" required>
            </label><br>
            <label for="editEmpJob">
                役職&nbsp;<span class="required">必須</span>
                <input type="text" id="editEmpJob" name="editEmpJob" value="{{$emp->getEmJob()}}" required>
            </label><br>
            <label for="editEmpMgr">
                上司&nbsp;<span class="required">必須</span>
                <select name="editEmpMgr" id="editEmpMgr" required>
                    @if($emp->getEmMgr() == 0)
                    <option value="0" selected>0：上司なし</option>
                    @else
                    <option value="0">0：上司なし</option>
                    @endif
                    @foreach($empMgrList as $mgr)
                        @if($emp->getEmMgr() != 0 && $emp->getEmMgr() == $mgr[0])
                    <option value="{{$mgr[0]}}" selected>{{$mgr[1] . ":" . $mgr[0]}}</option>
                        @else
                    <option value="{{$mgr[0]}}">{{$mgr[1] . ":" . $mgr[0]}}</option>
                        @endif
                    @endforeach
                </select>
            </label><br>
            <label for="editEmpHiredate">
                雇用日&nbsp;<span class="required">必須</span>
                <select name="year" id="year" required>
                    <option value="" selected>--</option>
                    @for($year= 2022; $year > 1980; $year--)
                        @if($emp->getEmHiredateYear() == $year)
                    <option value="{{$year}}" selected>{{$year}}</option>
                        @else
                    <option value="{{$year}}">{{$year}}</option>
                        @endif
                    @endfor
                </select>
                <select name="month" id="month" required>
                    <option value="" selected>--</option>
                    @for($month = 1; $month < 12; $month++)
                        @if($emp->getEmHiredateMonth() == $month)
                    <option value="{{$month}}" selected>{{$month}}</option>
                        @else
                    <option value="{{$month}}">{{$month}}</option>
                        @endif
                    @endfor
                </select>
                <select name="day" id="day" required>
                    <option value="" selected>--</option>
                    @for($day = 1; $day < 31; $day++ )
                        @if($emp->getEmHiredateDay() == $day)
                    <option value="{{$day}}" selected>{{$day}}</option>
                        @else
                    <option value="{{$day}}">{{$day}}</option>
                        @endif
                    @endfor
                </select>
            </label><br>
            <label for="editEmpSal">
                給与&nbsp;<span class="required">必須</span>
                <input type="number" min=0 id="editEmpSal" name="editEmpSal" value="{{$emp->getEmSal()}}" required>
            </label><br>
            <label for="editDpId">
                所属部門&nbsp;<span class="required">必須</span>
                <select name="editDeptId" id="editDeptId" required>
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
            <button type="submit">更新</button>
        </form>
    </section>
</body>
</html>