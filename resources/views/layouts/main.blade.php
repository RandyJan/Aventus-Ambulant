<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    {{-- font --}}
    {{-- <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"> --}}
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <style>
        body {
            /* font-family: 'Roboto', sans-serif; */
            font-family: 'Inter var', sans-serif;
        }

    </style>
</head>

<body class="h-full bg-gray-100">

    <div id="app" class="">
        <navigation page_title="@yield('title')"></navigation>
        @yield('content')

        @if(config('settings.show_screen_guide'))
            <div class="flex z-50 fixed justify-between w-full bottom-0 bg-black sm:bg-red-500 md:bg-green-500 lg:bg-blue-500 xl:bg-yellow-500 2xl:bg-indigo-500 text-white tracking-wider p-1 text-xs">

                <div>
                    Screen Guide
                </div>
                <div class="flex space-x-1">
                    <div>
                        <div class="sm:hidden">Default</div>
                        <div class="hidden sm:block md:hidden">sm: Mobile</div>
                        <div class="hidden md:block lg:hidden">md: Tablet</div>
                        <div class="hidden lg:block xl:hidden">lg: Desktop</div>
                        <div class="hidden xl:block 2xl:hidden">xl: Wide Desktop</div>
                        <div class="hidden 2xl:block">2xl: Ultra Wide Desktop</div>
                    </div>
                </div>
            </div>
        @endif

    </div>

    <script src="{{ mix('/js/app.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

</body>

</html>
