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
        $totalLayanan     = LaundryService::count();
        $totalPesanan     = Order::count();
        $totalPelanggan   = User::where('role', 'customer')->count();
        $pelangganAktif   = Order::distinct('users_id')->count('users_id');
        $totalPendapatan  = Order::where('status_pesanan', 'selesai')->sum('total_harga');
        $pesananBaru      = Order::where('status_pesanan', 'menunggu_penjemputan')->count();
        $pesananSelesai   = Order::where('status_pesanan', 'selesai')->count();

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
     * AJAX DASHBOARD UPDATE
     */
    public function getTotalPendapatan()
    {
        return response()->json([
            'totalPendapatan' => Order::where('status_pesanan', 'selesai')->sum('total_harga'),
            'pesananBaru'     => Order::where('status_pesanan', 'menunggu_penjemputan')->count(),
            'pelangganAktif'  => Order::distinct('users_id')->count('users_id'),
            'pesananTerbaru'  => Order::with('user')->orderBy('created_at', 'desc')->limit(5)->get(),
        ]);
    }

    /**
     * LIST LAYANAN
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $services = LaundryService::when($search, function ($query) use ($search) {
                $query->where('nama_layanan', 'like', "%{$search}%");
            })
            ->orderByDesc('created_at')
            ->paginate(8);

        return view('admin.layanan.index', [
            'services'        => $services,
            'search'          => $search,
            'totalLayanan'    => LaundryService::count(),
            'layananAktif'    => LaundryService::where('is_active', true)->count(),
            'layananNonAktif' => LaundryService::where('is_active', false)->count(),
        ]);
    }

    /**
     * TAMBAH LAYANAN
     */
    public function create()
    {
        return view('admin.layanan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_layanan' => 'required|string|max:150|unique:laundry_services,nama_layanan',
            'harga'        => 'required|integer|min:1',
            'deskripsi'    => 'nullable|string|max:500',
        ]);

        $validated['is_active'] = true;

        LaundryService::create($validated);

        return redirect()->route('admin.layanan')
            ->with('success', 'Layanan berhasil ditambahkan!');
    }

    /**
     * EDIT LAYANAN
     */
    public function edit($id)
    {
        $service = LaundryService::findOrFail($id);
        return view('admin.layanan.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $service = LaundryService::findOrFail($id);

        $validated = $request->validate([
            'nama_layanan' => "required|string|max:150|unique:laundry_services,nama_layanan,{$id}",
            'harga'        => 'required|integer|min:1',
            'deskripsi'    => 'nullable|string|max:500',
        ]);

        $service->update([
            'nama_layanan' => $validated['nama_layanan'],
            'harga'        => $validated['harga'],
            'deskripsi'    => $validated['deskripsi'],
            'is_active'    => $request->has('is_active'),
        ]);

        return redirect()->route('admin.layanan')
            ->with('success', 'Layanan berhasil diperbarui!');
    }

    /**
     * HAPUS LAYANAN
     */
    public function destroy($id)
    {
        $service = LaundryService::findOrFail($id);

        // Cegah menghapus layanan yang sudah dipakai order
        if ($service->orderDetails()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus layanan yang sudah digunakan dalam pesanan!');
        }

        $service->delete();

        return redirect()->route('admin.layanan')
            ->with('success', 'Layanan berhasil dihapus!');
    }

    /**
     * TOGGLE AKTIF / NONAKTIF LAYANAN
     */
    public function toggleActive($id)
    {
        $service = LaundryService::findOrFail($id);
        $service->update([
            'is_active' => !$service->is_active,
        ]);

        return back()->with('success', 'Status layanan diperbarui!');
    }

    /**
     * PELANGGAN
     */
    public function pelanggan()
    {
        $pelanggan = User::where('role', 'customer')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.pelanggan', compact('pelanggan'));
    }

    public function storePelanggan(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:150',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make('password123'),
            'phone'    => $validated['phone'],
            'role'     => 'customer',
        ]);

        return back()->with('success', 'Pelanggan berhasil ditambahkan! Password default: password123');
    }

    public function destroyPelanggan($id)
    {
        $pelanggan = User::where('role', 'customer')->findOrFail($id);
        $pelanggan->delete();

        return back()->with('success', 'Pelanggan berhasil dihapus!');
    }
}
