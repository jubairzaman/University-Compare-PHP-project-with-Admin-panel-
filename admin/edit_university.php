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
      <title>Edit University</title>
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
        <?php
          $uni_id = $_GET['id'];

          $db = mysqli_connect("localhost", "root", "", "find_my_uni");
          $sql = "SELECT * FROM universities WHERE id = $uni_id";
          $result = mysqli_query($db, $sql);
          $row = mysqli_fetch_array($result);
          
          $uni_name = $row['name'];
          // loop each character of $row in span tag
          echo '<h1 class="heading">';
          foreach(str_split($row['name']) as $char) {
            echo '<span>'.$char.'</span>';
          }
          echo '</h1>';
        ?>
        <div class="form-container">
            <div style="margin-top: .5%; background: white;">
              <?php

                $sql = "SELECT COUNT(*) FROM recommendations WHERE university_id = ".$uni_id;
                $result = mysqli_query($db, $sql);
                $recommendations_all = mysqli_fetch_all($result, MYSQLI_ASSOC);
                $recommendations_all = $recommendations_all[0]['COUNT(*)'];

                // get all 1 value recommendations count for $university
                $sql = "SELECT COUNT(*) FROM recommendations WHERE university_id = ".$uni_id." AND recommended = 1";
                $result = mysqli_query($db, $sql);
                $recommendations_positive = mysqli_fetch_all($result, MYSQLI_ASSOC);
                $recommendations_positive = $recommendations_positive[0]['COUNT(*)'];

                // get all the courses of the university
                $sql = "SELECT * FROM university_with_courses WHERE university_id = $uni_id";
                $result = mysqli_query($db, $sql);
                $courses = mysqli_fetch_all($result, MYSQLI_ASSOC);

                // get individual course details
                $all_courses = array();
                foreach ($courses as $course) {
                  $sql = "SELECT * FROM courses WHERE id = ".$course['course_id'];
                  $result = mysqli_query($db, $sql);
                  $course_details = mysqli_fetch_all($result, MYSQLI_ASSOC);
                  $course_details = $course_details[0];
                  
                  array_push($all_courses, $course_details);
                }
              ?>
              <form action="../server.php" method="post">
                <div class="inputBox">
                  <label for="cname">Name</label>
                </div>
                <div class="inputBox">
                  <input class="box" type="text" value="<?php echo $row['name']; ?>" placeholder="Enter university name" name="uni_name" required />
                  <input type="hidden" value="<?php echo $row['id']; ?>" name="uni_id" required />
                </div>

                <div class="inputBox">
                  <label for="cname">Address</label>
                </div>
                <div class="inputBox">
                  <input class="box" type="text" value="<?php echo $row['address']; ?>" placeholder="Enter address" name="address" required />
                </div>

                <div class="inputBox">
                  <label for="cname">Total Credits</label>
                </div>
                <div class="inputBox">
                  <input class="box" type="number" value="<?php echo $row['total_credits']; ?>" placeholder="Enter total credit hours" id="hotelid" name="credit" required />
                </div>

                <div class="inputBox">
                  <label for="cname">Total Tution Fee</label>
                </div>
                <div class="inputBox">
                  <input class="box" type="number" value="<?php echo $row['total_tution']; ?>" placeholder="Enter total tution fee" id="hotelid" name="tution" required />
                </div>

                <div class="inputBox">
                  <label for="cname">Image URL</label>
                </div>
                <div class="inputBox">
                  <input class="box" type="url" value="<?php echo $row['image_url']; ?>" placeholder="Enter image url" id="hotelid" name="image_url" required />
                </div>

                <div class="inputBox">
                  <label for="cname"><?php foreach ($all_courses as $c) {
                    echo '<a href="../courses.php?id='.$c['id'].'" target="__blank">'.$c['name'].'</a> - ';
                  }  ?></label>
                </div>

                <div class="inputBox">
                  <label for="cname">Add More Courses...</label>
                </div>
                <div class="inputBox">
                  <select class="box" name="courses" title="Select Courses...">
                    <?php
                      $db = mysqli_connect("localhost", "root", "", "find_my_uni");

                      $sql = "SELECT * FROM courses";
                      $result = mysqli_query($db, $sql);
                      while($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                      }
                    ?>
                  </select>
                </div>

                <input type="submit" class="btn" name="edit_uni" value="Update"/>
              </form>
              <?php
                if (isset($_SESSION['logged_in']) == 1) {
                  // check if user has already recommendations this university
                  $sql = "SELECT * FROM recommendations WHERE user_id = ".$_SESSION['user_ids']." AND university_id = $uni_id";
                  $result = mysqli_query($db, $sql);
                  $row = mysqli_fetch_array($result);
                  if ($row) {
                    echo '<alert class="alert alert-info">You have given recommendation.</alert>';
                    echo '<br>';
                    echo '<br>';
                  }

                  echo '<form action="../server.php" method="post">
                    <input type="hidden" name="uni_id" value="'.$uni_id.'">
                    <button type="submit" class="btn" name="clear_recommendations">Clear Recommendations</button>
                  </form>';

                  echo '<form action="../server.php" method="post">
                    <input type="hidden" name="uni_id" value="'.$uni_id.'">
                    <button type="submit" class="btn" name="delete_uni">Delete '.$uni_name.'</button>
                  </form>';
                }

              ?>
            </div>
          </div>
      </div>
  </body>
</html>