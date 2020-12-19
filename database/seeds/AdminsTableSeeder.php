<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();
        $adminRecords = [
            [
                'name' => 'Abyan Fawwaz',
                'type' => 'admin',
                'mobile' => '081238201029',
                'email' => 'abyfwz@gmail.com',
                'password' => '$2y$10$WNGF01MUiKiBJRc/z5im/uxDrx72uXSkXsR0T.RiqIBNq1tzbts6G', // 1234
                'image' => '',
                'status' => '1',
            ], [
                'name' => 'Nafhidah Ramdhani Qurrahman',
                'type' => 'admin',
                'mobile' => '082333889670',
                'email' => 'nafhidahrq@gmail.com',
                'password' => '$2y$10$O20AcnSjWsUgvogA0IQcheca7CKCH0PIGz9iJDyxt1/rYY1E0NaJG', //1234
                'image' => '',
                'status' => '1',
            ],
        ];
        foreach ($adminRecords as $key => $record) {
            \App\Admin::create($record);
        }
    }
}
