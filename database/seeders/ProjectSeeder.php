<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Models\Client;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        // Get all client and operator IDs to assign dynamically (assuming models exist for Client and User)
        $clients = Client::all();
        $operators = User::whereIn('role', ['operator'])->pluck('id'); // Assuming operators are identified by role

        // 10 Projects, each with more than 5 tasks

        // Project 1: Website Redesign for E-Commerce Store
        $project1 = Project::create([
            'title' => 'Website Redesign for E-Commerce Store',
            'client_id' => $clients->first()->id,
            'operator_ids' => json_encode([$operators->random(), $operators->random()]),
            'deadline' => '2024-12-15',
            'priority' => 'high',
            'status' => 'active',
            'description' => 'Redesign the UI/UX of an e-commerce store to enhance user experience and optimize for conversions.'
        ]);
        $this->createTasksForProject($project1, 7, $operators);

        // Project 2: Mobile App Development for Task Management
        $project2 = Project::create([
            'title' => 'Mobile App Development for Task Management',
            'client_id' => $clients->skip(1)->first()->id,
            'operator_ids' => json_encode([$operators->random(), $operators->random()]),
            'deadline' => '2024-12-20',
            'priority' => 'medium',
            'status' => 'active',
            'description' => 'Build a mobile app that allows users to create, assign, and track tasks efficiently.'
        ]);
        $this->createTasksForProject($project2, 6, $operators);

        // Project 3: Corporate Branding Overhaul
        $project3 = Project::create([
            'title' => 'Corporate Branding Overhaul',
            'client_id' => $clients->skip(2)->first()->id,
            'operator_ids' => json_encode([$operators->random(), $operators->random()]),
            'deadline' => '2024-12-25',
            'priority' => 'high',
            'status' => 'active',
            'description' => 'A complete overhaul of the company’s branding including logos, color schemes, and marketing materials.'
        ]);
        $this->createTasksForProject($project3, 8, $operators);

        // Project 4: Custom CRM Development
        $project4 = Project::create([
            'title' => 'Custom CRM Development',
            'client_id' => $clients->skip(3)->first()->id,
            'operator_ids' => json_encode([$operators->random(), $operators->random()]),
            'deadline' => '2024-12-18',
            'priority' => 'medium',
            'status' => 'active',
            'description' => 'Develop a custom CRM solution to manage customer interactions and sales processes.'
        ]);
        $this->createTasksForProject($project4, 7, $operators);

        // Project 5: Mobile Game Development
        $project5 = Project::create([
            'title' => 'Mobile Game Development',
            'client_id' => $clients->skip(4)->first()->id,
            'operator_ids' => json_encode([$operators->random(), $operators->random()]),
            'deadline' => '2024-12-30',
            'priority' => 'high',
            'status' => 'active',
            'description' => 'Develop an interactive mobile game with multiplayer functionality and in-app purchases.'
        ]);
        $this->createTasksForProject($project5, 6, $operators);

        // Project 6: Social Media Campaign for Product Launch
        $project6 = Project::create([
            'title' => 'Social Media Campaign for Product Launch',
            'client_id' => $clients->skip(5)->first()->id,
            'operator_ids' => json_encode([$operators->random(), $operators->random()]),
            'deadline' => '2024-12-22',
            'priority' => 'medium',
            'status' => 'active',
            'description' => 'Develop and execute a social media campaign for the launch of a new product.'
        ]);
        $this->createTasksForProject($project6, 5, $operators);

        // Project 7: SEO Optimization for E-Commerce Store
        $project7 = Project::create([
            'title' => 'SEO Optimization for E-Commerce Store',
            'client_id' => $clients->skip(6)->first()->id,
            'operator_ids' => json_encode([$operators->random(), $operators->random()]),
            'deadline' => '2024-12-28',
            'priority' => 'high',
            'status' => 'active',
            'description' => 'Optimize the website for search engines to improve organic traffic and rankings.'
        ]);
        $this->createTasksForProject($project7, 7, $operators);

        // Project 8: Real Estate Management System Development
        $project8 = Project::create([
            'title' => 'Real Estate Management System Development',
            'client_id' => $clients->skip(7)->first()->id,
            'operator_ids' => json_encode([$operators->random(), $operators->random()]),
            'deadline' => '2024-12-26',
            'priority' => 'medium',
            'status' => 'active',
            'description' => 'Develop a real estate management system for property listings, sales, and tracking.'
        ]);
        $this->createTasksForProject($project8, 6, $operators);

        // Project 9: Marketing Website for New Business
        $project9 = Project::create([
            'title' => 'Marketing Website for New Business',
            'client_id' => $clients->skip(8)->first()->id,
            'operator_ids' => json_encode([$operators->random(), $operators->random()]),
            'deadline' => '2024-12-12',
            'priority' => 'low',
            'status' => 'active',
            'description' => 'Create a marketing website for a new business with a focus on online lead generation.'
        ]);
        $this->createTasksForProject($project9, 6, $operators);

        // Project 10: Business Intelligence Dashboard Development
        $project10 = Project::create([
            'title' => 'Business Intelligence Dashboard Development',
            'client_id' => $clients->skip(9)->first()->id,
            'operator_ids' => json_encode([$operators->random(), $operators->random()]),
            'deadline' => '2024-12-30',
            'priority' => 'medium',
            'status' => 'active',
            'description' => 'Develop a business intelligence dashboard for tracking key performance indicators (KPIs).'
        ]);
        $this->createTasksForProject($project10, 7, $operators);
    }

    // Helper function to create tasks for a project
    private function createTasksForProject($project, $taskCount, $operators)
    {
        for ($i = 1; $i <= $taskCount; $i++) {
            Task::create([
                'task_name' => 'Task ' . $i . ' for ' . $project->title,
                'task_description' => 'Description for task ' . $i . ' of the project ' . $project->title,
                'task_priority' => ['low', 'medium', 'high'][rand(0, 2)],
                'task_deadline' => now()->addDays(rand(1, 10))->format('Y-m-d'),
                'operator_id' => $project->operator_ids ? json_decode($project->operator_ids)[rand(0, 1)] : $operators->random(),
                'project_id' => $project->id,
            ]);
        }
    }
}
