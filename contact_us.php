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
      <title>Contact Us</title>
  </head>
  <body>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
      <header>
        <div id="menu-bar" class="fas fa-bars"></div>
        <a href="index.php" class="logo"><span>Find My </span>University</a>

        <nav class="navbar">
          <a href="index.php">Home</a>
          <a href="profile/profile.php">Profile</a>
          <a href="contact_us.php">contact</a>
        </nav>

        <?php
          session_start();
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
          <span>c</span>
          <span>o</span>
          <span>n</span>
          <span>t</span>
          <span>a</span>
          <span>c</span>
          <span>t</span>

        <div class="box-container">
          <div class="box">
            <div class="content" style="margin-top: .5%; background: white;">
              <div class="card-group">
                <div class="card" style="width: 18rem;">
                  <img class="card-img-top" src="https://images.unsplash.com/photo-1659976400255-d5cca2c2234a?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=764&q=80" alt="Tajul Islam Sumon">
                  <div class="card-body">
                    <h1 class="card-text">Tajul Islam Sumon</h1>
                    <h3 class="card-text">NSU ID: 1721135642</h3>
                    <a class="btn btn-info" href="#" target="_blank" rel="noopener noreferrer">Facebook</a>
                    <a class="btn btn-info" href="#" target="_blank" rel="noopener noreferrer">LinkedIn</a>
                  </div>
                </div>
                <div class="card" style="width: 18rem;">
                  <img class="card-img-top" src="https://images.unsplash.com/photo-1659976400255-d5cca2c2234a?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=764&q=80" alt="Jubair Ibn Zaman">
                  <div class="card-body">
                    <h1 class="card-text">Jubair Ibn Zaman</h1>
                    <h3 class="card-text">NSU ID: 1711981642</h3>
                    <a class="btn btn-info" href="#" target="_blank" rel="noopener noreferrer">Facebook</a>
                    <a class="btn btn-info" href="#" target="_blank" rel="noopener noreferrer">LinkedIn</a>
                  </div>
                </div>
                <div class="card" style="width: 18rem;">
                  <img class="card-img-top" src="https://images.unsplash.com/photo-1659976400255-d5cca2c2234a?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=764&q=80" alt="Adnan Zaedi Nirjan">
                  <div class="card-body">
                    <h1 class="card-text">Adnan Zaedi Nirjan</h1>
                    <h3 class="card-text">NSU ID: 1731089642</h3>
                    <a class="btn btn-info" href="#" target="_blank" rel="noopener noreferrer">Facebook</a>
                    <a class="btn btn-info" href="#" target="_blank" rel="noopener noreferrer">LinkedIn</a>
                  </div>
                </div>
                <div class="card" style="width: 18rem;">
                  <img class="card-img-top" src="https://images.unsplash.com/photo-1659976400255-d5cca2c2234a?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=764&q=80" alt="Adit Hossain">
                  <div class="card-body">
                    <h1 class="card-text">Adit Hossain</h1>
                    <h3 class="card-text">NSU ID: 1813612042</h3>
                    <a class="btn btn-info" href="#" target="_blank" rel="noopener noreferrer">Facebook</a>
                    <a class="btn btn-info" href="#" target="_blank" rel="noopener noreferrer">LinkedIn</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <h3>Nice</h3>
      </div>
  </body>
</html>