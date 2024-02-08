<?php

namespace App\Repositories\Book;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Book;

class BookRepositoryImplement extends Eloquent implements BookRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Book $model)
    {
        $this->model = $model;
    }

    public function paginate(){
        return $this->model->paginate();
    }
    
    public function paginateHasTag(int $id){
        return \App\Models\Tag::where('id', $id)->first()->books()->paginate();
    }
}
