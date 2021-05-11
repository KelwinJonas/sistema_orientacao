<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Database\Seeders\AtividadeSeeder;
use Database\Seeders\InstituicaoSeeder;
use Database\Seeders\SecaoSeeder;
use Database\Seeders\TemplateSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();

        $this->call([
            AtividadeSeeder::class,
            InstituicaoSeeder::class,
            TemplateSeeder::class,
            SecaoSeeder::class,
        ]);
    }
}
