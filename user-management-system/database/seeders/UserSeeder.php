<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userAdmin = new User();
        $userAdmin->name = 'Usuario';
        $userAdmin->last_name = 'Prueba';
        $userAdmin->email = 'javivimi14@gmail.com';
        $userAdmin->password = 'sigati14';
        $userAdmin->phone = '954739328';
        $userAdmin->birthday_date = Carbon::parse('24-02-1997');
        $userAdmin->role = 'admin';
        $userAdmin->status = 'Activo';
        $userAdmin->save();
    }
}
