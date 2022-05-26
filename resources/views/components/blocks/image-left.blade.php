<div class="flex flex-col gap-4 mt-8 md:flex-row render-block render-block__image-left">
    <div class="flex-shrink-0 max-w-md">
        <img src="{{ $media->url }}" alt="{{ $media->alt }}" width="{{ $media->width }}"
            height="{{ $media->height }}" srcset="
                {{ $media->url }} 1200w,
                {{ $media->large_url }} 1024w,
                {{ $media->medium_url }} 640w
            " sizes="(max-width: 1200px) 100vw, 1200px" loading="lazy" class="" />
    </div>
    <x-prose>
        {!! $content !!}
    </x-prose>
</div>
