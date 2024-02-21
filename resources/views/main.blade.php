<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
          integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link href="{{ asset('images/funkos.bmp') }}" rel="icon" type="image/bmp">
    <style>
        footer{
            left: 0;
            bottom: 0;
            width: 100%;
            background: linear-gradient(to bottom, #101864, #060620);
            color: #fff;
            text-align: center;
            padding-bottom: 30px;
        }

        header{
            background: linear-gradient(to top, #101864, #060620);
        }

        #navbarNav{
            text-align: center;
        }

        div.nav-username{
            color: #fff;
            font-weight: bold;
            font-size: 20px;
            padding-top: 10px;
        }


        /* banners */
        .error-banner {
            background-color: #f44336;
            color: white;
            padding: 15px 20px;
            border-radius: 5px;
            text-align: center;
            position: fixed;
            top: 0;
            right: 0;
            z-index: 1000;
            animation: slideIn 0.5s ease-out;
        }

        .info-banner {
            background-color: #2196F3;
            color: white;
            padding: 15px 20px;
            border-radius: 5px;
            text-align: center;
            position: fixed;
            top: 0;
            right: 0;
            z-index: 1000;
            animation: slideIn 0.5s ease-out;
        }

        .close-btn {
            position: absolute;
            top: 5px;
            right: 10px;
            cursor: pointer;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-100%);
            }
            to {
                transform: translateY(0);
            }
        }

        @keyframes slideOut {
            from {
                transform: translateY(0);
            }
            to {
                transform: translateY(-100%);
            }
        }

        .hide-banner {
            animation: slideOut 0.5s ease-in;
        }
    </style>
</head>

<body>


    @include('header')
    <div class="container">
    <div class="mx-2 my-2">
        @include('flash::message')
    </div>

    @yield('content')

</div>

@include('footer')

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>
</body>
</html>
