<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Pesanan - LaundryKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#4FC3F7',
                        'primary-hover': '#25B6F5',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .payment-option {
            transition: all 0.2s ease;
        }
        .payment-option:hover {
            border-color: #4FC3F7;
        }
        .payment-option.active {
            border-color: #4FC3F7;
            background-color: #f0f9ff;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

    @include('includes.header')

    <main class="flex-grow py-6 px-4">
        <div class="max-w-7xl mx-auto">
            
            {{-- Header --}}
            <div class="mb-6">
                <a href="{{ route('customer.riwayat-pesanan') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-primary mb-3 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Riwayat Pesanan
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Pembayaran Pesanan</h1>
                <p class="text-sm text-gray-600 mt-1">ID Pesanan: <span class="font-mono text-primary">#{{ Str::limit($order->id, 8, '...') }}</span></p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                {{-- Form Pembayaran --}}
                <div class="lg:col-span-2 space-y-6">
                    
                    {{-- Pilih Metode --}}
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            Pilih Metode Pembayaran
                        </h2>

                        <form action="{{ route('customer.payment.process', $order->id) }}" method="POST" enctype="multipart/form-data" id="paymentForm">
                            @csrf
                            
                            <div class="space-y-3 mb-6">
                                {{-- QRIS --}}
                                <label class="payment-option block cursor-pointer border-2 border-gray-200 rounded-lg p-4" data-method="qris">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <input type="radio" name="metode_pembayaran" value="qris" class="w-4 h-4 text-primary" required>
                                            <div>
                                                <div class="font-semibold text-gray-800 flex items-center text-sm">
                                                    <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                                    </svg>
                                                    QRIS
                                                </div>
                                                <p class="text-xs text-gray-500">Scan QR Code untuk bayar</p>
                                            </div>
                                        </div>
                                        <div class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full font-semibold">Instan</div>
                                    </div>
                                </label>

                                {{-- Transfer Bank --}}
                                <label class="payment-option block cursor-pointer border-2 border-gray-200 rounded-lg p-4" data-method="transfer">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <input type="radio" name="metode_pembayaran" value="transfer_bank" class="w-4 h-4 text-primary" required>
                                            <div>
                                                <div class="font-semibold text-gray-800 flex items-center text-sm">
                                                    <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                                                    </svg>
                                                    Transfer Bank
                                                </div>
                                                <p class="text-xs text-gray-500">Transfer ke rekening LaundryKu</p>
                                            </div>
                                        </div>
                                        <div class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full font-semibold">Manual</div>
                                    </div>
                                </label>
                            </div>

                            {{-- Info Pembayaran QRIS --}}
                            <div id="qrisInfo" class="hidden bg-gradient-to-br from-blue-50 to-cyan-50 rounded-lg p-5 border border-blue-200 mb-6">
                                <h3 class="font-semibold text-gray-800 mb-3 flex items-center text-sm">
                                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Cara Bayar dengan QRIS
                                </h3>
                                
                                <div class="flex flex-col md:flex-row gap-4 items-center">
                                    {{-- QR Code --}}
                                    <div class="bg-white p-3 rounded-lg shadow-sm">
                                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=00020101021126660014ID.CO.QRIS.WWW0118ID1234567890123450215ID20230123456780303UME51440014ID.CO.TELKOM.WWW0215ID12345678901230303UME5204549953033605802ID5913LaundryKu6007Jakarta61051234062190515RP{{ str_replace('.', '', number_format($order->total_harga, 0, '', '')) }}070103116304ABCD" 
                                             alt="QRIS Code" 
                                             class="w-40 h-40 mx-auto">
                                        <p class="text-center text-xs text-gray-600 mt-2 font-mono">Scan dengan e-wallet Anda</p>
                                    </div>

                                    {{-- Instruksi --}}
                                    <div class="flex-1">
                                        <ol class="space-y-2 text-xs">
                                            <li class="flex items-start">
                                                <span class="flex-shrink-0 w-5 h-5 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs font-bold mr-2">1</span>
                                                <span class="text-gray-700">Buka aplikasi e-wallet (GoPay, OVO, Dana, dll)</span>
                                            </li>
                                            <li class="flex items-start">
                                                <span class="flex-shrink-0 w-5 h-5 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs font-bold mr-2">2</span>
                                                <span class="text-gray-700">Pilih menu <strong>Scan QR</strong></span>
                                            </li>
                                            <li class="flex items-start">
                                                <span class="flex-shrink-0 w-5 h-5 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs font-bold mr-2">3</span>
                                                <span class="text-gray-700">Scan QR Code di samping</span>
                                            </li>
                                            <li class="flex items-start">
                                                <span class="flex-shrink-0 w-5 h-5 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs font-bold mr-2">4</span>
                                                <span class="text-gray-700">Konfirmasi pembayaran</span>
                                            </li>
                                            <li class="flex items-start">
                                                <span class="flex-shrink-0 w-5 h-5 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs font-bold mr-2">5</span>
                                                <span class="text-gray-700">Screenshot bukti dan upload di bawah</span>
                                            </li>
                                        </ol>
                                    </div>
                                </div>
                            </div>

                            {{-- Info Pembayaran Transfer Bank --}}
                            <div id="transferInfo" class="hidden bg-gradient-to-br from-purple-50 to-pink-50 rounded-lg p-5 border border-purple-200 mb-6">
                                <h3 class="font-semibold text-gray-800 mb-3 flex items-center text-sm">
                                    <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Detail Rekening LaundryKu
                                </h3>

                                <div class="space-y-3">
                                    {{-- BCA --}}
                                    <div class="bg-white rounded-lg p-4 shadow-sm border border-blue-100">
                                        <div class="flex items-center space-x-2 mb-2">
                                            <div class="bg-blue-600 text-white font-bold px-2 py-1 rounded text-xs">BCA</div>
                                            <span class="text-xs text-gray-600">Bank Central Asia</span>
                                        </div>
                                        <div class="space-y-1">
                                            <div>
                                                <p class="text-xs text-gray-500">Nomor Rekening</p>
                                                <p class="font-mono text-lg font-bold text-gray-800">1234567890</p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500">Atas Nama</p>
                                                <p class="font-semibold text-sm text-gray-800">PT LaundryKu Indonesia</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3 bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                                    <p class="text-xs text-yellow-800 flex items-start">
                                        <svg class="w-4 h-4 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                        <span><strong>Penting:</strong> Transfer sesuai jumlah yang tertera. Setelah transfer, upload bukti pembayaran di bawah.</span>
                                    </p>
                                </div>
                            </div>

                            {{-- Upload Bukti --}}
                            <div class="bg-white rounded-lg p-5 border-2 border-dashed border-gray-300">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Bukti Pembayaran *</label>
                                <input type="file" 
                                       name="bukti_pembayaran" 
                                       id="buktiPembayaran"
                                       accept="image/*"
                                       required
                                       class="block w-full text-sm text-gray-500
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-lg file:border-0
                                              file:text-sm file:font-semibold
                                              file:bg-primary file:text-white
                                              hover:file:bg-primary-hover
                                              file:cursor-pointer cursor-pointer">
                                <p class="mt-2 text-xs text-gray-500">Format: JPG, PNG (Max. 2MB)</p>
                                
                                {{-- Preview --}}
                                <div id="imagePreview" class="mt-3 hidden">
                                    <img id="previewImg" src="" alt="Preview" class="max-w-xs rounded-lg border-2 border-gray-200">
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <button type="submit" 
                                    class="w-full mt-5 bg-primary hover:bg-primary-hover text-white font-semibold py-3 rounded-lg transition shadow-md hover:shadow-lg flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Konfirmasi Pembayaran
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Ringkasan Pesanan --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100 sticky top-6">
                        <h3 class="text-base font-semibold text-gray-800 mb-3 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Ringkasan Pesanan
                        </h3>

                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Status Pesanan</span>
                                <span class="font-semibold text-blue-600">{{ ucfirst(str_replace('_', ' ', $order->status_pesanan)) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Tanggal Order</span>
                                <span class="font-medium text-gray-800">{{ $order->created_at->format('d M Y') }}</span>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-3 mb-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 font-medium text-sm">Total Tagihan</span>
                                <div class="text-right">
                                    <p class="text-xl font-bold text-primary">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                                    <p class="text-xs text-gray-500">Sudah termasuk biaya admin</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-blue-50 rounded-lg p-3 border border-blue-200">
                            <p class="text-xs text-blue-800 flex items-start">
                                <svg class="w-4 h-4 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Pembayaran akan diverifikasi dalam <strong>1x24 jam</strong> setelah bukti diterima.</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    @include('includes.footer')

    <script>
        // Handle payment method selection
        document.querySelectorAll('.payment-option').forEach(option => {
            option.addEventListener('click', function() {
                // Remove active class from all
                document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('active'));
                
                // Add active to clicked
                this.classList.add('active');
                
                // Check the radio inside
                const radio = this.querySelector('input[type="radio"]');
                radio.checked = true;
                
                // Show/hide info
                const method = this.dataset.method;
                document.getElementById('qrisInfo').classList.add('hidden');
                document.getElementById('transferInfo').classList.add('hidden');
                
                if (method === 'qris') {
                    document.getElementById('qrisInfo').classList.remove('hidden');
                } else if (method === 'transfer') {
                    document.getElementById('transferInfo').classList.remove('hidden');
                }
            });
        });

        // Image preview
        document.getElementById('buktiPembayaran').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('imagePreview').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });

        // Copy to clipboard
        function copyText(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Nomor rekening berhasil disalin!');
            });
        }

        // Form validation
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            const metodePembayaran = document.querySelector('input[name="metode_pembayaran"]:checked');
            const buktiBayar = document.getElementById('buktiPembayaran').files[0];
            
            if (!metodePembayaran) {
                e.preventDefault();
                alert('Pilih metode pembayaran terlebih dahulu!');
                return;
            }
            
            if (!buktiBayar) {
                e.preventDefault();
                alert('Upload bukti pembayaran terlebih dahulu!');
                return;
            }
            
            return confirm('Yakin data pembayaran sudah benar?');
        });
    </script>

</body>
</html>