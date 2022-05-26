<div class="flex flex-col gap-6 mt-8 md:flex-row render-block render-block__grid">
    @foreach ($columns as $column)
        <div class="flex-1">
            @foreach ($column['content'] as $block)
                <x-dynamic-component :component="'trov::components.blocks.' . $block['type']"
                    :data="$block['data']" />
            @endforeach
        </div>
    @endforeach
</div>
