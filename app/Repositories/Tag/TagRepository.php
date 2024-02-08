<?php

namespace App\Repositories\Tag;

use LaravelEasyRepository\Repository;

interface TagRepository extends Repository{

    public function paginate();
}
