<?php namespace App\Controller;

use App\Model\Comment;
use App\Model\Like;
use App\Model\Post;

class PostController extends Controller{
    public function create($data){ 
        $post = new Post();
        return $post->create($data);
    }

    public function getAll(){
        $post = new Post();
        return $post->getAll();
    }

    public function like($data){
        $like = new Like();
        return $like->like($data);
    }

    public function unlike($data){
        $like = new like();
        return $like->unlike($data);
    }    
}