@extends('trov::layouts.auth', [
'title' => 'Reset your password'
])

@section('body')
<h2 class="text-2xl">Reset your password</h2>
<p class="mt-2 text-sm">Whoosah! Let's get you into your account.</p>
<form method="POST" action="/reset-password" class="mt-8">
    @csrf

    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <div class="space-y-6">
        <div>
            <label for="email" class="block text-sm font-medium leading-5 text-gray-300">
                Email address
            </label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required class="block w-full p-3 mt-1 text-gray-900 placeholder-gray-400 rounded">
            @error('email')
            <div class="mt-1 mb-8 text-sm text-red-300" role="alert">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium leading-5 text-gray-300">
                Password
            </label>
            <input id="password" type="password" name="password" required class="block w-full p-3 mt-1 text-gray-900 placeholder-gray-400 rounded">
            @error('password')
            <div class="mt-1 mb-8 text-sm text-red-300" role="alert">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div>
            <label for="password-confirm" class="block text-sm font-medium leading-5 text-gray-300">
                Confirm Password
            </label>
            <input id="password-confirm" type="password" name="password_confirmation" required class="block w-full p-3 mt-1 text-gray-900 placeholder-gray-400 rounded">
        </div>
    </div>

    <div class="mt-12">
        <button type="submit" class="px-8 py-2 text-lg font-bold text-white bg-pink-600 rounded-full hover:bg-pink-500">
            Reset Password
        </button>
    </div>

    <div class="mt-8">
        <a href="/login" class="text-sm font-medium text-pink-500 hover:text-pink-400 hover:underline">
            Nevermind, I remember now.
        </a>
    </div>
</form>
@endsection