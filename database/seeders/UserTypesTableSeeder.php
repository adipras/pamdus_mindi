<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_types')->truncate();

        DB::table('user_types')->insert(
            [
                [
                    'name' => 'admin'
                ],
                [
                    'name' => 'pelanggan'
                ],
            ]
        );
    }
}
