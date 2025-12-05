<?php

namespace App\Http\Controllers;

use App\Models\LaundryService;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminServiceController extends Controller
{
    /**
     * DASHBOARD ADMIN
     */
    public function dashboard()
    {
        $totalLayanan   = LaundryService::count();
        $totalPesanan   = Order::count();
        $totalPelanggan = User::where('role', 'customer')->count();

        $pelangganAktif = Order::distinct('users_id')->count('users_id');
        $totalPendapatan = Order::where('status_pesanan', 'selesai')->sum('total_harga');
        $pesananBaru = Order::where('status_pesanan', 'menunggu_penjemputan')->count();
        $pesananSelesai = Order::where('status_pesanan', 'selesai')->count();

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
     * AJAX: Ambil total pendapatan terbaru
     */
    public function getTotalPendapatan()
    {
        $totalPendapatan = Order::where('status_pesanan', 'selesai')->sum('total_harga');
        $pesananBaru = Order::where('status_pesanan', 'menunggu_penjemputan')->count();
        $pelangganAktif = Order::distinct('users_id')->count('users_id');
        $pesananTerbaru = Order::with('user')->orderBy('created_at', 'desc')->limit(5)->get();

        return response()->json([
            'totalPendapatan' => $totalPendapatan,
            'pesananBaru' => $pesananBaru,
            'pelangganAktif' => $pelangganAktif,
            'pesananTerbaru' => $pesananTerbaru,
        ]);
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

        $totalLayanan    = LaundryService::count();
        $layananAktif    = LaundryService::where('is_active', true)->count();
        $layananNonAktif = LaundryService::where('is_active', false)->count();

        return view('admin.layanan.index', compact(
            'totalLayanan',
            'layananAktif',
            'layananNonAktif',
            'services',
            'search'
        ));
    }

    /**
     * Form tambah layanan
     */
    public function create()
    {
        return view('admin.layanan.create');
    }

    /**
     * Simpan layanan baru
     */
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

    /**
     * Form edit layanan
     */
    public function edit($id)
    {
        $service = LaundryService::findOrFail($id);
        return view('admin.layanan.edit', compact('service'));
    }

    /**
     * Update layanan
     */
    public function update(Request $request, $id)
    {
        $service = LaundryService::findOrFail($id);

        $validated = $request->validate([
            'nama_layanan' => "required|string|max:150|unique:laundry_services,nama_layanan,{$id}",
            'harga'        => 'required|numeric|min:0',
            'deskripsi'    => 'nullable|string|max:500',
        ]);

        $service->update([
            'nama_layanan' => $validated['nama_layanan'],
            'harga'        => $validated['harga'],
            'deskripsi'    => $validated['deskripsi'],
            'is_active'    => $request->has('is_active') ? true : false,
        ]);

        return redirect()
            ->route('admin.layanan')
            ->with('success', 'Layanan berhasil diperbarui!');
    }

    /**
     * Hapus layanan
     */
    public function destroy($id)
    {
        $service = LaundryService::findOrFail($id);
        $service->delete();

        return redirect()
            ->route('admin.layanan')
            ->with('success', 'Layanan berhasil dihapus!');
    }

    /**
     * Halaman pelanggan
     */
    public function pelanggan()
    {
        $pelanggan = User::where('role', 'customer')->get();
        return view('admin.pelanggan', compact('pelanggan'));
    }

    /**
     * Simpan pelanggan baru
     */
    public function storePelanggan(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:150',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
        ]);

        // Password default: "password123"
        $password = Hash::make('password123');

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => $password,
            'phone'    => $validated['phone'] ?? null,
            'role'     => 'customer',
        ]);

        return redirect()->back()->with('success', 'Pelanggan berhasil ditambahkan! Password default: password123');
    }

    /**
     * Hapus pelanggan
     */
    public function destroyPelanggan($id)
    {
        $pelanggan = User::where('role', 'customer')->findOrFail($id);
        $pelanggan->delete();

        return redirect()->back()->with('success', 'Pelanggan berhasil dihapus!');
    }
}
