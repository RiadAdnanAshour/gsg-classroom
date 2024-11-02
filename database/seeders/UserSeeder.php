<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Add this line to import DB
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         //Query Builder
         DB::table('users')->insert(
            [
                'name' => 'Riad Ashour',
                'email'=> 'riadashour153@gmail.com',
                'password'=> Hash::make('password'), //sha  md5  rsa
            ]
         );
         DB::table('users')->insert(
            [
                'name' => 'Riad adnan Ashour',
                'email'=> 'riadashour1532@gmail.com',
                'password'=> Hash::make('password'), //sha  md5  rsa
            ]
         );
         DB::table('users')->insert(
            [
                'name' => 'Riad Ashour3',
                'email'=> 'riadashour1533@gmail.com',
                'password'=> Hash::make('password'), //sha  md5  rsa
            ]
         );
    }
}
