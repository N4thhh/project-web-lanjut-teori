<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelanggan - LaundryKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <div class="flex h-screen overflow-hidden">

        {{-- Sidebar --}}
        @include('includes.sidebar')

        {{-- CONTENT --}}
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
            
            {{-- HEADER --}}
            <header class="bg-white border-b border-gray-200 sticky top-0 z-30">
                <div class="flex items-center justify-between px-6 py-3">
                    <h1 class="text-xl font-semibold text-gray-800">Data Pelanggan</h1>

                    <div class="flex items-center space-x-3">
                        <img src="https://ui-avatars.com/api/?name=Admin&background=0D8ABC&color=fff" 
                             class="w-8 h-8 rounded-full">
                        <span class="text-sm font-medium text-gray-700">Admin</span>
                    </div>
                </div>
            </header>

            {{-- MAIN CONTENT --}}
            <main class="w-full flex-grow p-6">

                {{-- Search + Add --}}
                <div class="mb-4 flex justify-between items-center">
                    <input id="searchInput" onkeyup="filterCustomerTable()"
                        type="text" 
                        placeholder="Cari pelanggan..."
                        class="w-72 px-4 py-2 rounded-lg border bg-white shadow-sm focus:outline-none" />

                    <button id="btnAddCustomer"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
                        + Tambah Pelanggan
                    </button>
                </div>

                {{-- TABLE --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <table class="w-full text-sm text-left" id="customersTable">
                        <thead class="bg-gray-50 text-gray-700 uppercase">
                            <tr>
                                <th class="px-6 py-3">Nama</th>
                                <th class="px-6 py-3">Email</th>
                                <th class="px-6 py-3">Telepon</th>
                                <th class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b">
                                <td class="px-6 py-3">Budi Santoso</td>
                                <td class="px-6 py-3">budi@example.com</td>
                                <td class="px-6 py-3">08123456789</td>
                                <td class="px-6 py-3">
                                    <button onclick="deleteCustomer('Budi', this)"
                                        class="text-red-600 hover:underline">Hapus</button>
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="px-6 py-3">Siti Aminah</td>
                                <td class="px-6 py-3">siti@example.com</td>
                                <td class="px-6 py-3">085212345678</td>
                                <td class="px-6 py-3">
                                    <button onclick="deleteCustomer('Siti', this)"
                                        class="text-red-600 hover:underline">Hapus</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </main>
        </div>
    </div>

    {{-- MODAL TAMBAH PELANGGAN --}}
    <div id="modalAdd" class="fixed inset-0 bg-black bg-opacity-40 hidden flex items-center justify-center">
        <div class="bg-white w-96 p-6 rounded-lg shadow-lg">
            <h2 class="text-lg font-semibold mb-4">Tambah Pelanggan</h2>

            <div class="space-y-3">
                <input id="inputName" type="text" placeholder="Nama"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none">

                <input id="inputEmail" type="email" placeholder="Email"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none">

                <input id="inputPhone" type="text" placeholder="Telepon"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none">
            </div>

            <div class="flex justify-end space-x-2 mt-5">
                <button onclick="closeModal()"
                    class="px-4 py-2 bg-gray-200 rounded-lg">Batal</button>

                <button onclick="saveCustomer()"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg">Simpan</button>
            </div>
        </div>
    </div>

    {{-- JAVASCRIPT --}}
    <script>
        const modal = document.getElementById("modalAdd");

        document.getElementById("btnAddCustomer").onclick = () => {
            modal.classList.remove("hidden");
        };

        function closeModal() {
            modal.classList.add("hidden");
        }

        function filterCustomerTable() {
            const filter = document.getElementById("searchInput").value.toLowerCase();
            const trs = document.querySelectorAll("#customersTable tbody tr");
            trs.forEach(tr => {
                tr.style.display = tr.innerText.toLowerCase().includes(filter) ? "" : "none";
            });
        }

        function deleteCustomer(name, btn) {
            if (confirm("Yakin hapus pelanggan " + name + "?")) {
                btn.closest("tr").remove();
            }
        }

        // SIMPAN DATA PELANGGAN BARU
        function saveCustomer() {
            const name = document.getElementById("inputName").value.trim();
            const email = document.getElementById("inputEmail").value.trim();
            const phone = document.getElementById("inputPhone").value.trim();

            if (!name || !email || !phone) {
                alert("Semua field wajib diisi!");
                return;
            }

            const tbody = document.querySelector("#customersTable tbody");

            const tr = document.createElement("tr");
            tr.classList.add("border-b");

            tr.innerHTML = `
                <td class="px-6 py-3">${name}</td>
                <td class="px-6 py-3">${email}</td>
                <td class="px-6 py-3">${phone}</td>
                <td class="px-6 py-3">
                    <button onclick="deleteCustomer('${name}', this)" 
                        class="text-red-600 hover:underline">Hapus</button>
                </td>
            `;

            tbody.appendChild(tr);

            closeModal();

            // clear form
            document.getElementById("inputName").value = "";
            document.getElementById("inputEmail").value = "";
            document.getElementById("inputPhone").value = "";
        }
    </script>

</body>
</html>
