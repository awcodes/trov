<?php

namespace Trov\Http\Controllers;

use App\Models\Faq;
use App\Models\Page;
use App\Models\WhitePage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Meta;

class SitemapController extends Controller
{
    public function index()
    {
        $links = Meta::where('indexable', true)->whereRelation('metaable', 'status', 'Published')->get();

        $links->filter(fn ($link) => $link->metaable->front_page == false);

        return response()->view('trov::sitemap', [
            'links' => $links
        ])->header('Content-Type', 'text/xml');
    }
}
