<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')
            ->insertOrIgnore(
                [
                    'name' => 'test',
                    'email' => 'admin@admin.com',
                    'password' => Hash::make('123456'),
                ]
            );
        echo("Users Inserted").PHP_EOL;
    }


}
/// artisan db:seed --class=UserSeeder
