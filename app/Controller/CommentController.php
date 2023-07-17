<?php namespace App\Controller;

use App\Model\Comment;

class CommentController extends Controller{
    public function create($data){
        $comment = new Comment();
        return $comment->create($data);
    }

    public function delete($id){
        $comment = new Comment();
        return $comment->delete($id);
    }

    public function getByPostId($post_id){
        $comment = new Comment();
        return $comment->getByPostId($post_id);
    }
}