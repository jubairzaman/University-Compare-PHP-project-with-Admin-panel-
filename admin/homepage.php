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
      <title>Admin | Home</title>
  </head>
  <body>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
      <header>
        <div id="menu-bar" class="fas fa-bars"></div>
        <a href="homepage.php" class="logo"><span>Find My </span>University</a>

        <nav class="navbar">
          <a href="homepage.php">Home</a>
          <a href="../profile/profile.php">Profile</a>
          <a href="view_users.php">Users</a>
        </nav>

        <?php
          session_start();
          if($_SESSION['user_types'] != 'admin'){
              echo "<script>
              window.location.href='../index.php';
              alert('You do not have permission to view this page!');
            </script>";
            exit;
          }


          if(isset($_SESSION['logged_in']) == 1) {
            echo '<div class="icons">
                <form action="../server.php" method="post">
                  <button type="submit" class="btn" id="logout" name="logout">Logout</button>
                </form>
              </div>';
          } else {
            echo '<div class="icons">
                <i class="fas fa-user" id="login-btn"> <a href="../login.php">Login</a></i>
            </div>';
          }
        ?>
        
      </header>
      <div class="bg">
        <h1 class="heading">
          <span>u</span>
          <span>n</span>
          <span>i</span>
          <span>v</span>
          <span>e</span>
          <span>r</span>
          <span>s</span>
          <span>i</span>
          <span>t</span>
          <span>y</span>
        </h1>
        <div class="box-container" style="margin: 2.5%">
            <div style="margin-top: .5%; background: white;">
              <div align="center">
                <a class="btn" href="add_university.php">Add University</a>
              </div>
              <div align="center">
                <a class="btn" href="add_course.php">Add Course</a>
              </div>
              <br><br>
              <div class="card-group" style="padding:5%">
                  <?php
                    $db = mysqli_connect('localhost', 'root', '', 'find_my_uni');

                    // get all universities from universities table
                    $sql = "SELECT * FROM universities";
                    $result = mysqli_query($db, $sql);
                    $universities = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    // print all universities
                    foreach($universities as $university) {
                      // get all recommendations count for $university
                      $sql = "SELECT COUNT(*) FROM recommendations WHERE university_id = ".$university['id'];
                      $result = mysqli_query($db, $sql);
                      $recommendations_all = mysqli_fetch_all($result, MYSQLI_ASSOC);
                      $recommendations_all = $recommendations_all[0]['COUNT(*)'];

                      // get all 1 value recommendations count for $university
                      $sql = "SELECT COUNT(*) FROM recommendations WHERE university_id = ".$university['id']." AND recommended = 1";
                      $result = mysqli_query($db, $sql);
                      $recommendations_positive = mysqli_fetch_all($result, MYSQLI_ASSOC);
                      $recommendations_positive = $recommendations_positive[0]['COUNT(*)'];

                      echo '
                        <div class="card" style="width: 18rem;">
                          <img class="card-img-top" src="'.$university['image_url'].'" alt="'.$university['name'].'" width="50%" height="auto">
                          <div class="card-body">
                            <h1 class="card-text">'.$university['name'].'</h1>
                            <h3 class="card-text">Address: '.$university['address'].'</h3>
                            <strong class="card-text">Recommended by <span style="color: red;">'.$recommendations_positive.'</span> out of <span style="color: green;">'.$recommendations_all.'</span> student(s)</strong><br>
                            <a class="btn" href="edit_university.php?id='.$university['id'].'">View</a>
                          </div>
                        </div>
                        ';
                    }
                  ?>
                </div>
                <br><br>
                <div class="card-columns" style="padding: 5%;">
                  <?php
                    $sql = "SELECT * FROM courses";
                    $result = mysqli_query($db, $sql);
                    $resultCheck = mysqli_num_rows($result);

                    if($resultCheck > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                          echo '<div class="card p-3 text-white bg-info mb-3" style="width: 18rem;">                              
                            <div class="card-body">
                              <h1 class="card-title">'.$row['name'].'</h1>
                              <h3 class="card-text">Code: '.$row['code'].'</h3>
                              <p class="card-text">'.$row['description'].'</p>
                              <form action="../server.php" method="post">
                                <input type="hidden" value="'.$row["id"].'" name="c_id"/>
                                <button class="btn" type="submit" name="delete_course">Delete</button>
                              </form>
                            </div>
                          </div>';    
                        }
                    }
                  ?>
                </div>
            </div>
          </div>
        </div>
      </div>
  </body>
</html>