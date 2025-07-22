@section('title', 'Login | DownCare')
<x-guest-layout>
<x-auth-card>
    <div class="flex items-center justify-center">
            <img src="{{ asset('images/logo.png') }}" style="width: 150px"  alt="">
     </div>
     <div class="text-center mb-3">
            <h1><b>LOGIN</b></h1>
    </div>
        
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
            
            
        </div>
    </form>
    <div class="text-center mt-4">
        <span class="text-sm text-gray-600">Belum punya akun? </span>
        @if (Route::has('register'))
            <a href="{{ route('register') }}" class="text-sm text-blue-600 hover:underline">
                {{ __('Daftar di sini') }}
            </a>
        @endif
    </div>
    
</x-auth-card>
</x-guest-layout>
