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

        return response()->view('trov::sitemap', [
            'links' => $links
        ])->header('Content-Type', 'text/xml');
    }

    public function pretty()
    {
        $links = Meta::where('indexable', true)->whereRelation('metaable', 'status', 'Published')->get();

        return response()->view('trov::pretty-sitemap', [
            'links' => $links
        ]);
    }
}
