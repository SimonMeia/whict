<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js cloak style -->
    <style>
        [x-cloak] {
            display: none !important;
        }

        .loader {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: block;
            margin: 8px auto;
            position: relative;
            color: #777;
            box-sizing: border-box;
            animation: animloader 1s linear infinite alternate;
        }

        @keyframes animloader {
            0% {
                box-shadow: -24px -8px, -8px 0, 8px 0, 24px 0;
            }

            33% {
                box-shadow: -24px 0px, -8px -8px, 8px 0, 24px 0;
            }

            66% {
                box-shadow: -24px 0px, -8px 0, 8px -8px, 24px 0;
            }

            100% {
                box-shadow: -24px 0, -8px 0, 8px 0, 24px -8px;
            }
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>


<body>


    <div class="relative h-screen">
        <!-- Background Pattern -->
        <div class="absolute inset-0">
            <div
                class="relative h-full w-full bg-red [&>div]:absolute [&>div]:h-full [&>div]:w-full [&>div]:bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [&>div]:[background-size:16px_16px] [&>div]:[mask-image:radial-gradient(ellipse_50%_50%_at_50%_50%,#000_70%,transparent_100%)]">
                <div></div>
            </div>
        </div>

        <!-- Hero Content -->
        {{ $slot }}
    </div>
</body>

</html>
