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

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_get_all_books_with_specific_tag(){
        $tag = Tag::factory()->create();

        Book::factory()
            ->for(Author::factory()->create())
            ->count(5)
            ->create();

        $books = Book::factory()
            ->for(Author::factory()->create())
            ->count(5)
            ->create();

        foreach ($books as $book) {
            $book->tags()->attach($tag);
        }

        $this->get(route('books.index', ['tag' => $tag->id]))
            ->assertJsonCount(5, 'data')
            ->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function user_can_get_all_books_in_correct_format(){

        Book::factory()
            ->count(30)
            ->for(Author::factory()->create())
            ->create();

        $this->get(route('books.index'))
            ->assertJsonStructure(['data' => ['*' => ['id','author_id','title','price']], 'links', 'meta'])
            ->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function user_can_create_a_new_book(){

        $author = Author::factory()->create();

        $book = [
            'title' => 'A Time to Kill by John Grisham',
            'author_id' => $author->id,
            'price' => 11111.11,
        ];

        $this->post(route('books.store'), $book)
                ->assertJsonStructure(['data' => ['id','author_id','title','price']])
                ->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('books', $book);
    }

    /** @test */
    public function user_cant_create_a_book_with_invalid_amount(){

        $book = [
            'title' => 'A Time to Kill by John Grisham',
            'author_id' => 1,
            'price' => 11111.1111,
        ];

        $this->post(route('books.store'), $book)
                ->assertSessionHasErrors('price')
                ->assertStatus(Response::HTTP_FOUND);

        $this->assertDatabaseMissing('books', $book);
    }

    /** @test */
    public function user_can_update_an_existing_book(){

        $existing_book = Book::factory()
            ->for(Author::factory()->create())
            ->create();

        $book = [
            "title" => "Alex Ferguson: My Autobiography",
            "author_id" => $existing_book->author_id,
            "price" => 10.11,
        ];

        $this->patch(route('books.update', ['book' => $existing_book->id]), $book)
                ->assertJsonStructure(['data' => ['id','author_id','title','price']])
                ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseMissing('books', $existing_book->toArray());
        $this->assertDatabaseHas('books', $book);
    }

    /** @test */
    public function user_can_delete_a_book(){
        $book = Book::factory()
            ->for(Author::factory()->create())
            ->create();

        $this->delete(route('books.destroy', ['book' => $book->id]))
                ->assertJsonStructure(['message'])
                ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseMissing('books', $book->toArray());
    }
}
