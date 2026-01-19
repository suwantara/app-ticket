{{-- Alpine.js Alert/Confirmation Modal Component --}}
<div x-data="alertModal()" x-on:show-alert.window="showAlert($event.detail)"
    x-on:show-confirm.window="showConfirm($event.detail)">

    {{-- Alert Modal --}}
    <template x-teleport="body">
        <div x-show="isOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-99999 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
            style="display: none;">

            <div x-show="isOpen" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95" @click.away="close()"
                class="w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden">

                {{-- Icon Header --}}
                <div class="p-6 text-center"
                    :class="{
                        'bg-linear-to-br from-green-50 to-green-100': type === 'success',
                        'bg-linear-to-br from-red-50 to-red-100': type === 'error',
                        'bg-linear-to-br from-yellow-50 to-yellow-100': type === 'warning',
                        'bg-linear-to-br from-blue-50 to-blue-100': type === 'info' || type === 'confirm',
                    }">
                    <div class="mx-auto w-16 h-16 rounded-full flex items-center justify-center"
                        :class="{
                            'bg-green-100 text-green-600': type === 'success',
                            'bg-red-100 text-red-600': type === 'error',
                            'bg-yellow-100 text-yellow-600': type === 'warning',
                            'bg-blue-100 text-blue-600': type === 'info' || type === 'confirm',
                        }">
                        <template x-if="type === 'success'">
                            <i class="fa-solid fa-check text-3xl"></i>
                        </template>
                        <template x-if="type === 'error'">
                            <i class="fa-solid fa-xmark text-3xl"></i>
                        </template>
                        <template x-if="type === 'warning'">
                            <i class="fa-solid fa-exclamation text-3xl"></i>
                        </template>
                        <template x-if="type === 'info'">
                            <i class="fa-solid fa-info text-3xl"></i>
                        </template>
                        <template x-if="type === 'confirm'">
                            <i class="fa-solid fa-question text-3xl"></i>
                        </template>
                    </div>
                </div>

                {{-- Content --}}
                <div class="px-6 py-4 text-center">
                    <h3 class="text-xl font-bold text-gray-800 mb-2" x-text="title"></h3>
                    <p class="text-gray-600" x-html="message"></p>
                </div>

                {{-- Buttons --}}
                <div class="px-6 pb-6 flex gap-3 justify-center">
                    {{-- Cancel Button (for confirm) --}}
                    <template x-if="isConfirm">
                        <button @click="cancel()"
                            class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors cursor-pointer">
                            <span x-text="cancelText"></span>
                        </button>
                    </template>

                    {{-- OK/Confirm Button --}}
                    <button @click="confirm()"
                        class="px-6 py-2.5 font-medium rounded-lg transition-colors cursor-pointer"
                        :class="{
                            'bg-green-600 hover:bg-green-700 text-white': type === 'success',
                            'bg-red-600 hover:bg-red-700 text-white': type === 'error',
                            'bg-yellow-400 hover:bg-yellow-500 text-gray-700': type === 'warning',
                            'bg-blue-600 hover:bg-blue-700 text-white': type === 'info' || type === 'confirm',
                        }">
                        <span x-text="confirmText"></span>
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>

<script>
    function alertModal() {
        return {
            isOpen: false,
            isConfirm: false,
            type: 'info',
            title: '',
            message: '',
            confirmText: 'OK',
            cancelText: 'Batal',
            onConfirm: null,
            onCancel: null,

            showAlert(detail) {
                this.isConfirm = false;
                this.type = detail.type || 'info';
                this.title = detail.title || 'Notifikasi';
                this.message = detail.message || '';
                this.confirmText = detail.confirmText || 'OK';
                this.onConfirm = detail.onConfirm || null;
                this.isOpen = true;
            },

            showConfirm(detail) {
                this.isConfirm = true;
                this.type = 'confirm';
                this.title = detail.title || 'Konfirmasi';
                this.message = detail.message || 'Apakah Anda yakin?';
                this.confirmText = detail.confirmText || 'Ya, Lanjutkan';
                this.cancelText = detail.cancelText || 'Batal';
                this.onConfirm = detail.onConfirm || null;
                this.onCancel = detail.onCancel || null;
                this.isOpen = true;
            },

            confirm() {
                if (this.onConfirm && typeof this.onConfirm === 'function') {
                    this.onConfirm();
                }
                this.close();
            },

            cancel() {
                if (this.onCancel && typeof this.onCancel === 'function') {
                    this.onCancel();
                }
                this.close();
            },

            close() {
                this.isOpen = false;
                // Reset after animation
                setTimeout(() => {
                    this.onConfirm = null;
                    this.onCancel = null;
                }, 300);
            }
        }
    }

    // Global helper functions
    window.showAlert = function(options) {
        window.dispatchEvent(new CustomEvent('show-alert', {
            detail: options
        }));
    };

    window.showConfirm = function(options) {
        return new Promise((resolve) => {
            const detail = {
                ...options,
                onConfirm: () => resolve(true),
                onCancel: () => resolve(false),
            };
            window.dispatchEvent(new CustomEvent('show-confirm', {
                detail
            }));
        });
    };

    // Success alert shorthand
    window.alertSuccess = function(message, title = 'Berhasil!') {
        showAlert({
            type: 'success',
            title,
            message
        });
    };

    // Error alert shorthand
    window.alertError = function(message, title = 'Error!') {
        showAlert({
            type: 'error',
            title,
            message
        });
    };

    // Warning alert shorthand
    window.alertWarning = function(message, title = 'Perhatian!') {
        showAlert({
            type: 'warning',
            title,
            message
        });
    };

    // Info alert shorthand
    window.alertInfo = function(message, title = 'Informasi') {
        showAlert({
            type: 'info',
            title,
            message
        });
    };

    // Confirm shorthand
    window.confirmAction = async function(message, title = 'Konfirmasi') {
        return showConfirm({
            title,
            message
        });
    };
</script>
