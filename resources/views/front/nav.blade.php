<div id="nav">
  <a class="logo" href="{{ url('/schedules') }}">L</a>
  <span class="arrow-down glyphicon glyphicon-chevron-down"></span>
  <ul class="expand_list mobile-hidden">
    <li>查看班表</li>
    <p hidden>{{ $last_month = date('n')-1 == '0' ? '12' : date('n')-1 }}{{ $next_month = date('n')+1 == '13' ? '1' : date('n')+1 }}</p>
    <li class="expand_item hidden"><a href="{{ url('/schedules?choose_month='.$last_month) }}">{{$last_month}}月</a></li>
    <li class="expand_item hidden"><a href="{{ url('/schedules?choose_month='.date('n')) }}">{{date('n')}}月</a></li>
    <li class="expand_item hidden"><a href="{{ url('/schedules?choose_month='.$next_month) }}">{{$next_month}}月</a></li>
  </ul>
  <ul class="expand_list mobile-hidden">
    <li>劃{{ $month }}月班表</li>
    @foreach ($humans as $human)
    <li class="expand_item hidden">
      <a href="{{ url('/give_shift/'.$human->id.'/'.$month) }}">{{ $human->name }}</a>
    </li>
    @endforeach
  </ul>
  <a class="other-day-off mobile-hidden">申請額外劃休</a>
  <a class="about-shift mobile-hidden">關於排班</a>
  @if (Auth::check())
  <a href="{{ url('/admin/schedules') }}">未發佈的1月班表</a>
  <a href="{{ url('/setting') }}" class="mobile-hidden">後台</a>
  <a href="{{ url('/logout') }}" class="log-out mobile-hidden">Log-out</a>
  @else
  <a href="{{ url('/login') }}" class="log-in mobile-hidden">Log-in</a>
  @endif
</div>