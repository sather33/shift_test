<!DOCTYPE html>
<html lang="en">
@include('front.head')
<body>
    <div id="front_container">
        @include('front.nav')
        @yield('content')
    </div>
</body>
<script type="text/javascript">
    $(document).ready(function(){
        var anchor = $('#anchor').text();
        if(anchor != ''){
            var elmnt = document.getElementById(anchor).parentNode;
            elmnt.scrollIntoView(true);
        }
    });
</script>
</html>