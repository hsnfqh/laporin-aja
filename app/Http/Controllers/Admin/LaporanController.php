<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // HAPUS yang menggunakan with('user') jika tidak ada relasi
        $laporan = Laporan::orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.laporan.index', compact('laporan'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $laporan = Laporan::findOrFail($id);
        
        return view('admin.laporan.show', compact('laporan'));
    }

    /**
     * Update status laporan.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai'
        ]);

        $laporan = Laporan::findOrFail($id);
        $laporan->status = $request->status;
        $laporan->save();

        return redirect()->back()->with('success', 'Status laporan berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id);
        
        // Hapus file lampiran jika ada
        if ($laporan->lampiran && Storage::disk('public')->exists($laporan->lampiran)) {
            Storage::disk('public')->delete($laporan->lampiran);
        }
        
        $laporan->delete();

        return redirect()->route('admin.laporan.index')
            ->with('success', 'Laporan berhasil dihapus');
    }
}