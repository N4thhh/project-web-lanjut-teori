<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pesanan - Admin LaundryKu</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family:'Montserrat',Arial,sans-serif; background:#f6f8fc; margin:0; }
        .sidebar { width:220px; background:#1746a0; height:100vh; position:fixed; top:0; left:0; color:#fff; padding-top:24px; }
        .sidebar .logo { font-size:20px; font-weight:700; padding:0 24px 16px; }
        .sidebar ul { list-style:none; padding:0; margin:0; }
        .sidebar li { padding:12px 24px; cursor:pointer; opacity:.9; }
        .sidebar li.active,
        .sidebar li:hover { background:#eaf6ff; color:#1746a0; opacity:1; }
        .content { margin-left:220px; padding:32px 32px 24px; }
        h1 { color:#1746a0; margin:0 0 16px; font-size:24px; }
        table { width:100%; border-collapse:collapse; background:#fff; border-radius:14px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,.04); }
        thead { background:#f1f5f9; font-size:12px; text-transform:uppercase; color:#6b7280; }
        th, td { padding:10px 14px; font-size:13px; border-bottom:1px solid #e5e7eb; text-align:left; }
        tr:hover td { background:#f9fafb; }
        .badge { padding:4px 10px; border-radius:999px; font-size:10px; font-weight:600; display:inline-block; }
        .b-pending { background:#fef3c7; color:#92400e; }
        .b-proses { background:#dbeafe; color:#1d4ed8; }
        .b-selesai { background:#bbf7d0; color:#166534; }
        .b-diambil { background:#e9d5ff; color:#6b21a8; }
        .b-dibatalkan { background:#fee2e2; color:#b91c1c; }
        .status-pay-ok { color:#16a34a; font-weight:600; font-size:11px; }
        .status-pay-pending { color:#ea580c; font-weight:500; font-size:11px; }
        a.detail-link { font-size:11px; color:#2563eb; text-decoration:none; font-weight:500; }
        a.detail-link:hover { text-decoration:underline; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="logo">LaundryKu Admin</div>
    <ul>
        <li onclick="window.location='{{ route('admin.dashboard') }}'">Dashboard</li>
        <li class="active">Pesanan</li>
        {{-- menu lain jika perlu --}}
    </ul>
</div>

<div class="content">
    <h1>Data Pesanan</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Pelanggan</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Total</th>
                <th>Pembayaran</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name ?? '-' }}</td>
                    <td>{{ $order->created_at ? $order->created_at->format('d M Y H:i') : '-' }}</td>
                    <td>
                        @php $s = $order->status; @endphp
                        <span class="badge
                            {{ $s === 'pending' ? 'b-pending' : '' }}
                            {{ $s === 'proses' ? 'b-proses' : '' }}
                            {{ $s === 'selesai' ? 'b-selesai' : '' }}
                            {{ $s === 'diambil' ? 'b-diambil' : '' }}
                            {{ $s === 'dibatalkan' ? 'b-dibatalkan' : '' }}">
                            {{ ucfirst($s ?? 'unknown') }}
                        </span>
                    </td>
                    <td>Rp {{ number_format($order->total_harga ?? 0, 0, ',', '.') }}</td>
                    <td>
                        @if($order->payment)
                            <span class="status-pay-ok">{{ ucfirst($order->payment->status) }}</span>
                        @else
                            <span class="status-pay-pending">Belum dibayar</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="detail-link">Detail</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Belum ada pesanan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

</body>
</html>
