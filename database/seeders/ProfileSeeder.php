<?php

namespace Database\Seeders;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ProfileSeeder extends Seeder
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
            'token' => Str::random(60),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'password' => bcrypt($pass),
            'profile' => 'company',
        ]);
        $enduser = DB::table('end_users')->where('id', 1)->first();
        $this->command->info($enduser->name);
        $this->command->info($enduser->username);
        $this->command->info($enduser->email);

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
        ]);

        $user = DB::table('users')->where('id', 1)->first();

        Schema::disableForeignKeyConstraints();
        DB::table('profile_accounts')->truncate();
        Schema::enableForeignKeyConstraints();
        $profile = DB::table('profile_accounts')->insert([
            'id' => '1',
            'end_user_id' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $profile = DB::table('profile_accounts')->where('id', 1)->first();

        Schema::disableForeignKeyConstraints();
        DB::table('end_users')->truncate();
        Schema::enableForeignKeyConstraints();
        DB::table('end_users')->insert([
            'id' => '1',
            'name' => $enduser->name,
            'username' => $enduser->username,
            'email' => $enduser->email,
            'email_verified_at' => Carbon::now(),
            'token' => Str::random(60),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'password' => bcrypt($enduser->password),
            'profile' => 'company',
            'profile_id' => $profile->id,
        ]);

        Schema::disableForeignKeyConstraints();
        DB::table('users')->truncate();
        Schema::enableForeignKeyConstraints();
        DB::table('users')->insert([
            'id' => '1',
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'password' => bcrypt($user->password),
            'profile_id' => $profile->id,
        ]);
    }
}
