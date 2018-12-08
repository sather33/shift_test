<div id="nav">
    <ul class="expand_list">
        <li>查看班表</li>
        <li class="expand_item hidden">
            <a href="{{ url('/schedules') }}">每天</a>
        </li>
        <li class="expand_item hidden">
            <a href="{{ url('/schedules/week') }}">一個月</a>
        </li>
    </ul>
    <ul class="expand_list">
        <li>劃{{ $month }}月班表</li>
        @foreach ($humans as $human)
        <li class="expand_item hidden">
            <a href="{{ url('/give_shift/'.$human->id.'/'.$month) }}">{{ $human->name }}</a>
        </li>
        @endforeach
    </ul>
    @if (Auth::check())
    <ul class="expand_list admin_btn">
        <li><span class="glyphicon glyphicon-th-list"></span></li>
        <li class="expand_item hidden">
            <a href="{{ url('/logout') }}">登出</a>
        </li>
        <li class="expand_item hidden">
            <a href="{{ url('/setting') }}">後台</a>
        </li>
        <li class="expand_item hidden">
            <a href="{{ url('/admin/schedules') }}">班表</a>
        </li>
    </ul>
    @else
    <a href="{{ url('/login') }}" class="admin_btn">登入</a>
    @endif
</div>