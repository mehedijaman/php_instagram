<?php namespace App\Model;
use App\Model\Db;
use App\Model\Post;

class Comment{
    private $id;
    private $user;
    private $post;
    private $comment;
    private $published;
    private $created_at;
    private $updatd_at;
    private $deleted_at;

    private $db;

    public function __construct(){
        $this->db = Db::getInstance();
    }

    // public function __destruct(){
    //     $this->db->close();
    // }

    public function create($data){
        $this->user         = $data['user'];
        $this->post         = $data['post'];
        $this->comment      = $data['comment'];

        $query = "INSERT INTO post_comments (user, post, comment)";
        $query .= " VALUES($this->user, $this->post, '$this->comment')";       

        $this->db->execute($query);
        // Post::increseTotalComment($this->post);
    }

    public function delete($id){
        $this->id = $id;

        $comment = $this->get($this->id);
        $this->post = $comment[0]['post'];

        $query = "DELETE FROM post_comments WHERE id = $this->id";

        $this->db->execute($query);
        Post::decreaseTotalComment($this->post);
    }

    public function get($id){
        $this->id = $id;

        $query = "SELECT * FROM post_comments WHERE id = $this->id";

        $result = $this->db->fetchData($query);
        return $result;
    }

    public function getByPostId($post_id){
        $this->post = $post_id;
        $query = "SELECT * FROM post_comments WHERE post = $this->post";
        $result = $this->db->fetchData($query);
        return $result;
    }

    // Publish Comment
    public function publish($id){
        $this->id = $id;
        $query = "UPDATE post_comments SET published = 1 WHERE id = $this->id";
        self::$db->execute($query);
    }

    // Unpublish comment
    public function unpublish($id){
        $this->id = $id;
        $query = "UPDATE post_comments SET published = 0 WHERE id = $this->id";
        self::$db->execute($query);
    }
}