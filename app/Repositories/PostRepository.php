<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository extends CrudRepository
{

    public function model()
    {
        return Post::class;
    }
}
