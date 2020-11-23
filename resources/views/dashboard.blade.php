@extends('trov::layouts.base', [
'title' => 'Welcome'
])

@section('main')
<x-trov::page-header>
    <x-slot name="pageTitle">Welcome</x-slot>
</x-trov::page-header>

<x-trov::page-content></x-trov::page-content>
@endsection