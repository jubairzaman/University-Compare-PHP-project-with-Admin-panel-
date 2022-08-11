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
      <title>Credit Comparison</title>
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
          <span>m</span>
          <span>p</span>
          <span>a</span>
          <span>r</span>
          <span>i</span>
          <span>s</span>
          <span>i</span>
          <span>o</span>
          <span>n</span>
        </h1>
        <div class="box-container">
            <div style="background: white; font-size: 1.5rem; margin: 3%;">
              <?php
                $ids = $_GET['ids'];

                $db = mysqli_connect('localhost', 'root', '', 'find_my_uni');
                $sql = "SELECT * FROM universities WHERE id IN ($ids)";
                $result = mysqli_query($db, $sql);
                
                $i = 0;

                echo '<table class="table m-5">
                  <thead align="center">
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Name</th>
                      <th scope="col">Address</th>
                      <th scope="col">Special Courses</th>
                      <th scope="col">Total Credits</th>
                      <th scope="col">Total Tution Fees</th>
                    </tr>
                  </thead>
                  <tbody align="center">';

                while($row = mysqli_fetch_assoc($result)) {
                  $i++;
                  
                  // get all the courses of the university
                  $uni_sql = "SELECT * FROM university_with_courses WHERE university_id =" .$row["id"];
                  $uni_result = mysqli_query($db, $uni_sql);
                  $uni_courses = mysqli_fetch_all($uni_result, MYSQLI_ASSOC);

                  // get individual course details
                  $all_courses = array();
                  foreach ($uni_courses as $uni_course) {
                    $course_sql = "SELECT * FROM courses WHERE id = ".$uni_course['course_id'];
                    $course_result = mysqli_query($db, $course_sql);
                    $course_details = mysqli_fetch_all($course_result, MYSQLI_ASSOC);
                    $course_details = $course_details[0];
                    
                    array_push($all_courses, $course_details);
                  }

                  echo '<tr>
                        <th scope="row">'.$i.'</th>
                        <td>'.$row['name'].'</td>
                        <td>'.$row['address'].'</td>
                        <td>';

                        foreach ($all_courses as $c) {
                          echo '<a href="courses.php?id='.$c['id'].'" target="__blank"><strong>'.$c['name'].'</strong></a> - ';
                        }
                        echo '</td>
                        <td>'.$row['total_credits'].'</td>
                        <td>'.$row['total_tution'].'</td>
                      </tr>';
                }
                echo '</tbody>
                </table>';
              ?>
            </div>
        </div>
      </div>
  </body>
</html>