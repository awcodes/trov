<?xml version="1.0" encoding="UTF-8"?>
{{-- <?xml-stylesheet type="text/xsl" href="{{ asset('css/sitemap.xsl') }}"?> --}}

<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    <sitemap>
        <loc>
            <![CDATA[{{ config('app.url') }}]]>
        </loc>
        <lastmod>
            <![CDATA[{{ \Carbon\Carbon::now()->tz('UTC')->toAtomString() }}]]>
        </lastmod>
    </sitemap>

    @if ($links)
        @foreach ($links as $link)
            <sitemap>
                <loc>
                    <![CDATA[{{ trailing_slash_it($link->metaable->getPublicUrl()) }}]]>
                </loc>
                <lastmod>
                    <![CDATA[{{ $link->metaable->updated_at->tz('UTC')->toAtomString() }}]]>
                </lastmod>
            </sitemap>
        @endforeach
    @endif
</sitemapindex>
