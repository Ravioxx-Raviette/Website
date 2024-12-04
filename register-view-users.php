<!doctype HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Rivero Website</title>
    <link rel="stylesheet" type="text/css" href="view_userscss.css">
</head>
<body>
    <div id="container">
        <?php include('header.php');?> 
        <?php include('nav.php');?> 	
        <?php include('info-col.php');?> 
        
        <div id="content">
            <h2><center>Registered Users</center></h2>
            <p>
            <?php
                require("mysqli_connect.php");
                $q = "SELECT fname, lname, email, DATE_FORMAT(registration_date, '%M %d %Y') AS regdat, user_id FROM users ORDER BY user_id ASC";
                $result = @mysqli_query($dbc, $q);
                
                if ($result) {
                    echo '<table><tr>
                        <th><strong>Name</strong></th>
                        <th><strong>Email</strong></th>
                        <th><strong>Registered Date</strong></th>
                        <th><strong>Actions</strong></th>
                    </tr>';
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>
                            <td>' . htmlspecialchars($row['lname'] . ', ' . $row['fname']) . '</td>
                            <td>' . htmlspecialchars($row['email']) . '</td>
                            <td>' . htmlspecialchars($row['regdat']) . '</td>
                        
                                <td><a href="edit_user.php?id='.$row['user_id'].'"><img src="mark.png" class="buttonv1"> </a><a href="delete_user.php?id='.$row['user_id'].'">
                                <img src="hi.png" class="buttonv1"></a></td>
                            
                        </tr>';
                    }
                    echo '</table>';
                    mysqli_free_result($result);
                } else { 
                    echo '<p class="error">The current users cannot be retrieved. Contact the admin.</p>';
                }
                
                mysqli_close($dbc);
            ?>
            </p>
        </div>
        
        <?php include('footer.php');?> 
    </div>
</body>
</html>
