<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::firstOrCreate([
            'email' => 'test@example.org',
            'firstname' => 'firstname',
            'lastname' => 'lastname',
            ],[
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        $role = \App\Models\Role::firstOrCreate([
            'name' => 'admin',
        ]);

        $user->roles()->sync($role->id);

        $app = \App\Models\App::firstOrCreate([
            'name' => 'mountain',
            'active' => true,
            'user_id' => $user->id,
        ]);

        $url = str_replace('http://', '', env('APP_URL'));
        $url = str_replace('https://', '', $url);

        \App\Models\Url::firstOrCreate([
            'url' => $url,
            'app_id' => $app->id,
        ]);

        \App\Models\Url::firstOrCreate([
            'url' => 'localhost',
            'app_id' => $app->id,
        ]);

        \App\Models\Url::firstOrCreate([
            'url' => '::1',
            'app_id' => $app->id,
        ]);

        \App\Models\Url::firstOrCreate([
            'url' => '127.0.0.1',
            'app_id' => $app->id,
        ]);
    }
}
