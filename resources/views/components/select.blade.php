@props([
'label' => 'Set Your Label, Dummy!',
'name' => 'item',
'hiddenLabel' => false,
'helpText' => false,
'error' => false,
])

<div class="w-full">
    <label for="{{ $name }}" class="font-bold block mb-1 text-sm {{ $hiddenLabel ? 'sr-only' : null }}">{{ $label }}</label>

    <div class="relative flex items-center w-full">

        <select id="{{ $name }}" name="{{ $name }}" {!! $attributes->merge(['class' => 'form-select w-full ' . ($error ? 'border-red-600' : null)]) !!}>
            {{ $slot }}
        </select>

    </div>

    @if ($error)
    <x-trov::validation-message>{{ $error }}</x-trov::validation-message>
    @endif

    @if ($helpText)
    <x-trov::help-text>{{ $helpText }}</x-trov::help-text>
    @endif
</div>