 <?php 
session_start();
include("classes/connect.php");
include("classes/user.php");
include("classes/comment.php");
include("classes/post.php");
include("classes/post_like.php");

$admin=0;
$like=false;
if(isset($_SESSION['myblog_userid'])){
  $user = new User();
  $us_data = $user->get_data($_SESSION['myblog_userid']);
  $admin = $us_data['admin'];
}

  $comm= new Comment();
  $postid = $_GET['postid'];
       $comms= $comm->get_comments_nolimit($postid);
       if(isset($_SESSION['myblog_userid'])){
          $user_like = new Like();
          $like = $user_like->check_like($_SESSION['myblog_userid'], $postid);
       }

 $post = new Post();
 $row_post = $post->get_data($postid);

 $user = new User();
 $row_user = $user->get_data($row_post['userid']);

if(isset($_POST['description']) && isset($_SESSION['myblog_userid'])){
  $comm = new Comment();
  $userid = $_SESSION['myblog_userid'];
  $res = $comm->create_comment($_SESSION['myblog_userid'], $_POST);
  if($res!= ""){
    echo "<div class='container text-center bg-danger my-2 py-2 text-light'>";
    echo $res;
    echo "</div>";
  }else{
    header("Location: ".$_SERVER['PHP_SELF']."?postid=".$postid);
    exit();
  }
}
 ?>

 <html>

 <head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Insanity Blog</title>
   <link rel="stylesheet" href="style.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
 </head>

 <body>
   <header>
   </header>

   <main>
     <div class="container mt-5">
       <div class="row">
         <div class="col-12">
           <!-- POST -->
           <div class="mx-auto col-lg-8 col-md-10 col-sm-12">
             <div class="card mb-5 border border-2">
               <div class="card-body">
                 <a href="profile.php?id=<?php echo $row_user['userid']; ?>" class="text-decoration-none link-dark">
                   <div class="d-flex">

                     <div class="img-container" style="height:50px; width:50px;">
                       <img src="
                      <?php 
                      if($row_user['photo']==NULL){
                        echo "images/user_male.jpg";
                      }
                      else{
                        echo $row_user['photo'];
                      }
                      ?>
                      " style="width:100%; height:100%; object-fit: contain;"
                         class="rounded-circle border border-1 border-dark" alt="Profile Picture">
                     </div>
                     <div class="ms-2">
                       <h5 class="card-title"><?php echo $row_user['login']; ?></h5>

                       <p class="card-text text-muted">
                         <i class="fa fa-clock"></i>
                         <?php echo $row_post['date']; ?>
                       </p>
                     </div>
                   </div>
                 </a>
                 <hr class="my-2 mb-4">

                 <p class="card-text"><?php 
                echo "<pre class='fs-5' style='white-space: pre-wrap; text-align: justify; '>";
                echo $row_post['description'];
                echo "</pre>"; 
              ?></p>
                 <?php if($row_post['photo']!=NULL) :?>
                 <img src="<?php echo $row_post['photo']; ?>" class="card-img-top border border-1 border-dark"
                   alt="Image Content">
                 <?php endif; ?>
                 <div class="d-flex justify-content-between mt-2 align-items-center">
                   <div class="col-lg-6">
                     <p class="my-auto me-2 text-muted"> <?php echo $row_post['category']; ?> </p>
                   </div>
                   <div class="col-lg-6">
                     <div class="d-flex justify-content-end">
                     <?php if($admin==1) :?>
                      <a class="my-auto me-4 link-dark" href="remove_post.php?postid=<?php echo $row_post['postid']; ?>">
                      <i class="fa fa-trash-can"></i>
                    </a>
                    <?php endif; ?>
                       <p class="my-auto me-2"> <?php echo $row_post['likes']; ?> </p>

                       <?php if(!isset($_SESSION['myblog_userid'])) :?>
                      <a href="login.php"
                         class="btn btn-outline-danger" id="like-button">
                         <i class="fa fa-heart"></i>
                       </a>
                      <?php else: ?>
                       <?php if($like==false) : ?>
                       <a href="like_det.php?userid=<?php echo $_SESSION['myblog_userid']; ?>&postid=<?php echo $row_post['postid']; ?>"
                         class="btn btn-outline-danger" id="like-button">
                         <i class="fa fa-heart"></i>
                       </a>
                       <?php else : ?>
                       <a href="like_det.php?userid=<?php echo $_SESSION['myblog_userid']; ?>&postid=<?php echo $row_post['postid']; ?>"
                         class="btn btn-danger" id="like-button">
                         <i class="fa fa-heart"></i>
                       </a>
                       <?php endif; ?>
                       <?php endif; ?>

                     </div>

                   </div>

                 </div>

               </div>
              

               <!-- YOUR COMMENT -->
               <?php if(isset($_SESSION['myblog_userid'])) : ?>
                <hr> 
               <div class="card-body">
                 <form method="POST" action="" autocomplete="off">
                   <div class="input-group align-items-center">
                     <input type="hidden" name="post_id" value="<?php echo $row_post['postid']; ?>">
                     <input name="description" type="text" class="form-control" placeholder="Ваш коментар"
                       aria-label="Add a comment" aria-describedby="comment-button">
                     <button class="btn btn-primary" type="submit" id="comment-button">Додати коментар</button>
                   </div>
                 </form>
               </div>
               <?php endif; ?>
               <!-- END YOUR COMMENT -->

               <!-- POST COMMENTS -->
               <ul class="list-group list-group-flush">
                 <li class="list-group-item">
                   <?php 
                   if(is_bool($comms)){
                    echo "<div class='my-2 text-muted col-lg-12 text-center fs-5'>";
                    echo   "Немає комментарів.";
                    echo "</div>";
                   }
                  else{
                    foreach ($comms as $row) {
                      $user_class = new User();
                      $comm_class = new Comment();
                      $row_user = $user_class->get_data($row['userid']);
                      $row_comm = $comm_class->get_data($row['commid']);
                      include("comment-card.php");
                    }
                  }
                ?>

                 </li>
               </ul>
               <!-- END POST COMMENTS -->

             </div>
             <!-- POST END -->
           </div>
         </div>
       </div>
     </div>
   </main>

   <footer>

   </footer>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
     integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
   </script>
   <script src="script.js"></script>
 </body>

 </html>