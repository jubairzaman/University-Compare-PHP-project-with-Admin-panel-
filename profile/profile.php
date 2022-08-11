<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon" />
      <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />

      <link
        rel="stylesheet"
        href="https://unpkg.com/swiper/swiper-bundle.min.css"
      />
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous" />
      <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
      />
      
      <link rel="stylesheet" type="text/css" href="../style.css" />
      <style>
        /* Always set the map height explicitly to define the size of the div
        * element that contains the map. */
        #map {
          height: 100%;
        }
        /* Optional: Makes the sample page fill the window. */
        html, body {
          height: 100%;
          margin: 0;
          padding: 0;
        }
      </style>
      <title>Profile</title>
  </head>
  <body>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
      <header>
        <div id="menu-bar" class="fas fa-bars"></div>
        <a href="index.php" class="logo"><span>Find My </span>University</a>


        <?php
          session_start();

          if($_SESSION['user_ids']==null){
            echo "<script>
            window.location.href='../login.php';
            alert('Please, login first!');
            </script>";
            exit;
          }
          
          if($_SESSION['user_types'] == 'admin'){
            echo '<nav class="navbar">
              <a href="../admin/homepage.php">Home</a>
              <a href="../profile/profile.php">Profile</a>
              <a href="../profile/edit_profile.php">Edit Profile</a>
              <a href="../profile/change_password.php">Change Password</a>
            </nav>';
          } else {
            echo '<nav class="navbar">
              <a href="../index.php">Home</a>
              <a href="profile.php">Profile</a>
              <a href="edit_profile.php">Edit Profile</a>
              <a href="change_password.php">Change Password</a>
              <a href="../contact_us.php">contact</a>
            </nav>';
          }

          if(isset($_SESSION['logged_in']) == 1) {
            echo '<div class="icons">
                <form action="server.php" method="post">
                  <button type="submit" class="btn" id="logout" name="logout">Logout</button>
                </form>
              </div>';
          } else {
            echo '<div class="icons">
                <i class="fas fa-user" id="login-btn"> <a href="login.php">Login</a></i>
            </div>';
          }
        ?>
        
      </header>
      <div class="bgh">
        <h1 class="heading">
          <span>p</span>
          <span>r</span>
          <span>o</span>
          <span>f</span>
          <span>i</span>
          <span>l</span>
          <span>e</span>
        </h1>
        <div class="box-container">
          <div class=' w-75 mx-auto border ' style="margin-top: .5%; background: white;">
            <?php
              $db = mysqli_connect('localhost','root','','find_my_uni');
              $user_id1 = $_SESSION['user_ids'];
              $user_id1 = stripcslashes($user_id1);

              $sqlp = "SELECT * FROM users WHERE id='$user_id1'";
              $resp = mysqli_query($db,$sqlp);
              $rowp = mysqli_fetch_array($resp);

              ?>

              <div align="center" style="font-size: 1.5rem;">
                <div>
                  <label for="fname"><b>First Name: </b></label><?php echo $rowp['first_name'];?>
                  <label><b> </b><br></label>
                </div>
                <br>
                <div id="line">
                  <label for="lname"><b>Last Name: </b> <?php echo $rowp['last_name'];?><br> </label>
                  <label><b> </b><br></label>
                </div>
                <br>
                <div>
                  <label for="email"><b>Email: </b> <?php echo $rowp['email'];?><br> </label>
                  <label><b> </b><br></label>
                </div>
              </div>
          </div>
        </div>
      </div>
  </body>
</html>