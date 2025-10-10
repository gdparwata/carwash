<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\User;
use App\Models\Libur;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    // Main index untuk menampilkan halaman pegawai (diakses via admin/pegawais)
    public function index()
    {
        $pegawais = Pegawai::all();
        $admins = User::where('role', 'admin')->get();
        $liburs = Libur::with(['pegawai', 'user'])->get(); // Update dengan relationship
        
        return view('admin.pegawai.index', compact('pegawais', 'admins', 'liburs'));
    }

    // CRUD untuk Pegawai
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pegawais,email',
            'nomor_telepon' => 'required|string|max:255',
        ]);

        $pegawai = Pegawai::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'nomor_telepon' => $request->nomor_telepon,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pegawai berhasil ditambahkan',
            'data' => $pegawai
        ]);
    }

    public function edit($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        return response()->json(['success' => true, 'data' => $pegawai]);
    }

    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pegawais,email,' . $id . ',id_Pegawai',
            'nomor_telepon' => 'required|string|max:255',
        ]);

        $pegawai->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'nomor_telepon' => $request->nomor_telepon,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pegawai berhasil diupdate',
            'data' => $pegawai
        ]);
    }

    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pegawai berhasil dihapus'
        ]);
    }

    // CRUD untuk Admin
    public function adminIndex()
    {
        $admins = User::where('role', 'admin')->get();
        return response()->json(['data' => $admins]);
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $admin = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Admin berhasil ditambahkan',
            'data' => $admin
        ]);
    }

    public function editAdmin($id)
    {
        $admin = User::findOrFail($id);
        return response()->json(['success' => true, 'data' => $admin]);
    }

    public function updateAdmin(Request $request, $id)
    {
        $admin = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email,' . $id . ',id_User',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $admin->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Admin berhasil diupdate',
            'data' => $admin
        ]);
    }

    public function destroyAdmin($id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();

        return response()->json([
            'success' => true,
            'message' => 'Admin berhasil dihapus'
        ]);
    }

    // *** TAMBAHAN CRUD UNTUK LIBUR ***
       // *** TAMBAHAN CRUD UNTUK LIBUR ***
    public function liburIndex()
    {
        $liburs = Libur::with(['pegawai', 'user'])->get();
        return response()->json(['data' => $liburs]);
    }

    public function storeLibur(Request $request)
    {
        $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'id_pegawai' => 'nullable|exists:pegawais,id_Pegawai',
            'id_user' => 'nullable|exists:users,id_User',
        ], [
            'hari.required' => 'Hari libur harus diisi',
            'hari.in' => 'Hari libur harus salah satu dari: Senin, Selasa, Rabu, Kamis, Jumat, Sabtu, Minggu',
        ]);

        // Pastikan hanya salah satu yang diisi
        if ((!$request->id_pegawai && !$request->id_user) || 
            ($request->id_pegawai && $request->id_user)) {
            return response()->json([
                'success' => false,
                'message' => 'Pilih salah satu antara pegawai atau admin'
            ], 422);
        }

        $libur = Libur::create([
            'hari' => $request->hari,
            'id_pegawai' => $request->id_pegawai,
            'id_user' => $request->id_user,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data libur berhasil ditambahkan',
            'data' => $libur->load(['pegawai', 'user'])
        ]);
    }

    public function editLibur($id)
    {
        $libur = Libur::with(['pegawai', 'user'])->findOrFail($id);
        return response()->json(['success' => true, 'data' => $libur]);
    }

    public function updateLibur(Request $request, $id)
    {
        $libur = Libur::findOrFail($id);

        $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'id_pegawai' => 'nullable|exists:pegawais,id_Pegawai',
            'id_user' => 'nullable|exists:users,id_User',
        ], [
            'hari.required' => 'Hari libur harus diisi',
            'hari.in' => 'Hari libur harus salah satu dari: Senin, Selasa, Rabu, Kamis, Jumat, Sabtu, Minggu',
        ]);

        // Pastikan hanya salah satu yang diisi
        if ((!$request->id_pegawai && !$request->id_user) || 
            ($request->id_pegawai && $request->id_user)) {
            return response()->json([
                'success' => false,
                'message' => 'Pilih salah satu antara pegawai atau admin'
            ], 422);
        }

        $libur->update([
            'hari' => $request->hari,
            'id_pegawai' => $request->id_pegawai,
            'id_user' => $request->id_user,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data libur berhasil diupdate',
            'data' => $libur->load(['pegawai', 'user'])
        ]);
    }

    public function destroyLibur($id)
    {
        $libur = Libur::findOrFail($id);
        $libur->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data libur berhasil dihapus'
        ]);
    }


    // Statistik
    public function statistik()
    {
        $totalPegawai = Pegawai::count();
        $totalAdmin = User::where('role', 'admin')->count();
        $totalLibur = Libur::count(); // Tambahan
        $pegawais = Pegawai::all();
        $admins = User::where('role', 'admin')->get();

        return response()->json([
            'totalPegawai' => $totalPegawai,
            'totalAdmin' => $totalAdmin,
            'totalLibur' => $totalLibur, // Tambahan
            'pegawais' => $pegawais,
            'admins' => $admins
        ]);
    }

    // API methods untuk AJAX calls
    public function getAdminData()
    {
        $admins = User::where('role', 'admin')->get();
        return response()->json(['data' => $admins]);
    }

    public function getStatistikData()
    {
        $totalPegawai = Pegawai::count();
        $totalAdmin = User::where('role', 'admin')->count();
        $totalLibur = Libur::count(); // Tambahan
        $pegawais = Pegawai::all();
        $admins = User::where('role', 'admin')->get();

        return response()->json([
            'success' => true,
            'totalPegawai' => $totalPegawai,
            'totalAdmin' => $totalAdmin,
            'totalLibur' => $totalLibur, // Tambahan
            'pegawais' => $pegawais,
            'admins' => $admins
        ]);
    }

    // *** TAMBAHAN API UNTUK DROPDOWN LIBUR ***
    public function getPegawaiDropdown()
    {
        $pegawais = Pegawai::select('id_Pegawai', 'nama')->get();
        return response()->json(['data' => $pegawais]);
    }

    public function getAdminDropdown()
    {
        $admins = User::select('id_User', 'name')
                     ->where('role', 'admin')
                     ->get();
        return response()->json(['data' => $admins]);
    }

    // Method untuk API endpoint yang sudah ada (compatibility)
    public function getAll()
    {
        $pegawais = Pegawai::all();
        return response()->json($pegawais);
    }
}