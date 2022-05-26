<details class="group render-block render-block__details">
    <summary class="flex items-center justify-between px-4 py-3 cursor-pointer">
        <span>{{ $summary }}</span>
        <div class="grid p-1 rounded-full place-content-center">
            <x-heroicon-s-chevron-down class="w-5 h-5 text-gray-900 group-open:hidden" />
            <x-heroicon-s-chevron-up class="hidden w-5 h-5 text-gray-900 group-open:block" />
        </div>
    </summary>
    <div class="p-4 space-y-4 bg-white open:bg-white">
        @foreach ($content as $block)
            <x-dynamic-component :component="'trov::components.blocks.' . $block['type']"
                :data="$block['data']" />
        @endforeach
    </div>
</details>
