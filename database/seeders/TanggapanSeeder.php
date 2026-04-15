<?php

namespace Database\Seeders;

use App\Models\Laporan;
use App\Models\Tanggapan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TanggapanSeeder extends Seeder
{
    /**
     * Seed tanggapan table.
     */
    public function run(): void
    {
        if (! Schema::hasTable('tanggapan') || ! Schema::hasTable('laporans') || ! Schema::hasTable('users')) {
            return;
        }

        $admin = User::query()->where('role', 'admin')->orderBy('id')->first();
        $operator = User::query()
            ->where('role', 'operator')
            ->where('status', 'aktif')
            ->orderBy('id')
            ->first();

        if ($admin === null && $operator === null) {
            return;
        }

        $targetReports = Laporan::query()
            ->whereIn('status', ['diproses', 'selesai'])
            ->orderBy('id')
            ->get();

        foreach ($targetReports as $report) {
            if ($admin !== null) {
                Tanggapan::updateOrCreate(
                    [
                        'laporan_id' => $report->id,
                        'user_id' => $admin->id,
                        'isi_tanggapan' => 'Laporan telah diterima tim admin dan sedang dipantau proses tindak lanjutnya.',
                    ],
                    []
                );
            }

            if ($operator !== null) {
                $operatorResponse = $report->status === 'selesai'
                    ? 'Penanganan lapangan sudah selesai. Mohon cek lokasi untuk verifikasi akhir.'
                    : 'Tim operator sedang memproses laporan ini dan akan memberikan pembaruan berkala.';

                Tanggapan::updateOrCreate(
                    [
                        'laporan_id' => $report->id,
                        'user_id' => $operator->id,
                        'isi_tanggapan' => $operatorResponse,
                    ],
                    []
                );
            }
        }
    }
}
