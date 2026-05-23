<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="mt-1 block w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <!-- Remember Me -->
        <div class="block">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded-[5px] border-blade-neon bg-white text-blade-main focus:ring-blade-main" name="remember">
                <span class="ms-2 text-sm text-gray-600 ">{{ __('Remember me') }}</span>
            </label>
        </div>
        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end">
            @if (Route::has('password.request'))
                <a class="rounded-[5px] text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-blade-main focus:ring-offset-2" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="w-full sm:w-auto" id="login">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
        <div>
            <a href="{{ route('google.redirect') }}"
                class="inline-flex min-h-10 w-full items-center justify-center gap-2 rounded-[5px] border border-blade-neon bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-blade-soft focus:outline-none focus:ring-2 focus:ring-blade-main focus:ring-offset-2">
            <img src="{{ asset('img/icons/google.svg') }}" alt="" class="h-5 w-5">
            <span>Googleでログイン</span>
            </a>
        </div>
    </form>
    <script src="{{ asset('js/app.js') }}"></script>
</x-guest-layout>
