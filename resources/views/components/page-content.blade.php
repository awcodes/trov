@props([
'sidebar' => false,
])
<article class="container flex flex-col px-6 py-12 mx-auto lg:flex-row">
    <div class="flex-1 order-2 max-w-full lg:order-1">
        {{ $slot }}
    </div>
    @if ($sidebar)
    <aside class="order-1 w-full mb-6 space-y-6 lg:max-w-sm lg:mb-0 lg:ml-6 lg:order-2">
        {{ $sidebar }}
    </aside>
    @endif
</article>