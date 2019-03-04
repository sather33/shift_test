@extends('front.layout')
@section('content')
<div id="content_box">
    <div class="row">
        @if($member_total)
            <div class="check_total">
                @for ($j = 0; $j < count($member_total); $j++)
                <span>{{ $name = array_keys($member_total)[$j] }}: {{ $member_total[$name] }} // </span>
                @endfor
            </div>
        @endif
        @if(!!$schedule_Y)
            <div class="edit_table_box" id="{{$schedule_Y->year}}_{{$schedule_Y->month}}_{{$schedule_Y->day}}">
        @else
            <div class="edit_table_box" id="{{$schedule_A->year}}_{{$schedule_A->month}}_{{$schedule_A->day}}">
        @endif
            @if(!!$schedule_Y)
            <div class="table_shopY">
                <table class="table" >
                    <thead>
                        <tr>
                            <th class="name">
                                <form action="{{ url('/schedule/day_off/'.$schedule_Y->year.'/'.$schedule_Y->month.'/'.$schedule_Y->day).'/'.$back }}" method="POST" enctype="multipart/form-data" role="form">
                                    {!! csrf_field() !!}
                                    <input type="submit" value="店休">
                                </form>
                            </th>
                            <th class="time">
                                <strong>{{$schedule_Y->year}}/{{$schedule_Y->month}}/{{$schedule_Y->day}} {{$week[$schedule_Y->week_id]}}</strong>
                                @foreach ($schedule_Y->shift as $shift)
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
                                <div class="editing" style="display:none">false</div>
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
            @endif
            @if (!!$schedule_A)
            <div class="table_shopA">
                <table class="table" >
                    <thead>
                        <tr>
                            <th class="name">
                                <form action="{{ url('/schedule/day_off/'.$schedule_A->year.'/'.$schedule_A->month.'/'.$schedule_A->day).'/'.$back }}" method="POST" enctype="multipart/form-data" role="form">
                                    {!! csrf_field() !!}
                                    <input type="submit" value="店休">
                                </form>
                            </th>
                            <th class="time">
                                <strong>{{$schedule_A->year}}/{{$schedule_A->month}}/{{$schedule_A->day}} {{$week[$schedule_A->week_id]}}</strong>
                                @foreach ($schedule_A->shift as $shift)
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
                                <div class="editing" style="display:none">false</div>
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
            @endif
            <div class="table_default">
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
        <div>
            @if(!!$schedule_Y)
                <form action="{{ url('/schedule/'.$schedule_Y->year.'/'.$schedule_Y->month.'/'.$schedule_Y->day).'/'.$back }}" method="POST" enctype="multipart/form-data" role="form">
            @else
                <form action="{{ url('/schedule/'.$schedule_A->year.'/'.$schedule_A->month.'/'.$schedule_A->day).'/'.$back }}" method="POST" enctype="multipart/form-data" role="form">
            @endif  
                    {!! csrf_field() !!}
                    <div>
                        @foreach ($humans as $human)
                        <div>
                            <input type="text" name='{{$human->name}}_started_A' hidden>
                            <input type="text" name='{{$human->name}}_ended_A' hidden>
                            <input type="text" name='{{$human->name}}_started_Y' hidden>
                            <input type="text" name='{{$human->name}}_ended_Y' hidden>
                        </div>
                        @endforeach
                    </div>
                    <input type="submit" value="儲存">
                </form>
        </div>
    </div>
</div>
@stop
@section('script')
<script type="text/javascript">
    $(document).ready(function(){
        const shopId = ['Y', 'A'];
        for (let i = 0; i < shopId.length; i++) {
            //set by click
            $(`.table_shop${shopId[i]} .show_time div`).click(function() {
                if($(this).parent()[0].getElementsByClassName('editing')[0].innerHTML === 'false'){
                    // console.log('good');
                    //change to editing
                    $(this).parent()[0].getElementsByClassName('editing')[0].innerHTML = 'true';

                    //remove all color
                    for (let index = 0; index < $(this).parent()[0].getElementsByTagName('div').length; index++) {
                        $(this).parent()[0].getElementsByTagName('div')[index].classList.remove('active');
                    }

                    //set click div color and input
                    $(this).addClass('active');
                    var name = $(this).parent().parent()[0].getElementsByTagName('td')[0].innerHTML;
                    var startNum = $(this).attr('class').split(' ')[0];
                    $(`input[name='${name}_started_${shopId[i]}']`).val(startNum);
                }else{
                    // console.log('bad');
                    $(this).parent()[0].getElementsByClassName('editing')[0].innerHTML = 'false';

                    //color the div
                    var startNum = $(this).parent()[0].getElementsByClassName('active')[0].className.split(' ')[0];
                    var endNum = $(this).attr('class').split(' ')[0];
                    var name = $(this).parent().parent()[0].getElementsByTagName('td')[0].innerHTML;
                    
                    if (startNum < endNum) {
                        // console.log('small');
                        for (let index = startNum; index <= endNum; index++) {
                            $(this).parent()[0].getElementsByClassName(index)[0].classList.add('active');
                        }
                        //set input
                        $(`input[name='${name}_ended_${shopId[i]}']`).val(parseInt(endNum)+1);
                    } else if (startNum == endNum) {
                        // console.log('same');
                        // console.log(`input[name='${name}_started_${shopId[i]}']`);
                        $(this).removeClass('active');
                        $(`input[name='${name}_started_${shopId[i]}']`).val(null);
                        $(`input[name='${name}_ended_${shopId[i]}']`).val(null);
                    }
                }
            });

            //set default input
            var shopYDefaultInputName = $(`.table_shop${shopId[i]} .lucky`);
            var shopYDefaultInputValue = $(`.table_shop${shopId[i]} .lucky_time`);
            if (shopYDefaultInputName.length > 0) {
                for (let index = 0; index < shopYDefaultInputName.length; index++) {
                    var name = shopYDefaultInputName[index].innerHTML;
                    var value = shopYDefaultInputValue[index].innerHTML.split('-');
                    $(`input[name='${name}_started_${shopId[i]}']`).val(value[0]);
                    $(`input[name='${name}_ended_${shopId[i]}']`).val(value[1]);
                    // console.log($(`input[name='${name}_started_${shopId[i]}']`).val());
                    // console.log($(`input[name='${name}_ended_${shopId[i]}']`).val());
                }
            }
        }
    });
</script>
@stop