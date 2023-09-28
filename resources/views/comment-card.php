<?php
?>
<div class="card mt-2">
                   
                  <div class="card-body">
                  <a href="profile.php?id=<?php echo $row_user['userid']; ?>" class="text-decoration-none link-dark">
                  <div class="other d-flex align-items-center">
                    <div class="img-container d-flex" style="height:35px; width:35px;">
                      <img src=
                      "<?php 
                      if($row_user['photo']==NULL){
                        echo "images/user_male.jpg";
                      }
                      else{
                        echo $row_user['photo'];
                      }
                      ?>"
                       style="width:100%; height:100%; object-fit: contain;" class="rounded-circle border border-1 border-dark" alt="Profile Picture">
                    </div>
                     <div class="ms-2">
                        <p class="fs-6 m-0"><?php echo $row_user['login']; ?></p>
                        <p class="card-text my-auto text-muted fs-6"><?php echo $row_comm['date']; ?></p>
                    </div>
                  </div>
                  </a> 
                    <p class="card-text mt-2 comment-text fs-7 mb-0 text-wrap"><?php echo $row_comm['description'] ?></p>
                    <div class="footer-comment align-items-center d-flex justify-content-end align-items-center">
                      <?php if($admin==1) :?>
                        <a class="my-auto me-4 link-dark" href="remove-comment.php?commid=<?php echo $row_comm['commid']; ?>">
                        <i class="fa fa-trash-can"></i>
                      </a>
                      <?php endif; ?>
                    </div>
                      
                    <!--
                    <p class="my-auto me-2"> 0 </p>
                      <button class="btn btn-outline-primary" id="like-button">
                        <i class="fa fa-thumbs-up"></i>
                      </button>
                    </div> 
                    -->
                    
                    
                  </div>
                </div>