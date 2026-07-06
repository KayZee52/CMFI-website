<x-guest-layout>
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-2">Welcome back</h1>
        <p class="text-slate-500 font-medium">Please enter your credentials to access the CRM portal.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="form-label">Email Address</label>
            <input id="email" class="input-class" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="password" class="form-label mb-0">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-[13px] font-bold text-indigo-600 hover:text-indigo-700 transition-colors" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>
            <input id="password" class="input-class"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" class="w-4 h-4 rounded border-slate-300 text-slate-900 focus:ring-slate-900 transition-all cursor-pointer" name="remember">
            <span class="ms-3 text-sm font-medium text-slate-600 cursor-pointer select-none" onclick="document.getElementById('remember_me').click()">Keep me logged in</span>
        </div>

        <button type="submit" class="btn-primary w-full py-4 text-lg">
            {{ __('Sign In') }}
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </button>
    </form>
</x-guest-layout>
