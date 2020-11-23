@extends('trov::layouts.auth', [
'title' => 'Login'
])

@section('body')
<h2 class="text-2xl">Log in to your account</h2>
<form method="POST" action="/login" class="mt-8">
    @csrf
    <div class="space-y-6">
        <div>
            <label for="email" class="block text-sm font-medium leading-5 text-gray-300">
                Email
            </label>
            <input id="email" type="email" name="email" required class="block w-full p-3 mt-1 text-gray-900 placeholder-gray-400 rounded" value="{{ old('email') }}">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium leading-5 text-gray-300">
                Password
            </label>
            <input id="password" type="password" name="password" required class="block w-full p-3 mt-1 text-gray-900 placeholder-gray-400 rounded">
        </div>
    </div>

    <div class="mt-12">
        @if($errors->any())
        <div class="mb-8 text-red-300" role="alert">
            <strong>Are you sure we know each other?</strong>
            <div class="text-sm">I couldn't log you in with the provided credentials.</div>
        </div>
        @endif

        @if (session('status'))
        <div class="mb-8 text-green-300" role="alert">
            {{ session('status') }}
        </div>
        @endif

        <button type="submit" class="px-8 py-2 text-lg font-bold text-white bg-pink-600 rounded-full hover:bg-pink-500">
            Sign in
        </button>
    </div>

    <div class="mt-8">
        <a href="/forgot-password" class="text-sm font-medium text-pink-500 hover:text-pink-400 hover:underline">
            Help me, passwords are hard!
        </a>
    </div>
</form>
@endsection