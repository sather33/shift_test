@extends('front.layout')
@section('content')
<div id="content_box">
    <div id="setting_form" class="">
        <h1>後台</h1>
        <form class="form-horizontal" action="{{ url('/setting') }}" method="POST" enctype="multipart/form-data" role="form">

            {!! csrf_field() !!}

            <label for="month">設定劃班月份</label>
            <select id="month" name="month" class="form-control">
                <option value=""></option>
                @for ($i = 1; $i <= '12'; $i++)
                <option value="{{$i}}" {{ ( $i == ( $month ?: '0' ) ) ? 'selected' : '' }}>{{$i}}</option>
                @endfor
            </select>
            <input type="submit" class="btn btn-success" value="儲存">
        </form>
        <form class="form-horizontal" action="{{ url('/limit') }}" method="POST" enctype="multipart/form-data" role="form"
        onsubmit='return confirm("確定要更改截止時間嗎?")'>
            {!! csrf_field() !!}

            <label for="month">設定截止日期</label>
            <select name="limit_date" id="limit_date" class="form-control" >
                <option value=""></option>
                @for ($i = 1; $i <= $current_dates; $i++)
                <option value="{{$i}}" {{ $option->limit_date == $i ? 'selected' :'' }} >{{$i}}</option>
                @endfor
            </select>
            <span>日</span>
            <select id="limit_hour" name="limit_hour" class="form-control" >
                <option value=""></option>
                @for ($i = 1; $i <= '24'; $i++)
                <option value="{{$i}}" {{ $option->limit_hour == $i ? 'selected' :'' }}>{{$i}}</option>
                @endfor
            </select>
            <span>時&nbsp;</span>
            <input type="submit" class="btn btn-success" value="儲存">
        </form>
        @if($member_total)
            @for ($j = 0; $j < count($member_total); $j++)
            <h3>{{ $name = array_keys($member_total)[$j] }}: {{ $member_total[$name] }} 小時</h3>
            @endfor
        @endif

        <table>
            <thead>
                <tr class="head_tr">
                    <th>班表</th>
                    <th>劃班情形</th>
                    <th>時數</th>
                    <th>排班</th>
                    <th>發布</th>
                    <th>月曆</th>
                    <th>匯出</th>
                </tr>
            </thead>
            <tbody>
                @foreach($schedules as $schedule)
                <tr class="body_tr">
                    <th>{{$schedule->year}}/{{$schedule->month}}</th>
                    <th>
                        <form class="form-horizontal" action="{{ url('/schedules/check') }}" method="POST" enctype="multipart/form-data" role="form">
                            {!! csrf_field() !!}

                            <input name="checked_year" hidden value={{$schedule->year}}>
                            <input name="checked_month" hidden value={{$schedule->month}}>
                            <input type="submit" class="btn btn-primary" value="查詢">
                        </form>
                    </th>
                    <th>
                        <form class="form-horizontal" action="{{ url('/calculate_time') }}" method="POST" enctype="multipart/form-data" role="form">
                            {!! csrf_field() !!}

                            <input name="calculate_year" hidden value={{$schedule->year}}>
                            <input name="calculate_month" hidden value={{$schedule->month}}>
                            <input type="submit" class="btn btn-secondary" value="查詢">
                        </form>
                    </th>
                    <th>
                        <form class="form-horizontal" action="{{ url('/shift_schedule') }}" method="POST" enctype="multipart/form-data" role="form">
                            {!! csrf_field() !!}

                            <input name="shift_year" hidden value={{$schedule->year}}>
                            <input name="shift_month" hidden value={{$schedule->month}}>
                            <input type="submit" class="btn btn-warning" value="排班" >
                            <!-- 還沒寫好 -->
                        </form>
                    </th>
                    <th>
                        <form class="form-horizontal" action="{{ url('/publish_schedule') }}" method="POST" enctype="multipart/form-data" role="form"
                            onsubmit='return confirm("確定要發布班表嗎?")'>
                            {!! csrf_field() !!}

                            <input name="publish_year" hidden value={{$schedule->year}}>
                            <input name="publish_month" hidden value={{$schedule->month}}>
                            <input type="submit" class="btn btn-danger" value="發布" {{ $schedule->actived ? 'disabled' : '' }}>
                        </form>
                    </th>
                    <th>
                        <a href="{{ url('/Y/schedules_week/'.$schedule->year.'/'.$schedule->month) }}">延吉</a>
                        <a href="{{ url('/A/schedules_week/'.$schedule->year.'/'.$schedule->month) }}">安東</a>
                    </th>
                    <th>
                        <form class="form-horizontal" action="{{ url('/export') }}" method="POST" enctype="multipart/form-data" role="form">
                            {!! csrf_field() !!}

                            <input name="year" hidden value={{$schedule->year}}>
                            <input name="month" hidden value={{$schedule->month}}>
                            <input type="submit" class="btn btn-dark" value="匯出">
                        </form>
                    </th>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- <form class="form-horizontal" action="{{ url('/calculate_time') }}" method="POST" enctype="multipart/form-data" role="form">

            {!! csrf_field() !!}

            <label for="calculate_month">查詢總時數</label>
            <select name="calculate_year" id="calculate_year" class="form-control">
                <option value="2018">2018</option>
                <option value="2019">2019</option>
            </select>
            <select id="calculate_month" name="calculate_month" class="form-control">
                <option value=""></option>
                @for ($i = 1; $i <= '12'; $i++)
                <option value="{{$i}}">{{$i}}</option>
                @endfor
            </select>
            <input type="submit" class="btn btn-success" value="查詢">
            @if($member_total)
                @for ($j = 0; $j < count($member_total); $j++)
                <h3>{{ $name = array_keys($member_total)[$j] }}: {{ $member_total[$name] }} 小時</h3>
                @endfor
            @endif
        </form> -->

        <!-- <form class="form-horizontal" action="{{ url('/shift_schedule') }}" method="POST" enctype="multipart/form-data" role="form"
            onsubmit='return confirm("確定要排班嗎?")'>

            {!! csrf_field() !!}

            <label for="shift_month">排班</label>
            <select name="shift_year" id="shift_year" class="form-control">
                <option value="2018">2018</option>
                <option value="2019">2019</option>
            </select>
            <select id="shift_month" name="shift_month" class="form-control">
                <option value=""></option>
                @for ($i = 1; $i <= '12'; $i++)
                <option value="{{$i}}">{{$i}}</option>
                @endfor
            </select>
            <input type="submit" class="btn btn-success" value="排班">
        </form> -->

        <!-- <form class="form-horizontal" action="{{ url('/publish_schedule') }}" method="POST" enctype="multipart/form-data" role="form"
            onsubmit='return confirm("確定要發布班表嗎?")'>

            {!! csrf_field() !!}

            <label for="publish_month">發布班表</label>
            <select name="publish_year" id="publish_year" class="form-control">
                <option value="2018">2018</option>
                <option value="2019">2019</option>
            </select>
            <select id="publish_month" name="publish_month" class="form-control">
                <option value=""></option>
                @for ($i = 1; $i <= '12'; $i++)
                <option value="{{$i}}">{{$i}}</option>
                @endfor
            </select>
            <input type="submit" class="btn btn-success" value="發布">
        </form> -->

        <!-- <form class="form-horizontal" action="{{ url('/limit') }}" method="POST" enctype="multipart/form-data" role="form"
            onsubmit='return confirm("確定要更改截止時間嗎?")'>

            {!! csrf_field() !!}

            <label for=limit_hour">更改截止時間</label>
            <select name="limit_date" id="limit_date" class="form-control" >
                <option value=""></option>
                @for ($i = 1; $i <= $current_dates; $i++)
                <option value="{{$i}}" {{ $option->limit_date == $i ? 'selected' :'' }} >{{$i}}</option>
                @endfor
            </select>
            <span>日</span>
            <select id="limit_hour" name="limit_hour" class="form-control" >
                <option value=""></option>
                @for ($i = 1; $i <= '24'; $i++)
                <option value="{{$i}}" {{ $option->limit_hour == $i ? 'selected' :'' }}>{{$i}}</option>
                @endfor
            </select>
            <span>時&nbsp;</span>
            <input type="submit" class="btn btn-success" value="儲存">
        </form> -->

        <!-- <form class="form-horizontal" action="{{ url('/schedules_week') }}" method="POST" enctype="multipart/form-data" role="form">

            {!! csrf_field() !!}

            <label for=month">用月份查詢班表</label>
            <select name="year" id="year" class="form-control">
                <option value="2018">2018</option>
                <option value="2019">2019</option>
            </select>
            <select id="month" name="month" class="form-control">
                <option value=""></option>
                @for ($i = 1; $i <= '12'; $i++)
                <option value="{{$i}}">{{$i}}</option>
                @endfor
            </select>
            <input type="submit" class="btn btn-success" value="查詢">
        </form> -->
    </div>
</div>
@stop