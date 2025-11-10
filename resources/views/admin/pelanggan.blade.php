<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Pelanggan | Admin LaundryKu</title>
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
        .content {
            margin-left: 220px;
            padding: 40px 4vw 25px 4vw;
        }
        .dashboard-header {
            font-size: 25px;
            color: #1746a0;
            font-weight: 700;
        }
        .dashboard-welcome {
            color: #7987ae;
            margin-bottom: 25px;
            font-size: 16px;
        }
        .main-card-wrap {
            display: flex;
            gap: 18px;
            margin-bottom: 28px;
        }
        .stat-card-single {
            background: linear-gradient(135deg,#eaf6ff 70%, #d2eafd 100%);
            color: #1746a0;
            box-shadow: 0 8px 24px #1746a015;
            border: 1.5px solid #d2eafd;
            padding: 26px 30px;
            border-radius: 15px;
            min-width: 190px;
            min-height: 62px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .stat-card-single-icon {
            font-size: 28px;
            background: #2196f3;
            color: #fff;
            padding: 11px 13px;
            border-radius: 10px;
        }
        .stat-title {
            font-size: 14px;
            color: #6c7689;
        }
        .stat-value {
            font-size: 25px;
            font-weight: 700;
            color: #1746a0;
        }
        .customers-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
            flex-wrap: wrap;
            gap: 10px;
        }
        .customers-search {
            background: #fff;
            border: 1.5px solid #eaf6ff;
            border-radius: 9px;
            padding: 12px 16px;
            font-size: 15px;
            min-width: 260px;
            width: 340px;
            transition: border-color .18s;
        }
        .customers-search:focus {
            outline: none;
            border-color: #2196f3;
        }
        .btn-add-customer {
            background: #2196f3;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            padding: 12px 22px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 9px;
            cursor: pointer;
            box-shadow: 0 2px 10px #1746a013;
            transition: background 0.16s;
        }
        .btn-add-customer:hover {
            background: #166bc2;
        }
        .customers-list {
            background: #fff;
            border-radius: 16px;
            border: 1.5px solid #eaf6ff;
            padding: 26px 22px 16px 22px;
            box-shadow: 0 4px 22px #1746a012;
        }
        .customers-list-title {
            font-size: 18px;
            font-weight: 700;
            color: #1746a0;
            margin-bottom: 18px;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
            background: transparent;
        }
        th, td {
            padding: 10px 12px;
            text-align: left;
            font-size: 15.5px;
        }
        th {
            color: #1746a0;
            background: #f7fafc;
            font-weight: 600;
        }
        tr {
            background: #fff;
        }
        td.customer-info {
            display: flex;
            align-items: center;
            gap: 13px;
        }
        .avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            object-fit: cover;
        }
        td.actions {
            text-align: center;
        }
        .btn-delete {
            background: #ff445c;
            border: none;
            border-radius: 50%;
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background .17s;
        }
        .btn-delete:hover {
            background: #d92b47;
        }
        .btn-delete svg {
            width: 20px;
            height: 20px;
            stroke: #fff;
        }
        @media (max-width:900px){
            .content{padding:18px;}
            .main-card-wrap{flex-direction:column;}
            .customers-search{width:100%;}
        }
    </style>
    <script>
        // Live search filter
        function filterCustomerTable() {
            var input = document.getElementById("searchInput");
            var filter = input.value.toLowerCase();
            var table = document.getElementById("customersTable");
            var trs = table.getElementsByTagName("tr");
            for (let i = 1; i < trs.length; i++) {
                let tdText = trs[i].innerText.toLowerCase();
                if (tdText.indexOf(filter) > -1) {
                    trs[i].style.display = "";
                } else {
                    trs[i].style.display = "none";
                }
            }
        }
        // Dummy action
        function deleteCustomer(name) {
            if (confirm("Yakin hapus data pelanggan " + name + "?")) {
                alert("Pelanggan " + name + " berhasil dihapus (mock only)");
            }
        }
        function addCustomer() {
            alert('Fitur Tambah Pelanggan (mock demo)');
        }
    </script>
</head>
<body>
    @include('includes.sidebar')
    <div class="content">
        <div class="dashboard-header">Manajemen Pelanggan</div>
        <div class="dashboard-welcome">Kelola data pelanggan dan riwayat pesanan</div>

        <div class="main-card-wrap">
            <div class="stat-card-single">
                <span class="stat-card-single-icon">&#128100;</span>
                <div>
                    <div class="stat-title">Total Pelanggan</div>
                    <div class="stat-value">1,234</div>
                </div>
            </div>
        </div>

        <div class="customers-toolbar">
            <input type="text" class="customers-search" id="searchInput" placeholder="Cari pelanggan... (nama, email, telepon)" onkeyup="filterCustomerTable()">
            <button class="btn-add-customer" onclick="addCustomer()">
                <svg width="18" height="18" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:middle;"><circle cx="9" cy="9" r="8"/><path d="M9 5v8M5 9h8"/></svg>
                Tambah Pelanggan
            </button>
        </div>

        <div class="customers-list">
            <div class="customers-list-title">Daftar Pelanggan</div>
            <table id="customersTable">
                <tr>
                    <th>Pelanggan</th>
                    <th>Kontak</th>
                    <th>Tanggal Bergabung</th>
                    <th>Total Pesanan</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
                <tr>
                    <td class="customer-info">
                        <img class="avatar" src="https://randomuser.me/api/portraits/men/11.jpg">
                        Ahmad Rizki <br><span style="color:#888; font-size:13px;">ID: CUST001</span>
                    </td>
                    <td>ahmad.rizki@email.com<br><span style="color:#888; font-size:13px;">+62 812 3456 7890</span></td>
                    <td>10 Des 2023</td>
                    <td>12</td>
                    <td class="actions">
                        <button class="btn-delete" onclick="deleteCustomer('Ahmad Rizki')" title="Hapus"><svg fill="none" stroke="#fff" viewBox="0 0 24 24"><rect x="5" y="8" width="14" height="10" rx="2"/><path d="M10 11v4M14 11v4"/><path d="M8 8V5a1 1 0 011-1h6a1 1 0 011 1v3"/></svg></button>
                    </td>
                </tr>
                <tr>
                    <td class="customer-info">
                        <img class="avatar" src="https://randomuser.me/api/portraits/women/15.jpg">
                        Siti Nurhaliza <br><span style="color:#888; font-size:13px;">ID: CUST002</span>
                    </td>
                    <td>siti.nurhaliza@email.com<br><span style="color:#888; font-size:13px;">+62 813 4567 8901</span></td>
                    <td>15 Des 2023</td>
                    <td>8</td>
                    <td class="actions">
                        <button class="btn-delete" onclick="deleteCustomer('Siti Nurhaliza')" title="Hapus"><svg fill="none" stroke="#fff" viewBox="0 0 24 24"><rect x="5" y="8" width="14" height="10" rx="2"/><path d="M10 11v4M14 11v4"/><path d="M8 8V5a1 1 0 011-1h6a1 1 0 011 1v3"/></svg></button>
                    </td>
                </tr>
                <tr>
                    <td class="customer-info">
                        <img class="avatar" src="https://randomuser.me/api/portraits/men/4.jpg">
                        Budi Santoso <br><span style="color:#888; font-size:13px;">ID: CUST003</span>
                    </td>
                    <td>budi.santoso@email.com<br><span style="color:#888; font-size:13px;">+62 814 5678 9012</span></td>
                    <td>20 Des 2023</td>
                    <td>15</td>
                    <td class="actions">
                        <button class="btn-delete" onclick="deleteCustomer('Budi Santoso')" title="Hapus"><svg fill="none" stroke="#fff" viewBox="0 0 24 24"><rect x="5" y="8" width="14" height="10" rx="2"/><path d="M10 11v4M14 11v4"/><path d="M8 8V5a1 1 0 011-1h6a1 1 0 011 1v3"/></svg></button>
                    </td>
                </tr>
                <tr>
                    <td class="customer-info">
                        <img class="avatar" src="https://randomuser.me/api/portraits/women/20.jpg">
                        Maya Sari <br><span style="color:#888; font-size:13px;">ID: CUST004</span>
                    </td>
                    <td>maya.sari@email.com<br><span style="color:#888; font-size:13px;">+62 815 6789 0123</span></td>
                    <td>25 Des 2023</td>
                    <td>6</td>
                    <td class="actions">
                        <button class="btn-delete" onclick="deleteCustomer('Maya Sari')" title="Hapus"><svg fill="none" stroke="#fff" viewBox="0 0 24 24"><rect x="5" y="8" width="14" height="10" rx="2"/><path d="M10 11v4M14 11v4"/><path d="M8 8V5a1 1 0 011-1h6a1 1 0 011 1v3"/></svg></button>
                    </td>
                </tr>
                <tr>
                    <td class="customer-info">
                        <img class="avatar" src="https://randomuser.me/api/portraits/men/55.jpg">
                        Andi Wijaya <br><span style="color:#888; font-size:13px;">ID: CUST005</span>
                    </td>
                    <td>andi.wijaya@email.com<br><span style="color:#888; font-size:13px;">+62 816 7890 1234</span></td>
                    <td>02 Jan 2024</td>
                    <td>4</td>
                    <td class="actions">
                        <button class="btn-delete" onclick="deleteCustomer('Andi Wijaya')" title="Hapus"><svg fill="none" stroke="#fff" viewBox="0 0 24 24"><rect x="5" y="8" width="14" height="10" rx="2"/><path d="M10 11v4M14 11v4"/><path d="M8 8V5a1 1 0 011-1h6a1 1 0 011 1v3"/></svg></button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
