@props([
'theme' => 'secondary',
'themes' => [
'primary' => 'bg-teal-100 text-teal-800 ',
'secondary' => 'bg-gray-200 text-gray-800 ',
'danger' => 'bg-red-200 text-red-800 ',
'warning' => 'bg-yellow-200 text-yellow-800 ',
'success' => 'bg-green-200 text-green-800 ',
'info' => 'bg-blue-200 text-blue-800 ',
],
'size' => 'default',
'sizes' => [
'default' => 'px-2 py-px text-xs leading-4 ',
'lg' => 'px-3 py-1 text-sm leading-5 ',
],
'type' => 'pill',
'types' => [
'pill' => 'rounded-full ',
'square' => 'rounded ',
]
])

<span {{ $attributes->merge(['class' => 'inline-flex items-center font-medium ' . $sizes[$size] . $types[$type] . $themes[$theme]]) }}>
    {{ $slot }}
</span>