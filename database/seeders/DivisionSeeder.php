<?php

namespace Database\Seeders;

use App\Models\Divisi;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    public function run(): void
    {
        Divisi::create([
            'name'        => 'IT',
            'code'        => 'IT',
            'description' => 'Divisi Teknologi Informasi',
        ]);

        Divisi::create([
            'name'        => 'HRD',
            'code'        => 'HR',
            'description' => 'Divisi Sumber Daya Manusia',
        ]);
    }
}
