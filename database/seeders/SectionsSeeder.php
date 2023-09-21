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
        Section::insert([
            [
                'id'             => 1,
                'title'          => 'Welcome to ErpMaster',
                'image'          => 'image.jpg',
                'featured_title' => 'ERPMASTER',
                'subtitle'       => 'ERPMASTER',
                'label'          => 'ERPMASTER',
                'link'           => 'https://erpmaster.com/',
                'description'    => 'ERPMASTER',
                'status'         => '1',
                'bg_color'       => '#ffffff',
                'page_id'        => null,
                'position'       => '1',
                'language_id'    => '1',
            ],
        ]);
    }
}
