<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin LaundryKu Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', Arial, sans-serif;
            background: #f6f8fc;
            margin: 0;
        }
        .sidebar {
            width: 220px;
            background: #1746a0;
            height: 100vh;
            float: left;
            border-right: 1px solid #eee;
            box-shadow: 2px 0 8px #0001;
        }
        .sidebar h2 {
            color: #36bffa;
            font-size: 22px;
            margin: 28px 22px 26px 22px;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar li {
            color: #fff;
            padding: 15px 26px;
            margin: 6px 0;
            cursor: pointer;
            border-radius: 9px;
            font-weight: 500;
            transition: 0.17s;
            display: flex;
            align-items: center;
        }
        .sidebar li.active,
        .sidebar li:hover {
            background: #eaf6ff;
            color: #1746a0;
        }
        .content {
            margin-left: 220px;
            padding: 40px 4vw 25px 4vw;
        }
        .dashboard-header {
            font-size: 25px;
            color: #1746a0;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: .5px;
        }
        .dashboard-welcome {
            color: #7987ae;
            margin-bottom: 30px;
            font-size: 16px;
        }
        .actions-bar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 14px;
            margin-bottom: 8px;
        }
        .btn-export, .btn-date {
            font-family: inherit;
            font-weight: 600;
            border-radius: 9px;
            border: none;
            outline: none;
            font-size: 15px;
            padding: 13px 23px;
            cursor: pointer;
            box-shadow: 0 2px 8px #1746a013;
            background: #2196f3;
            color: #fff;
            transition: background 0.15s, box-shadow 0.15s;
        }
        .btn-export {
            background: #2196f3;
        }
        .btn-export:hover {
            background: #1565c0;
        }
        .btn-date {
            background: #fff;
            color: #1746a0;
            border: 1.5px solid #eaf6ff;
            display: flex;
            align-items: center;
            gap: 7px;
        }
        .btn-date:hover {
            background: #e3f1ff;
        }
        .stat-card {
            background: linear-gradient(135deg,#eaf6ff 60%, #d2eafd 100%);
            color: #1746a0;
            box-shadow: 0 8px 28px #1746a015;
            border: 1.5px solid #d2eafd;
            padding: 32px 34px;
            border-radius: 18px;
            min-width: 220px;
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition:transform .15s;
        }
        .stat-title {
            font-size: 15px;
            color: #7987ae;
            margin-bottom: 10px;
        }
        .stat-value {
            font-size: 32px;
            font-weight: bold;
            color: #1746a0;
        }
        .stats {
            display: flex;
            gap: 32px;
            margin-bottom: 34px;
        }
        .orders {
            background: #fff;
            border-radius: 18px;
            padding: 30px;
            margin-bottom: 17px;
            box-shadow: 0 4px 24px #1746a012;
            border: 1.5px solid #eaf6ff;
        }
        .orders-title {
            font-size: 18px;
            font-weight: 700;
            color: #1746a0;
            margin-bottom: 18px;
            letter-spacing: .2px;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 12px;
            background: transparent;
        }
        th, td {
            padding: 14px 8px;
            text-align: left;
            font-size: 16px;
        }
        th {
            color: #1746a0;
            background: #f3f7fa;
            border-bottom: 2px solid #eaf6ff;
            font-weight: 600;
        }
        tr {
            transition: background .22s;
            height: 54px;
        }
        tr:hover {
            background: #f6faff;
        }
        td.status {
        text-align: left !important;
        padding-left: 14px;
        vertical-align: middle;
    }
    .status-badge {
        display: inline-block;
        text-align: left;
        margin-left: 0;
        min-width: 110px;
        min-height: 38px;
        padding: 10px 30px;
        border-radius: 11px;
        font-weight: bold;
        font-size: 16px;
        box-shadow: 0 2px 10px #36bffa22;
        color: #fff;
    }
        .diproses.status-badge {
            background: #36bffa;
        }
        .selesai.status-badge {
            background: #46c47c;
        }
        @media (max-width:990px){
            .stats{flex-direction:column;}
            .content{padding:22px;}
        }
    </style>
</head>
<body>
    @include('includes.sidebar')
    <div class="content">
        <div class="dashboard-header">Dashboard</div>
        <div class="dashboard-welcome">Selamat datang kembali, Admin!</div>
        
        <div class="actions-bar">
            <button class="btn-export">
                &#128190; Export Data
            </button>
            <button class="btn-date">
                <svg width="18" height="18" fill="none" stroke="#2196f3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:middle;"><rect x="3" y="5" width="12" height="10" rx="2"/><path d="M8 3v2M12 3v2"/><path d="M3 9h12"/></svg>
                Pilih Tanggal
            </button>
        </div>
        
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
                    <td class="status"><span class="status-badge diproses">Diproses</span></td>
                    <td>Rp 75.000</td>
                </tr>
                <tr>
                    <td>#12344</td>
                    <td>Siti Nurhaliza</td>
                    <td>Setrika Premium</td>
                    <td class="status"><span class="status-badge diproses">Diproses</span></td>
                    <td>Rp 45.000</td>
                </tr>
                <tr>
                    <td>#12343</td>
                    <td>Budi Santoso</td>
                    <td>Cuci Lipat Regular</td>
                    <td class="status"><span class="status-badge selesai">Selesai</span></td>
                    <td>Rp 65.000</td>
                </tr>
                <tr>
                    <td>#12342</td>
                    <td>Maya Sari</td>
                    <td>Dry Clean Jas</td>
                    <td class="status"><span class="status-badge selesai">Selesai</span></td>
                    <td>Rp 120.000</td>
                </tr>
                <tr>
                    <td>#12341</td>
                    <td>Andi Wijaya</td>
                    <td>Cuci Sepatu</td>
                    <td class="status"><span class="status-badge diproses">Diproses</span></td>
                    <td>Rp 35.000</td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
