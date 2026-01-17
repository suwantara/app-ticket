<x-layouts.app title="Daftar" :hideFooter="true" :hideNavbar="true">
    <div class="min-h-screen flex items-center justify-center bg-neutral-primary py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            {{-- Logo & Title --}}
            <div class="text-center mb-8">
                <img src="{{ asset('img/logo-semabu.png') }}" alt="logo-semabu" class="h-12 mx-auto">
            </div>

            {{-- Register Form --}}
            <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-200">
                {{-- Error Alert --}}
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-start">
                            <i class="fa-solid fa-circle-exclamation text-red-500 mr-2 mt-0.5"></i>
                            <div>
                                <p class="text-sm font-medium text-red-700">Terjadi kesalahan:</p>
                                <ul class="mt-1 text-sm text-red-600 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    {{-- Name --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('name') border-red-500 @enderror"
                            placeholder="Masukkan nama lengkap" required autofocus autocomplete="name">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('email') border-red-500 @enderror"
                            placeholder="nama@email.com" required autocomplete="email">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password
                        </label>
                        <div class="relative" x-data="{ show: false }">
                            <input :type="show ? 'text' : 'password'" name="password" id="password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors pr-12 @error('password') border-red-500 @enderror"
                                placeholder="Minimal 8 karakter" required autocomplete="new-password">
                            <button type="button" @click="show = !show"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i x-show="!show" class="fa-solid fa-eye"></i>
                                <i x-show="show" class="fa-solid fa-eye-slash"></i>
                            </button>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="fa-solid fa-info-circle mr-1"></i>
                            Min. 8 karakter, huruf besar & kecil, angka, dan simbol
                        </p>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Konfirmasi Password
                        </label>
                        <div class="relative" x-data="{ show: false }">
                            <input :type="show ? 'text' : 'password'" name="password_confirmation"
                                id="password_confirmation"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors pr-12"
                                placeholder="Ulangi password" required autocomplete="new-password">
                            <button type="button" @click="show = !show"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i x-show="!show" class="fa-solid fa-eye"></i>
                                <i x-show="show" class="fa-solid fa-eye-slash"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Terms --}}
                    <div class="flex items-start">
                        <input type="checkbox" name="terms" id="terms" required
                            class="w-4 h-4 mt-0.5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="terms" class="ml-2 text-sm text-gray-600">
                            Saya menyetujui
                            <a href="#" class="text-blue-600 hover:text-blue-500">Syarat & Ketentuan</a>
                            dan
                            <a href="#" class="text-blue-600 hover:text-blue-500">Kebijakan Privasi</a>
                        </label>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit"
                        class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-900 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <i class="fa-solid fa-user-plus mr-2"></i>
                        Daftar Sekarang
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

                {{-- Login Link --}}
                <div class="mt-6 text-center">
                    <a href="{{ route('login') }}"
                        class="w-full inline-flex justify-center items-center py-3 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <i class="fa-solid fa-right-to-bracket mr-2"></i>
                        Sudah Punya Akun? Masuk
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
