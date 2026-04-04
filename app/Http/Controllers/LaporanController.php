<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    /**
     * Constructor - middleware auth
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource (INDEX)
     */
    public function index()
    {
        $laporans = Laporan::where('user_id', Auth::id())
                          ->orderBy('created_at', 'desc')
                          ->paginate(10);
        
        return view('laporan.index', compact('laporans'));
    }

    /**
     * Show the form for creating a new resource (CREATE)
     */
    public function create()
    {
        $kategoriList = [
            'Infrastruktur' => 'Infrastruktur (Jalan, Jembatan, Drainase)',
            'Kebersihan' => 'Kebersihan (Sampah, Limbah)',
            'Kesehatan' => 'Kesehatan (Fasilitas Kesehatan, Wabah)',
            'Pendidikan' => 'Pendidikan (Sekolah, Fasilitas Belajar)',
            'Keamanan' => 'Keamanan (Kriminalitas, Patroli)',
            'Pelayanan Publik' => 'Pelayanan Publik (Administrasi, Perizinan)',
            'Lingkungan' => 'Lingkungan (Polusi, Penghijauan)',
            'Lainnya' => 'Lainnya'
        ];
        
        return view('laporan.create', compact('kategoriList'));
    }

    /**
     * Store a newly created resource in storage (STORE)
     */
    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'nama_pelapor' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'kategori' => 'required|string|max:100',
            'lokasi' => 'required|string|max:500',
            'tanggal_kejadian' => 'required|date',
            'judul_laporan' => 'required|string|max:255',
            'deskripsi' => 'required|string|min:10',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120' // Max 5MB
        ]);

        // Handle upload file lampiran
        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $lampiranPath = $file->storeAs('lampiran', $fileName, 'public');
        }

        // Simpan ke database
        $laporan = Laporan::create([
            'nama_pelapor' => $validated['nama_pelapor'],
            'no_hp' => $validated['no_hp'],
            'email' => $validated['email'],
            'kategori' => $validated['kategori'],
            'lokasi' => $validated['lokasi'],
            'tanggal_kejadian' => $validated['tanggal_kejadian'],
            'judul_laporan' => $validated['judul_laporan'],
            'deskripsi' => $validated['deskripsi'],
            'lampiran' => $lampiranPath,
            'user_id' => Auth::id(),
            'status' => 'pending'
        ]);

        return redirect()->route('laporan.show', $laporan->id)
                         ->with('success', 'Laporan berhasil dikirim!');
    }

    /**
     * Display the specified resource (SHOW)
     */
    public function show($id)
    {
        $laporan = Laporan::where('user_id', Auth::id())
                          ->findOrFail($id);
        
        return view('laporan.show', compact('laporan'));
    }

    /**
     * Show the form for editing the specified resource (EDIT)
     */
    public function edit($id)
    {
        $laporan = Laporan::where('user_id', Auth::id())
                          ->findOrFail($id);
        
        // Cek status, jika sudah diproses/selesai tidak bisa diedit
        if ($laporan->status != 'pending') {
            return redirect()->route('laporan.show', $laporan->id)
                             ->with('error', 'Laporan yang sudah diproses tidak dapat diedit!');
        }
        
        $kategoriList = [
            'Infrastruktur' => 'Infrastruktur (Jalan, Jembatan, Drainase)',
            'Kebersihan' => 'Kebersihan (Sampah, Limbah)',
            'Kesehatan' => 'Kesehatan (Fasilitas Kesehatan, Wabah)',
            'Pendidikan' => 'Pendidikan (Sekolah, Fasilitas Belajar)',
            'Keamanan' => 'Keamanan (Kriminalitas, Patroli)',
            'Pelayanan Publik' => 'Pelayanan Publik (Administrasi, Perizinan)',
            'Lingkungan' => 'Lingkungan (Polusi, Penghijauan)',
            'Lainnya' => 'Lainnya'
        ];
        
        return view('laporan.edit', compact('laporan', 'kategoriList'));
    }

    /**
     * Update the specified resource in storage (UPDATE)
     */
    public function update(Request $request, $id)
    {
        $laporan = Laporan::where('user_id', Auth::id())
                          ->findOrFail($id);
        
        // Cek status
        if ($laporan->status != 'pending') {
            return redirect()->route('laporan.show', $laporan->id)
                             ->with('error', 'Laporan yang sudah diproses tidak dapat diubah!');
        }
        
        // Validasi
        $validated = $request->validate([
            'nama_pelapor' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'kategori' => 'required|string|max:100',
            'lokasi' => 'required|string|max:500',
            'tanggal_kejadian' => 'required|date',
            'judul_laporan' => 'required|string|max:255',
            'deskripsi' => 'required|string|min:10',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120'
        ]);
        
        // Handle upload file baru
        if ($request->hasFile('lampiran')) {
            // Hapus file lama jika ada
            if ($laporan->lampiran && Storage::disk('public')->exists($laporan->lampiran)) {
                Storage::disk('public')->delete($laporan->lampiran);
            }
            
            $file = $request->file('lampiran');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $lampiranPath = $file->storeAs('lampiran', $fileName, 'public');
            $validated['lampiran'] = $lampiranPath;
        }
        
        // Update data
        $laporan->update($validated);
        
        return redirect()->route('laporan.show', $laporan->id)
                         ->with('success', 'Laporan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage (DESTROY)
     */
    public function destroy($id)
    {
        $laporan = Laporan::where('user_id', Auth::id())
                          ->findOrFail($id);
        
        // Cek status
        if ($laporan->status != 'pending') {
            return redirect()->route('laporan.index')
                             ->with('error', 'Laporan yang sudah diproses tidak dapat dihapus!');
        }
        
        // Hapus file lampiran
        if ($laporan->lampiran && Storage::disk('public')->exists($laporan->lampiran)) {
            Storage::disk('public')->delete($laporan->lampiran);
        }
        
        // Hapus data
        $laporan->delete();
        
        return redirect()->route('laporan.index')
                         ->with('success', 'Laporan berhasil dihapus!');
    }
}