@extends('trov::layouts.auth', [
'title' => 'Forgot Password'
])

@section('body')
<h2 class="text-2xl">Forgot your password, huh?</h2>
<p class="mt-2 text-sm">No worries! Just let me know your email address.</p>
<form method="POST" action="{{ route('password.email') }}" class="mt-8">
    @csrf

    <div>
        <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

        <div class="col-md-6">
            <input id="email" type="email" name="email" required class="block w-full p-3 mt-1 text-gray-900 placeholder-gray-400 rounded">
        </div>
    </div>

    <div class="mt-12">

        @error('email')
        <div class="mb-8 text-red-300" role="alert">
            <strong>Are you sure we know each other?</strong>
            <div class="text-sm">{{ $message }}</div>
        </div>
        @enderror

        @if (session('status'))
        <div class="mb-8 text-green-300" role="alert">
            {{ session('status') }}
        </div>
        @endif

        <button type="submit" class="px-8 py-2 text-lg font-bold text-white bg-pink-600 rounded-full hover:bg-pink-500">
            {{ __('Send Password Reset Link') }}
        </button>
    </div>

    <div class="mt-8">
        <a href="/login" class="text-sm font-medium text-pink-500 hover:text-pink-400 hover:underline">
            Nevermind, I remember now.
        </a>
    </div>
</form>
@endsection