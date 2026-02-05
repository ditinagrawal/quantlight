<?php

namespace Database\Seeders;

use App\Models\LabUpdate;
use Illuminate\Database\Seeder;

class LabUpdateSeeder extends Seeder
{
    /**
     * Seed the lab_updates table with the static "Latest discoveries" items.
     */
    public function run(): void
    {
        $items = [
            [
                'title' => 'Generation of Complex Vector & Vortex EUV Beams',
                'excerpt' => null,
                'image' => 'quantlight/assets/img/blog1.png',
                'link' => '/news',
                'categories' => 'Photonics, Vector Beams',
                'published_date' => '2025-09-22',
                'is_published' => true,
                'sort_order' => 0,
            ],
            [
                'title' => 'High-Harmonic Array Beams for Advanced Imaging',
                'excerpt' => null,
                'image' => 'quantlight/assets/img/blog2.png',
                'link' => '/news',
                'categories' => 'High Harmonics, XUV Beams',
                'published_date' => '2025-09-15',
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Spatial Shaping of Harmonics Using Vortex Beams',
                'excerpt' => null,
                'image' => 'quantlight/assets/img/blog3.png',
                'link' => '/news',
                'categories' => 'Optical Vortices, Laser Research',
                'published_date' => '2025-09-10',
                'is_published' => true,
                'sort_order' => 2,
            ],
        ];

        foreach ($items as $item) {
            LabUpdate::firstOrCreate(
                ['title' => $item['title']],
                $item
            );
        }
    }
}
