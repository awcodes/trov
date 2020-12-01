@props([
'label' => 'Set Your Label, Dummy!',
'name' => 'item',
'hiddenLabel' => false,
'helpText' => false,
'error' => false,
])

<div class="w-full" x-data="{ value: @entangle($attributes->wire('model')), picker: undefined }" x-init="new Pikaday({ field: $refs.input, format: 'MM/DD/YYYY', onOpen() { this.setDate($refs.input.value) } })" x-on:change="value = $event.target.value">
    <label for="{{ $name }}" class="font-bold mb-1 text-sm block {{ $hiddenLabel ? 'sr-only' : null }}">{{ $label }}</label>
    <div class="flex rounded-md shadow-sm">
        <span class="inline-flex items-center px-3 text-gray-600 bg-gray-200 border border-r-0 border-gray-400 rounded-l-md sm:text-sm">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M6 2C5.44772 2 5 2.44772 5 3V4H4C2.89543 4 2 4.89543 2 6V16C2 17.1046 2.89543 18 4 18H16C17.1046 18 18 17.1046 18 16V6C18 4.89543 17.1046 4 16 4H15V3C15 2.44772 14.5523 2 14 2C13.4477 2 13 2.44772 13 3V4H7V3C7 2.44772 6.55228 2 6 2ZM6 7C5.44772 7 5 7.44772 5 8C5 8.55228 5.44772 9 6 9H14C14.5523 9 15 8.55228 15 8C15 7.44772 14.5523 7 14 7H6Z" />
            </svg>
        </span>

        <input id="{{ $name }}" name="{{ $name }}" {{ $attributes->whereDoesntStartWith('wire:model') }} x-ref="input" x-bind:value="value" class="rounded-none rounded-r-md flex-1 form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 {{ $error ? 'border-red-600' : null }}" />
    </div>
    @if ($error)
    <p class="text-sm text-red-600">{{ $error }}</p>
    @endif

    @if ($helpText)
    <p class="text-sm italic text-gray-700">{{ $helpText }}</p>
    @endif
</div>

@push('styles')
@once
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
@endonce
@endpush

@push('scripts')
@once
<script src="https://unpkg.com/moment" defer></script>
<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js" defer></script>
@endonce
@endpush