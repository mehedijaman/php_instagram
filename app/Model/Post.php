<?php 
namespace App\Model;
use App\Model\Db;
use Exception;

class Post{
    private $id;
    private $user;
    private $title;
    private $description;
    private $photo;
    private $location;
    private $tags;
    private $total_likes;
    private $total_comments;
    private $total_shares;
    private $published;
    private $created_at;
    private $updated_at;
    private $deleted_at;

    private static $db;

    public function __construct(){
        self::$db = Db::getInstance();
    }

    // public function __destruct(){
    //     self::$db->close();
    // }

    // Create a new post
    public function create($data){
        $this->user         = $data['user'];
        $this->title        = $data['title'];
        $this->description  = $data['description'];
        $this->photo        = $data['photo'];

        $query = "INSERT INTO posts (user, title, description, photo)";
        $query .= " VALUES($this->user, '$this->title', '$this->description', '$this->photo')";       

        self::$db->execute($query);
    }

    // Get single post by Primary Key
    public function get($id){
        $query = "SELECT * FROM posts WHERE id = $id AND where deleted_at IS NULL";
        $result = self::$db->fetchData($query);
        return $result;
    }

    // Get all posts
    public function getAll(){
        $query = "SELECT posts.*, post_comments.*,
            posts.id as post_id,
            users.name AS user_name,
            users.photo AS user_photo,
            (SELECT COUNT(*) FROM post_likes WHERE post_likes.post = posts.id) AS total_likes,
            (SELECT COUNT(*) FROM post_comments WHERE post_comments.post = posts.id) AS total_comments
            FROM posts
            LEFT JOIN users ON posts.user = users.id
            LEFT JOIN post_comments  ON posts.id = post_comments.post
            WHERE posts.deleted_at IS NULL ORDER BY posts.id DESC";

        $result = self::$db->fetchData($query);
        return $result;
    }

    // Update Total Likes when someone likes a post
    public static function increaseTotalLike($id){
        $query = "UPDATE posts SET total_likes = total_likes + 1 WHERE id = $id";
        self::$db->execute($query);
    }

    public static function decreaeTotalLike($id){
        $query = "UPDATE posts SET total_likes = total_likes + 1 WHERE id = $id";
        self::$db->execute($query);
    }

    // Update Total Comment Count when someone comment on a post
    public static function increseTotalComment($id){
        return $query = "UPDATE posts SET total_comments = total_comments + 1 WHERE id = $id";
        self::$db->execute($query);
    }

    public static function decreaseTotalComment($id){
        $query = "UPDATE posts SET total_comments -= 1 WHERE id = $id";
        self::$db->execute($query);
    }

    // Publish post
    public function publish($id){
        $query = "UPDATE posts SET published = 1 WHERE id = $id";
        self::$db->execute($query);
    }

    // Unpublish post
    public function unpublish($id){
        $query = "UPDATE posts SET published = 0 WHERE id = $id";
        self::$db->execute($query);
    }
    
    // Soft Delete a post. this will only update the deleted_at field
    public function softDelete($id){
        $query = "UPDATE posts SET deleted_at = CURRENT_TIMESTAMP WHERE id = $id";
        self::$db->execute($query);
    }
    
    // Hard Delete a post. this will delete the record forever
    public function hardDelete($id){
        $query = "DELETE FROM posts WHERE id = $id";
        self::$db->execute($query);
    }
}