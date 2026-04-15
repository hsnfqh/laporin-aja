<?php

namespace Database\Seeders;

use App\Models\DaerahButuhRelawan;
use App\Models\Relawan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class RelawanSeeder extends Seeder
{
    /**
     * Seed relawan table.
     */
    public function run(): void
    {
        if (! Schema::hasTable('relawans') || ! Schema::hasTable('users')) {
            return;
        }

        $candidateUsers = [
            [
                'name' => 'Siti Rahma',
                'email' => 'siti.relawan@example.com',
                'password' => 'password',
                'no_hp' => '081234500111',
                'role' => 'user',
                'status' => 'aktif',
            ],
            [
                'name' => 'Andi Pratama',
                'email' => 'andi.relawan@example.com',
                'password' => 'password',
                'no_hp' => '081234500222',
                'role' => 'user',
                'status' => 'aktif',
            ],
            [
                'name' => 'Rina Kartika',
                'email' => 'rina.relawan@example.com',
                'password' => 'password',
                'no_hp' => '081234500333',
                'role' => 'user',
                'status' => 'aktif',
            ],
        ];

        foreach ($candidateUsers as $candidateUser) {
            User::updateOrCreate(
                ['email' => $candidateUser['email']],
                [
                    'name' => $candidateUser['name'],
                    'password' => Hash::make($candidateUser['password']),
                    'no_hp' => $candidateUser['no_hp'],
                    'role' => $candidateUser['role'],
                    'status' => $candidateUser['status'],
                ]
            );
        }

        $daerahByName = DaerahButuhRelawan::query()
            ->pluck('id', 'nama_daerah')
            ->all();

        $rows = [
            [
                'email' => 'warga@example.com',
                'nama_lengkap' => 'Warga Test',
                'no_hp' => '081276543210',
                'domisili' => 'Bandung',
                'keahlian' => 'Pertolongan Pertama',
                'motivasi' => 'Ingin membantu warga sekitar ketika terjadi bencana.',
                'status' => 'aktif',
                'daerah' => 'Bandung',
            ],
            [
                'email' => 'budi@example.com',
                'nama_lengkap' => 'Budi Santoso',
                'no_hp' => '081255512345',
                'domisili' => 'Jakarta',
                'keahlian' => 'Koordinasi Lapangan',
                'motivasi' => 'Siap terlibat sebagai relawan dalam kegiatan sosial.',
                'status' => 'pending',
                'daerah' => 'Jakarta Pusat',
            ],
            [
                'email' => 'siti.relawan@example.com',
                'nama_lengkap' => 'Siti Rahma',
                'no_hp' => '081234500111',
                'domisili' => 'Yogyakarta',
                'keahlian' => 'Logistik',
                'motivasi' => 'Memiliki pengalaman distribusi bantuan saat tanggap darurat.',
                'status' => 'aktif',
                'daerah' => 'Yogyakarta',
            ],
            [
                'email' => 'andi.relawan@example.com',
                'nama_lengkap' => 'Andi Pratama',
                'no_hp' => '081234500222',
                'domisili' => 'Surabaya',
                'keahlian' => 'Evakuasi',
                'motivasi' => 'Berpengalaman membantu evakuasi saat bencana banjir.',
                'status' => 'nonaktif',
                'daerah' => 'Surabaya',
            ],
            [
                'email' => 'rina.relawan@example.com',
                'nama_lengkap' => 'Rina Kartika',
                'no_hp' => '081234500333',
                'domisili' => 'Semarang',
                'keahlian' => 'Komunikasi',
                'motivasi' => 'Siap menjadi penghubung informasi di lapangan.',
                'status' => 'aktif',
                'daerah' => 'Semarang',
            ],
        ];

        foreach ($rows as $row) {
            $user = User::query()->where('email', $row['email'])->first();

            if ($user === null) {
                continue;
            }

            Relawan::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nama_lengkap' => $row['nama_lengkap'],
                    'email' => $row['email'],
                    'no_hp' => $row['no_hp'],
                    'domisili' => $row['domisili'],
                    'keahlian' => $row['keahlian'],
                    'motivasi' => $row['motivasi'],
                    'status' => $row['status'],
                    'daerah_butuh_relawan_id' => $daerahByName[$row['daerah']] ?? null,
                ]
            );
        }
    }
}
