@props([
'label' => 'Set your label, Dummy!',
'hiddenLabel' => false,
'helpText' => false,
'error' => false,
'name' => 'x',
'value' => null,
'plugins' => 'link code lists autoresize',
'toolbar' => 'bold italic underline bullist numlist link code',
'menubar' => false,
'addMedia' => false,
])

@php
if ($addMedia) {
$toolbar = $toolbar . ' addMedia';
}
@endphp
<div class="w-full" wire:ignore>
    <label for="{{ $name }}" class="font-bold mb-1 text-sm block {{ $hiddenLabel ? 'sr-only' : null }}">{{ $label }}</label>
    <textarea id="{{ $name }}" name="{{ $name }}" {{ $attributes }} class="w-full form-input">{{ $slot }}</textarea>

    @if ($error)
    <x-trov::validation-message>{{ $error }}</x-trov::validation-message>
    @endif

    @if ($helpText)
    <x-trov::help-text>{{ $helpText }}</x-trov::help-text>
    @endif
</div>

@push('scripts')
@once
<script src="https://cdn.tiny.cloud/1/jz7xyc3oqboxeu2do3jekht8y8tq762vdrpmvt4yd1eq89bo/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
@endonce
<script>
    tinymce.init({
        selector: '#{{ $name }}',
        plugins: '{{ $plugins }}',
        toolbar: '{{ $toolbar }}',
        menubar: '{{ $menubar }}',
        body_class: 'font-sans antialiased text-base leading-normal m-4',
        setup: function (editor) {
            editor.on('init change', function () {
                editor.save();
            });
            editor.on("change", function(e){
                @this.set("{{ $attributes->whereStartsWith('wire:model')->first() }}", editor.getContent());
            });
            @if($addMedia)
            editor.ui.registry.addButton('addMedia', {
                tooltip: 'Insert Media',
                icon: 'image',
                onAction: function (_) {
                    window.insertMedia = true;
                    window.ml.show({ folder: { path: "{{ config('services.cloudinary.folder') }}" } });
                }
            });
            @endif
        },
    });
</script>
@endpush