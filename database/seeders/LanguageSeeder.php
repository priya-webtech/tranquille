<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;
use Illuminate\Support\Facades\Schema;


class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        Language::truncate();
        
        Language::create([
            'active' => 'Y',
            'name' => 'Dutch',
            'status' => 0
        ]);
        Language::create([
            'active' => 'Y',
            'name' => 'Turkish',
            'status' => 0
        ]);
        Language::create([
            'active' => 'Y',
            'name' => 'English',
            'status' => 0
        ]);

        Schema::enableForeignKeyConstraints();

    }
}
