<!DOCTYPE html>
<html lang="id">
<head>
    <title>Upload Pembayaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen p-6">
    <div class="max-w-md mx-auto bg-white rounded-xl shadow-md p-6">
        <h1 class="text-xl font-bold mb-4">Pembayaran Pesanan</h1>
        
        <div class="mb-4 bg-blue-50 p-4 rounded text-sm text-blue-700">
            Total Tagihan: <span class="font-bold">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
        </div>

        <form action="{{ route('customer.payment.process', $order->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Metode Pembayaran</label>
                <select name="metode_pembayaran" class="w-full border rounded p-2">
                    <option value="transfer_bca">Transfer BCA</option>
                    <option value="transfer_bri">Transfer BRI</option>
                    <option value="ewallet_dana">DANA</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium mb-1">Bukti Transfer</label>
                <input type="file" name="bukti_pembayaran" class="w-full border rounded p-2" required>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
                Kirim Bukti Pembayaran
            </button>
            
            <a href="{{ route('customer.riwayat-pesanan') }}" class="block text-center mt-3 text-sm text-gray-500">Batal</a>
        </form>
    </div>
</body>
</html>