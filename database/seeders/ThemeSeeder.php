<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $themes = [
            [
                'name' => 'Classic',
                'slug' => 'classic',
                'colors' => [
                    'primary' => '#000000',
                    'secondary' => '#8B4513',
                    'accent' => '#FFFFFF',
                    'background' => '#FFFFFF',
                    'text' => '#000000',
                ],
                'description' => 'A classic black, brown, and white theme',
            ],
            [
                'name' => 'Ocean',
                'slug' => 'ocean',
                'colors' => [
                    'primary' => '#1E40AF',
                    'secondary' => '#0EA5E9',
                    'accent' => '#F0F9FF',
                    'background' => '#FFFFFF',
                    'text' => '#1F2937',
                ],
                'description' => 'A calming ocean-inspired blue theme',
            ],
            [
                'name' => 'Forest',
                'slug' => 'forest',
                'colors' => [
                    'primary' => '#166534',
                    'secondary' => '#22C55E',
                    'accent' => '#F0FDF4',
                    'background' => '#FFFFFF',
                    'text' => '#1F2937',
                ],
                'description' => 'A natural green forest theme',
            ],
            [
                'name' => 'Sunset',
                'slug' => 'sunset',
                'colors' => [
                    'primary' => '#DC2626',
                    'secondary' => '#F59E0B',
                    'accent' => '#FEF3C7',
                    'background' => '#FFFFFF',
                    'text' => '#1F2937',
                ],
                'description' => 'A warm sunset orange and red theme',
            ],
            [
                'name' => 'Purple',
                'slug' => 'purple',
                'colors' => [
                    'primary' => '#7C3AED',
                    'secondary' => '#A855F7',
                    'accent' => '#F3E8FF',
                    'background' => '#FFFFFF',
                    'text' => '#1F2937',
                ],
                'description' => 'A modern purple and violet theme',
            ],
            [
                'name' => 'Dark',
                'slug' => 'dark',
                'colors' => [
                    'primary' => '#FFFFFF',
                    'secondary' => '#D1D5DB',
                    'accent' => '#374151',
                    'background' => '#111827',
                    'text' => '#FFFFFF',
                ],
                'description' => 'A sleek dark theme with white accents',
            ],
        ];

        foreach ($themes as $theme) {
            Theme::create($theme);
        }
    }
}
