<div class="flex justify-center">
    @if($getRecord()->qr_code_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($getRecord()->qr_code_path))
        @if(str_ends_with($getRecord()->qr_code_path, '.svg'))
            <div class="w-48 h-48 p-4 bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 [&>svg]:w-full [&>svg]:h-full">
                {!! \Illuminate\Support\Facades\Storage::disk('public')->get($getRecord()->qr_code_path) !!}
            </div>
        @else
            <img
                src="{{ asset('storage/' . $getRecord()->qr_code_path) }}"
                alt="QR Code"
                class="w-48 h-48 p-4 bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 object-contain"
            >
        @endif
    @else
        <div class="w-48 h-48 p-4 bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 [&>svg]:w-full [&>svg]:h-full">
            {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(160)->margin(0)->generate(json_encode(['ticket_number' => $getRecord()->ticket_number, 'qr_code' => $getRecord()->qr_code])) !!}
        </div>
    @endif
</div>
<p class="text-center text-sm text-gray-500 dark:text-gray-400 mt-2 font-mono">{{ $getRecord()->qr_code }}</p>
