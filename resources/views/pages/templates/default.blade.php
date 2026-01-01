<x-layouts.app :title="$page->meta_title ?? $page->title">
    {{-- Page Header --}}
    <section class="bg-gradient-to-r from-blue-600 to-blue-800 py-16">
        <div class="container mx-auto px-4 text-center">
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
        <div class="container mx-auto px-4 -mt-8">
            <img src="{{ Storage::url($page->featured_image) }}"
                 alt="{{ $page->title }}"
                 class="w-full max-w-4xl mx-auto rounded-xl shadow-2xl object-cover max-h-96">
        </div>
    @endif

    {{-- Page Content --}}
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <article class="prose prose-lg max-w-none prose-headings:text-gray-800 prose-p:text-gray-600 prose-a:text-blue-600 hover:prose-a:text-blue-800 prose-ul:text-gray-600 prose-ol:text-gray-600 prose-strong:text-gray-700">
                    {!! $page->content !!}
                </article>
            </div>
        </div>
    </section>
</x-layouts.app>
