@extends('front.layout')
@section('content')
<div id="content_box" class={{ $shopId == 'Y' ? "table_shopY" : "table_shopA" }}>
    <div class="row">
        <span style="display: none" id="anchor">{{$anchor}}</span>
        @foreach ($schedules as $schedule)
        <div class="table_box">
            <div class="day-off hidden">DAY OFF</div>
            <table class="table" id="{{$schedule->year}}_{{$schedule->month}}_{{$schedule->day}}">
                <thead>
                    <tr>
                        <th class="name">
                            @if (Auth::check())
                            <a class="" href="{{ url('/schedule/'.$schedule->year.'/'.$schedule->month.'/'.$schedule->day.'/edit/normal') }}">修改</a>
                            @endif
                        </th>
                        <th class="time">
                            <strong>{{$schedule->year}}/{{$schedule->month}}/{{$schedule->day}} {{$week[$schedule->week_id]}}</strong>
                            @if($schedule->shift !== 'off')
                                @foreach ($schedule->shift as $shift)
                                <span class="lucky">{{ array_keys($shift)[0] }}</span>
                                <span class="lucky_time">{{ $shift[array_keys($shift)[0]][0] }}-{{ $shift[array_keys($shift)[0]][1] }}</span>
                                @endforeach
                            @else
                                <span class="lucky">off</span>
                                <span class="lucky_time">off</span>
                            @endif
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Name</td>
                        <td class="time_title">
                            @for ($i = 10; $i < 24; $i++)
                            <div class="{{ $i }}">{{ $i }}</div>
                            @endfor
                        </td>
                    </tr>
                    @foreach ($humans as $human)
                    <tr>
                        <td>{{ $human->name }}</td>
                        <td class="{{ $human->name }} show_time">
                            @for ($i = 10; $i < 24; $i++)
                            <div class="{{ $i }}"></div>
                            @endfor
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td>缺人</td>
                        <td class="lack_human show_time">
                            @for ($i = 10; $i < 24; $i++)
                            <div class="{{ $i }}"></div>
                            @endfor
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endforeach
    </div>
</div>
@stop