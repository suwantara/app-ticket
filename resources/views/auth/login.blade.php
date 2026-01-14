<x-layouts.app title="Login">
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            {{-- Logo & Title --}}
            <div class="text-center mb-8">
                <a href="{{ route('home') }}" class="inline-flex items-center space-x-2 text-3xl font-bold text-gray-800">
                    <i class="fa-solid fa-ship text-blue-600"></i>
                    <span>Fast<span class="text-blue-600">Boat</span>Ticket</span>
                </a>
                <h2 class="mt-6 text-2xl font-bold text-gray-900">Masuk ke Akun Anda</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500">
                        Daftar sekarang
                    </a>
                </p>
            </div>

            {{-- Login Form --}}
            <div class="bg-white rounded-2xl shadow-xl p-8">
                {{-- Error Alert --}}
                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center">
                            <i class="fa-solid fa-circle-exclamation text-red-500 mr-2"></i>
                            <span class="text-sm text-red-700">{{ $errors->first() }}</span>
                        </div>
                    </div>
                @endif

                {{-- Success Alert --}}
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center">
                            <i class="fa-solid fa-circle-check text-green-500 mr-2"></i>
                            <span class="text-sm text-green-700">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fa-solid fa-envelope mr-1 text-gray-400"></i> Email
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('email') border-red-500 @enderror"
                               placeholder="nama@email.com"
                               required autofocus autocomplete="email">
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fa-solid fa-lock mr-1 text-gray-400"></i> Password
                        </label>
                        <div class="relative" x-data="{ show: false }">
                            <input :type="show ? 'text' : 'password'" name="password" id="password"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors pr-12 @error('password') border-red-500 @enderror"
                                   placeholder="••••••••"
                                   required autocomplete="current-password">
                            <button type="button" @click="show = !show"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i x-show="!show" class="fa-solid fa-eye"></i>
                                <i x-show="show" class="fa-solid fa-eye-slash"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Remember Me --}}
                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember"
                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                        </label>
                        {{-- <a href="#" class="text-sm text-blue-600 hover:text-blue-500">
                            Lupa password?
                        </a> --}}
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit"
                            class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <i class="fa-solid fa-right-to-bracket mr-2"></i>
                        Masuk
                    </button>
                </form>

                {{-- Divider --}}
                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">atau</span>
                        </div>
                    </div>
                </div>

                {{-- Register Link --}}
                <div class="mt-6 text-center">
                    <a href="{{ route('register') }}"
                       class="w-full inline-flex justify-center items-center py-3 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <i class="fa-solid fa-user-plus mr-2"></i>
                        Buat Akun Baru
                    </a>
                </div>
            </div>

            {{-- Back to Home --}}
            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="text-sm text-gray-600 hover:text-gray-900">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
