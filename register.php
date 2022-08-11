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
      
      <link rel="stylesheet" type="text/css" href="style.css" />
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
      <title>Register</title>
  </head>
  <body>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
      <?php
          session_start();
          if($_SESSION['user_ids']!=null){
              echo "<script>
              window.location.href='index.php';
              alert('You are logged in!');
            </script>";
            exit;
          }
        ?>
      <header>
        <div id="menu-bar" class="fas fa-bars"></div>
        <a href="index.php" class="logo"><span>Find My </span>University</a>

        <nav class="navbar">
          <a href="index.php">Home</a>
          <a href="profile/profile.php">Profile</a>
          <a href="review.php">review</a>
          <a href="contact_us.php">contact</a>
        </nav>

      </header>
      <div class="bg">
        <div class="form-container">
            <div class="content" style="margin-top: 10%; background: white;">
                <form action="server.php" method="post">
                    <label for="username"><b>First Name</b></label>
                    <input class="box" type="text" name="first_name" placeholder="Enter your first name" required>
                    <label for="username"><b>Last Name</b></label>
                    <input class="box" type="text" name="last_name" placeholder="Enter your last name" required>
                    <label for="username"><b>Email</b></label>
                    <input class="box" type="email" name="user_email" placeholder="Enter your email" required>
                    <label for="username"><b>Password</b></label>
                    <input class="box" type="password" name="user_password" placeholder="Enter your password" required>
                    <button type="submit" class="btn" name="register">Register</button>
                    <span class="psw">
                        <a href="login.php">Login Here</a>
                    </span>
                </form>

            </div>
          </div>
        </div>
      </div>
  </body>
</html>