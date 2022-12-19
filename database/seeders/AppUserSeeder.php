<?php

namespace Database\Seeders;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class AppUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('end_users')->truncate();
        Schema::enableForeignKeyConstraints();
        $name = $this->command->ask('App Name');
        $username = $this->command->ask('App Username');
        $mail = $this->command->ask("App E-mail de {$name}");
        $pass = $this->command->secret("App Password de {$name}");
        DB::table('end_users')->insert([
            'id' => '1',
            'name' => $name,
            'username' => $username,
            'email' => $mail,
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'password' => bcrypt($pass),
            'profile_id' => '1',
            'profile' => 'company',
        ]);
    }
}
