<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepository extends CrudRepository
{

    public function model()
    {
        return Comment::class;
    }
}
