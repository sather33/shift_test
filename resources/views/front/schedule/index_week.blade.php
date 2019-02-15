@extends('front.layout')
@section('content')
<div class="general_form week_box">
    <form action="" class={{ $shopId == 'Y' ? "table_shopY" : "table_shopA" }}>
        <div class="month_box">
            <div class="month_box_title">
                <div>一</div>
                <div>二</div>
                <div>三</div>
                <div>四</div>
                <div>五</div>
                <div>六</div>
                <div>日</div>
            </div>
            @if ($first_weekday_number>0)
                @for ($k = 0; $k < $first_weekday_number; $k++)
                <div class="black_day"></div>
                @endfor
            @endif
            @foreach($schedules as $schedule)
            <div class="per_day">
                <a class="" href="{{ url('/schedule/'.$schedule->year.'/'.$schedule->month.'/'.$schedule->day.'/edit/admin') }}">
                    <p>{{$schedule->day}}</p>
                </a>
                @foreach ($schedule->shift as $shift)
                <h5 class={{ array_keys($shift)[0] }}>{{ array_keys($shift)[0] }} {{ $shift[array_keys($shift)[0]][0] }}-{{ $shift[array_keys($shift)[0]][1] }}</h5>
                @endforeach
            </div>
            @endforeach
            @if ($first_weekday_number>0)
                @for ($k = 0; $k < 7-(($first_weekday_number+$days)/7); $k++)
                <div class="black_day"></div>
                @endfor
            @endif
        </div>
    </form>
</div>
@stop