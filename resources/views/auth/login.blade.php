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

                <div class="">
                    <input id="email" type="email" class="pt-8 w-full rounded p-3 bg-blue-800 text-gray-200 outline-none focus:bg-blue-700" name="email" value="{{ old('email') }}" required autofocus placeholder="your@email.com">

                    @if ($errors->has('email'))
                        <span class="" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="relative pt-3">
                <label for="password" class="uppercase text-blue-500 text-xs font-bold absolute pl-3 pt-2">Password</label>

                <div class="">
                    <input id="password" type="password" class="pt-8 w-full rounded p-3 bg-blue-800 text-gray-200 outline-none focus:bg-blue-700" name="password" required placeholder="Password">

                    @if ($errors->has('password'))
                        <span class="" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="pt-2">
                <div class="">
                    <div class="">
                        <input class="" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="text-white" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Login') }}
                    </button>

                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
