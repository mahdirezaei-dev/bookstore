<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::factory()
            ->has(Tag::factory()->count(5))
            ->count(3)
            ->create();

        Author::factory()
            ->has(Tag::factory()->count(5))
            ->count(3)
            ->create();
    }
}
