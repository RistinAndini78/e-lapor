<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PengaduanController extends Controller
{
    public function index(Request $request)
    {
        $user = auth('api')->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $query = Pengaduan::with(['user', 'category'])->latest();

        // Search and Filter functionality (Opsional C di Ketentuan)
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('judul_pengaduan', 'like', "%{$searchTerm}%")
                  ->orWhere('deskripsi_masalah', 'like', "%{$searchTerm}%")
                  ->orWhere('lokasi_kejadian', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->has('status')) {
            $query->where('status_laporan', $request->status);
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }

        $pengaduan = $query->get();

        return response()->json($pengaduan);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul_pengaduan' => 'required|string|max:255',
            'deskripsi_masalah' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'lokasi_kejadian' => 'required|string',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $path = null;
        if ($request->hasFile('foto_bukti')) {
            $path = $request->file('foto_bukti')->store('uploads/pengaduan', 'public');
        }

        $user = auth('api')->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $pengaduan = Pengaduan::create([
            'user_id' => $user->id,
            'category_id' => $request->category_id,
            'judul_pengaduan' => $request->judul_pengaduan,
            'deskripsi_masalah' => $request->deskripsi_masalah,
            'lokasi_kejadian' => $request->lokasi_kejadian,
            'foto_bukti' => $path,
            'status_laporan' => 'menunggu',
        ]);

        return response()->json([
            'message' => 'Pengaduan berhasil dibuat.',
            'data' => $pengaduan
        ], 201);
    }

    public function show(string $id)
    {
        $pengaduan = Pengaduan::with(['user', 'category'])->findOrFail($id);

        $user = auth('api')->user();
        if ($user && $user->role !== 'admin' && $pengaduan->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($pengaduan);
    }

    public function update(Request $request, string $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        $currentUser = auth('api')->user();
        if ($currentUser && $pengaduan->user_id !== $currentUser->id && $currentUser->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($pengaduan->status_laporan !== 'menunggu') {
            return response()->json(['error' => 'Laporan yang sedang diproses tidak dapat diubah.'], 403);
        }

        $validator = Validator::make($request->all(), [
            'judul_pengaduan' => 'required|string|max:255',
            'deskripsi_masalah' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'lokasi_kejadian' => 'required|string',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if ($request->hasFile('foto_bukti')) {
            if ($pengaduan->foto_bukti) {
                Storage::disk('public')->delete($pengaduan->foto_bukti);
            }
            $pengaduan->foto_bukti = $request->file('foto_bukti')->store('uploads/pengaduan', 'public');
        }

        $pengaduan->update($request->only(['judul_pengaduan', 'deskripsi_masalah', 'category_id', 'lokasi_kejadian']));

        return response()->json([
            'message' => 'Pengaduan berhasil diperbarui.',
            'data' => $pengaduan
        ]);
    }

    public function destroy(string $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        $currentUser = auth('api')->user();
        if ($currentUser && $pengaduan->user_id !== $currentUser->id && $currentUser->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($pengaduan->status_laporan !== 'menunggu') {
            return response()->json(['error' => 'Laporan yang sedang diproses tidak dapat dihapus.'], 403);
        }

        if ($pengaduan->foto_bukti) {
            Storage::disk('public')->delete($pengaduan->foto_bukti);
        }

        $pengaduan->delete();

        return response()->json(['message' => 'Pengaduan berhasil dihapus.']);
    }

    public function updateStatus(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'status_laporan' => 'required|in:menunggu,diproses,selesai',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->update(['status_laporan' => $request->status_laporan]);

        return response()->json([
            'message' => 'Status laporan berhasil diperbarui.',
            'data' => $pengaduan
        ]);
    }

    public function indexPublic()
    {
        $pengaduan = Pengaduan::with('category')
            ->select('id', 'category_id', 'judul_pengaduan', 'lokasi_kejadian', 'status_laporan', 'foto_bukti', 'created_at')
            ->latest()
            ->get();

        return response()->json($pengaduan);
    }
}
