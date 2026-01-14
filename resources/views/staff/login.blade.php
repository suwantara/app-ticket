<x-layouts.staff title="Login Staff">
    <div class="min-h-screen bg-linear-to-br from-slate-900 to-slate-800 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <!-- Logo/Header -->
            <div class="text-center mb-8">
                <div class="mx-auto h-16 w-16 bg-blue-600 rounded-xl flex items-center justify-center mb-4">
                    <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-white">Portal Petugas</h2>
                <p class="mt-2 text-slate-400">Masuk untuk mengakses sistem boarding</p>
            </div>

            <!-- Login Form -->
            <div class="bg-white rounded-2xl shadow-2xl p-8">
                @if(session('error'))
                    <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4 rounded-r">
                        <p class="text-red-700">{{ session('error') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('staff.login.post') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email
                        </label>
                        <input type="email"
                               name="email"
                               id="email"
                               value="{{ old('email') }}"
                               class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }}"
                               placeholder="petugas@example.com"
                               required
                               autofocus>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password
                        </label>
                        <input type="password"
                               name="password"
                               id="password"
                               class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }}"
                               placeholder="••••••••"
                               required>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input type="checkbox"
                                   name="remember"
                                   id="remember"
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="remember" class="ml-2 block text-sm text-gray-700">
                                Ingat saya
                            </label>
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition duration-200 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        Masuk
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-gray-700">
                        ← Kembali ke Beranda
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <p class="mt-8 text-center text-slate-500 text-sm">
                &copy; {{ date('Y') }} Ferry Ticket System. All rights reserved.
            </p>
        </div>
    </div>
</x-layouts.staff>
