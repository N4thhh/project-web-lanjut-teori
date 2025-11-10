<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin LaundryKu Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Montserrat', Arial, sans-serif; background: #f5f7fb; margin: 0; }
        .sidebar { width: 220px; background: #fff; height: 100vh; float: left; border-right: 1px solid #eaeaea; }
        .sidebar h2 { color: #176bb4; font-size: 20px; margin: 20px; }
        .sidebar ul { list-style: none; padding: 0; }
        .sidebar li { padding: 12px 24px; color: #222; cursor: pointer; }
        .sidebar li.active, .sidebar li:hover { background: #eaf5ff; color: #176bb4; font-weight: bold; }
        .content { margin-left: 220px; padding: 30px; }
        .dashboard-header { font-size: 22px; color: #222; margin-bottom: 10px; }
        .dashboard-welcome { color: #888; margin-bottom: 22px; }
        .stats { display: flex; gap: 22px; margin-bottom: 28px; }
        .stat-card { background: #fff; padding: 22px; border-radius: 12px; min-width: 220px; box-shadow: 0 2px 8px #0001; flex: 1; }
        .stat-title { font-size: 15px; color: #888; margin-bottom: 6px; }
        .stat-value { font-size: 28px; font-weight: bold; color: #176bb4; }
        .orders { background: #fff; border-radius: 12px; padding: 24px; margin-bottom: 30px; box-shadow: 0 2px 8px #0001; }
        .orders-title { font-weight: bold; font-size: 16px; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 0; }
        th, td { padding: 10px 8px; text-align: left; font-size: 15px; }
        th { color: #176bb4; border-bottom: 2px solid #eaeaea; }
        td.status { font-weight: bold; border-radius: 6px; padding: 6px 10px; color: #fff; }
        .diproses { background: #56b4ef; }
        .selesai { background: #46c47c; }
    </style>
</head>
<body>
    @include('includes.sidebar')

    <div class="content">
        <div class="dashboard-header">Dashboard</div>
        <div class="dashboard-welcome">Selamat datang kembali, Admin!</div>
        <div class="stats">
            <div class="stat-card">
                <div class="stat-title">Total Pesanan Hari Ini</div>
                <div class="stat-value">24</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Pelanggan Aktif</div>
                <div class="stat-value">156</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Pesanan Selesai</div>
                <div class="stat-value">18</div>
            </div>
        </div>
        <div class="orders">
            <div class="orders-title">Pesanan Terbaru</div>
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Pelanggan</th>
                    <th>Layanan</th>
                    <th>Status</th>
                    <th>Total</th>
                </tr>
                <tr>
                    <td>#12345</td>
                    <td>Ahmad Rizki</td>
                    <td>Cuci Kering Express</td>
                    <td class="status diproses">Diproses</td>
                    <td>Rp 75.000</td>
                </tr>
                <tr>
                    <td>#12344</td>
                    <td>Siti Nurhaliza</td>
                    <td>Setrika Premium</td>
                    <td class="status diproses">Diproses</td>
                    <td>Rp 45.000</td>
                </tr>
                <tr>
                    <td>#12343</td>
                    <td>Budi Santoso</td>
                    <td>Cuci Lipat Regular</td>
                    <td class="status selesai">Selesai</td>
                    <td>Rp 65.000</td>
                </tr>
                <tr>
                    <td>#12342</td>
                    <td>Maya Sari</td>
                    <td>Dry Clean Jas</td>
                    <td class="status selesai">Selesai</td>
                    <td>Rp 120.000</td>
                </tr>
                <tr>
                    <td>#12341</td>
                    <td>Andi Wijaya</td>
                    <td>Cuci Sepatu</td>
                    <td class="status diproses">Diproses</td>
                    <td>Rp 35.000</td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
