<x-layouts.app :title="$page->meta_title ?? 'Pesan Tiket'" :description="$page->meta_description ?? null">
    {{-- Hero Section --}}
    <x-header-section title="Pesan Tiket Fast Boat"
        subtitle="Temukan jadwal terbaik dan pesan tiket perjalanan Anda dengan mudah" />

    {{-- Booking Search Form Section --}}
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            {{-- Search Form --}}
            <livewire:search-booking-form />

            {{-- Search Results (separate component) --}}
            <livewire:search-results />
        </div>
    </section>

    {{-- Information Section --}}
    <x-ticket-step-section />

    {{-- FAQ Section --}}
    <x-faq-section />
</x-layouts.app>
