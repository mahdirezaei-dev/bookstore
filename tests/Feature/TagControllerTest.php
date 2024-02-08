<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Author;
use App\Models\Tag;
use Symfony\Component\HttpFoundation\Response;


class TagControllerTest extends TestCase
{
        use RefreshDatabase;

    /** @test */
    public function user_can_get_all_tags_in_correct_format(){

        Tag::factory()
            ->count(20)
            ->create();

        $this->get(route('tags.index'))
            ->assertJsonStructure(['data' => ['*' => ['id','name']], 'links', 'meta'])
            ->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function user_can_create_a_new_tag(){

        $tag = [
            'name' => 'Biography'
        ];

        $this->post(route('tags.store'), $tag)
                ->assertJsonStructure(['data' => ['id','name']])
                ->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('tags', $tag);
    }

    /** @test */
    public function user_cant_create_a_tag_without_name(){

        $tag = [];

        $this->post(route('tags.store'), $tag)
                ->assertSessionHasErrors('name')
                ->assertStatus(Response::HTTP_FOUND);

        $this->assertDatabaseMissing('tags', $tag);
    }

    /** @test */
    public function user_can_update_an_existing_tag(){

        $existing_tag = Tag::factory()
            ->create();

        $tag = [
            "name" => "Autobiography"
        ];

        $this->patch(route('tags.update', ['tag' => $existing_tag->id]), $tag)
                ->assertJsonStructure(['data' => ['id','name']])
                ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseMissing('tags', $existing_tag->toArray());
        $this->assertDatabaseHas('tags', $tag);
    }

    /** @test */
    public function user_can_delete_a_tag(){
        $tag = Tag::factory()
            ->create();

        $this->delete(route('tags.destroy', ['tag' => $tag->id]))
                ->assertJsonStructure(['message'])
                ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseMissing('tags', $tag->toArray());
    }
}
