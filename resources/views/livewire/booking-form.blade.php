<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Flash Messages -->
        @if(session()->has('error'))
        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            <i class="fa-solid fa-exclamation-circle mr-2"></i>{{ session('error') }}
        </div>
        @endif

        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex items-center justify-center">
                @foreach([1 => 'Kontak', 2 => 'Penumpang', 3 => 'Konfirmasi'] as $step => $label)
                <div class="flex items-center">
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold
                                    {{ $currentStep >= $step ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-500' }}">
                            @if($currentStep > $step)
                            <i class="fa-solid fa-check"></i>
                            @else
                            {{ $step }}
                            @endif
                        </div>
                        <span class="mt-2 text-sm {{ $currentStep >= $step ? 'text-blue-600 font-semibold' : 'text-gray-400' }}">
                            {{ $label }}
                        </span>
                    </div>
                    @if($step < 3)
                    <div class="w-20 h-1 mx-2 {{ $currentStep > $step ? 'bg-blue-600' : 'bg-gray-200' }}"></div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <!-- Step 1: Contact Information -->
                    @if($currentStep === 1)
                    <h2 class="text-xl font-bold text-gray-800 mb-6">
                        <i class="fa-solid fa-user mr-2 text-blue-600"></i> Informasi Kontak
                    </h2>
                    <p class="text-gray-500 mb-6">Data kontak akan digunakan untuk konfirmasi dan pengiriman e-ticket.</p>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" wire:model="contactName"
                                   class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Sesuai KTP/Identitas">
                            @error('contactName') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                            <input type="email" wire:model="contactEmail"
                                   class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="email@example.com">
                            @error('contactEmail') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon</label>
                            <input type="tel" wire:model="contactPhone"
                                   class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="08xxxxxxxxxx">
                            @error('contactPhone') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button wire:click="nextStep"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors cursor-pointer">
                            Lanjut <i class="fa-solid fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                    @endif

                    <!-- Step 2: Passenger Information -->
                    @if($currentStep === 2)
                    <h2 class="text-xl font-bold text-gray-800 mb-6">
                        <i class="fa-solid fa-users mr-2 text-blue-600"></i> Data Penumpang
                    </h2>
                    <p class="text-gray-500 mb-6">Masukkan data sesuai identitas resmi (KTP/Passport).</p>

                    <div class="space-y-6">
                        @foreach($passengers as $index => $passenger)
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <h3 class="font-semibold text-gray-700 mb-4">
                                <i class="fa-solid fa-user-circle mr-2 text-blue-500"></i>
                                Penumpang {{ $index + 1 }}
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                    <input type="text" wire:model="passengers.{{ $index }}.name"
                                           class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                           placeholder="Sesuai identitas">
                                    @error("passengers.{$index}.name") <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
                                    <select wire:model="passengers.{{ $index }}.type"
                                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 cursor-pointer">
                                        <option value="adult">Dewasa</option>
                                        <option value="child">Anak (2-12 thn)</option>
                                        <option value="infant">Bayi (< 2 thn)</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                                    <select wire:model="passengers.{{ $index }}.gender"
                                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 cursor-pointer">
                                        <option value="">Pilih</option>
                                        <option value="male">Laki-laki</option>
                                        <option value="female">Perempuan</option>
                                    </select>
                                    @error("passengers.{$index}.gender") <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Identitas</label>
                                    <select wire:model="passengers.{{ $index }}.id_type"
                                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 cursor-pointer">
                                        <option value="ktp">KTP</option>
                                        <option value="passport">Passport</option>
                                        <option value="sim">SIM</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Identitas</label>
                                    <input type="text" wire:model="passengers.{{ $index }}.id_number"
                                           class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                           placeholder="Opsional">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-6 flex justify-between">
                        <button wire:click="previousStep"
                                class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-semibold transition-colors cursor-pointer">
                            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
                        </button>
                        <button wire:click="nextStep"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors cursor-pointer">
                            Lanjut <i class="fa-solid fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                    @endif

                    <!-- Step 3: Confirmation -->
                    @if($currentStep === 3)
                    <h2 class="text-xl font-bold text-gray-800 mb-6">
                        <i class="fa-solid fa-clipboard-check mr-2 text-blue-600"></i> Konfirmasi Pemesanan
                    </h2>

                    <!-- Contact Summary -->
                    <div class="bg-blue-50 rounded-lg p-4 mb-6">
                        <h3 class="font-semibold text-gray-700 mb-3">Informasi Kontak</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500">Nama:</span>
                                <div class="font-medium">{{ $contactName }}</div>
                            </div>
                            <div>
                                <span class="text-gray-500">Email:</span>
                                <div class="font-medium">{{ $contactEmail }}</div>
                            </div>
                            <div>
                                <span class="text-gray-500">Telepon:</span>
                                <div class="font-medium">{{ $contactPhone }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Passengers Summary -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <h3 class="font-semibold text-gray-700 mb-3">Daftar Penumpang</h3>
                        <div class="space-y-2">
                            @foreach($passengers as $index => $passenger)
                            <div class="flex items-center justify-between text-sm bg-white p-3 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <span class="w-6 h-6 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xs font-bold">
                                        {{ $index + 1 }}
                                    </span>
                                    <span class="font-medium">{{ $passenger['name'] }}</span>
                                </div>
                                <div class="flex items-center gap-4 text-gray-500">
                                    <span>{{ $passenger['type'] === 'adult' ? 'Dewasa' : ($passenger['type'] === 'child' ? 'Anak' : 'Bayi') }}</span>
                                    <span>{{ $passenger['gender'] === 'male' ? 'L' : 'P' }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Terms -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                        <div class="flex items-start gap-3">
                            <i class="fa-solid fa-info-circle text-yellow-600 mt-0.5"></i>
                            <div class="text-sm text-yellow-800">
                                <p class="font-semibold mb-1">Perhatian:</p>
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Pastikan data penumpang sudah benar sesuai identitas.</li>
                                    <li>E-Ticket akan dikirim ke email yang terdaftar.</li>
                                    <li>Harap hadir di pelabuhan 30 menit sebelum keberangkatan.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-between">
                        <button wire:click="previousStep"
                                class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-semibold transition-colors cursor-pointer">
                            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
                        </button>
                        <button x-data
                                @click="confirmAction('Apakah Anda yakin data yang dimasukkan sudah benar? Pastikan data penumpang sesuai dengan identitas yang akan digunakan saat boarding.', 'Konfirmasi Pemesanan').then(confirmed => { if(confirmed) $wire.submitBooking(); })"
                                wire:loading.attr="disabled"
                                wire:loading.class="opacity-75 cursor-wait"
                                class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-8 py-3 rounded-lg font-semibold transition-all shadow-lg cursor-pointer">
                            <span wire:loading.remove wire:target="submitBooking">
                                <i class="fa-solid fa-check-circle mr-2"></i> Konfirmasi & Pesan
                            </span>
                            <span wire:loading wire:target="submitBooking">
                                <i class="fa-solid fa-spinner fa-spin mr-2"></i> Memproses...
                            </span>
                        </button>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Order Summary Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-4">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fa-solid fa-receipt mr-2 text-blue-600"></i> Ringkasan Pesanan
                    </h3>

                    <!-- Outbound Trip -->
                    @if($schedule)
                    <div class="border-b border-gray-200 pb-4 mb-4">
                        <div class="flex items-center gap-2 text-blue-600 font-semibold mb-2">
                            <i class="fa-solid fa-plane-departure"></i>
                            <span>Keberangkatan</span>
                        </div>
                        <div class="text-sm space-y-1">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Tanggal</span>
                                <span class="font-medium">{{ \Carbon\Carbon::parse($travelDate)->translatedFormat('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Rute</span>
                                <span class="font-medium">{{ $schedule->route->origin->name }} → {{ $schedule->route->destination->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Waktu</span>
                                <span class="font-medium">{{ $schedule->departure_time_formatted }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Kapal</span>
                                <span class="font-medium">{{ $schedule->ship->name }}</span>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Return Trip -->
                    @if($returnSchedule)
                    <div class="border-b border-gray-200 pb-4 mb-4">
                        <div class="flex items-center gap-2 text-green-600 font-semibold mb-2">
                            <i class="fa-solid fa-plane-arrival"></i>
                            <span>Kepulangan</span>
                        </div>
                        <div class="text-sm space-y-1">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Tanggal</span>
                                <span class="font-medium">{{ \Carbon\Carbon::parse($returnDate)->translatedFormat('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Rute</span>
                                <span class="font-medium">{{ $returnSchedule->route->origin->name }} → {{ $returnSchedule->route->destination->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Waktu</span>
                                <span class="font-medium">{{ $returnSchedule->departure_time_formatted }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Kapal</span>
                                <span class="font-medium">{{ $returnSchedule->ship->name }}</span>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Price Breakdown -->
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Tiket Pergi ({{ $passengerCount }} pax)</span>
                            <span>Rp {{ number_format($schedule->price * $passengerCount, 0, ',', '.') }}</span>
                        </div>
                        @if($returnSchedule)
                        <div class="flex justify-between">
                            <span class="text-gray-500">Tiket Pulang ({{ $passengerCount }} pax)</span>
                            <span>Rp {{ number_format($returnSchedule->price * $passengerCount, 0, ',', '.') }}</span>
                        </div>
                        @endif
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-gray-800">Total</span>
                            <span class="text-2xl font-bold text-blue-600">
                                Rp {{ number_format($this->totalPrice, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
