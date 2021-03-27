<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UserTableSeeder extends Seeder
{ 
    const ARRAR_USER = [
        '1' => [
            'name' =>'admin_demo1',
            'email' => 'admin1_demo12@gmail.com',
            'password' => 'admin_demo12'
        ],
        '2' => [
            'name' => 'admin_demo21',
            'email' => 'admin231_demo12@gmail.com',
            'password' => 'admin_demo123'
        ],
        '3' => [
            'name' => 'admin_demo131',
            'email' => 'admin1_demo123@gmail.com',
            'password' => 'admin_demo1234'
        ]
    ];
     /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::ARRAR_USER as $value) {
            DB::table('users')->insert([
                'name'=> $value['name'],
                'email' => $value['email'],
                'password' => Hash::make($value['password']),
            ]);
        }
    }
}