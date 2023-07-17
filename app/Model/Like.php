<?php namespace App\Model;
use App\Model\Post;
use App\Model\Db;

class Like{
    private $id;
    private $user;
    private $post;
    private $created_at;
    private $updated_at;
    private $deleted_at;

    private $db;

    public function __construct(){
        $this->db = Db::getInstance();
    }

    // public function __destruct(){
    //     $this->db->close();
    // }

    public function like($data){
        $this->user = $data['user'];
        $this->post = $data['post'];

        $query = "INSERT INTO post_likes (user, post)";
        $query .= " VALUES($this->user, $this->post)";

        $this->db->execute($query);
        // Post::increaseTotalLike($this->post);
    }

    public function unlike($data){
        $this->user = $data['user'];
        $this->post = $data['post'];

        $query = "DELETE FROM post_likes WHERE user = $this->user AND post = $this->post";
        $this->db->execute($query);
        Post::decreaeTotalLike($this->post);
    }
}