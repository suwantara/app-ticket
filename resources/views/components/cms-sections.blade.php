@props(['sections' => []])

@if($sections && count($sections) > 0)
    @foreach($sections as $section)
        @if($section['is_visible'] ?? true)
            @php
                $bgColor = $section['background_color'] ?? '';
                $textColor = $section['text_color'] ?? '';
                $padding = match($section['padding'] ?? 'lg') {
                    'sm' => 'py-8',
                    'md' => 'py-12',
                    'lg' => 'py-16',
                    'xl' => 'py-24',
                    default => 'py-16',
                };
                $layout = match($section['layout'] ?? 'contained') {
                    'full' => 'w-full',
                    'contained' => 'container mx-auto px-4',
                    'narrow' => 'container mx-auto px-4 max-w-3xl',
                    default => 'container mx-auto px-4',
                };
                $textAlign = match($section['text_align'] ?? 'center') {
                    'left' => 'text-left',
                    'center' => 'text-center',
                    'right' => 'text-right',
                    default => 'text-center',
                };
                $columns = match($section['columns'] ?? '3') {
                    '1' => 'grid-cols-1',
                    '2' => 'grid-cols-1 md:grid-cols-2',
                    '3' => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3',
                    '4' => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-4',
                    default => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3',
                };
                $bgImage = $section['background_image'] ?? null;
            @endphp

            <section class="relative {{ $padding }} overflow-hidden"
                     style="{{ $bgColor ? "background-color: {$bgColor};" : '' }} {{ $textColor ? "color: {$textColor};" : '' }}">
                
                {{-- Background Image --}}
                @if($bgImage)
                <div class="absolute inset-0 z-0">
                    <img src="{{ Storage::url($bgImage) }}" alt="" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/50"></div>
                </div>
                @endif

                <div class="relative z-10 {{ $layout }}">
                    {{-- Section Title --}}
                    @if($section['section_title'] ?? false)
                    <h2 class="text-3xl md:text-4xl font-bold mb-8 {{ $textAlign }}">
                        {{ $section['section_title'] }}
                    </h2>
                    @endif

                    {{-- Section Content Based on Type --}}
                    @switch($section['section_type'] ?? 'text')
                        {{-- Hero Banner --}}
                        @case('hero')
                            <div class="{{ $textAlign }}">
                                @if($section['section_content'] ?? false)
                                <div class="prose prose-lg max-w-none mx-auto {{ $textColor ? '' : 'prose-invert' }}">
                                    {!! $section['section_content'] !!}
                                </div>
                                @endif
                                @if($section['cta_button_text'] ?? false)
                                <div class="mt-8">
                                    <a href="{{ $section['cta_button_link'] ?? '#' }}" 
                                       class="inline-block bg-white text-gray-900 font-semibold px-8 py-4 rounded-lg hover:bg-gray-100 transition-colors shadow-lg cursor-pointer">
                                        {{ $section['cta_button_text'] }}
                                    </a>
                                </div>
                                @endif
                            </div>
                            @break

                        {{-- Text Content --}}
                        @case('text')
                            <div class="prose prose-lg max-w-none {{ $textAlign }} mx-auto">
                                {!! $section['section_content'] ?? '' !!}
                            </div>
                            @break

                        {{-- Gallery --}}
                        @case('gallery')
                            @if(isset($section['items']) && count($section['items']) > 0)
                            <div class="grid {{ $columns }} gap-6">
                                @foreach($section['items'] as $item)
                                <div class="group relative overflow-hidden rounded-xl shadow-lg aspect-video">
                                    @if($item['image'] ?? false)
                                    <img src="{{ Storage::url($item['image']) }}" 
                                         alt="{{ $item['title'] ?? '' }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @endif
                                    @if($item['title'] ?? false)
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end">
                                        <div class="p-4 text-white">
                                            <h3 class="font-bold text-lg">{{ $item['title'] }}</h3>
                                            @if($item['description'] ?? false)
                                            <p class="text-sm text-gray-200">{{ $item['description'] }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                    @if($item['link'] ?? false)
                                    <a href="{{ $item['link'] }}" class="absolute inset-0 cursor-pointer"></a>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            @endif
                            @break

                        {{-- Cards --}}
                        @case('cards')
                            @if(isset($section['items']) && count($section['items']) > 0)
                            <div class="grid {{ $columns }} gap-6">
                                @foreach($section['items'] as $item)
                                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow {{ $textAlign }}">
                                    @if($item['image'] ?? false)
                                    <img src="{{ Storage::url($item['image']) }}" 
                                         alt="{{ $item['title'] ?? '' }}"
                                         class="w-full h-48 object-cover rounded-lg mb-4">
                                    @endif
                                    @if($item['icon'] ?? false)
                                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="{{ $item['icon'] }} text-2xl text-blue-600"></i>
                                    </div>
                                    @endif
                                    @if($item['title'] ?? false)
                                    <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $item['title'] }}</h3>
                                    @endif
                                    @if($item['description'] ?? false)
                                    <p class="text-gray-600">{{ $item['description'] }}</p>
                                    @endif
                                    @if($item['link'] ?? false)
                                    <a href="{{ $item['link'] }}" class="inline-block mt-4 text-blue-600 hover:text-blue-800 font-medium cursor-pointer">
                                        Selengkapnya <i class="fa-solid fa-arrow-right ml-1"></i>
                                    </a>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            @endif
                            @break

                        {{-- Features --}}
                        @case('features')
                            @if($section['section_content'] ?? false)
                            <p class="text-lg text-gray-600 mb-10 max-w-2xl mx-auto {{ $textAlign }}">
                                {!! strip_tags($section['section_content']) !!}
                            </p>
                            @endif
                            @if(isset($section['items']) && count($section['items']) > 0)
                            <div class="grid {{ $columns }} gap-8">
                                @foreach($section['items'] as $item)
                                <div class="{{ $textAlign }}">
                                    @if($item['icon'] ?? false)
                                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center {{ $textAlign === 'text-center' ? 'mx-auto' : '' }} mb-4">
                                        <i class="{{ $item['icon'] }} text-2xl text-blue-600"></i>
                                    </div>
                                    @endif
                                    @if($item['title'] ?? false)
                                    <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $item['title'] }}</h3>
                                    @endif
                                    @if($item['description'] ?? false)
                                    <p class="text-gray-600">{{ $item['description'] }}</p>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            @endif
                            @break

                        {{-- CTA --}}
                        @case('cta')
                            <div class="{{ $textAlign }}">
                                @if($section['section_content'] ?? false)
                                <div class="prose prose-lg max-w-none mx-auto mb-8 {{ $bgImage || $bgColor ? 'prose-invert' : '' }}">
                                    {!! $section['section_content'] !!}
                                </div>
                                @endif
                                @if($section['cta_button_text'] ?? false)
                                <a href="{{ $section['cta_button_link'] ?? '#' }}" 
                                   class="inline-block bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold px-8 py-4 rounded-lg transition-all shadow-lg hover:shadow-xl cursor-pointer">
                                    {{ $section['cta_button_text'] }}
                                </a>
                                @endif
                            </div>
                            @break

                        {{-- Testimonials --}}
                        @case('testimonials')
                            @if(isset($section['items']) && count($section['items']) > 0)
                            <div class="grid {{ $columns }} gap-6">
                                @foreach($section['items'] as $item)
                                <div class="bg-white rounded-xl shadow-lg p-6">
                                    <div class="flex items-center mb-4">
                                        @if($item['image'] ?? false)
                                        <img src="{{ Storage::url($item['image']) }}" 
                                             alt="{{ $item['title'] ?? '' }}"
                                             class="w-12 h-12 rounded-full object-cover mr-4">
                                        @else
                                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mr-4">
                                            <i class="fa-solid fa-user text-gray-500"></i>
                                        </div>
                                        @endif
                                        <div>
                                            @if($item['title'] ?? false)
                                            <h4 class="font-semibold text-gray-800">{{ $item['title'] }}</h4>
                                            @endif
                                        </div>
                                    </div>
                                    @if($item['description'] ?? false)
                                    <p class="text-gray-600 italic">"{{ $item['description'] }}"</p>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            @endif
                            @break

                        {{-- Contact --}}
                        @case('contact')
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <div class="prose prose-lg max-w-none">
                                    {!! $section['section_content'] ?? '' !!}
                                </div>
                                @if(isset($section['items']) && count($section['items']) > 0)
                                <div class="space-y-4">
                                    @foreach($section['items'] as $item)
                                    <div class="flex items-start gap-4 p-4 bg-white rounded-lg shadow">
                                        @if($item['icon'] ?? false)
                                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                            <i class="{{ $item['icon'] }} text-xl text-blue-600"></i>
                                        </div>
                                        @endif
                                        <div>
                                            @if($item['title'] ?? false)
                                            <h4 class="font-semibold text-gray-800">{{ $item['title'] }}</h4>
                                            @endif
                                            @if($item['description'] ?? false)
                                            <p class="text-gray-600">{{ $item['description'] }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            @break

                        {{-- Map --}}
                        @case('map')
                            <div class="{{ $textAlign }}">
                                @if($section['section_content'] ?? false)
                                <div class="prose prose-lg max-w-none mx-auto mb-8">
                                    {!! $section['section_content'] !!}
                                </div>
                                @endif
                                @if($section['map_embed'] ?? false)
                                <div class="rounded-xl overflow-hidden shadow-lg aspect-video max-w-4xl mx-auto">
                                    <iframe src="{{ $section['map_embed'] }}" 
                                            width="100%" 
                                            height="100%" 
                                            style="border:0;" 
                                            allowfullscreen="" 
                                            loading="lazy" 
                                            referrerpolicy="no-referrer-when-downgrade">
                                    </iframe>
                                </div>
                                @endif
                            </div>
                            @break

                        {{-- Custom HTML --}}
                        @case('custom_html')
                            {!! $section['custom_html'] ?? '' !!}
                            @break

                        @default
                            <div class="prose prose-lg max-w-none">
                                {!! $section['section_content'] ?? '' !!}
                            </div>
                    @endswitch
                </div>
            </section>
        @endif
    @endforeach
@endif
