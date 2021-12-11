<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <img src="{{ asset('images/logo.png') }}" class="" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="username" :value="__('Username')" />

                <x-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
               

                <x-button class="ml-3">
                    {{ __('Login') }}
                </x-button>
            </div>
            <hr>
            <ul>
                <li>Login [username, password]
                    <ul style="margin-left:50px;"><li>Admin: [admin, 123456789 ]</li><li>Sales: [sales, sales]</li></ul>
                </li>
                <li>Features
                    <ul style="margin-left:50px;"><li>Laravel 8</li><li>Admin Lte</li></ul>
                </li>
                 <li>Packages
                    <ul style="margin-left:50px;"><li>laravel/breeze</li><li>bumbummen99/shoppingcart</li><li>milon/barcode</li></ul>
                </li>
                <li>Fork at <ul  style="margin-left:50px;"><li><a style="color:red;" href="https://github.com/infomasudcse/inventory-by-laravel" alt="github link">Github</a></li></ul></li>
                
            </ul>
        </form>
    </x-auth-card>
</x-guest-layout>







