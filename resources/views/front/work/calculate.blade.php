@extends('front.layout')
@section('content')
<div id="content_box">
    <div id="setting_form" class="">
        @if($member_total)
            @for ($j = 0; $j < count($member_total); $j++)
            <h3>{{ $name = array_keys($member_total)[$j] }}: {{ $member_total[$name] }} 小時</h3>
            @endfor
        @endif
        <a href="/setting">返回後台</a>
    </div>
</div>
@stop