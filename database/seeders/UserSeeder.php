<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nama'      =>  'adminadminadmin',
            'no_hp'     =>  '085333096854',
            'password'  =>  bcrypt('123123'),
            'role'      =>  'admin',
            'kelamin'   =>  'laki-laki',
            'tgl_lahir' =>  now(),
            'pekerjaan' =>  'pengbawang',
            'foto'      =>  null,
        ]);

        $genders = ['laki-laki', 'perempuan'];

        foreach ($genders as $key => $gender) {
            for ($i=0; $i < 10; $i++) { 
                User::create([
                    'nama'  =>  $gender.$i,
                    'no_hp' =>  '08'.($key+1).'23456789'.$i,
                    'password'  => bcrypt('123123'),
                    'role'      =>  'user',
                    'kelamin'   =>  $gender,
                    'tgl_lahir' =>  now(),
                    'pekerjaan' =>  'pengbawang',
                    'foto'      =>  null,
                ]);
            }
        }

    }
}
