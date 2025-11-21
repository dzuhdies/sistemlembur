<?php

namespace Database\Seeders;

use App\Models\Divisi;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $it = Divisi::where('code', 'IT')->first();
        $hr = Divisi::where('code', 'HR')->first();

        // STAFF
        User::create([
            'name'        => 'Zaha',
            'password'    => Hash::make('password'),
            'role'        => 'leader',
            'division_id' => $hr?->id,
        ]);

        // // LEADER
        // User::create([
        //     'name'        => 'Leader IT',
        //     'password'    => Hash::make('password'),
        //     'role'        => 'leader',
        //     'division_id' => $it?->id,
        // ]);

        // // MANAGER
        // User::create([
        //     'name'        => 'Manager HR',
        //     'password'    => Hash::make('password'),
        //     'role'        => 'manager',
        //     'division_id' => $hr?->id,
        // ]);
    }
}
