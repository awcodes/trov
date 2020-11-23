@props(['head' => null])

<div class="w-full overflow-x-auto">
    <table {{ $attributes->merge(['class' => 'w-full']) }}>
        <thead>
            {{ $head }}
        </thead>
        <tbody class="divide-y divide-gray-200">
            {{ $slot }}
        </tbody>
    </table>
</div>