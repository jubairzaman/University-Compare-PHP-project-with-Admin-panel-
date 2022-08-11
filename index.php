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
      <title>Home</title>
  </head>
  <body>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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

        <div class="box-container w-75 mx-auto">
          <div class="content mx-auto w-75 border rounded-3" align="center" style="margin-top: .5%; margin-bottom: 5%; background: white;">
            <h1>Find Your University for Computer Science</h1>
            <p>Find your university to study Computer Science and get the best reviews</p>
            <div style="margin-bottom: 5px;">
              <form id="loginForm" method="post">
                <input class="searchInput" type="text" id="search-input" name="search" placeholder="Search" />
                <button type="submit" class="btn" name="uni_search">Search</button>
              </form>
            </div>
          </div>


          <div class="content" style="margin-top: 5%;">
            <div id="full_card">
              <div class="card-group">
                <?php
                  $db = mysqli_connect("localhost", "root", "", "find_my_uni");

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
                      <div class="card mx-3 rounded-3" style="width: 18rem; ">
                        <img class="card-img-top crdimg" src="'.$university['image_url'].'" alt="'.$university['name'].'" width="50%" height="200px">
                        <div class="card-body">
                          <h1 class="card-text">'.$university['name'].'</h1>
                          <h3 class="card-text">Address: '.$university['address'].'</h3>
                          <strong class="card-text">Recommended by <span style="color: red;">'.$recommendations_positive.'</span> out of <span style="color: green;">'.$recommendations_all.'</span> student(s)</strong><br>
                          
                          
                        </div>
                        <div class="mx-3">
                        <a class="btn" href="view_university.php?id='.$university['id'].'">View</a>
                        <button class="btn" id="uni_select" value="'.$university['id'].'" style="margin-left: 20px">Select</button>
                        </div>
                        
                      </div>
                      ';
                  }
                ?>
              </div>
            </div>
            <div align="center" class="pb-3" id="clear_button" style="display: none">
              <button class="btn">Clear (<strong id="uni_count">2</strong>)</button>
            </div>
            <div class="box" id="result" name="result">
          </div>
        </div>
      </div>
      <script src="js/index.js"></script>
  </body>
</html>

<script>
$(document).ready(function(){
	load_data();
	function load_data(query)
	{
		$.ajax({
			url:"fetch.php",
			method:"post",
			data:{query:query},
			success:function(data)
			{
				$('#result').html(data);
			}
		});
	}
	
	$('#search-input').keyup(function(){
		var search = $(this).val();
    let fullCard = document.getElementById('full_card');
		if(search != '')
		{
			load_data(search);
      fullCard.style.display = 'none';	
		}
		else
		{
			load_data();
      fullCard.style.display = 'block';	
		}
	});
});
</script>