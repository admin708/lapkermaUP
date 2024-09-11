<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\LapkermaRefIndikatorKinerja;

class LapkermaRefIndikatorKinerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LapkermaRefIndikatorKinerja::create([
            'uuid' => '25dffbab-969f-4601-9729-a968bf7eace6',
            'id_sasaran_kegiatan' => 1,
            'nama' => 'Kesiapan kerja lulusan',
        ]);
        LapkermaRefIndikatorKinerja::create([
            'uuid' => '32ee3044-ad1c-4973-b253-0cdc644b67af',
            'id_sasaran_kegiatan' => 1,
            'nama' => 'Mahasiswa di luar kampus',
        ]);

        LapkermaRefIndikatorKinerja::create([
            'uuid' => 'd1e737c0-bf38-416f-80b0-6bee3810adfb',
            'id_sasaran_kegiatan' => 2,
            'nama' => 'Link and match PTS',
        ]);

        LapkermaRefIndikatorKinerja::create([
            'uuid' => '41ac9539-4170-46a8-ac9a-0a5ecee38a6c',
            'id_sasaran_kegiatan' => 3,
            'nama' => 'Dosen di luar kampus',
        ]);
        LapkermaRefIndikatorKinerja::create([
            'uuid' => '8e488df6-e4e7-4db8-a9ec-f78caa9d9afb',
            'id_sasaran_kegiatan' => 3,
            'nama' => 'Kualifikasi dosen',
        ]);
        LapkermaRefIndikatorKinerja::create([
            'uuid' => '0372fbb2-cf28-4639-9221-9e56833cee56',
            'id_sasaran_kegiatan' => 3,
            'nama' => 'Penerapan riset dosen',
        ]);

        LapkermaRefIndikatorKinerja::create([
            'uuid' => 'cb6698bc-72da-4d6b-b8ec-a4f7df5d9607',
            'id_sasaran_kegiatan' => 4,
            'nama' => 'Kemitraan prorgam studi',
        ]);
        LapkermaRefIndikatorKinerja::create([
            'uuid' => '4a37967d-0cb4-4b68-b28b-e0dc5a85b3a7',
            'id_sasaran_kegiatan' => 4,
            'nama' => 'Pembelajaran dalam kelas',
        ]);
        LapkermaRefIndikatorKinerja::create([
            'uuid' => '244de932-e5ef-4f77-8439-0ec250ca365a',
            'id_sasaran_kegiatan' => 4,
            'nama' => 'Akreditasi Internasional',
        ]);

        LapkermaRefIndikatorKinerja::create([
            'uuid' => 'ac321d60-b77c-4f1a-b18c-72f523db94f8',
            'id_sasaran_kegiatan' => 5,
            'nama' => 'IKK 2.5.2.1 Persentase Prodi bekerjasama dengan mitra',
        ]);
    }
}
