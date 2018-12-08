<div id="nav">
  <a class="logo" href="{{ url('/schedules') }}">L</a>
  <ul class="expand_list">
    <li>選擇班表</li>
    <li class="expand_item hidden">1</li>
    <li class="expand_item hidden">2</li>
    <li class="expand_item hidden">3</li>
  </ul>
  <ul class="expand_list">
    <li>劃{{ $month }}月班表</li>
    @foreach ($humans as $human)
    <li class="expand_item hidden">
      <a href="{{ url('/give_shift/'.$human->id.'/'.$month) }}">{{ $human->name }}</a>
    </li>
    @endforeach
  </ul>
  <a class="other-day-off">申請額外劃休</a>
  <a class="about-shift">關於排班</a>
  @if (Auth::check())
  <a href="{{ url('/setting') }}">後台</a>
  <a href="{{ url('/logout') }}" class="log-out">Log-out</a>
  @else
  <a href="{{ url('/login') }}" class="log-in">Log-in</a>
  @endif
</div>