@extends('trov::layouts.base', [
'title' => isset($pageTitle) ? $pageTitle : 'Welcome'
])

@section('main')
<x-trov::page-header>
    <x-slot name="pageTitle">@yield('pageTitle', 'Welcome')</x-slot>
</x-trov::page-header>

<x-trov::page-content>
    @yield('pageContent')
</x-trov::page-content>
@endsection