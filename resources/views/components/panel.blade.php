<div class="overflow-hidden border border-gray-300 rounded">
    @isset($title)
    <div class="px-4 py-2 text-sm font-bold border-b border-gray-300 bg-white">
        {{ $title }}
    </div>
    @endisset
    <div class="bg-white">
        <div class="divide-y divide-gray-100">
            {{ $slot }}
        </div>
    </div>
    @isset($actions)
    <div class="flex items-center justify-end px-4 py-3 text-right bg-white border-t border-gray-300">
        {{ $actions }}
    </div>
    @endisset
</div>