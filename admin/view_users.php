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
      <title>Admin | Users</title>
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
          <span>a</span>
          <span>l</span>
          <span>l</span>
          <span class="space"></span>
          <span>u</span>
          <span>s</span>
          <span>e</span>
          <span>r</span>
          <span>s</span>
        </h1>
        <div class="box-container">
            <div style="background: white; font-size: 1.5rem; margin: 2%;">
              <?php
                $db = mysqli_connect('localhost', 'root', '', 'find_my_uni');

                $sql = "SELECT * FROM users";
                $result = mysqli_query($db, $sql);
                $resultCheck = mysqli_num_rows($result);
                if($resultCheck > 0) {
                  echo '<table class="table">
                    <thead align="center">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Admin</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody align="center">';
                  $i = 0;
                  while($row = mysqli_fetch_assoc($result)) {
                    // show users in a table
                    if ($row["id"] != $_SESSION["user_ids"]) {
                    $i++;
                    echo '
                      <tr>
                        <td>'.$i.'</td>
                        <td>'.$row['first_name'].'</td>
                        <td>'.$row['last_name'].'</td>
                        <td>'.$row['email'].'</td>
                        <td>';
                        if ($row['user_type'] == 'admin') {
                          echo '<i class="fas fa-check"></i>';
                        } else {
                          echo '<i class="fas fa-times"></i>';
                        }
                        echo '</td>
                        <td><form action="../server.php" method="post">
                          <input type="hidden" name="user_id" value="'.$row['id'].'">
                          <button type="submit" style="padding: 5px" class="btn-danger" name="delete_user">Delete</button>
                        </form></td>
                      </tr>';
                    }
                  }

                  echo '
                      </tbody>
                    </table>';
                }
              ?>
            </div>
          </div>
        </div>
      </div>
  </body>
</html>