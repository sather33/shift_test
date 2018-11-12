@extends('front.layout')
@section('content')
    <div id="weekday_form" class="general_form">
        <h1>設定班次</h1>
        <form class="form-horizontal" action="{{ url('/weekday') }}" method="POST" enctype="multipart/form-data" role="form">

            {!! csrf_field() !!}
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
            </div>
        </form>
    </div>
@stop