<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Pelanggan | Admin LaundryKu</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Montserrat', Arial, sans-serif; background: #f6f8fc; margin: 0; }
        .sidebar { width: 220px; background: #1746a0; height: 100vh; float: left; border-right: 1px solid #eee; box-shadow: 2px 0 8px #0001; }
        .content { margin-left: 220px; padding: 40px 4vw 25px 4vw; }
        .dashboard-header { font-size: 25px; color: #1746a0; font-weight: 700; }
        .dashboard-welcome { color: #7987ae; margin-bottom: 25px; font-size: 16px; }
        .main-card-wrap { display: flex; gap: 18px; margin-bottom: 28px; }
        .stat-card-single { background: linear-gradient(135deg,#eaf6ff 70%, #d2eafd 100%); color: #1746a0; box-shadow: 0 8px 24px #1746a015; border: 1.5px solid #d2eafd; padding: 26px 30px; border-radius: 15px; min-width: 190px; min-height: 62px; display: flex; align-items: center; gap: 15px; }
        .stat-card-single-icon { font-size: 28px; background: #2196f3; color: #fff; padding: 11px 13px; border-radius: 10px; }
        .stat-title { font-size: 14px; color: #6c7689; }
        .stat-value { font-size: 25px; font-weight: 700; color: #1746a0; }
        .customers-toolbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; flex-wrap: wrap; gap: 10px; }
        .customers-search { background: #fff; border: 1.5px solid #eaf6ff; border-radius: 9px; padding: 12px 16px; font-size: 15px; min-width: 260px; width: 340px; transition: border-color .18s; }
        .customers-search:focus { outline: none; border-color: #2196f3;}
        .btn-add-customer { background: #2196f3; color: #fff; border: none; border-radius: 10px; font-size: 15px; padding: 12px 22px; font-weight: 600; display: flex; align-items: center; gap: 9px; cursor: pointer; box-shadow: 0 2px 10px #1746a013; transition: background 0.16s; }
        .btn-add-customer:hover { background: #166bc2; }
        .customers-list { background: #fff; border-radius: 16px; border: 1.5px solid #eaf6ff; padding: 26px 22px 16px 22px; box-shadow: 0 4px 22px #1746a012;}
        .customers-list-title { font-size: 18px; font-weight: 700; color: #1746a0; margin-bottom: 18px; }
        table { width: 100%; border-collapse: separate; border-spacing: 0 8px; background: transparent; }
        th, td { padding: 10px 12px; text-align: left; font-size: 15.5px; }
        th { color: #1746a0; background: #f7fafc; font-weight: 600; }
        tr { background: #fff; }
        td.customer-info { display: flex; align-items: center; gap: 13px; }
        .avatar { width: 34px; height: 34px; border-radius: 50%; object-fit: cover; }
        td.actions { text-align: center; }
        .btn-delete { background: #ff445c; border: none; border-radius: 50%; width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: background .17s; }
        .btn-delete:hover { background: #d92b47; }
        .btn-delete svg { width: 20px; height: 20px; stroke: #fff; }
        @media (max-width:900px){ .content{padding:18px;} .main-card-wrap{flex-direction:column;} .customers-search{width:100%;} }

        /* Modal */
        .modal { display: none; position: fixed; z-index: 10; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4); }
        .modal-content { background-color: #fff; margin: 8% auto; padding: 30px 35px; border: 1px solid #ccc; width: 100%; max-width: 480px; border-radius: 15px; box-shadow: 0 4px 20px #0002; }
        .close { color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer; }
        .close:hover { color: #1746a0; }
        .modal h2 { text-align: center; color: #1746a0; margin-bottom: 25px; }
        .form-group { margin-bottom: 16px; }
        label { display: block; margin-bottom: 6px; font-weight: 600; color: #333; font-size: 14px; }
        input { width: 100%; padding: 10px 12px; border: 1.5px solid #dce7f3; border-radius: 8px; font-size: 14px; transition: border-color .2s; }
        input:focus { border-color: #2196f3; outline: none; }
        .btn-submit { width: 100%; background: #2196f3; color: white; border: none; padding: 12px; border-radius: 10px; font-weight: 600; font-size: 15px; cursor: pointer; transition: background 0.2s; }
        .btn-submit:hover { background: #166bc2; }
    </style>
</head>
<body>
    @include('includes.sidebar')
    <div class="content">
        <div class="dashboard-header">Manajemen Pelanggan</div>
        <div class="dashboard-welcome">Kelola data pelanggan dan riwayat pesanan</div>

        <div class="main-card-wrap">
            <div class="stat-card-single">
                <span class="stat-card-single-icon"><i class="fa fa-users"></i></span>
                <div>
                    <div class="stat-title">Total Pelanggan</div>
                    <div class="stat-value">1,234</div>
                </div>
            </div>
        </div>

        <div class="customers-toolbar">
            <input type="text" class="customers-search" id="searchInput" placeholder="Cari pelanggan..." onkeyup="filterCustomerTable()">
            <button class="btn-add-customer" id="btnAddCustomer">
                <i class="fa fa-user-plus"></i> Tambah Pelanggan
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
                        <button class="btn-delete" onclick="deleteCustomer('Ahmad Rizki', this)" title="Hapus">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- MODAL TAMBAH PELANGGAN -->
    <div id="addCustomerModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <h2>Tambah Pelanggan</h2>
            <form id="customerForm">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" id="custName" placeholder="Masukkan nama lengkap" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" id="custEmail" placeholder="Masukkan email pelanggan" required>
                </div>
                <div class="form-group">
                    <label>No. Telepon</label>
                    <input type="text" id="custPhone" placeholder="Contoh: +62 812 3456 7890" required>
                </div>
                <div class="form-group">
                    <label>Tanggal Bergabung</label>
                    <input type="date" id="custJoinDate" required>
                </div>
                <button type="submit" class="btn-submit">Simpan Data</button>
            </form>
        </div>
    </div>

    <script>
        // Search filter
        function filterCustomerTable() {
            const filter = document.getElementById("searchInput").value.toLowerCase();
            const trs = document.querySelectorAll("#customersTable tr");
            trs.forEach((tr, i) => {
                if (i === 0) return; // skip header
                tr.style.display = tr.innerText.toLowerCase().includes(filter) ? "" : "none";
            });
        }

        // Modal handling
        const modal = document.getElementById("addCustomerModal");
        const btn = document.getElementById("btnAddCustomer");
        const span = document.getElementById("closeModal");

        btn.onclick = () => { modal.style.display = "block"; }
        span.onclick = () => { modal.style.display = "none"; }
        window.onclick = (e) => { if (e.target === modal) modal.style.display = "none"; }

        // Delete customer
        function deleteCustomer(name, btn) {
            if (confirm("Yakin hapus data pelanggan " + name + "?")) {
                const row = btn.closest("tr");
                row.remove();
                alert("Pelanggan " + name + " berhasil dihapus.");
            }
        }

        // Form submit handler
        document.getElementById("customerForm").addEventListener("submit", function(e) {
            e.preventDefault();
            const name = document.getElementById("custName").value;
            const email = document.getElementById("custEmail").value;
            const phone = document.getElementById("custPhone").value;
            const date = document.getElementById("custJoinDate").value;

            const table = document.getElementById("customersTable");
            const row = table.insertRow(-1);
            row.innerHTML = `
                <td class="customer-info">
                    <img class="avatar" src="https://randomuser.me/api/portraits/lego/1.jpg">
                    ${name} <br><span style="color:#888; font-size:13px;">ID: CUST${Math.floor(Math.random()*9999).toString().padStart(3,'0')}</span>
                </td>
                <td>${email}<br><span style="color:#888; font-size:13px;">${phone}</span></td>
                <td>${date}</td>
                <td>0</td>
                <td class="actions">
                    <button class="btn-delete" onclick="deleteCustomer('${name}', this)" title="Hapus">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>`;
            
            modal.style.display = "none";
            this.reset();
            alert("Data pelanggan baru berhasil ditambahkan!");
        });
    </script>
</body>
</html>
