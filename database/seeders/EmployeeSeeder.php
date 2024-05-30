<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            ['name' => 'Aathi', 'email' => 'aathi@gmail.com', 'contact' => '7822323232', 'designation' => 'Developer', 'city' => 'Coimbatore'],
            ['name' => 'Ram', 'email' => 'ram@gmail.com', 'contact' => '7822323332', 'designation' => 'Tester', 'city' => 'Madurai'],
            ['name' => 'Tom', 'email' => 'tom@gmail.com', 'contact' => '5822323232', 'designation' => 'HR', 'city' => 'Chennai']
        ];

        foreach ($plans as $plan ) {
        	Employee::create($plan);   	
        }
    }
}
