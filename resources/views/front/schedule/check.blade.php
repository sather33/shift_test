@extends('front.layout')
@section('content')
{{-- <h1>
    <span>2018</span>
    <br>
    @for ($i = 1; $i <= '12'; $i++)
    <span class="{{ ( $i == $current_month ) ? 'current_month' : '' }}">{{ $i }}</span>
    @endfor
</h1> --}}
<div id="content_box">
    <div class="row">
        @for ($k = 1; $k <= $days; $k++)
        <div class="col-md-6 col-xs-12 table_box">
            <table class="table" id="{{$year}}_{{$current_month}}_{{$k}}">
                <thead>
                    <tr>
                        <th class="name">
                            @if (Auth::check())
                            <a class="btn btn-warning" href="{{ url('/schedule/'.$year.'/'.$current_month.'/'.$k.'/edit') }}">修改</a>
                            @endif
                        </th>
                        <th class="time">
                            <strong>{{$year}}/{{$current_month}}/{{$k}} {{ $dates->where('day', $k)->first() ? $week[$dates->where('day', $k)->first()->week_id] : ''}}</strong>
                            @foreach ($dates->where('day', $k) as $date)
                            <span class="lucky">{{ $date->member->name }}</span>
                            <span class="lucky_time">{{ $date->shift }}</span>
                            @endforeach
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
        @endfor
    </div>
</div>
@stop