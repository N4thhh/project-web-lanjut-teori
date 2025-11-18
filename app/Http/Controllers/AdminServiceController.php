<?php

namespace App\Http\Controllers;

use App\Models\LaundryService;
use Illuminate\Http\Request;

class AdminServiceController extends Controller
{
    public function index()
    {
        $totalLayanan = LaundryService::count();
        $layananAktif = LaundryService::where('is_active', true)->count();
        $layananNonAktif = LaundryService::where('is_active', false)->count();
        
        // Ambil data layanan untuk ditampilkan di tabel (jika nanti ada tabel)
        $services = LaundryService::all(); 

        return view('admin.layanan.index', compact('totalLayanan', 'layananAktif', 'layananNonAktif', 'services'));
    }

    /**
     * Menampilkan form tambah layanan.
     */
    public function create()
    {
        return view('admin.layanan.create');
    }

    /**
     * Menyimpan layanan baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_layanan' => 'required|string|max:150',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        $validated['is_active'] = true; 

        LaundryService::create($validated);

        return redirect()->route('admin.layanan')->with('success', 'Layanan berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit layanan.
     */
    public function edit($id)
    {
        $service = LaundryService::findOrFail($id);
        return view('admin.layanan.edit', compact('service'));
    }

    /**
     * Menyimpan perubahan layanan ke database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:150',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        $service = LaundryService::findOrFail($id);

        $service->update([
            'nama_layanan' => $request->nama_layanan,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.layanan')->with('success', 'Layanan berhasil diperbarui!');
    }

    /**
     * Menghapus layanan dari database.
     */
    public function destroy($id)
    {
        $service = LaundryService::findOrFail($id);
        
        // Hapus data
        $service->delete();

        return redirect()->route('admin.layanan')->with('success', 'Layanan berhasil dihapus!');
    }
}