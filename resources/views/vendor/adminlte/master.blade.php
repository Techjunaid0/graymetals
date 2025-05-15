<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title_prefix', config('adminlte.title_prefix', ''))
@yield('title', config('adminlte.title', 'AdminLTE 2'))
@yield('title_postfix', config('adminlte.title_postfix', ''))</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/Ionicons/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet"/>

    @if(config('adminlte.plugins.select2'))
        <!-- Select2 -->
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css">
    @endif

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/AdminLTE.min.css') }}">

    @if(config('adminlte.plugins.datatables'))
        <!-- DataTables with bootstrap 3 style -->
        <link rel="stylesheet" href="//cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.css">
    @endif

    @yield('adminlte_css')

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style type="text/css">
      
      #loader {
        position: fixed;
        left: 45%;
        top: 40%;
        z-index: 9999;
      }
      .cover-body {
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1045;
        overflow: hidden;
        position: fixed;
        background: #0b0b0b;
        opacity: 0.8;
      }
      .bring-up {
        z-index: 10000;
      }
      .sk-folding-cube {
        -webkit-backface-visibility: hidden;
        margin: 40px auto;
        width: 40px;
        height: 40px;
        position: relative;
        -webkit-transform: rotateZ(45deg);
        transform: rotateZ(45deg);
      }
      .sk-folding-cube .sk-cube {
        float: left;
        width: 50%;
        height: 50%;
        position: relative;
        -webkit-transform: scale(1.1);
        -ms-transform: scale(1.1);
        transform: scale(1.1);
      }
      .sk-folding-cube .sk-cube:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #1e9fbc;
        -webkit-animation: sk-foldCubeAngle 2.4s infinite linear both;
        animation: sk-foldCubeAngle 2.4s infinite linear both;
        -webkit-transform-origin: 100% 100%;
        -ms-transform-origin: 100% 100%;
        transform-origin: 100% 100%;
      }
      .sk-folding-cube .sk-cube2 {
        -webkit-transform: scale(1.1) rotateZ(90deg);
        transform: scale(1.1) rotateZ(90deg);
      }
      .sk-folding-cube .sk-cube3 {
        -webkit-transform: scale(1.1) rotateZ(180deg);
        transform: scale(1.1) rotateZ(180deg);
      }
      .sk-folding-cube .sk-cube4 {
        -webkit-transform: scale(1.1) rotateZ(270deg);
        transform: scale(1.1) rotateZ(270deg);
      }
      .sk-folding-cube .sk-cube2:before {
        -webkit-animation-delay: 0.3s;
        animation-delay: 0.3s;
      }
      .sk-folding-cube .sk-cube3:before {
        -webkit-animation-delay: 0.6s;
        animation-delay: 0.6s;
      }
      .sk-folding-cube .sk-cube4:before {
        -webkit-animation-delay: 0.9s;
        animation-delay: 0.9s;
      }
       @-webkit-keyframes sk-foldCubeAngle {
       0%, 10% {
       -webkit-transform: perspective(140px) rotateX(-180deg);
       transform: perspective(140px) rotateX(-180deg);
       opacity: 0;
      }
       25%, 75% {
       -webkit-transform: perspective(140px) rotateX(0deg);
       transform: perspective(140px) rotateX(0deg);
       opacity: 1;
      }
       90%, 100% {
       -webkit-transform: perspective(140px) rotateY(180deg);
       transform: perspective(140px) rotateY(180deg);
       opacity: 0;
      }
      }
       @keyframes sk-foldCubeAngle {
       0%, 10% {
       -webkit-transform: perspective(140px) rotateX(-180deg);
       transform: perspective(140px) rotateX(-180deg);
       opacity: 0;
      }
       25%, 75% {
       -webkit-transform: perspective(140px) rotateX(0deg);
       transform: perspective(140px) rotateX(0deg);
       opacity: 1;
      }
       90%, 100% {
       -webkit-transform: perspective(140px) rotateY(180deg);
       transform: perspective(140px) rotateY(180deg);
       opacity: 0;
      }
      }
    </style>
</head>
<body class="hold-transition @yield('body_class')">
  <div id="loader" style="display: none;">
    <div class="cover-body"></div>
      <div class="sk-folding-cube bring-up">
          <div class="sk-cube1 sk-cube"></div>
          <div class="sk-cube2 sk-cube"></div>
          <div class="sk-cube4 sk-cube"></div>
          <div class="sk-cube3 sk-cube"></div>
      </div>
  </div>

@yield('body')
@stack('modals')

<script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/toastr.min.js') }}"></script>
@if(config('adminlte.plugins.select2'))
    <!-- Select2 -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
@endif

@if(config('adminlte.plugins.datatables'))
    <!-- DataTables with bootstrap 3 renderer -->
    <script src="//cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.js"></script>
@endif

@if(config('adminlte.plugins.chartjs'))
    <!-- ChartJS -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js"></script>
@endif

<script type="text/javascript">
    toastr.options = {
      "closeButton": false,
      "debug": false,
      "newestOnTop": false,
      "progressBar": false,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    };
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function(){
          $('#loader').show();
        },
        complete: function(){
          $('#loader').hide();
        }
    });
    @if(session('toaster_data'))
        toastr['{{ session('toaster_data')['type'] }}']("{{ session('toaster_data')['message'] }}");
        @php
            session()->forget('toaster_data');
        @endphp
    @endif
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
@yield('adminlte_js')

</body>
</html>
