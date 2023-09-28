
<?php
  session_start();

  include("classes/connect.php");
  include("classes/login.php");

  $login = "";
  $pass = "";
  if($_SERVER['REQUEST_METHOD']=='POST'){
    $logining = new Login();
    $res = $logining->evaluate($_POST);
    if($res != ""){
      echo "<div class='container text-center bg-danger my-2 py-2 text-light'>";
      echo $res;
      echo "</div>";
    }
    else{
        
      header("Location: profile.php?id=" . urlencode($_SESSION['myblog_userid']));

        die;
    }

    $login = $_POST['login'];
    $pass = $_POST['password'];
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
    <div class="profile-form container mt-5">
        <div class="row justify-content-center">
          <div class="col-lg-6">
            <h1 class="mb-4 text-center">Авторизація</h1>
            <form method="post" action=""  autocomplete="off">
              <div class="mb-3">
                <label for="loginInput" class="form-label">Логін</label>
                <input value="<?php echo $login ?>" name = "login" type="text" class="form-control" id="loginInput" required>
              </div>
              <div class="mb-3">
                <label for="passwordInput" class="form-label">Пароль</label>
                <input value="<?php echo $pass ?>" name="password" type="password" class="form-control" id="passwordInput" required>
              </div>
              <div class="text-center mt-5">
                <button type="submit" class="fs-4 px-4 btn btn-dark">Увійти</button>
              </div>
            </form>
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