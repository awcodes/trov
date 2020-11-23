@props([
'label' => 'Set Your Label, Dummy!',
'name' => 'item',
'hiddenLabel' => false,
'helpText' => false,
'error' => false,
])

<div class="w-full">
    <label for="{{ $name }}" class="font-bold mb-1 text-sm block {{ $hiddenLabel ? 'sr-only' : null }}">{{ $label }}</label>

    <textarea id="{{ $name }}" name="{{ $name }}" {!! $attributes->merge(['class' => 'form-input w-full ' . ($error ? 'border-red-600' : null)]) !!}></textarea>

    @if ($error)
    <x-trov::validation-message>{{ $error }}</x-trov::validation-message>
    @endif

    @if ($helpText)
    <x-trov::help-text>{{ $helpText }}</x-trov::help-text>
    @endif
</div>