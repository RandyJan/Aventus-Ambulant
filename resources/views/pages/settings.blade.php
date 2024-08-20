<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Settings</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">

</head>

<body>

    <div id="app">
        <div class="relative bg-sky-700 pb-32 overflow-hidden">
            <div aria-hidden="true"
                class="inset-y-0 absolute inset-x-0 left-1/2 transform -translate-x-1/2 w-full overflow-hidden lg:inset-y-0">
                <div class="absolute inset-0 flex">
                    <div class="h-full w-1/2" style="background-color: #0a527b;"></div>
                    <div class="h-full w-1/2" style="background-color: #065d8c;"></div>
                </div>
                <div class="relative flex justify-center">
                    <svg class="flex-shrink-0" width="1750" height="308" viewBox="0 0 1750 308"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M284.161 308H1465.84L875.001 182.413 284.161 308z" fill="#0369a1" />
                        <path d="M1465.84 308L16.816 0H1750v308h-284.16z" fill="#065d8c" />
                        <path d="M1733.19 0L284.161 308H0V0h1733.19z" fill="#0a527b" />
                        <path d="M875.001 182.413L1733.19 0H16.816l858.185 182.413z" fill="#0a4f76" />
                    </svg>
                </div>
            </div>
            <header class="relative py-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h1 class="text-3xl font-bold text-white">
                        Settings
                    </h1>
                </div>
            </header>
        </div>

        <settings
            login_url="/login"
        ></settings>
    </div>

    <script src="/js/app.js"></script>
</body>

</html>
