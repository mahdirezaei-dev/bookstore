<?php

namespace App\Repositories\Author;

use LaravelEasyRepository\Repository;

interface AuthorRepository extends Repository{

    public function paginate();
    public function paginateHasTag(int $id);
}
