<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/css/iziToast.min.css">

    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/js/iziToast.min.js"></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>

    @include('flash')

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else

                            <li class="nav-item"><a href="{{route('carts.index')}}" class="nav-link">Cart <span class="badge badge-primary cart">{{ \App\Carts::where('user_id',auth()->id())->whereStatus(0)->count() }}</span> </a></li>

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <script>

        function toast(msg,type){
            if (type == "success"){
                iziToast.success({
                    title: "Success",
                    message: msg,
                    position: 'topRight',
                });
            }else {
                iziToast.error({
                    title: "Error",
                    message: msg,
                    position: 'topRight',
                });
            }
        }

        var cart_url = '{{route('carts.store')}}';

        $(".add-to-cart").click(function (e) {
            e.preventDefault();

            var product_id = $(this).data('product-id');
            var quantity = $("#quantity").val();

            $.ajax({
                url : cart_url,
                type: "POST",
                data : {
                    '_token' : $("#token").val(),
                    'product' : product_id,
                    'quantity' : quantity
                },
                dataType : 'json',
                cache: false,
                timeout : 45000,
                success: function(data){
                 //   console.log(data);
                    if(data.status == 1){
                        toast(data.message);
                        return;
                    }


                    toast(data.message,"success");
                },
                error : function (er) {
                    toast("Network error");
                }
            });
        });

        $(".add, .remove").click(function (e) {
            e.preventDefault();

            var id = $(this).data('id');
            var quantity = $("#quantity").val();

            $.ajax({
                url : $(this).data('url'),
                type: "POST",
                data : {
                    '_token' : $("#token").val(),
                    'id' : id,
                    'quantity' : quantity,
                    '_method' :'PATCH',
                    'type' : $(this).data('type')
                },
                dataType : 'json',
                cache: false,
                timeout : 45000,
                success: function(data){
                    //console.log(data);

                    if(data.status == 1){
                        toast(data.message);
                        return;
                    }

                    toast(data.message,"success");
                },
                error : function (er) {
                    toast("Network error");
                }
            });
        });
    </script>

</body>
</html>
