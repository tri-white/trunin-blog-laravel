<?php
  session_start();
  include("classes/connect.php");
  include("classes/post.php");
  include("classes/user.php");
  include("classes/image.php");
  include("classes/comment.php");
  include("classes/post_like.php");

  
$admin = 0;
$like = false;
  $post = new Post();
  $categories = $post->get_categories();
  //collect all posts in array to output it later
  $key="";
  $cat="all";
      $sort="date-desc";
      $posts = $post->get_posts($key,$cat,$sort);
  if($posts==false){
    echo "<div class='container text-center bg-danger my-2 py-2 text-light'>";
    echo "Не вдалося вивести пости з бази даних. Можливо відсутнє з'єднання";
    echo "</div>";
  }

  if(isset($_SESSION['myblog_userid'])){
    $user = new User();
    $us_data = $user->get_data($_SESSION['myblog_userid']);
    $admin = $us_data['admin'];
  }
      

  if($_SERVER['REQUEST_METHOD']=="POST"){

    if(isset($_POST['search-input-key'])){
        //collect all posts in array to output it later
        $key = $_POST['search-input-key'];
        $cat = $_POST['post-category-filter'];
        $sort = $_POST['post-sort'];
        $posts = $post->get_posts($key,$cat,$sort);
    }
    else if(isset($_POST['description'])){
      $comm = new Comment();
      $userid = $_SESSION['myblog_userid'];
      $res = $comm->create_comment($userid, $_POST);
      if($res!= ""){
        echo "<div class='container text-center bg-danger my-2 py-2 text-light'>";
        echo $res;
        echo "</div>";
      }else{
        header("Location: index.php");
        die;
      }

      

    }
    else{
      $post_created = $post->create_post($_POST, $_SESSION['myblog_userid'], $_FILES);
      if($post_created != ""){
        echo "<div class='container text-center bg-danger my-2 py-2 text-light'>";
        echo $res;
        echo "</div>";
      }else{
        header("Location: index.php");
        die;
      }
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

    <!-- CREATE POST -->
    <?php if(isset($_SESSION['myblog_userid'])) : ?>
    <div class="container mt-5">
      <div class="row d-flex justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-12">
          <form method="post" action="" enctype="multipart/form-data">
            <textarea name="post-description" class="form-control" id="contentInput" rows="5" required
              placeholder="Що у вас нового?"></textarea>

            <div class="row d-flex">
              <div class="col-lg-4 col-md-6 col-sm-12 mt-1">
                <select name="post-category" class="form-select" aria-label="Категорія" style="width:100%;">
                  <option value="no">Без категорії</option>
                  <?php foreach ($categories as $category): ?>
                  <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-lg-4 col-md-6 col-sm-12 mt-1">
                <label for="inputField" class="btn btn-light border border-1 border-dark my-auto"
                  style="width:100%;">Завантажити фото</label>
                <input name="post-image" type="file" id="inputField" style="display:none">
              </div>
              <div class="col-lg-4 col-md-12 col-sm-12 mt-1">
                <button type="submit" class="btn btn-outline-primary" style="width:100%;">Опублікувати</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <?php endif; ?>

    <!-- POSTS SECTION-->
    <div class="container mt-5">
    <div class="mb-2 mt-5 col-lg-12 text-center display-5">
          Пошук
        </div>
      <div class="col-lg-8 col-md-10 col-sm-12 mx-auto align-items-center">
        <!-- Search bar -->
        <div class="row d-flex justify-content-center">
          <div class="col-lg-8 col-md-10 col-sm-12 text-center">
            <form method="post" action="">
              <div class="input-group">
                <input value="<?php echo $key; ?>" name="search-input-key" type="search" class="px-3 form-control" placeholder="Пошук..."
                  aria-label="Search" aria-describedby="search-addon" />
                <button type="submit" class="btn btn-outline-dark">Знайти</button>
              </div>
              <div class="d-flex justify-content-between mb-2 mt-2">
                <div class="col-lg-6">
                  <select id="post-category-filter" name="post-category-filter" class="form-select"
                    aria-label="Категорія" style="width:100%;">
                    <option value="all" <?php if ($cat == 'all') echo ' selected'; ?>>Всі категорії</option>
                    <option value="no" <?php if ($cat == 'no') echo ' selected'; ?>>Без категорії</option>
                    <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category; ?>" <?php if ($cat == $category) echo ' selected'; ?>>
                      <?php echo $category; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-lg-6">
                  <select id="post-sort" name="post-sort" class="form-select" aria-label="Категорія"
                    style="width:100%;">
                    <option value="date-desc" <?php if ($sort == 'date-desc') echo ' selected'; ?>>По даті (↓)</option>
                    <option value="date-asc" <?php if ($sort == 'date-asc') echo ' selected'; ?>>По даті (↑)</option>
                    <option value="like-desc" <?php if ($sort == 'like-desc') echo ' selected'; ?>>По вподобайкам (↓)
                    </option>
                    <option value="like-asc" <?php if ($sort == 'like-asc') echo ' selected'; ?>>По вподобайкам (↑)
                    </option>
                    <option value="comm-desc" <?php if ($sort == 'comm-desc') echo ' selected'; ?>>По комментарям (↓)
                    </option>
                    <option value="comm-asc" <?php if ($sort == 'comm-asc') echo ' selected'; ?>>По комментарям (↑)
                    </option>
                  </select>
                  </div>
                </div>
          </div>
          </form>

        </div>

        <div class="mb-5 mt-5 col-lg-12 text-center display-2">
          Пости
        </div>
        <div class="row d-flex justify-content-center">
          <div class="col-lg-8 col-md-10 col-sm-12">

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
                  include("post-card.php");
                }
              }
              
                        

              ?>
          </div>

        </div>
      </div>
    </div>
  </main>

  <footer>

  </footer>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" integrity="sha512-XXX"
    crossorigin="anonymous"></script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
  </script>
  <script src="script.js"></script>
</body>

</html>