<?php 
namespace App\Model;

use Nette;

final class CommentFacade
{
    public function __construct(
        private Nette\Database\Explorer $database
    )
    {

    }

    public function getComments()
    {
        return $this->database
            ->table('posts')
            ->order('created_at DESC');
    }

    public function insertComment(array $data)
    {
        return $this->database
            ->table('comments')
            ->insert($data);
    }
}

