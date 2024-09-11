<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\LapkermaRefSasaranKegiatan;

class LapkermaRefSasaranKegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LapkermaRefSasaranKegiatan::create([
            'uuid' => '57ec65bd-e13b-4ebf-911c-a1c9097b8783',
            'nama' => 'Meningkatnya kualitas lulusan pendidikan tinggi',
        ]);
        LapkermaRefSasaranKegiatan::create([
            'uuid' => 'e223673c-14ac-4f14-9821-a65c04a8862d',
            'nama' => 'Meningkatnya inovasi perguruan tinggi dalam rangka meningkatkan mutu pendidikan',
        ]);
        LapkermaRefSasaranKegiatan::create([
            'uuid' => 'dcb9e13a-28c9-4ddf-803d-6abe69fa787d',
            'nama' => 'Meningkatnya kualitas dosen pendidikan tinggi',
        ]);
        LapkermaRefSasaranKegiatan::create([
            'uuid' => '219cfb2b-d599-4728-a4b8-8c2b2b56869a',
            'nama' => 'Meningkatnya kualitas kurikulum dan pembelajaran',
        ]);
        LapkermaRefSasaranKegiatan::create([
            'uuid' => '9326f685-600f-47a8-a4ea-faf237988f15',
            'nama' => 'Meningkatnya program studi yang berkualitas',
        ]);
    }
}
