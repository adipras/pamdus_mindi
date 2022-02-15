<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->where('email', 'tottiprasetyo@gmail.com')->delete();

        DB::table('users')->insert([
            'name' => 'Adi Prasetyo',
            'email' => 'tottiprasetyo@gmail.com',
            'nik' => '3404012310870005',
            'password' => bcrypt('2323271109'),
            'type' => 'admin',
        ]);
    }
}
