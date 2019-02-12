<div id="nav" {{ empty($nav_hidden) ?: 'hidden'}} class={{ $shopId === 'Y' ? 'shopY' : 'shopA' }}>
  <a class="logo" href="{{ $shopId === 'Y' ? url('/A/schedules') : url('/Y/schedules') }}">{{$shopId}}</a>
  <span class="arrow-down glyphicon glyphicon-chevron-down"></span>
  <ul class="expand_list mobile-hidden">
    <li>查看班表</li>
    <p hidden>{{ $last_month = date('n')-1 == '0' ? '12' : date('n')-1 }}{{ $next_month = date('n')+1 == '13' ? '1' : date('n')+1 }}</p>
    <li class="expand_item hidden"><a href="{{ url('/'.$shopId.'/schedules?choose_month='.$last_month) }}">{{$last_month}}月</a></li>
    <li class="expand_item hidden"><a href="{{ url('/'.$shopId.'/schedules?choose_month='.date('n')) }}">{{date('n')}}月</a></li>
    <li class="expand_item hidden"><a href="{{ url('/'.$shopId.'/schedules?choose_month='.$next_month) }}">{{$next_month}}月</a></li>
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
  <a href='/Y/schedules' class="mobile-hidden">延吉店</a>
  <a href='/A/schedules' class="mobile-hidden">安東店</a>
  @if (Auth::check())
  <!-- <a href="{{ url('/admin/schedules') }}">未發佈的1月班表</a> -->
  <a href="{{ url('/setting') }}" class="mobile-hidden">後台</a>
  <a href="/Y/un_schedules" class="mobile-hidden">延吉店(未發佈)</a>
  <a href="/A/un_schedules" class="mobile-hidden">安東店(未發佈)</a>
  <a href="{{ url('/logout') }}" class="log-out mobile-hidden">Log-out</a>
  @else
  <a href="{{ url('/login') }}" class="log-in mobile-hidden">Log-in</a>
  @endif
</div>

@if(!empty($nav_hidden))
<div id="top-nav" style={{ empty($nav_hidden) ? "display:none" : ''}} class={{ $shopId === 'Y' ? 'shopY' : 'shopA' }}>
  <a href="{{ $shopId === 'Y' ? url('/Y/schedules') : url('/A/schedules') }}">< Back Schedules</a>
  <h2>{{$current_month}}月</h2>
</div>
@endif