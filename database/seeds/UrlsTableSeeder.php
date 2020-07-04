<?php

use Illuminate\Database\Seeder;

class UrlsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $url = str_replace('http://', '', env('APP_URL'));
        $url = str_replace('https://', '', $url);

        factory(App\Models\Url::class, 30)->create();

        if (!\App\Models\Url::where('url', $url)->exists()) {
            factory(App\Models\Url::class)->create([
                'url' => $url,
            ]);
        }
    }
}
