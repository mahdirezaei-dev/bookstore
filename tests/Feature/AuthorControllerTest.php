<?php

namespace Tests\Feature;

use App\Http\Resources\BookResource;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use \App\Models\Tag;

class AuthorControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_get_all_authors_with_specific_tag(){
        $tag = Tag::factory()->create();

        Author::factory()
            ->count(5)
            ->create();
            
        $authors = Author::factory()
            ->count(5)
            ->create();

        foreach ($authors as $author) {
            $author->tags()->attach($tag);
        }

        $this->get(route('authors.index', ['tag' => $tag->id]))
            ->assertJsonCount(5, 'data')
            ->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function user_can_get_all_authors_in_correct_format(){

        Author::factory()
            ->count(30)
            ->create();

        $this->get(route('authors.index'))
            ->assertJsonStructure(['data' => ['*' => ['id','name']], 'links', 'meta'])
            ->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function user_can_create_a_new_author(){

        $author = [
            'name' => 'Jan Doe',
        ];

        $this->post(route('authors.store'), $author)
                ->assertJsonStructure(['data' => ['id','name']])
                ->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('authors', $author);
    }

    /** @test */
    public function user_can_update_an_existing_author(){

        $existing_author = Author::factory()
            ->create();

        $author = [
            "name" => "Alex Ferguson",
        ];

        $this->patch(route('authors.update', ['author' => $existing_author->id]), $author)
                ->assertJsonStructure(['data' => ['id','name']])
                ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseMissing('authors', $existing_author->toArray());
        $this->assertDatabaseHas('authors', $author);
    }

    /** @test */
    public function user_can_delete_a_author(){
        $author = Author::factory()
            ->create();

        $this->delete(route('authors.destroy', ['author' => $author->id]))
                ->assertJsonStructure(['message'])
                ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseMissing('authors', $author->toArray());
    }
}
