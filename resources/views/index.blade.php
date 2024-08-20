<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
</head>

<body class="bg-gray-600">

    <div id="app" class="p-4 grid gap-4">

        <div class="card">
            <h1>
                Typography
            </h1>
            <div class="p-2">
                <p class="text-xs">Sample - xs</p>
                <p class="text-sm">Sample - sm</p>
                <p class="text-base">Sample - base</p>
                <p class="text-lg">Sample - lg</p>
                <p class="text-xl">Sample - xl</p>
                <p class="text-2xl">Sample - 2xl</p>
                <p class="text-3xl">Sample - 3xl</p>
                <p class="text-4xl">Sample - 4xl</p>
                <p class="text-5xl">Sample - 5xl</p>
                <p class="text-6xl">Sample - 6xl</p>
            </div>
        </div>

        <div class="card">
            <h1>
                Buttons
            </h1>
            <div class="p-2 ">

                <div class="space-x-2">
                    <button class="btn btn-xs">button</button>
                    <button class="btn">button</button>
                    <button class="btn btn-md">button</button>
                    <button class="btn btn-lg">button</button>
                </div>

                <div class="mt-2 space-x-2">
                    <button class="btn btn-xs btn-info">button</button>
                    <button class="btn btn-info">button</button>
                    <button class="btn btn-md btn-info">button</button>
                    <button class="btn btn-lg btn-info">button</button>
                </div>

                <div class="mt-2 space-x-2">
                    <button class="btn btn-xs btn-warning">button</button>
                    <button class="btn btn-warning">button</button>
                    <button class="btn btn-md btn-warning">button</button>
                    <button class="btn btn-lg btn-warning">button</button>
                </div>

                <div class="mt-2 space-x-2">
                    <button class="btn btn-xs btn-danger">button</button>
                    <button class="btn btn-danger">button</button>
                    <button class="btn btn-md btn-danger">button</button>
                    <button class="btn btn-lg btn-danger">button</button>
                </div>


            </div>
        </div>

        <div class="card">
            <h1>
                Forms
            </h1>
            <div class="p-2">
            </div>
        </div>

        <div class="card">
            <h1>
                Modal
            </h1>
            <div class="p-2">
            </div>
        </div>

        <div class="card">
            <h1>
                Badges
            </h1>
            <div class="p-2">
            </div>
        </div>

    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
