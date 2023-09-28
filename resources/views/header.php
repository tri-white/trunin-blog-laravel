<?php 
session_start(); 
include("classes/connect.php");
include("classes/user.php");
?>

<header>
<nav class="navbar navbar-expand-sm navbar-light bg-light border-bottom border-2 border-primary">
        <div class="container">
          <a class="navbar-brand fs-3" href="index.php">Trunin Blog</a>
  
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
  
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto fs-5">
              <li class="nav-item mx-lg-2 mx-md-1 mx-sm-0">
                <a class="nav-link" href="index.php">Блог</a>
              </li>
              <li class="nav-item mx-lg-2 mx-md-1 mx-sm-0">
                <a class="nav-link" href="about.php">Про сайт</a>
              </li>
              <li class="nav-item mx-lg-2 mx-md-1 mx-sm-0 dropdown">
                <a class="nav-link dropdown-toggle pe-auto" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                  aria-expanded="false">
                    <?php if(isset($_SESSION['myblog_userid'])) : ?>
                      <?php 
                        $user = new User();
                        $user_data = $user->get_data($_SESSION['myblog_userid']);
                        echo $user_data['login'];
                        ?>
                    <?php else : ?>
                    Профіль
                    <?php endif; ?>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <?php if(isset($_SESSION['myblog_userid'])) : ?>

                    <li><a class="dropdown-item" href="profile.php?id=<?php echo $_SESSION['myblog_userid']?>">Мій профіль</a></li>
                    <li><a class="dropdown-item" href="logout.php">Вихід з профілю</a></li>
                  <?php else : ?>
                    <li><a class="dropdown-item" href="login.php">Авторизація</a></li>
                    <li><a class="dropdown-item" href="registration.php">Реєстрація</a></li>
                  <?php endif; ?>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </nav>
</header>
