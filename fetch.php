<?php
    $connect = mysqli_connect("localhost", "root", "", "find_my_uni");
    $output = '';
    if(isset($_POST["query"]))
    {
        $search = mysqli_real_escape_string($connect, $_POST["query"]);
        $query = "
        SELECT * FROM universities 
        WHERE name LIKE '%".$search."%'
        OR total_credits LIKE '%".$search."%' 
        OR id LIKE '%".$search."%'
        ";
        $result = mysqli_query($connect, $query);
        if(mysqli_num_rows($result) > 0)
        {
            $output .= '<div class="card-group">';
            while($row = mysqli_fetch_array($result))
            {
                $output .= '
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="'.$row['image_url'].'" alt="'.$row['name'].'" width="50%" height="auto">
                    <div class="card-body">
                    <h1 class="card-text">'.$row['name'].'</h1>
                    <h3 class="card-text">Address: '.$row['address'].'</h3>
    
                    <a class="btn" href="view_university.php?id='.$row['id'].'">View</a>
                    </div>
                </div>
                            
                ';
            }
            $output .= '</div>';
            echo $output;
        }
    }
?>