<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionsSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        Section::factory()->count(3)->create();
    }
}
