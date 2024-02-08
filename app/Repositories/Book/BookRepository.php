<?php

namespace App\Repositories\Book;

use LaravelEasyRepository\Repository;

interface BookRepository extends Repository{

    public function paginate();
    public function paginateHasTag(int $id);
}
