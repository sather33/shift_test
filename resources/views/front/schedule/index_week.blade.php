@extends('front.layout')
@section('content')
{{-- <h1>
    <span>2018</span>
    <br>
    @for ($i = 1; $i <= '12'; $i++)
    <span class="{{ ( $i == $current_month ) ? 'current_month' : '' }}">{{ $i }}</span>
    @endfor
</h1> --}}
    <div id="give_form" class="general_form">
        <form action="">
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
                @foreach($schedules as $schedale)
                <div class="per_day">
                    <p>{{$schedale->day}}</p>
                    @foreach ($schedale->shift as $shift)
                    <h5>{{ array_keys($shift)[0] }} {{ $shift[array_keys($shift)[0]][0] }}-{{ $shift[array_keys($shift)[0]][1] }}</h5>
                    @endforeach
                </div>
                @endforeach
            </div>
        </form>
    </div>
@stop