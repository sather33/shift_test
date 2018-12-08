@extends('front.layout')
@section('content')
<div id="content_box">
    <div class="row">
        <div class="table_box" id="edit_schedule_box">
            <table class="table" id="{{$schedule->year}}_{{$schedule->month}}_{{$schedule->day}}">
                <thead>
                    <tr>
                        <th class="name">
                            {{-- <a class="btn btn-warning" href="{{ url('/schedule/'.$schedule->year.'/'.$schedule->month.'/'.$schedule->day.'/edit') }}">儲存</a> --}}
                        </th>
                        <th class="time">
                            <strong>{{$schedule->year}}/{{$schedule->month}}/{{$schedule->day}} {{$week[$schedule->week_id]}}</strong>
                            @foreach ($schedule->shift as $shift)
                            <span class="lucky">{{ array_keys($shift)[0] }}</span>
                            <span class="lucky_time">{{ $shift[array_keys($shift)[0]][0] }}-{{ $shift[array_keys($shift)[0]][1] }}</span>
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
        <div class="table_box">
            <table class="table">
                <thead>
                    <tr>
                        <th class="name"></th>
                        <th class="time">
                            <strong>能上班時段</strong>
                            @foreach ($dates as $date)
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
                </tbody>
            </table>
        </div>
    </div>
    <div id="input_edit" class="general_form">
        <form class="form-horizontal" action="{{ url('/schedule/'.$schedule->year.'/'.$schedule->month.'/'.$schedule->day) }}" method="POST" enctype="multipart/form-data" role="form">
    
            {!! csrf_field() !!}

            @if($member_total)
                @for ($j = 0; $j < count($member_total); $j++)
                <span>{{ $name = array_keys($member_total)[$j] }}: {{ $member_total[$name] }} 小時</span>
                @endfor
            @endif
            <div class="month_box edit_setting_box">
                @foreach ($humans as $human)
                <div class="per_day edit_{{ $human->name }}">
                    <p>{{ $human->name }}</p>
                    <select name="{{$human->id}}_started" id="{{$human->name}}_started" class="start">
                        <option value=""></option>
                        @for ($j = 10; $j <= '24'; ++$j)
                        <option value="{{ $j }}">{{ $j }}</option>
                        @endfor
                    </select>
                    <span>-</span>
                    <select name="{{$human->id}}_ended" id="{{$human->name}}_ended" class="end">
                        <option value=""></option>
                        @for ($j = 10; $j <= '24'; ++$j)
                        <option value="{{ $j }}">{{ $j }}</option>
                        @endfor
                    </select>
                    <br>
                    <input type="checkbox" class="set_10_15" name="easy_set">
                    <span class="set_span">10-15</span>
                    <input type="checkbox" class="set_10_18" name="easy_set">
                    <span>10-18</span><br>
                    <input type="checkbox" class="set_18_24" name="easy_set">
                    <span class="set_span">18-24</span>
                    <input type="checkbox" class="set_10_24" name="easy_set">
                    <span>&nbsp;全天&nbsp;</span>
                </div>
                @endforeach
                <div class="per_day edit_lack_human">
                    <p>缺人</p>
                    <select name="lack_human_started" id="lack_human_started" class="start">
                        <option value=""></option>
                        @for ($j = 10; $j <= '24'; ++$j)
                        <option value="{{ $j }}">{{ $j }}</option>
                        @endfor
                    </select>
                    <span>-</span>
                    <select name="lack_human_ended" id="lack_human_ended" class="end">
                        <option value=""></option>
                        @for ($j = 10; $j <= '24'; ++$j)
                        <option value="{{ $j }}">{{ $j }}</option>
                        @endfor
                    </select>
                    <br>
                    <input type="checkbox" class="set_10_15" name="easy_set">
                    <span class="set_span">10-15</span>
                    <input type="checkbox" class="set_10_18" name="easy_set">
                    <span>10-18</span><br>
                    <input type="checkbox" class="set_18_24" name="easy_set">
                    <span class="set_span">18-24</span>
                    <input type="checkbox" class="set_10_24" name="easy_set">
                    <span>&nbsp;全天&nbsp;</span>
                </div>
            </div>
            <input type="submit" value="儲存">
        </form>
    </div>
</div>
@stop