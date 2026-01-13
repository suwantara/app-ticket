<x-layouts.app :title="$page->meta_title ?? 'Home'">
    {{-- Hero Section with Booking Search --}}
    <x-hero-section />

    <x-feature-section />


    <div class="bg-blue-900">
        {{-- Destination Section --}}
        <livewire:destination-section />
    </div>

    <x-ticket-step-section />

    {{-- Jadwal & Rute Populer Hari Ini --}}
    <livewire:schedule-section />

    {{-- CTA Section --}}
    <x-cta-section />


</x-layouts.app>
