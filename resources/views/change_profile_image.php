<?php
  session_start();

  include("classes/connect.php");
  include("classes/login.php");
  include("classes/user.php");
  include("classes/image.php");


  // check if user is logged in
  if(isset($_SESSION['myblog_userid']) && is_numeric($_SESSION['myblog_userid'])){
    $id = $_SESSION['myblog_userid'];
    $login = new Login();
    $res = $login->check_login($id);
    if($res == false){
      header("Location: login.php");
      die;
    }
  }
  else{
    header("Location: login.php");
    die;
  }

                    $user = new User();
                    $userid = $_SESSION['myblog_userid'];
					$user_data = $user->get_data($userid);

	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
 
		if(isset($_FILES['profile-image']['name']) && $_FILES['profile-image']['name'] != "")
		{
 
			if($_FILES['profile-image']['type'] == "image/jpeg")
			{

				$allowed_size = (1024 * 1024) * 7;
				if($_FILES['profile-image']['size'] < $allowed_size)
				{
					//everything is fine
					$folder = "uploads/" . $user_data['userid'] . "/";

					//create folder
					if(!file_exists($folder))
					{

						mkdir($folder,0777,true);
					}

					$image = new Image();

					$filename = $folder . $image->generate_filename(15) . ".jpg";
					move_uploaded_file($_FILES['profile-image']['tmp_name'], $filename);

					


						if(file_exists($user_data['photo']))
						{
							unlink($user_data['photo']);
						}

					if(file_exists($filename))
					{

						$userid = $user_data['userid'];

							$query = "update users set photo = '$filename' where userid = '$userid' limit 1";

						$DB = new Database();
						$DB->write($query);

						header(("Location: profile.php"));
						die;
					}


				}else
				{

					echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey;'>";
					echo "<br>The following errors occured:<br><br>";
					echo "Only images of size 3Mb or lower are allowed!";
					echo "</div>";

				}
			}else
			{

				echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey;'>";
				echo "<br>The following errors occured:<br><br>";
				echo "Only images of Jpeg type are allowed!";
				echo "</div>";

			}

		}else
		{
			echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey;'>";
			echo "<br>The following errors occured:<br><br>";
			echo "please add a valid image!";
			echo "</div>";
		}
		
	}
?>