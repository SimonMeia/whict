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
        <main class="relative z-10 flex h-full flex-col items-center justify-center px-4">
            <div class="text-center">
                <div class="text-center mb-10">
                    <x-text-animation>
                        What Have I Commited Today ?
                    </x-text-animation>
                    <p class="text-neutral-500">Check your GitHub commits for a specific day</p>
                </div>
                <x-card>
                    @if (Auth::check())
                        <div class="max-w-lg">
                            <div class="grid grid-cols-2 gap-2">
                                <x-button
                                    severity="secondary"
                                    type="link"
                                    href="{{ route('commits', ['date' => now()->subDay()->toDateString()]) }}"
                                >
                                    Yesterday
                                </x-button>
                                <x-button
                                    severity="primary"
                                    type="link"
                                    href="{{ route('commits', ['date' => now()->toDateString()]) }}"
                                >
                                    Today
                                </x-button>
                            </div>

                            <div
                                class="py-4 flex items-center text-sm text-gray-800 before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6">
                                Or choose a date
                            </div>

                            <div
                                x-data="{
                                    selectedDate: '{{ now()->toDateString() }}',
                                    formatDateForUrl(dateString) {
                                        if (!dateString) return '{{ now()->toDateString() }}';
                                        // Convert from 'MMM DD, YYYY' to 'YYYY-MM-DD'
                                        const date = new Date(dateString);
                                        if (isNaN(date.getTime())) return '{{ now()->toDateString() }}';
                                        return date.getFullYear() + '-' +
                                            String(date.getMonth() + 1).padStart(2, '0') + '-' +
                                            String(date.getDate()).padStart(2, '0');
                                    }
                                }"
                                @date-selected.window="selectedDate = formatDateForUrl($event.detail.date)"
                                class="flex gap-2"
                            >
                                <div class="grow">
                                    <x-date-picker />
                                </div>
                                <x-button
                                    severity="secondary"
                                    type="link"
                                    href="{{ route('commits') }}"
                                    x-bind:href="'{{ route('commits') }}?date=' + selectedDate"
                                >
                                    Search
                                </x-button>
                            </div>
                        </div>
                    @else
                        <div>
                            <a href="{{ route('auth.redirect') }}"> Sign in with GitHub </a>
                        </div>
                    @endif
                </x-card>
                @if (Auth::check())
                    <div class="mt-6 text-sm text-neutral-500">
                        Authenticated as <span class="font-bold">{{ Auth::user()->name }}</span>
                        <span class="text-neutral-400">({{ Auth::user()->email }})</span>
                    </div>
                @endif
            </div>
        </main>
    </div>




</body>

</html>
