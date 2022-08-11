<?php
    session_start();

    $db = mysqli_connect('localhost','root','','find_my_uni');

    //Login for users
    if(isset($_POST['login'])){
        $user_email = $_POST['user_email'];
        $bpassword = $_POST['user_password'];
        $password = md5($bpassword);

        $user_email = stripcslashes($user_email);
        $password = stripcslashes($password);
        $sql = "SELECT * FROM users WHERE email='$user_email' AND password='$password'";
        $res = mysqli_query($db,$sql);
        
        if($res->num_rows > 0){
            $row = mysqli_fetch_array($res);
            $_SESSION['logged_in']='1';
            $_SESSION['user_ids']= $row['id'];
            $_SESSION['user_types']= $row['user_type'];
            

            if(empty($_POST["remember"])) {  
                if(isset($_COOKIE["user_email"])) {  
                    setcookie ("user_email","", time() - 3600);  
                }  
                if(isset($_COOKIE["password"])) {  
                    setcookie ("password","", time() - 3600);  
                }  
            }  
            else {  
                setcookie ("user_email",$user_email,time()+ (7 * 24 * 60 * 60),"/");  
                setcookie ("password",$bpassword,time()+ (7 * 24 * 60 * 60),"/");
            }
            if ($row['user_type'] == 'admin'){
                echo "<script>
                    window.location.href='admin/homepage.php';
                </script>";
            }
            else{
                echo "<script>
                    window.location.href='index.php';
                </script>";
            }
            exit;
        }
        else{
            $_SESSION['logged_in']='0';
            echo "<script>
                    window.location.href='login.php';
                    alert('email or password is incorrect');
                    </script>";
        }
    }

    //Register
    if(isset($_POST['register'])){
        $fname = $_POST["first_name"];
        $lname = $_POST["last_name"];
        $email = $_POST["user_email"];
        $spassword = md5($_POST["user_password"]);


        $fname = stripcslashes($fname);
        $lname = stripcslashes($lname);
        $email = stripcslashes($email);
        $spassword = stripcslashes($spassword);
        
        $ssql = "SELECT * FROM users WHERE email='$email'";
        $sres = mysqli_query($db,$ssql);
        $sdel = mysqli_num_rows($sres);
        if($sdel>0){
            echo "<script>
            window.location.href='register.php';
            alert('email is already taken');
        </script>";
        }else{
            $ssql = "INSERT INTO users (first_name, last_name, user_type, email, password) VALUES ('$fname','$lname', 'user', '$email','$spassword')";
            if (mysqli_query($db, $ssql)){
                echo "<script>
                window.location.href='login.php';
                alert('Registration Done! Now,Please Login');
            </script>";
            exit;
            } 
            else {
                echo "error!".mysqli_error($db);
            }
        }
    }

    //Logout for users
    if(isset($_POST['logout'])){

    
    session_unset();

    session_destroy();
        echo "<script>
                window.location.href='login.php';
                alert('Logged out');
            </script>";
    }

    //User Update
    if(isset($_POST['update_profile'])){
        $fname = $_POST["first_name"];
        $lname = $_POST["last_name"];
        $email = $_POST["user_email"];
        $user_id = $_SESSION['user_ids'];

        $user_id = stripcslashes($user_id);
        $fname = stripcslashes($fname);
        $lname = stripcslashes($lname);
        $email = stripcslashes($email);

        $query="UPDATE users SET first_name = '$fname', last_name = '$lname', email = '$email' WHERE id='$user_id'";
        $query_run=mysqli_query($db,$query);

        if($query_run) {
            echo "<script>
                window.location.href='profile/profile.php';
                alert('Data is updated');
            </script>";
        } else {  echo "<script>
                window.location.href='profile/editprofiletwo.php';
                alert('Data is not updated');
            </script>";
        }
    }

    //Change Password
    if(isset($_POST['cpassb'])){
        $cpass = md5($_POST["cpass"]);
        $user_id = $_SESSION['user_ids'];

        $user_id = stripcslashes($user_id);
        $cpass= stripcslashes($cpass);

        $query="UPDATE users SET password = '$cpass' WHERE id='$user_id'";
        $query_run=mysqli_query($db,$query);

        if($query_run) {
            echo "<script>
                window.location.href='profile/profile.php';
                alert('password is updated');
            </script>";
        } else {  echo "<script>
                window.location.href='profile/changepassword.php';
                alert('password is not updated');
            </script>";
        }
        
    }

    //Add Rating
    if(isset($_POST['add_rating'])){
        $recommendation = $_POST["recommendation"];
        $uni_id = $_POST["uni_id"];
        $user_id = $_SESSION['user_ids'];

        // check if the user has already rated the university
        $query="SELECT * FROM recommendations WHERE user_id='$user_id' AND university_id='$uni_id'";
        $query_run=mysqli_query($db,$query);
        $num_rows = mysqli_num_rows($query_run);
        if($num_rows > 0){
            // delete the rating
            $query="DELETE FROM recommendations WHERE user_id='$user_id' AND university_id='$uni_id'";
            $query_run=mysqli_query($db,$query);

            if($query_run) {
                echo "<script>
                    window.location.href='view_university.php?id=$uni_id';
                    alert('Rating is deleted');
                </script>";
                exit;
            } else {
                echo "error!".mysqli_error($db);
            }
        } else {
            $query="INSERT INTO recommendations (user_id, university_id, recommended) VALUES ('$user_id', '$uni_id', '$recommendation')";
            $query_run=mysqli_query($db,$query);
            if($query_run) {
                echo "<script>
                    window.location.href='view_university.php?id=$uni_id';
                    alert('Rating is added');
                </script>";
                exit;
            } else {
                echo "error!".mysqli_error($db);
            }
        }
    }


    //Add University
    if (isset($_POST['add_uni'])){
        $uni_name = $_POST["uni_name"];
        $uni_address = $_POST["address"];
        $total_credits = $_POST["credit"];
        $total_tution = $_POST["tution"];
        $image_url = $_POST["image_url"];

        $uni_name = stripcslashes($uni_name);
        $uni_address = stripcslashes($uni_address);
        $total_credits = stripcslashes($total_credits);
        $total_tution = stripcslashes($total_tution);
        $image_url = stripcslashes($image_url);

        $courses_ids = $_POST["courses"];
        // convert courses_ids to array
        $courses_ids = explode(',', $courses_ids);

        $sql = "INSERT INTO universities (name, address, total_credits, total_tution, image_url) VALUES ('$uni_name','$uni_address','$total_credits','$total_tution','$image_url')";
        $res = mysqli_query($db, $sql);
        $uni_id = mysqli_insert_id($db);
        
        // loop courses_ids
        foreach($courses_ids as $course_id){
            $course_sql = "INSERT INTO university_with_courses (course_id, university_id) VALUES ($course_id, $uni_id)";
            $course_res = mysqli_query($db, $course_sql);
        }

        if ($res && $course_res){
            echo "<script>
                window.location.href='admin/homepage.php';
                alert('University is added');
            </script>";
            exit;
        } 
        else {
            echo "error!".mysqli_error($db);
        }
    }


    //Edit University
    if (isset($_POST['edit_uni'])){
        $uni_id = $_POST["uni_id"];
        $uni_name = $_POST["uni_name"];
        $uni_address = $_POST["address"];
        $total_credits = $_POST["credit"];
        $total_tution = $_POST["tution"];
        $image_url = $_POST["image_url"];

        $uni_name = stripcslashes($uni_name);
        $uni_address = stripcslashes($uni_address);
        $total_credits = stripcslashes($total_credits);
        $total_tution = stripcslashes($total_tution);
        $image_url = stripcslashes($image_url);

        $course_id = $_POST["courses"];

        $sql = "UPDATE universities SET name='$uni_name', address='$uni_address', total_credits='$total_credits', total_tution='$total_tution', image_url='$image_url' WHERE id=$uni_id";
        $res = mysqli_query($db, $sql);

        // check if $course_id exists with $uni_id in university_with_courses table
        $course_sql = "SELECT * FROM university_with_courses WHERE course_id=$course_id AND university_id=$uni_id";
        $course_res = mysqli_query($db, $course_sql);
        $course_row = mysqli_num_rows($course_res);
        if($course_row == 0){
            $course_sql = "INSERT INTO university_with_courses (course_id, university_id) VALUES ($course_id, $uni_id)";
            $course_res = mysqli_query($db, $course_sql);

            if ($res && $course_res){
                echo "<script>
                    window.location.href='admin/edit_university.php?id=$uni_id';
                    alert('University is updated');
                </script>";
                exit;
            } 
            else {
                echo "error!".mysqli_error($db);
            }
        } else {
            $course_sql = "DELETE FROM university_with_courses WHERE course_id=$course_id AND university_id=$uni_id";
            $course_res = mysqli_query($db, $course_sql);

            if ($res && $course_res){
                echo "<script>
                    window.location.href='admin/edit_university.php?id=$uni_id';
                    alert('University is updated. Course deleted.');
                </script>";
                exit;
            } 
            else {
                echo "error!".mysqli_error($db);
            }
        }
    }


    //Delete University
    if (isset($_POST['delete_uni'])){
        $uni_id = $_POST["uni_id"];
        $sql = "DELETE FROM universities WHERE id=$uni_id";
        $res = mysqli_query($db, $sql);
        if ($res){
            echo "<script>
                window.location.href='admin/homepage.php';
                alert('University is deleted');
            </script>";
            exit;
        } 
        else {
            echo "error!".mysqli_error($db);
        }
    }


    // Delete Recommendations
    if (isset($_POST['clear_recommendations'])){
        $uni_id = $_POST["uni_id"];
        $sql = "DELETE FROM recommendations WHERE university_id=$uni_id";
        $res = mysqli_query($db, $sql);
        if ($res){
            echo "<script>
                window.location.href='admin/edit_university.php?id=$uni_id';
                alert('Recommendation is cleared');
            </script>";
            exit;
        } 
        else {
            echo "error!".mysqli_error($db);
        }
    }


    // Delete User
    if (isset($_POST['delete_user'])){
        $user_id = $_POST["user_id"];
        $sql = "DELETE FROM users WHERE id=$user_id";
        $res = mysqli_query($db, $sql);
        if ($res){
            echo "<script>
                window.location.href='admin/view_users.php';
                alert('User is deleted');
            </script>";
            exit;
        } 
        else {
            echo "error!".mysqli_error($db);
        }
    }


    // Add Course
    if (isset($_POST['add_course'])){
        $course_name = $_POST["c_name"];
        $course_code = $_POST["code"];
        $course_description = $_POST["description"];

        $course_name = stripcslashes($course_name);
        $course_code = stripcslashes($course_code);
        $course_description = stripcslashes($course_description);

        $sql = "INSERT INTO courses (name, code, description) VALUES ('$course_name','$course_code','$course_description')";
        $res = mysqli_query($db, $sql);
        if ($res){
            echo "<script>
                window.location.href='admin/homepage.php';
                alert('Course is added');
            </script>";
            exit;
        } 
        else {
            echo "error!".mysqli_error($db);
        }
    }


    // Delete Course
    if (isset($_POST['delete_course'])){
        $course_id = $_POST["c_id"];
        $sql = "DELETE FROM courses WHERE id=$course_id";
        $res = mysqli_query($db, $sql);
        if ($res){
            echo "<script>
                window.location.href='admin/homepage.php';
                alert('Course is deleted');
            </script>";
            exit;
        } 
        else {
            echo "error!".mysqli_error($db);
        }
    }
?>
