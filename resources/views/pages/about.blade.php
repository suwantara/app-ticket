<x-layouts.app :title="$page->meta_title ?? 'Tentang Kami'">
    {{-- Page Header --}}
    <section class="relative bg-gradient-to-r from-blue-600 to-blue-800 py-20">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.4\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                {{ $page->title }}
            </h1>
            @if($page->meta_description)
                <p class="text-lg text-blue-100 max-w-2xl mx-auto">
                    {{ $page->meta_description }}
                </p>
            @endif
        </div>
    </section>

    {{-- Featured Image --}}
    @if($page->featured_image)
        <div class="container mx-auto px-4 -mt-10 relative z-20">
            <img src="{{ Storage::url($page->featured_image) }}"
                 alt="{{ $page->title }}"
                 class="w-full max-w-4xl mx-auto rounded-xl shadow-2xl object-cover max-h-96">
        </div>
    @endif

    {{-- Main Content --}}
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <article class="prose prose-lg max-w-none prose-headings:text-gray-800 prose-p:text-gray-600 prose-a:text-blue-600 hover:prose-a:text-blue-800 prose-ul:text-gray-600 prose-ol:text-gray-600 prose-strong:text-gray-700">
                    {!! $page->content !!}
                </article>
            </div>
        </div>
    </section>

    {{-- Team/Stats Section --}}
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Pencapaian Kami</h2>
                <p class="text-gray-600">Komitmen kami dalam melayani wisatawan Indonesia</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-4xl mx-auto">
                <div class="text-center">
                    <div class="text-4xl md:text-5xl font-bold text-blue-600 mb-2">5+</div>
                    <div class="text-gray-600">Tahun Pengalaman</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl md:text-5xl font-bold text-blue-600 mb-2">50K+</div>
                    <div class="text-gray-600">Pelanggan Puas</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl md:text-5xl font-bold text-blue-600 mb-2">20+</div>
                    <div class="text-gray-600">Rute Tersedia</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl md:text-5xl font-bold text-blue-600 mb-2">15+</div>
                    <div class="text-gray-600">Partner Operator</div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-16 bg-blue-600">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">Ada Pertanyaan?</h2>
            <p class="text-blue-100 mb-8">Tim kami siap membantu Anda</p>
            <a href="{{ route('contact') }}" class="inline-block bg-white text-blue-600 font-semibold px-8 py-4 rounded-lg hover:bg-gray-100 transition-colors">
                <i class="fa-solid fa-envelope mr-2"></i> Hubungi Kami
            </a>
        </div>
    </section>
</x-layouts.app>
