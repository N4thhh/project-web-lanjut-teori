<?php

namespace App\Http\Controllers;

use App\Models\LaundryService;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class AdminServiceController extends Controller
{
    /**
     * DASHBOARD ADMIN
     */
    public function dashboard()
    {
        // Statistik utama
        $totalLayanan     = LaundryService::count();
        $totalPesanan     = Order::count();
        $totalPelanggan   = User::where('role', 'customer')->count();

        // Pelanggan aktif = customer yang pernah melakukan pesanan
        $pelangganAktif = Order::distinct('users_id')->count('users_id');

        // Total pendapatan hanya pesanan selesai
        $totalPendapatan = Order::where('status_pesanan', 'selesai')
            ->sum('total_harga');

        // Pesanan baru (menunggu penjemputan)
        $pesananBaru = Order::where('status_pesanan', 'menunggu_penjemputan')->count();

        // Pesanan selesai
        $pesananSelesai = Order::where('status_pesanan', 'selesai')->count();

        // Pesanan terbaru (ambil 5 terakhir, hanya relasi user)
        $pesananTerbaru = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalLayanan',
            'totalPesanan',
            'totalPelanggan',
            'pelangganAktif',
            'totalPendapatan',
            'pesananBaru',
            'pesananSelesai',
            'pesananTerbaru'
        ));
    }

    /**
     * Halaman layanan (index)
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $services = LaundryService::when($search, function ($query) use ($search) {
                $query->where('nama_layanan', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(8);

        $totalLayanan     = LaundryService::count();
        $layananAktif     = LaundryService::where('is_active', true)->count();
        $layananNonAktif  = LaundryService::where('is_active', false)->count();

        return view('admin.layanan.index', compact(
            'totalLayanan',
            'layananAktif',
            'layananNonAktif',
            'services',
            'search'
        ));
    }

    /** Form tambah layanan */
    public function create()
    {
        return view('admin.layanan.create');
    }

    /** Simpan layanan baru */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_layanan' => 'required|string|max:150|unique:laundry_services,nama_layanan',
            'harga'        => 'required|numeric|min:0',
            'deskripsi'    => 'nullable|string|max:500',
        ]);

        $validated['is_active'] = true;

        LaundryService::create($validated);

        return redirect()
            ->route('admin.layanan')
            ->with('success', 'Layanan berhasil ditambahkan!');
    }

    /** Form edit layanan */
    public function edit($id)
    {
        $service = LaundryService::findOrFail($id);
        return view('admin.layanan.edit', compact('service'));
    }

    /** Update layanan */
    public function update(Request $request, $id)
    {
        $service = LaundryService::findOrFail($id);

        $request->validate([
            'nama_layanan' => "required|string|max:150|unique:laundry_services,nama_layanan,{$id}",
            'harga'        => 'required|numeric|min:0',
            'deskripsi'    => 'nullable|string|max:500',
        ]);

        $service->update([
            'nama_layanan' => $request->nama_layanan,
            'harga'        => $request->harga,
            'deskripsi'    => $request->deskripsi,
            'is_active'    => $request->has('is_active') ? true : false,
        ]);

        return redirect()
            ->route('admin.layanan')
            ->with('success', 'Layanan berhasil diperbarui!');
    }

    /** Hapus layanan */
    public function destroy($id)
    {
        $service = LaundryService::findOrFail($id);
        $service->delete();

        return redirect()
            ->route('admin.layanan')
            ->with('success', 'Layanan berhasil dihapus!');
    }
}
