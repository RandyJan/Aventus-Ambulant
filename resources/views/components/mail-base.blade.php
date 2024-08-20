<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <!-- The CSS stylesheet which will be inlined. -->
    {{-- <link rel="stylesheet" type="text/css" href="{{ config('app.url').mix('css/mail.css') }}"> --}}
    {{-- <style>
        {!! file_get_contents( public_path('css/mail.css') ) !!}
    </style>

    @if ($subject = $attributes->get('subject'))
        <title>{{ $subject }}</title>
    @endif --}}
    <style>
        html {
            line-height: 1.5;
            /* 1 */
            -webkit-text-size-adjust: 100%;
            /* 2 */
            -moz-tab-size: 4;
            /* 3 */
            -o-tab-size: 4;
            tab-size: 4;
            /* 3 */
            font-family: "DM Sans", system-ui;
            /* 4 */
        }

        /*
1. Remove the margin in all browsers.
2. Inherit line-height from `html` so users can set them as a class directly on the `html` element.
*/

        body {
            margin: 0;
            /* 1 */
            line-height: inherit;
            /* 2 */
            font-size: 10px;
        }

        table,
        th,
        td {
            /* border: 1px solid black; */
            border-collapse: collapse;
            vertical-align: top;
        }

        .bold {
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }

        .border {
            border: 1px solid gray;
        }
        .border-b {
            border-bottom: 1px solid gray;
        }
    </style>
</head>

<body style="">
    {{-- <div class="w-full h-full px-8 py-12"> --}}
    {{ $slot }}
    {{-- </div> --}}
</body>

</html>
