@props([
'label' => 'Set a label, dummy!',
'name' => 'checkbox',
'helpText' => false,
'error' => false,
'active' => false,
])

<div class="w-full">
    <div class="relative flex items-start">
        <div class="flex items-center h-5">
            <input id="{{ $name }}" type="checkbox" name="{{ $name }}" class="w-4 h-4 text-green-500 form-checkbox" {{ $attributes }} {{ $active ? 'checked' : null }}>
        </div>
        <div class="ml-2 text-sm leading-5">
            <label for="{{ $name }}" class="text-base text-gray-700">{{ $label }}</label>
        </div>
    </div>

    @if ($error)
    <x-trov::validation-message>{{ $error }}</x-trov::validation-message>
    @endif

    @if ($helpText)
    <x-trov::help-text>{{ $helpText }}</x-trov::help-text>
    @endif
</div>