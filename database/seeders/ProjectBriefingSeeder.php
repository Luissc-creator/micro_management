<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectBriefingSeeder extends Seeder
{
    public function run()
    {
        $briefings = [
            [
                'project_id' => 1, // Replace with actual project IDs
                'briefing' => 'This is the briefing for the e-commerce website redesign.  We need a modern, responsive design that improves user experience and increases conversions.',
            ],
            [
                'project_id' => 2,
                'briefing' => 'Develop a mobile task management app with user authentication, task creation/editing, categorization, reminders, and calendar integration.',
            ],
            [
                'project_id' => 3,
                'briefing' => 'Overhaul our corporate branding, including logo design, typography, color palette, and brand messaging.  We need a cohesive online and offline presence.',
            ],
            [
                'project_id' => 4,
                'briefing' => 'Develop a custom CRM system for managing customer data, sales pipelines, and integrating with existing tools.  User roles and permissions are crucial.',
            ],
            [
                'project_id' => 5,
                'briefing' => 'Create an engaging mobile game with unique mechanics, high-quality graphics, in-app purchases, and social sharing options.',
            ],
            [
                'project_id' => 6,
                'briefing' => 'Launch a social media campaign for our new product.  This includes content creation, influencer marketing, performance monitoring, and customer engagement.',
            ],
            [
                'project_id' => 7,
                'briefing' => 'Optimize our e-commerce store for search engines.  This includes keyword research, on-page optimization, technical SEO, content creation, and link building.',
            ],
            [
                'project_id' => 8,
                'briefing' => 'Develop a real estate management system to handle property listings, client interactions, transactions, and reporting.  Role-based access is required.',
            ],
            [
                'project_id' => 9,
                'briefing' => 'Create a marketing website for our new business, focused on lead generation.  It should include contact forms, SEO optimization, and a responsive design.',
            ],
            [
                'project_id' => 10,
                'briefing' => 'Develop a business intelligence dashboard that integrates data from various sources, provides customizable visualizations, and offers real-time updates.',
            ],
        ];

        DB::table('project_briefings')->insert($briefings);
    }
}
