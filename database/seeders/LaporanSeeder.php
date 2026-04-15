<?php

namespace Database\Seeders;

use App\Models\Laporan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LaporanSeeder extends Seeder
{
    /**
     * Seed laporans table.
     */
    public function run(): void
    {
        if (! Schema::hasTable('laporans') || ! Schema::hasTable('users')) {
            return;
        }

        $userReporter = User::query()->where('email', 'warga@example.com')->first();
        $budiReporter = User::query()->where('email', 'budi@example.com')->first();
        $operator = User::query()
            ->where('role', 'operator')
            ->where('status', 'aktif')
            ->orderBy('id')
            ->first();

        if ($userReporter === null || $budiReporter === null) {
            return;
        }

        $reports = [
            [
                'user' => $userReporter,
                'nama_pelapor' => 'Warga Test',
                'no_hp' => '081276543210',
                'email' => 'warga@example.com',
                'kategori' => 'Infrastruktur',
                'lokasi' => 'Jl. Cendrawasih No. 12, Bandung',
                'tanggal_kejadian' => Carbon::now()->subDays(9)->toDateString(),
                'judul_laporan' => 'Jalan berlubang di akses utama perumahan',
                'deskripsi' => 'Terdapat lubang besar di badan jalan yang membahayakan pengendara motor saat malam hari.',
                'status' => 'pending',
                'operator_id' => null,
                'catatan_operator' => null,
                'ditugaskan_at' => null,
                'diproses_at' => null,
                'selesai_at' => null,
            ],
            [
                'user' => $budiReporter,
                'nama_pelapor' => 'Budi Santoso',
                'no_hp' => '081255512345',
                'email' => 'budi@example.com',
                'kategori' => 'Kebersihan',
                'lokasi' => 'Pasar Baru, Jakarta Pusat',
                'tanggal_kejadian' => Carbon::now()->subDays(7)->toDateString(),
                'judul_laporan' => 'Penumpukan sampah di area pasar',
                'deskripsi' => 'Sampah tidak terangkut selama beberapa hari dan menimbulkan bau menyengat.',
                'status' => 'diproses',
                'operator_id' => $operator?->id,
                'catatan_operator' => 'Petugas kebersihan sudah dijadwalkan untuk pengangkutan tambahan.',
                'ditugaskan_at' => Carbon::now()->subDays(6),
                'diproses_at' => Carbon::now()->subDays(5),
                'selesai_at' => null,
            ],
            [
                'user' => $userReporter,
                'nama_pelapor' => 'Warga Test',
                'no_hp' => '081276543210',
                'email' => 'warga@example.com',
                'kategori' => 'Keamanan',
                'lokasi' => 'Jl. Melati Raya, Yogyakarta',
                'tanggal_kejadian' => Carbon::now()->subDays(12)->toDateString(),
                'judul_laporan' => 'Penerangan jalan mati di malam hari',
                'deskripsi' => 'Lampu jalan sudah mati lebih dari satu minggu sehingga area menjadi gelap.',
                'status' => 'selesai',
                'operator_id' => $operator?->id,
                'catatan_operator' => 'Perbaikan instalasi lampu jalan telah selesai dilakukan.',
                'ditugaskan_at' => Carbon::now()->subDays(11),
                'diproses_at' => Carbon::now()->subDays(10),
                'selesai_at' => Carbon::now()->subDays(8),
            ],
            [
                'user' => $budiReporter,
                'nama_pelapor' => 'Budi Santoso',
                'no_hp' => '081255512345',
                'email' => 'budi@example.com',
                'kategori' => 'Lingkungan',
                'lokasi' => 'Sungai Brantas, Surabaya',
                'tanggal_kejadian' => Carbon::now()->subDays(4)->toDateString(),
                'judul_laporan' => 'Pencemaran sungai akibat limbah',
                'deskripsi' => 'Warna air sungai berubah pekat dan berbau, diduga karena limbah rumah tangga.',
                'status' => 'diproses',
                'operator_id' => $operator?->id,
                'catatan_operator' => 'Sedang koordinasi dengan dinas lingkungan untuk pengambilan sampel.',
                'ditugaskan_at' => Carbon::now()->subDays(3),
                'diproses_at' => Carbon::now()->subDays(2),
                'selesai_at' => null,
            ],
            [
                'user' => $userReporter,
                'nama_pelapor' => 'Warga Test',
                'no_hp' => '081276543210',
                'email' => 'warga@example.com',
                'kategori' => 'Pelayanan Publik',
                'lokasi' => 'Kantor Kecamatan Semarang Timur',
                'tanggal_kejadian' => Carbon::now()->subDays(2)->toDateString(),
                'judul_laporan' => 'Antrian pelayanan administrasi terlalu lama',
                'deskripsi' => 'Sistem antrian sering berhenti sehingga waktu tunggu warga menjadi sangat lama.',
                'status' => 'pending',
                'operator_id' => null,
                'catatan_operator' => null,
                'ditugaskan_at' => null,
                'diproses_at' => null,
                'selesai_at' => null,
            ],
        ];

        foreach ($reports as $report) {
            Laporan::updateOrCreate(
                [
                    'user_id' => $report['user']->id,
                    'judul_laporan' => $report['judul_laporan'],
                ],
                [
                    'nama_pelapor' => $report['nama_pelapor'],
                    'no_hp' => $report['no_hp'],
                    'email' => $report['email'],
                    'kategori' => $report['kategori'],
                    'lokasi' => $report['lokasi'],
                    'tanggal_kejadian' => $report['tanggal_kejadian'],
                    'deskripsi' => $report['deskripsi'],
                    'status' => $report['status'],
                    'operator_id' => $report['operator_id'],
                    'catatan_operator' => $report['catatan_operator'],
                    'ditugaskan_at' => $report['ditugaskan_at'],
                    'diproses_at' => $report['diproses_at'],
                    'selesai_at' => $report['selesai_at'],
                ]
            );
        }
    }
}
