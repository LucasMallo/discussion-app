<?php 
namespace App\Model;

use Nette;

final class PostFacade
{
    public function __construct(
        private Nette\Database\Explorer $database
    )
    {

    }

    public function getPosts()
    {
        return $this->database
            ->table('posts')
            ->order('created_at DESC');
    }

    public function getPost(int $id)
    {
        return $this->database
            ->table('posts')
            ->get($id);
    }

    public function insertPost(array $data)
    {
        return $this->database
            ->table('posts')
            ->insert($data);
    }
}

