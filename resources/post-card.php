
 <!-- POST -->
 <div class="card mb-5">
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
     <a href="post-card_details.php?postid=<?php echo $row_post['postid']; ?>" class="text-decoration-none link-dark">
       <p class="card-text"><?php 
                echo "<pre class='fs-5' style='white-space: pre-wrap; text-align: justify; '>";
                echo $row_post['description'];
                echo "</pre>"; 
              ?></p>
       <?php if($row_post['photo']!=NULL) :?>
       <img src="<?php echo $row_post['photo']; ?>" class="card-img-top border border-1 border-dark"
         alt="Image Content">
       <?php endif; ?>
     </a>
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
           <a href="login.php" class="btn btn-outline-danger" id="like-button">
             <i class="fa fa-heart"></i>
           </a>
           <?php else: ?>
           <?php if($like==false) : ?>
           <a href="like.php?userid=<?php echo $_SESSION['myblog_userid']; ?>&postid=<?php echo $row_post['postid']; ?>"
             class="btn btn-outline-danger" id="like-button">
             <i class="fa fa-heart"></i>
           </a>
           <?php else : ?>
           <a href="like.php?userid=<?php echo $_SESSION['myblog_userid']; ?>&postid=<?php echo $row_post['postid']; ?>"
             class="btn btn-danger" id="like-button">
             <i class="fa fa-heart"></i>
           </a>
           <?php endif; ?>
           <?php endif; ?>

         </div>

       </div>

     </div>

   </div>

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
       <?php if($comm_count!=false && $comm_count[0]['COUNT(*)']>2) :?>
       <div class="col-12 mt-4">
         <a href="post-card_details.php?postid=<?php echo $row_post['postid']; ?>"
           class="text-decoration-none link-dark text-light py-2">
           <div class="container-fluid bg-primary text-center">

             <p>
             Переглянути ще <?php echo $comm_count[0]['COUNT(*)']-2 ?> комментарів
             </p>

           </div>
         </a>

       </div>

       <?php endif; ?>
     </li>
   </ul>
   <!-- END POST COMMENTS -->

   <!-- YOUR COMMENT -->
   <?php if(isset($_SESSION['myblog_userid'])) : ?>
   <div class="card-body">
     <form method="POST" action="" autocomplete="off">
       <div class="input-group align-items-center">
         <input type="hidden" name="post_id" value="<?php echo $row['postid']; ?>">
         <input name="description" type="text" class="form-control" placeholder="Ваш коментар"
           aria-label="Add a comment" aria-describedby="comment-button">
         <button class="btn btn-primary" type="submit" id="comment-button">Додати коментар</button>
       </div>
     </form>
   </div>
   <?php endif; ?>
   <!-- END YOUR COMMENT -->
 </div>
 <!-- POST END -->