@props(['type' => 'button', 'severity' => 'primary'])

@php
    $classes = match ($severity) {
        'secondary'
            => 'inline-flex h-fit items-center justify-center px-4 py-2  font-medium tracking-wide transition-colors duration-200 bg-white border rounded-md text-neutral-500 hover:text-neutral-700 border-neutral-200/70 hover:bg-neutral-100 active:bg-white focus:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-200/60 focus:shadow-outline',
        'primary'
            => 'inline-flex h-fit items-center justify-center px-4 py-2  font-medium tracking-wide text-white transition-colors duration-200 rounded-md bg-neutral-950 hover:bg-neutral-900 focus:ring-2 focus:ring-offset-2 focus:ring-neutral-900 focus:shadow-outline focus:outline-none',
        'info'
            => 'inline-flex h-fit items-center justify-center px-4 py-2  font-medium tracking-wide text-white transition-colors duration-200 rounded-md bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-700 focus:shadow-outline focus:outline-none',
        'danger'
            => 'inline-flex h-fit items-center justify-center px-4 py-2  font-medium tracking-wide text-white transition-colors duration-200 rounded-md bg-red-600 hover:bg-red-700 focus:ring-2 focus:ring-offset-2 focus:ring-red-700 focus:shadow-outline focus:outline-none',
        'success'
            => 'inline-flex h-fit items-center justify-center px-4 py-2  font-medium tracking-wide text-white transition-colors duration-200 rounded-md bg-green-600 hover:bg-green-700 focus:ring-2 focus:ring-offset-2 focus:ring-green-700 focus:shadow-outline focus:outline-none',
        'warning'
            => 'inline-flex h-fit items-center justify-center px-4 py-2  font-medium tracking-wide text-white transition-colors duration-200 rounded-md bg-yellow-500 hover:bg-yellow-600 focus:ring-2 focus:ring-offset-2 focus:ring-yellow-600 focus:shadow-outline focus:outline-none',
        default => '',
    };
@endphp




@if ($type === 'button')
    <button type="button" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@elseif($type === 'link')
    <a {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@endif
