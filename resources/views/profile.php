<?php
  session_start();

  include("classes/connect.php");
  include("classes/login.php");
  include("classes/user.php");
  include("classes/post.php");
  include("classes/comment.php");
  include("classes/post_like.php");
  
$admin=0;
if(isset($_SESSION['myblog_userid'])){
  $user = new User();
  $us_data = $user->get_data($_SESSION['myblog_userid']);
  $admin = $us_data['admin'];
}

  if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id = $_GET['id'];

      $user = new User();
      $user_data = $user->get_data($id);
      if(!$user_data){
        header("Location: index.php");
        die;
      }
      $post = new User();
      $offset = 0;
      $posts = $post->get_posts($user_data['userid'], $offset);
    }
    else{
      if(isset($_SESSION['myblog_userid'])){
         $_GET['id'] = $_SESSION['myblog_userid'];
         $id = $_GET['id'];

         $user = new User();
         $user_data = $user->get_data($id);
         if(!$user_data){
           header("Location: index.php");
           die;
         }
         $post = new User();
   
         $offset = 0;
         $posts = $post->get_posts($user_data['userid'], $offset);
       }
      }
     
  

?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Insanity Blog</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  </head>
<body>
  <header>
  </header>
  
  <main>
    <div class="container mt-5">
      <div class="row">
        <div class="col-lg-12">
          <div class="profile-image mx-auto" style="height:150px; width:150px;">
              <img src="
              <?php 
                      if($user_data['photo']==NULL){
                        echo "images/user_male.jpg";
                      } 
                      else{
                        echo $user_data['photo'];
                      }
                      ?>
              " style="width:100%; height:100%; object-fit: contain;" class="rounded-circle border border-1 border-dark" alt="Profile Picture">
          </div>
          
          <?php if(isset($_SESSION['myblog_userid']) && $_SESSION['myblog_userid']==$_GET['id']) : ?>
          <form action="change_profile_image.php" method="POST" enctype="multipart/form-data">
            <div class="col-lg-12 my-2 align-items-center text-center">
              <label for="inputField" class="text-muted text-decoration-underline" style="cursor:pointer;">Змінити фотографію профілю</label>
              <input name="profile-image" type="file" id="inputField" style="display:none">
              <button class="ms-2" type="submit">Зберегти фото</button>
            </div> 
          </form>
          <?php endif; ?>
          
          


          <div class="profile-info text-center mt-2">
            <h5><?php echo $user_data['login'] ?></h5>
            <?php if($admin==1 && $_SESSION['myblog_userid']!=$_GET['id']) :?>
                        <a class="my-auto me-4 link-dark" href="remove_profile.php?profileid=<?php echo $user_data['userid']; ?>">
                        <i class="fa fa-trash-can"></i>
                      </a>
                      <?php endif; ?>
          </div>

          <div class="profile-posts">
                  <h1> <?php echo $user_data['description'] ?></h1>
                </div>
        </div>
       
      </div>

        <div class="row">
            <div class="col-lg-12">
              <div class="container mt-5">
                <div class="row d-flex justify-content-center">
                    <div class="mb-3 col-lg-12 text-center display-2">
                      Пости
                    </div>
                  <div class="col-lg-6 col-md-8 col-sm-12">
                      <?php 
                        if(is_bool($posts)){
                          echo "<div class='mb-5 text-muted col-lg-12 text-center display-4'>";
                          echo   "Не знайдено постів";
                          echo "</div>";
                        }
                        else{
                        foreach ($posts as $row) {
                          $user_class = new User();
                          $post_class = new Post();
                          $row_user = $user_class->get_data($row['userid']);
                          $row_post = $post_class->get_data($row['postid']);
                          include("post-card_profile.php");
                        }
                      }
                                  
                      
                      ?>
                  </div>
                </div>
              </div>
            </div>
      </div>
    </div>
  </main>
  
  <footer>

  </footer>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="script.js"></script>
</body>
</html>