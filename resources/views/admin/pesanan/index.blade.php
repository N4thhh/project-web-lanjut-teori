<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pesanan - Admin LaundryKu</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', Arial, sans-serif;
            background: #f6f8fc;
            margin: 0;
        }
        .content {
            margin-left: 220px; /* mengikuti sidebar yang sama dengan dashboard */
            padding: 40px 4vw 25px 4vw;
        }
        .page-title {
            font-size: 25px;
            color: #1746a0;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: .5px;
        }
        .table-wrap {
            margin-top: 24px;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 4px 18px rgba(23,70,160,0.06);
            padding: 18px 20px 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        th, td {
            padding: 10px 8px;
            text-align: left;
        }
        th {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: #9ca3af;
            border-bottom: 1px solid #e5e7eb;
        }
        tr + tr {
            border-bottom: 1px solid #f3f4f6;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
        }
        .s-pending { background:#fef3c7; color:#92400e; }
        .s-proses { background:#dbeafe; color:#1d4ed8; }
        .s-selesai { background:#bbf7d0; color:#166534; }
        .s-diambil { background:#ede9fe; color:#5b21b6; }
        .s-dibatalkan { background:#fee2e2; color:#b91c1c; }
        .pay-ok { color:#16a34a; font-size:11px; font-weight:600; }
        .pay-pending { color:#f97316; font-size:11px; font-weight:500; }
        .empty {
            padding: 12px 0;
            color: #9ca3af;
            font-size: 13px;
        }
    </style>
</head>
<body>

@include('includes.sidebar')

<div class="content">
    <div class="page-title">Data Pesanan</div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pelanggan</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Pembayaran</th>
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
                            <span class="status-badge
                                {{ $s === 'pending' ? 's-pending' : '' }}
                                {{ $s === 'proses' ? 's-proses' : '' }}
                                {{ $s === 'selesai' ? 's-selesai' : '' }}
                                {{ $s === 'diambil' ? 's-diambil' : '' }}
                                {{ $s === 'dibatalkan' ? 's-dibatalkan' : '' }}">
                                {{ ucfirst($s ?? '-') }}
                            </span>
                        </td>
                        <td>Rp {{ number_format($order->total_harga ?? 0, 0, ',', '.') }}</td>
                        <td>
                            @if($order->payment)
                                <span class="pay-ok">{{ ucfirst($order->payment->status) }}</span>
                            @else
                                <span class="pay-pending">Belum dibayar</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty">Belum ada pesanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
