<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends Model
{
    use HasFactory;

    public $timestamps = false;


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name'];

    /**
     * Get all the authors that are assigned this tag.
     */
    public function authors(): MorphToMany
    {
        return $this->morphedByMany(Author::class, 'taggable');
    }

    /**
     * Get all the books that are assigned this tag.
     */
    public function books(): MorphToMany
    {
        return $this->morphedByMany(Book::class, 'taggable');
    }
}
