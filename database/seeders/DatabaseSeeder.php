<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Page;
use App\Models\Theme;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed themes first
        $this->call(ThemeSeeder::class);

        // Create a sample client
        $client = Client::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'slug' => 'john-doe',
            'password' => bcrypt('password'),
            'company_name' => 'John\'s Company',
            'description' => 'A sample company for testing',
            'is_active' => true,
        ]);

        // Get the classic theme
        $theme = Theme::where('slug', 'classic')->first();

        // Create sample pages for the client
        Page::create([
            'client_id' => $client->id,
            'theme_id' => $theme->id,
            'title' => 'Welcome to Our Company',
            'slug' => 'welcome',
            'content' => [
                'sections' => [
                    [
                        'type' => 'hero',
                        'data' => [
                            'headline' => 'Welcome to Our Company',
                            'subheadline' => 'We provide amazing services to help your business grow',
                            'buttonText' => 'Get Started'
                        ]
                    ],
                    [
                        'type' => 'text',
                        'data' => [
                            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.'
                        ]
                    ],
                    [
                        'type' => 'features',
                        'data' => [
                            'features' => [
                                [
                                    'title' => 'Fast Service',
                                    'description' => 'We deliver results quickly and efficiently'
                                ],
                                [
                                    'title' => 'Quality Work',
                                    'description' => 'High-quality solutions tailored to your needs'
                                ],
                                [
                                    'title' => '24/7 Support',
                                    'description' => 'Round-the-clock support for all your needs'
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'meta_title' => 'Welcome to Our Company - Professional Services',
            'meta_description' => 'Discover our professional services and solutions for your business needs.',
            'is_published' => true,
        ]);

        Page::create([
            'client_id' => $client->id,
            'theme_id' => $theme->id,
            'title' => 'About Us',
            'slug' => 'about',
            'content' => [
                'sections' => [
                    [
                        'type' => 'text',
                        'data' => [
                            'content' => 'We are a team of passionate professionals dedicated to delivering exceptional results. Our mission is to help businesses achieve their goals through innovative solutions and outstanding service.'
                        ]
                    ]
                ]
            ],
            'meta_title' => 'About Us - Our Story and Mission',
            'meta_description' => 'Learn about our company, our mission, and the team behind our success.',
            'is_published' => true,
        ]);
    }
}