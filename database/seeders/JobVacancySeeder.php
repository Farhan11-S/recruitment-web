<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JobVacancy;
use Carbon\Carbon;

class JobVacancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JobVacancy::create([
            'title' => 'Operator Produksi',
            'description' => 'Bertanggung jawab untuk mengoperasikan mesin produksi sesuai dengan standar yang ditetapkan. Memastikan kualitas produk terjaga dan melakukan pembersihan dasar pada area kerja dan mesin. Dibutuhkan ketelitian dan kemampuan bekerja dalam tim. Minimal lulusan SMA/SMK.',
            'status' => 'open',
            'deadline_at' => Carbon::parse('2025-06-30'),
        ]);

        JobVacancy::create([
            'title' => 'Teknisi Perawatan Mesin',
            'description' => 'Melakukan perawatan preventif dan korektif pada mesin-mesin produksi. Menganalisis dan menyelesaikan masalah teknis pada mesin untuk memastikan kelancaran proses produksi. Diutamakan lulusan D3/S1 Teknik Mesin atau Elektro dengan pengalaman minimal 1 tahun.',
            'status' => 'open',
            'deadline_at' => Carbon::parse('2025-07-15'),
        ]);

        JobVacancy::create([
            'title' => 'Staf Quality Control (QC)',
            'description' => 'Melakukan inspeksi kualitas pada bahan baku, proses produksi, dan produk jadi. Memastikan semua produk memenuhi standar kualitas perusahaan sebelum didistribusikan. Mampu membuat laporan hasil inspeksi secara berkala. Lulusan D3/S1 Teknik Industri, Kimia, atau sejenisnya.',
            'status' => 'open',
            'deadline_at' => Carbon::parse('2025-06-30'),
        ]);
    }
}