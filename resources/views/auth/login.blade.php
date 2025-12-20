<x-guest-layout>
    <div class="login-card">
        <div class="login-header">
            <h2>نظام إدارة العيادة</h2>
            <p class="text-muted">تسجيل الدخول</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label">البريد الإلكتروني</label>
                <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required
                    autofocus autocomplete="username">
                @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">كلمة المرور</label>
                <input id="password" class="form-control" type="password" name="password" required
                    autocomplete="current-password">
                @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="mb-3 form-check">
                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                <label class="form-check-label" for="remember_me">
                    تذكرني
                </label>
            </div>

            <button type="submit" class="btn btn-primary">
                تسجيل الدخول
            </button>
        </form>
    </div>
</x-guest-layout>