<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Author::factory()
            ->hasBooks(5)
            ->has(Tag::factory()->count(5))
            ->count(3)
            ->create();
    }
}
