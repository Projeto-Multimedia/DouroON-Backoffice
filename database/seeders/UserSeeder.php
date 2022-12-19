<?php

namespace Database\Seeders;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('users')->truncate();
        Schema::enableForeignKeyConstraints();
        $name = $this->command->ask('Web Service Name');
        $username = $this->command->ask('Web Service Username');
        $mail = $this->command->ask("Web Service E-mail de {$name}");
        $pass = $this->command->secret("Web Service Password de {$name}");
        DB::table('users')->insert([
            'id' => '1',
            'name' => $name,
            'username' => $username,
            'email' => $mail,
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'password' => bcrypt($pass),
            'profile_id' => '1',
        ]);
    }
}
