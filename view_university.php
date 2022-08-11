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
      <title>University</title>
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
      <div class="bg">
        <?php
          $uni_id = $_GET['id'];

          $db = mysqli_connect("localhost", "root", "", "find_my_uni");
          $sql = "SELECT * FROM universities WHERE id = $uni_id";
          $result = mysqli_query($db, $sql);
          $row = mysqli_fetch_array($result);

          // loop each character of $row in span tag
          echo '<h1 class="heading">';
          foreach(str_split($row['name']) as $char) {
            echo '<span>'.$char.'</span>';
          }
          echo '</h1>';
        ?>
        <div class="form-container" style="margin: 0;">
            <div align="center" style="background: white; padding: 100px; font-size: 1.5rem;">
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

                // show university data in a table
                echo '<table class="table">
                  <tr>
                    <th>Name</th>
                    <td>'.$row['name'].'</td>
                  </tr>
                  <tr>
                    <th>Address</th>
                    <td>'.$row['address'].'</td>
                  </tr>
                  <tr>
                    <th>Total Tution</th>
                    <td>'.$row['total_tution'].'</td>
                  </tr>
                  <tr>
                    <th>Total Credits</th>
                    <td>'.$row['total_credits'].'</td>
                  </tr>
                  <tr>
                    <th>Special Courses</th>
                    <td>';

                  foreach ($all_courses as $c) {
                    echo '<a href="courses.php?id='.$c['id'].'" target="__blank">'.$c['name'].'</a> ';
                  }
                    
                   echo '</td>
                  </tr>
                  <tr>
                    <th>Rating</th>
                    <td class="card-text">Recommended by <span style="color: red;">'.$recommendations_positive.'</span> out of <span style="color: green;">'.$recommendations_all.'</span> student(s)</td>
                  </tr>
                </table>';
              ?>

              <?php
                if (isset($_SESSION['logged_in']) == 1) {
                  // check if user has already recommendations this university
                  $sql = "SELECT * FROM recommendations WHERE user_id = ".$_SESSION['user_ids']." AND university_id = $uni_id";
                  $result = mysqli_query($db, $sql);
                  $row = mysqli_fetch_array($result);
                  echo '<br>';
                  echo '<br>';
                  if ($row) {
                    echo '<alert class="alert alert-info">You have given recommendation.</alert>';
                    echo '<br>';
                    echo '<br>';
                  }

                  echo '<h2>Add Recommendation</h2>';
                  echo '<form id="loginForm" action="server.php" method="post">
                    <input class="box" type="hidden" name="uni_id" value="'.$uni_id.'">
                    <select class="box" name="recommendation">
                      <option value="1">Yes</option>
                      <option value="0">No</option>
                    </select>
                    <button type="submit" class="btn" name="add_rating">Submit</button>
                  </form>';
                }

              ?>
            </div>
          </div>
        </div>
      </div>
  </body>
</html>