@extends('layouts.app')

@section('content')
<div class="mx-auto h-full flex justify-center items-center bg-gray-300">
    <div class="w-96 bg-blue-900 rounded-lg shadow-xl p-6">
        <h1 class="fill-current text-white text-3xl">Forum with Laravel / Vue</h1>
        <h1 class="text-white text-2xl pt-8">Wellcome Back</h1>
        <h2 class="text-blue-300">Enter Your Credentials Below</h2>

        <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}" class="pt-8">
            @csrf
            <div class="relative">
                <label for="email" class="uppercase text-blue-500 text-xs font-bold absolute pl-3 pt-2">E-mail</label>
                <div>
                    <input id="email" type="email" class="pt-8 w-full rounded p-3 bg-blue-800 text-gray-200 outline-none focus:bg-blue-700" name="email" value="{{ old('email') }}"  autofocus placeholder="your@email.com">
                    @if ($errors->has('email'))
                        <span class="text-red-600 text-sm pb-1" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="relative pt-3">
                <label for="password" class="uppercase text-blue-500 text-xs font-bold absolute pl-3 pt-2">Password</label>
                <div>
                    <input id="password" type="password" class="pt-8 w-full rounded p-3 bg-blue-800 text-gray-200 outline-none focus:bg-blue-700" name="password"  placeholder="Password">
                    @if ($errors->has('password'))
                        <span class="text-red-600 text-sm pb-1" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="pt-2">
                <input class="" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="text-white" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>
            <div class="pt-8">
                <button type="submit" class="w-full bg-gray-300 uppercase rounded py-2 px-3 text-left text-blue-800 font-bold">
                    {{ __('Login') }}
                </button>
            </div>
            <div class="flex justify-between pt-8 text-white font-bold text-sm">
                <a class="" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
                <a class="" href="{{ route('register') }}">
                    Register
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
