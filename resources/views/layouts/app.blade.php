<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ config('app.name', 'Companion') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="DashboardKit" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon icon -->
    <link rel="icon" href="{{ url('/') . '/' . asset('assets/image/fevicon.png') }}" type="image/x-icon">
    <!-- data tables css -->
    <link rel="stylesheet" href="{{ url('/') . '/' . asset('assets/css/plugins/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('/') . '/' . asset('assets/css/plugins/animate.min.css') }}">
    <!-- font css -->
    <link rel="stylesheet" href="{{ url('/') . '/' . asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ url('/') . '/' . asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ url('/') . '/' . asset('assets/fonts/material.css') }}">
    <!-- vendor css -->
    <link rel="stylesheet" href="{{ url('/') . '/' . asset('assets/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ url('/') . '/' . asset('assets/css/customizer.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{url('/') . '/' . asset('assets/css/plugins/bootstrap-timepicker.min.css')}}">

    @livewireStyles
    <script src="{{ mix('/js/app.js') }}" defer></script>
    <script src="{{ url('/') . '/' . asset('assets/js/vendor-all.min.js') }}"></script>

</head>

<body class="">
    <div class="pc-mob-header pc-header">
        <div class="pcm-logo">
            <img src="{{ url('/') . '/' . asset('assets/images/logo.svg') }}" alt="" class="logo logo-lg">
        </div>
        <div class="pcm-toolbar">
            <a href="#!" class="pc-head-link" id="mobile-collapse">
                <div class="hamburger hamburger--arrowturn">
                    <div class="hamburger-box">
                        <div class="hamburger-inner"></div>
                    </div>
                </div>
                <!-- <i data-feather="menu"></i> -->
            </a>
            <a href="#!" class="pc-head-link" id="header-collapse">
                <i data-feather="more-vertical"></i>
            </a>
        </div>
    </div>
    @include('layouts.sidebar')
    @include('layouts.navigation')
    <main>
        <!-- [ Main Content ] start -->
        <div class="pc-container">
            <div class="pcoded-content">
                {{ $slot }}
            </div>
        </div>

    </main>
    <footer class="bg-dark pt-3 pb-4 m-t-50">
                <div class="baseurl" data-baseurl="{{ url('/') }}"></div>
                <div class="container p_f ml_l">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <p class="text-white mb-0 ">
                                © Tranquille
                                <script>
                                    document.write(/\d{4}/.exec(Date())[0])
                                </script> | All Rights Reserved. Website Design Company - <a
                                    href="https://www.pixbrand.org/" target="_blank"> Pix Brand Pvt. Ltd.</a>
                            </p>
                        </div>

                    </div>
                </div>
            </footer>
    <!-- Scripts -->

    <script src="{{ url('/') . '/' . asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ url('/') . '/' . asset('assets/js/plugins/feather.min.js') }}"></script>
    <script src="{{ url('/') . '/' . asset('assets/js/pcoded.min.js') }}"></script>
    <!-- custom-chart js -->
    <!--     <script src="{{ url('/') . '/' . asset('assets/js/pages/dashboard-sale.js') }}"></script> -->
    <script src="{{ url('/') . '/' . asset('assets/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('/') . '/' . asset('assets/js/plugins/dataTables.bootstrap4.min.js') }}"></script>
    <!-- jquery-validation Js -->
    <script src="{{ url('/') . '/' . asset('assets/js/plugins/jquery.validate.min.js') }}"></script>
    <!-- bootstrap-datepicker -->
    <script src="{{ url('/') . '/' . asset('assets/js/plugins/bootstrap-datepicker.min.js') }}"></script>
    <!-- notification Js -->
    <script src="{{ url('/') . '/' . asset('assets/js/plugins/bootstrap-notify.min.js') }}"></script>
    <script src="{{ url('/') . '/' . asset('assets/js/pages/ac-notification.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
    <script src="{{ url('/') . '/' . asset('assets/js/plugins/bootstrap-timepicker.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });

        //
        $.fn.timepicker.defaults = $.extend(true, {}, $.fn.timepicker.defaults, {
        icons: {
            up: 'feather icon-chevron-up',
            down: 'feather icon-chevron-down'
        }
        });
        // minimum setup
        $('#pc-timepicker-1').timepicker();
    </script>

    <script>
        function toggle(source) {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i] != source)
                    checkboxes[i].checked = source.checked;
            }
        }
    </script>
    <script>
        arrows = {
            leftArrow: '<i class="feather icon-chevron-left"></i>',
            rightArrow: '<i class="feather icon-chevron-right"></i>'
        }
        // minimum setup
        $('#pc-datepicker-2').datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows
        });
        {{--function seenNotification() {--}}
        {{--    $.ajax({--}}
        {{--        type: 'GET',--}}
        {{--        url: "{{route('reed-notification')}}",--}}
        {{--        // data: {'trainerID': trainerID},--}}
        {{--        dataTypes: 'json',--}}
        {{--        success: function (res) {--}}
        {{--            if (res) {--}}
        {{--                $(".number").text(0);--}}
        {{--            }--}}
        {{--        }--}}
        {{--    });--}}
        {{--}--}}
    </script>

</body>

</html>
