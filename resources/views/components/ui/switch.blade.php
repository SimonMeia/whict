@props(['name' => 'switch', 'label' => '', 'checked' => false, 'id' => null, 'labelPosition' => 'right'])

@php
    $switchId = $id ?? 'switch-' . uniqid();
    $isLabelLeft = $labelPosition === 'left';
@endphp

<div class="flex items-center space-x-2"
    :class="{ 'flex-row-reverse space-x-reverse': {{ $isLabelLeft ? 'true' : 'false' }} }"
>
    <input
        id="{{ $switchId }}"
        type="checkbox"
        name="{{ $name }}"
        value="1"
        class="hidden"
        {{ $checked ? 'checked' : '' }}
        {{ $attributes->merge(['x-model' => $name]) }}
    >

    <button
        x-ref="switchButton"
        type="button"
        x-on:click="{{ $name }} = ! {{ $name }}"
        :class="{{ $name }} ? 'bg-black' : 'bg-neutral-200'"
        class="relative inline-flex h-6 py-0.5 focus:outline-none rounded-full w-10 transition-colors duration-200"
        x-cloak
    >
        <span :class="{{ $name }} ? 'translate-x-[18px]' : 'translate-x-0.5'"
            class="w-5 h-5 duration-200 ease-in-out bg-white rounded-full shadow-md"
        >
        </span>
    </button>

    @if ($label)
        <label
            for="{{ $switchId }}"
            :class="{ 'text-black': {{ $name }}, 'text-gray-400': !{{ $name }} }"
            class="text-sm select-none cursor-pointer transition-colors duration-200"
            x-cloak
        >
            {{ $label }}
        </label>
    @endif
</div>
