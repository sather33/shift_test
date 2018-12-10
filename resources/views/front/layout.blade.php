<!DOCTYPE html>
<html lang="en">
@include('front.head')
<body>
    <div id="front_container">
        @include('front.nav')
        @yield('content')
    </div>
</body>
@yield('script')
<script type="text/javascript">
    $(document).ready(function(){
        var table = $('.table');
        for(i=0; i<table.length; ++i){
            var lucky = table[i].getElementsByClassName('lucky');
            var lucky_time = table[i].getElementsByClassName('lucky_time');
            var edited = $('#input_edit');
            var is_edited = edited.children().length;
            for(j=0; j<lucky.length; ++j){
                var lucky_name = lucky[j].textContent;
                var shift = lucky_time[j].textContent.split('-');
                var set_array = table[i].getElementsByClassName(lucky_name)[0];
                for(k=shift[0]; k<shift[1]; ++k){
                    set_array.getElementsByClassName(k)[0].classList.add('active');
                }
                if((is_edited != '0') && (i == '0')){
                    var edit_lucky = edited[0].getElementsByClassName(`edit_${lucky_name}`)[0];
                    edit_lucky.getElementsByClassName('start')[0].value = shift[0];
                    edit_lucky.getElementsByClassName('end')[0].value = shift[1];
                }
            }
        }

        var anchor = $('#anchor').text();
        if(anchor != ''){
            var elmnt = document.getElementById(anchor).parentNode;
            elmnt.scrollIntoView(true);
        };
        // for nav
        $('.expand_list').on('click', function(){
            $(this).find('.expand_item').toggleClass('hidden');
            // var delayInMilliseconds = 3000; //1000 = 1 second
            // var this_i = $(this);
            // delay_time(this_i, delayInMilliseconds);
        });
        // function delay_time(this_i, delayInMilliseconds){
        //     setTimeout(function() {
        //         this_i.find('.expand_item').toggleClass('hidden');
        //     }, delayInMilliseconds);
        // };
        $('.arrow-down').click(function(){
            $('.mobile-hidden').toggleClass('mobile-show');
        });
    });
</script>
</html>