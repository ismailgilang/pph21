<?php

namespace App\Http\Controllers;

use App\Models\penggajian;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::all();
        return view('menu.users.index', compact('data'));
    }

    public function dashboard()
    {
        $tahun = now()->year;

        // Data karyawan aktif (yang sebelumnya)
        $aktif = DB::table('penggajians')
            ->select(DB::raw('MONTH(created_at) as bulan'), DB::raw('COUNT(DISTINCT karyawan_id) as jumlah'))
            ->whereYear('created_at', $tahun)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();

        // Data pajak per bulan (jumlahkan pph21)
        $pajak = DB::table('penggajians')
            ->select(DB::raw('MONTH(created_at) as bulan'), DB::raw('SUM(pph21) as total_pajak'))
            ->whereYear('created_at', $tahun)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();

        // Format bulan: Jan, Feb, ...
        $labels = [];
        $jumlahAktif = [];
        $jumlahPajak = [];

        foreach (range(1, 12) as $i) {
            $labels[] = Carbon::create()->month($i)->format('M');
            $matchAktif = $aktif->firstWhere('bulan', $i);
            $matchPajak = $pajak->firstWhere('bulan', $i);

            $jumlahAktif[] = $matchAktif ? $matchAktif->jumlah : 0;
            $jumlahPajak[] = $matchPajak ? (float)$matchPajak->total_pajak : 0;
        }

        return view('dashboard', compact('labels', 'jumlahAktif', 'jumlahPajak'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required',
        ]);

        // Hash password setelah validasi
        $validated['password'] = Hash::make($validated['password']);

        // Hanya data tervalidasi yang digunakan
        User::create($validated);

        return redirect()->back()->with('success', 'User created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('menu.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string',
            'role' => 'required' // Pastikan hanya role yang valid
        ]);

        $user = User::findOrFail($id);

        // Handle password update secara aman
        $updateData = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'role' => $validatedData['role']
        ];

        if (!empty($validatedData['password'])) {
            $updateData['password'] = Hash::make($validatedData['password']);
        }

        $user->update($updateData);

        return redirect()->route('Users.index')->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('Users.index')->with('success', 'Data berhasil dihapus!');
    }
}
