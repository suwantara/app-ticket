<footer class="bg-neutral-primary-soft shadow-xs border border-default">
    <div class="w-full container mx-auto p-4 md:py-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <a href="{{ route('home') }}" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                <img src="{{ asset('img/logo-semabu.png') }}" class="h-10" alt="SemabuHills Logo" width="196"
                    height="40" />
            </a>
            <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-body sm:mb-0">
                <li>
                    <a href="{{ route('home') }}" class="hover:underline me-4 md:me-6">Beranda</a>
                </li>
                <li>
                    <a href="{{ route('about') }}" class="hover:underline me-4 md:me-6">Tentang</a>
                </li>
                <li>
                    <a href="{{ route('contact') }}" class="hover:underline me-4 md:me-6">Kontak</a>
                </li>
            </ul>
        </div>
        <hr class="my-6 border-default sm:mx-auto lg:my-8" />
        <span class="block text-sm text-body sm:text-center">© {{ date('Y') }} <a href="{{ route('home') }}"
                class="hover:underline">SemabuHills</a>. All Rights Reserved.</span>
    </div>
</footer>
