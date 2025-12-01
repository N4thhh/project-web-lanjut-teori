<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pesanan - Admin LaundryKu</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family:'Montserrat',Arial,sans-serif; background:#f6f8fc; margin:0; }
        .content { max-width:900px; margin:40px auto; background:#fff; padding:24px 28px; border-radius:16px; box-shadow:0 4px 12px rgba(0,0,0,.06);}
        h1 { margin:0 0 10px; color:#1746a0; font-size:22px; }
        .meta { font-size:12px; color:#6b7280; margin-bottom:14px; }
        table { width:100%; border-collapse:collapse; margin-top:16px; font-size:12px; }
        th, td { padding:8px 6px; border-bottom:1px solid #e5e7eb; text-align:left; }
        .label { font-weight:600; color:#4b5563; width:140px; }
        .status-select { padding:6px 8px; border-radius:8px; border:1px solid #d1d5db; font-size:11px;}
        .btn { padding:6px 14px; border-radius:999px; border:none; font-size:11px; background:#1746a0; color:#fff; cursor:pointer; }
    </style>
</head>
<body>

<div class="content">
        {{-- TOMBOL KEMBALI --}}
    <a href="{{ route('admin.orders.index') }}"
       style="display:inline-flex; align-items:center; gap:6px; 
              font-size:12px; color:#2563eb; text-decoration:none; 
              margin-bottom:10px;">
        &#8592; {{-- panah kiri --}}
        <span>Kembali ke Data Pesanan</span>
    </a>

    <h1>Detail Pesanan</h1>
    <div class="meta">
        ID: {{ $order->id }} •
        Tanggal: {{ $order->created_at ? $order->created_at->format('d M Y H:i') : '-' }} •
        Pelanggan: {{ $order->user->name ?? '-' }}
    </div>

    <table>
        <tr>
            <td class="label">Alamat</td>
            <td>{{ $order->alamat }}</td>
        </tr>
        <tr>
            <td class="label">Status Pesanan</td>
            <td>{{ ucfirst($order->status) }}</td>
        </tr>
        <tr>
            <td class="label">Pembayaran</td>
            <td>
                @if($order->payment)
                    {{ ucfirst($order->payment->metode_pembayaran) }} -
                    {{ ucfirst($order->payment->status) }} -
                    Rp {{ number_format($order->payment->jumlah_bayar, 0, ',', '.') }}
                @else
                    Belum ada data pembayaran
                @endif
            </td>
        </tr>
        <tr>
            <td class="label">Total Harga</td>
            <td>Rp {{ number_format($order->total_harga ?? 0, 0, ',', '.') }}</td>
        </tr>
    </table>

    <h3 style="margin-top:18px; font-size:13px; color:#111827;">Item Pesanan</h3>
    <table>
        <thead>
            <tr>
                <th>Layanan</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($order->orderDetails as $detail)
                <tr>
                    <td>{{ $detail->laundryService->nama_layanan ?? '-' }}</td>
                    <td>{{ $detail->jumlah }}</td>
                    <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="3">Tidak ada item.</td></tr>
            @endforelse
        </tbody>
    </table>

    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" style="margin-top:18px; display:flex; gap:8px; align-items:center;">
        @csrf
        @method('PATCH')
        <span style="font-size:11px; color:#6b7280;">Ubah Status:</span>
        <select name="status" class="status-select">
            <option value="pending" {{ $order->status=='pending'?'selected':'' }}>Pending</option>
            <option value="proses" {{ $order->status=='proses'?'selected':'' }}>Proses</option>
            <option value="selesai" {{ $order->status=='selesai'?'selected':'' }}>Selesai</option>
            <option value="diambil" {{ $order->status=='diambil'?'selected':'' }}>Diambil</option>
            <option value="dibatalkan" {{ $order->status=='dibatalkan'?'selected':'' }}>Dibatalkan</option>
        </select>
            <input type="text" name="catatan"
           placeholder="Catatan (opsional, misal: kurir sudah jemput, 3 kg)"
           style="flex:1; min-width:220px; padding:6px 8px; border-radius:8px; border:1px solid #d1d5db; font-size:11px;">

        <button type="submit" class="btn">Simpan</button>
    </form>
    <h3 style="margin-top:24px; font-size:13px; color:#111827;">Riwayat Status Pesanan</h3>

<table style="margin-top:8px;">
    <thead>
        <tr>
            <th style="width: 160px;">Waktu</th>
            <th>Status Lama</th>
            <th>Status Baru</th>
            <th>Catatan</th>
        </tr>
    </thead>
    <tbody>
        @forelse($order->histories as $history)
            <tr>
                <td>{{ $history->created_at->format('d M Y H:i') }}</td>
                <td>{{ $history->status_lama ?? '-' }}</td>
                <td>{{ $history->status_baru }}</td>
                <td>{{ $history->catatan ?? '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4">Belum ada riwayat status.</td>
            </tr>
        @endforelse
    </tbody>
</table>

</div>

</body>
</html>
