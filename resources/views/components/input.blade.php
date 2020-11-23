@props([
'label' => 'Set Your Label, Dummy!',
'name' => 'item',
'hiddenLabel' => false,
'leadingAddOn' => false,
'trailingAddOn' => false,
'helpText' => false,
'error' => false,
])

<div class="w-full">
    <label for="{{ $name }}" class="font-bold block mb-1 text-sm {{ $hiddenLabel ? 'sr-only' : null }}">{{ $label }}</label>

    <div class="relative flex items-center w-full">

        @if ($leadingAddOn)
        <span class="flex items-center self-stretch px-3 text-gray-700 bg-gray-300 border border-r-0 border-gray-400 rounded-l-md sm:text-sm">
            {{ $leadingAddOn }}
        </span>
        @endif

        <input id="{{ $name }}" name="{{ $name }}" {!! $attributes->merge(['class' => ($leadingAddOn ? 'rounded-none rounded-r-md' : ($trailingAddOn ? 'rounded-none rounded-l-md' : 'rounded-md')) . ' form-input w-full ' . ($error ? 'border-red-600' : null)]) !!}>

        @if ($trailingAddOn)
        <span class="flex items-center self-stretch px-3 text-gray-700 bg-gray-300 border border-r-0 border-gray-400 rounded-r-md sm:text-sm">
            {{ $trailingAddOn }}
        </span>
        @endif

    </div>

    @if ($error)
    <x-trov::validation-message>{{ $error }}</x-trov::validation-message>
    @endif

    @if ($helpText)
    <x-trov::help-text>{{ $helpText }}</x-trov::help-text>
    @endif
</div>