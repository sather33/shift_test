<!-- Redactor 3 Js -->
<script src="{{ url(asset('/assets/vendor/redactor/js/redactor.js')) }}"></script>
<script src="{{ url(asset('/assets/vendor/redactor/js/zh_tw.js')) }}"></script>
<script src="{{ url(asset('/assets/vendor/redactor/plugins/alignment.js')) }}"></script>
{{-- <script src="{{ url(asset('/assets/vendor/redactor/plugins/counter_modified.js')) }}"></script> --}}
{{-- <script src="{{ url(asset('/assets/vendor/redactor/plugins/limiter.min.js')) }}"></script> --}}
{{-- <script src="{{ url(asset('/assets/vendor/redactor/plugins/table.js')) }}"></script> --}}
{{-- <script src="{{ url(asset('/assets/vendor/redactor/plugins/video.js')) }}"></script> --}}



<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

<!-- Bootstrap Js CDN -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- bootstrap 3 datepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap 3 datepicker languague -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/locales/bootstrap-datepicker.zh-TW.min.js"></script>

<!-- Sweet Alert Js -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@include('LaravelSweetAlert::show')


<script src="{{ url(asset(mix('/assets/js/app.js'))) }}"></script>


<script type="text/javascript">
	function readURL(input, imgId) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();

	        reader.onload = function (e) {
	            $('#' + imgId)
	                .attr('src', e.target.result);
	        };

	        reader.readAsDataURL(input.files[0]);
	    }
	}

	function cancelUploadImg(input, imgId, src, size = '500x500')
	{
	    if (input[0].files && input[0].files[0]) 
	    {
	        if(src !== '')
	            $('#'+imgId).attr('src', src);
	        else
	            $('#'+imgId).attr('src', 'https://fakeimg.pl/' + size + '/');
	        input[0].value = '';
	    }

	    // console.log(input[0].value);
	    
	}

	$(document).ready(function () {
	     $('#sidebarCollapse').on('click', function () {
	         $('#sidebar').toggleClass('active');
	     });
	});

	
</script>

<script>
	var pathArray = window.location.pathname.split( '/' );
	// console.log(pathArray);
	
	var $selectedShort = $("a[href='/" + pathArray[1] + "']");
	var $selectedLong = $("a[href='/" + pathArray[1] + "/" + pathArray[2] + "']");
	var $selected;
	
	if ($selectedLong.length == 0)
		$selected = $selectedShort;
	else
		$selected = $selectedLong;
	// if($selected.length == 0 || typeof pathArray[2] != 'undefined')
	// 	$selected = $("a[href='/" + pathArray[1] + "/" + pathArray[2] + "']");

	var $li = $selected.parents('li');

	var $parents = $selected.parents('.list-unstyled');
	console.log($parents.attr('id'));

	var $prev = $parents.prev('[href="#' + $parents.attr('id') + '"]');

	$prev.attr('aria-expanded', true).removeClass('collapsed');
	$parents.addClass('in').attr('aria-expanded', true).css('height', '');
	$li.addClass('active');
</script>

@yield('scripts')