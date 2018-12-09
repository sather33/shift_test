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

        <form class="form-horizontal" action="{{ url('/schedules/check') }}" method="POST" enctype="multipart/form-data" role="form">

            {!! csrf_field() !!}

            <label for="checked_month">查詢劃班情況</label>
            <select name="checked_year" id="checked_year" class="form-control">
                <option value="2018">2018</option>
                <option value="2019">2019</option>
            </select>
            <select id="checked_month" name="checked_month" class="form-control">
                <option value=""></option>
                @for ($i = 1; $i <= '12'; $i++)
                <option value="{{$i}}">{{$i}}</option>
                @endfor
            </select>
            <input type="submit" class="btn btn-success" value="查詢">
        </form>

        <form class="form-horizontal" action="{{ url('/calculate_time') }}" method="POST" enctype="multipart/form-data" role="form">

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
        </form>

        <form class="form-horizontal" action="{{ url('/shift_schedule') }}" method="POST" enctype="multipart/form-data" role="form"
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
        </form>

        <form class="form-horizontal" action="{{ url('/publish_schedule') }}" method="POST" enctype="multipart/form-data" role="form"
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
        </form>

        <form class="form-horizontal" action="{{ url('/limit') }}" method="POST" enctype="multipart/form-data" role="form"
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
            <!-- <select id=limit_hour" name=limit_hour" class="form-control"> -->
            <select id="limit_hour" name="limit_hour" class="form-control" >
                <option value=""></option>
                @for ($i = 1; $i <= '24'; $i++)
                <option value="{{$i}}" {{ $option->limit_hour == $i ? 'selected' :'' }}>{{$i}}</option>
                @endfor
            </select>
            <span>時&nbsp;</span>
            <input type="submit" class="btn btn-success" value="儲存">
        </form>
    </div>
</div>
@stop