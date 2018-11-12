<!-- Styles -->

<!-- Bootstrap CSS CDN -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- bootstrap 3 datepicker -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker3.min.css" />
{{-- <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/datepicker3/css/bootstrap-datepicker3.min.css') }}" /> --}}

<!-- Redactor 3 CSS -->
<link rel="stylesheet" href="{{ url(asset('/assets/vendor/redactor/css/redactor.min.css')) }}">

<link href="{{ asset(mix('/assets/css/app.css')) }}" rel="stylesheet">

@yield('styles')