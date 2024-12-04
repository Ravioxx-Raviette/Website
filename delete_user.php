<!doctype html>
<html lang="en">
<head>
    <title>Delete User - Rivero Website</title>
    <meta charset="utf-8">
    <!-- Linking the external CSS file -->
    <link rel="stylesheet" type="text/css" href="css/includes.css">
</head>
<body>
    <div id="container">
        <?php include('header.php'); ?> 
        <?php include('nav.php'); ?>     
        <?php include('info-col.php'); ?> 
        
        <div id="content_for_delete">
            <h2><center>Delete Content</center></h2>
            
            <?php 
                // Sanitizing the user ID input
                if ((isset($_GET['id'])) && (is_numeric($_GET['id']))) {
                    $id = (int) $_GET['id']; 
                } elseif ((isset($_POST['id'])) && (is_numeric($_POST['id']))) {
                    $id = (int) $_POST['id']; 
                } else {
                    echo '<p>Invalid Access!</p>';
                    exit();
                }

                // Database connection
                require('mysqli_connect.php');
                if (!$dbc) {
                    echo '<p>Could not connect to the database.</p>';
                    exit();
                }

                // Handling deletion form submission
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if ($_POST['sure'] == 'Yes') {
                        $q = "DELETE FROM users WHERE user_id=$id";
                        $result = @mysqli_query($dbc, $q);
                        
                        if ($result && mysqli_affected_rows($dbc) == 1) {
                            echo '<p>The user has been deleted.</p>';
                            echo '<p><a href="register-view-users.php">Return to View Users</a></p>';
                        } else {
                            echo '<p>An error occurred while trying to delete the user.</p>';
                        }
                    } else {
                        echo '<p>The user was not deleted.</p>';
						echo '<p><a href="register-view-users.php">Return to View Users</a></p>';
                    }
                } else {
                    // Fetching user information to confirm deletion
                    $q = "SELECT CONCAT(fname, ' ', lname) AS name FROM users WHERE user_id=$id";
                    $result = @mysqli_query($dbc, $q);

                    if ($result && mysqli_num_rows($result) == 1) {
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        echo "<h3>Are you sure you want to delete {$row['name']}?</h3>";
                        echo '
                            <form action="delete_user.php" method="post" class="delete-form">
                                <input id="Submit-yes" type="submit" name="sure" value="Yes" class="button-delete">
                                <input id="Submit-no" type="submit" name="sure" value="No" class="button-cancel">
                                <input type="hidden" name="id" value="' . $id . '">
                            </form>';
                    } else {
                        echo '<p><center>Why are you here? Go back please.</center></p>';
						echo '<p><a href="register-view-users.php">Return to View Users</a></p>';
                    }
                }

                // Close the database connection
                mysqli_close($dbc);
            ?>

            <?php include('footer.php'); ?> 
        </div>
    </div>
</body>
</html>
