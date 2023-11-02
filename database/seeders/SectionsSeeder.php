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
                'title'          => 'Tahe Cosmetics',
                'image'          => uploadImage('images/sections', '640', '480'),
                'featured_title' => 'Tahe Cosmetics',
                'subtitle'       => 'Tahe Cosmetics',
                'label'          => 'Tahe Cosmetics',
                'link'           => 'https://Tahe-Cosmetics.com/',
                'description'    => 'ERPMASTER',
                'status'         => '1',
                'bg_color'       => '#ffffff',
                'page_id'        => null,
                'position'       => '1',
                'language_id'    => '1',
            ],
            [
                'id'             => 2,
                'title'          => 'About us',
                'image'          => uploadImage('images/sections', '640', '480'),
                'featured_title' => 'Tahe Cosmetics',
                'subtitle'       => 'Tahe Cosmetics',
                'label'          => 'Tahe Cosmetics',
                'link'           => 'https://Tahe-Cosmetics.com/',
                'description'    => 'Features of this package and what it includes',
                'status'         => '1',
                'bg_color'       => '#effaeb',
                'text_color'     => 'black',
                'position'       => '1',
                'type'           => 'about',
            ],
            [
                'id'             => 3,
                'title'          => 'Contact',
                'image'          => uploadImage('images/sections', '640', '480'),
                'featured_title' => 'Tahe Cosmetics',
                'subtitle'       => 'Tahe Cosmetics',
                'label'          => 'Tahe Cosmetics',
                'link'           => 'https://Tahe-Cosmetics.com/',
                'description'    => 'Features of this package and what it includes',
                'status'         => '1',
                'bg_color'       => '#effaeb',
                'text_color'     => 'black',
                'position'       => '1',
                'type'           => 'contact',
            ],

        ]);
    }
}
