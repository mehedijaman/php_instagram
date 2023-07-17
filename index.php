<?php

use App\Controller\CommentController;
use App\Controller\PostController;
use App\Model\Post;

require_once __DIR__ . '/vendor/autoload.php';
$PostController = new PostController();

if(isset($_POST['submit'])){
  if($_POST['submit'] == 'post-submit'){
    if (isset($_FILES['post-image']) && $_FILES['post-image']['error'] === UPLOAD_ERR_OK) {

      $target_dir     = "public/uploads/posts/";
      $file_name      = $_FILES['post-image']['name'];
      $file_ext       = pathinfo($file_name, PATHINFO_EXTENSION);
      $file_tmp_name  = $_FILES['post-image']['tmp_name'];
      $file_new_name  = uniqid().uniqid().'.'.$file_ext;
      $target_path    = $target_dir . $file_new_name;


      if (!move_uploaded_file($file_tmp_name, $target_path)) {
        echo "Failed to upload file.";
      }
    } else {
      echo "No file uploaded or an error occurred.";
    }

    $data = [
      'user'        => 1,
      'title'       => '',
      'description' => $_POST['post-description'],
      'photo'       => $file_new_name,
    ];
    
    $PostController->create($data);
  }

  if($_POST['submit'] == 'like-submit'){
    $data = [
      'user' => 1,
      'post' => $_POST['post-id']
    ];

    $PostController->like($data);
  }

  if($_POST['submit'] == 'comment-submit'){
    $data = [
      'user'    => 1,
      'post'    => $_POST['post-id'],
      'comment' => $_POST['comment-description']
    ];
    $CommentController = new CommentController();
    $CommentController->create($data);
  }
}

// $PostController = new PostController();
$result = $PostController->getAll();
// Group the comments by post ID
$posts = [];
foreach ($result as $row) {
    $postId = $row['id'];
    
    if (!isset($posts[$postId])) {
      $posts[$postId] = [
          'post' => [
              'id' => $row['post_id'],
              'user' => $row['user_name'],
              'title' => $row['title'],
              'description' => $row['description'],
              'photo' => $row['photo'],
              'location' => $row['location'],
              'total_likes' => $row['total_likes'],
              'total_comments' => $row['total_comments'],
              'total_shares' => $row['total_shares'],
              'created_at' => $row['created_at'],
              'comments' => []
          ]
      ];
    }
    
    // Add comments to the respective post
    $posts[$postId]['post']['comments'][] = [
      'id' => $row['comment_id'],
      'user' => $row['comment_user'],
      'comment' => $row['comment'],
      'published' => $row['comment_published'],
      'created_at' => $row['comment_created_at'],
      'updated_at' => $row['comment_updated_at'],
      'deleted_at' => $row['comment_deleted_at']
  ];
}

// var_dump($posts);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="assets/css/style.css"> 
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <title>Social Feed</title>
</head>

<body>
  <div class="container pt-5">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="post-form" id="post-form" enctype="multipart/form-data" method="post">
      <div class="post-form row">
        <div class="col-12 p-2">
          <textarea class="form-control" id="post-description" name="post-description" placeholder="Write your post..."></textarea>
        </div>
        <div class="col-6 p-2">
          <input type="file" class="form-control-file" id="post-img" name="post-image">
        </div>
        <div class="col-6 p-2 text-right">
          <button class="btn btn-primary" id="post-submit-btn" type="submit" name="submit" value="post-submit">Post</button>
        </div>
      </div>
    </form>

    <div class="feed">
      <?php foreach($posts as $Post) { ?>
        <div class="post">
          <div class="post-header">
            <img src="public/uploads/faces/10.jpg" alt="Profile Image" class="profile-image">
            <span class="username"><?php echo $Post['post']['user']; ?></span>
          </div>
          <div class="post-content">
            <img src="public/uploads/posts/<?php echo $Post['post']['photo']; ?>" alt="Post Image" class="post-image">
            <p class="caption"><?php echo $Post['post']['description'] ?></p>
          </div>
          <div class="post-actions">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
              <input type="hidden" name="post-id" value="<?php echo $Post['post']['id']; ?>">
              <button type="submit" name="submit" value="like-submit"><i class="fas fa-heart"> <?php echo $Post['post']['total_likes']; ?></i> </button>
            </form>
            
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
              <input type="hidden" name="post-id" value="<?php echo $Post['post']['id']; ?>">
              <button type="submit" name="submit" value="comment-view"><i class="fas fa-comment"> <?php  echo $Post['post']['total_comments']; ?></i></button>
            </form>  

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
              <input type="hidden" name="post-id" value="<?php echo $Post['post']['id']; ?>">
              <button type="submit" name="submit" value="share-submit"><i class="fas fa-share"></i></button>
            </form>             
          </div>
          <div class="comments">
            <?php 
            // var_dump($Post['post']['comments']);
            foreach($Post['post']['comments'] as $comment) {  ?>
            <div class="comment">
              <span class="comment-username">Wendell Berry:</span>
              <span class="comment-text"><?php echo $comment['comment']; ?></span>
            </div>
            <?php } ?>
          </div>
          <div class="comment-input row">
            <form class="form-inline" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
              <div class="col-9 p-2">
                <input type="hidden" name="post-id" value="<?php echo $Post['post']['id']; ?>">
                <input type="text" name="comment-description" class="form-control" placeholder="Write a comment...">
              </div>
              <div class="col-3 p-2">
                <button type="submit" name="submit" value="comment-submit" class="btn btn-primary">Post</button>
              </div>
            </form>
          </div>
        </div>
      <?php } ?>
      <div class="post">
        <div class="post-header">
          <img src="public/uploads/faces/10.jpg" alt="Profile Image" class="profile-image">
          <span class="username">John Lubbock</span>
        </div>
        <div class="post-content">
          <img src="public/uploads/posts/weather-2.jpg" alt="Post Image" class="post-image">
          <p class="caption">Rest is not idleness, and to lie sometimes on the grass under trees on a summer's day, listening to the murmur of the water, or watching the clouds float across the sky, is by no means a waste of time.</p>
        </div>
        <div class="post-actions">
          <i class="fas fa-heart"></i> 
          <i class="fas fa-comment"></i> 
          <i class="fas fa-share"></i>
        </div>
        <div class="comments">
          <div class="comment">
            <span class="comment-username">Wendell Berry:</span>
            <span class="comment-text">For a time, I rest in the grace of the world, and am free.</span>
          </div>
        </div>
        <div class="comment-input row">
          <div class="col-9 p-2">
            <input type="text" class="form-control" placeholder="Write a comment...">
          </div>
          <div class="col-3 p-2">
            <button class="btn btn-primary">Post</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/js/timeline.js"></script>
</body>
</html>