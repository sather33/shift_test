@extends('front.layout')
@section('content')
    <div id="give_form" class="general_form">
        <h1>Hi ! {{$user->name}}</h1>
        <form class="form-horizontal" action="{{ url('/give_shift/'.$user->id.'/'.$month) }}" method="POST" enctype="multipart/form-data" role="form">

            {!! csrf_field() !!}
            
            <input type="text" class="hidden" value="{{ $month }}" name="month">
            <input type="text" class="hidden" value="{{ $year }}" name="year">
            <input type="text" class="hidden" value="{{ $days }}" name="days">

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
                @for ($i = 1; $i <= $days; ++$i)
                <div class="per_day">
                    <p>{{$i}}</p>
                    <select name="{{$i}}_started" id="{{$i}}_started" class="start">
                        <option value=""></option>
                        @for ($j = 10; $j <= '24'; ++$j)
                        <option value="{{ $j }}" {{ ($j == ($schedule->where('day', $i)->first() ? $schedule->where('day', $i)->first()->start : '')) ? 'selected' : '' }}>{{ $j }}</option>
                        @endfor
                    </select>
                    <span>-</span>
                    <select name="{{$i}}_ended" id="{{$i}}_ended" class="end">
                        <option value=""></option>
                        @for ($j = 10; $j <= '24'; ++$j)
                        <option value="{{ $j }}" {{ ($j == ($schedule->where('day', $i)->first() ? $schedule->where('day', $i)->first()->end : '')) ? 'selected' : '' }}>{{ $j }}</option>
                        @endfor
                    </select>
                    <br>
                    <input type="checkbox" class="set_10_15" name="easy_set">
                    <span class="set_span">10-15</span>
                    <input type="checkbox" class="set_10_18" name="easy_set">
                    <span>10-18</span><br>
                    <input type="checkbox" class="set_10_22" name="easy_set">
                    <span class="set_span">10-22</span>
                    <input type="checkbox" class="set_18_24" name="easy_set">
                    <span>18-24</span><br>
                    <input type="checkbox" class="set_10_24" name="easy_set">
                    <span>&nbsp;全天&nbsp;</span>
                </div>
                @endfor
            </div>
            @if($not_limit)
            <div class="submit_box">
                <button type="submit" class="btn btn-success">儲存</button>
            </div>
            @endif
        </form>
    </div>
@stop
@section('script')
<script type="text/javascript">
    $(document).ready(function(){
        $('.set_10_15').change(function(){
            if($(this).prop('checked')){
                $(this).parent().find('.start').val(10);
                $(this).parent().find('.end').val(15);
            }else{
                $(this).parent().find('.start').val('');
                $(this).parent().find('.end').val('');
            }
        });
        $('.set_10_18').change(function(){
            if($(this).prop('checked')){
                $(this).parent().find('.start').val(10);
                $(this).parent().find('.end').val(18);
            }else{
                $(this).parent().find('.start').val('');
                $(this).parent().find('.end').val('');
            }
        });
        $('.set_10_22').change(function(){
            if($(this).prop('checked')){
                $(this).parent().find('.start').val(10);
                $(this).parent().find('.end').val(22);
            }else{
                $(this).parent().find('.start').val('');
                $(this).parent().find('.end').val('');
            }
        });
        $('.set_18_24').change(function(){
            if($(this).prop('checked')){
                $(this).parent().find('.start').val(18);
                $(this).parent().find('.end').val(24);
            }else{
                $(this).parent().find('.start').val('');
                $(this).parent().find('.end').val('');
            }
        });
        $('.set_10_24').change(function(){
            if($(this).prop('checked')){
                $(this).parent().find('.start').val(10);
                $(this).parent().find('.end').val(24);
            }else{
                $(this).parent().find('.start').val('');
                $(this).parent().find('.end').val('');
            }
        });
    });
</script>
@stop