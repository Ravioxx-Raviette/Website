<!doctype html>
<html lang="en">
<head>
    <title>Edit User - Rivero Website</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/includes.css">
</head>
<body>
    <div id="container">
        <?php include('header.php'); ?> 
        <?php include('nav.php'); ?>     
        <?php include('info-col.php'); ?> 
        
        <!-- Edit User Content -->
        <div id="content_for_edit">
            <h2><center>Edit User Information</center></h2>
            
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

                // Handling edit form submission
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $fname = mysqli_real_escape_string($dbc, trim($_POST['fname']));
                    $lname = mysqli_real_escape_string($dbc, trim($_POST['lname']));
                    $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
                    $user_id = (int) $_POST['id']; // Get the user ID for update

                    // Fetching current user information for comparison
                    $q = "SELECT fname, lname, email FROM users WHERE user_id=$user_id";
                    $result = @mysqli_query($dbc, $q);

                    if ($result && mysqli_num_rows($result) == 1) {
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        
                        // Only update the user if there is any change in the fields
                        if ($fname != $row['fname'] || $lname != $row['lname'] || $email != $row['email']) {
                            $q = "UPDATE users SET fname='$fname', lname='$lname', email='$email' WHERE user_id=$user_id";
                            $result = @mysqli_query($dbc, $q);

                            if ($result && mysqli_affected_rows($dbc) == 1) {
                                echo '<p>The user information has been updated.</p>';
                                echo '<p><a href="register-view-users.php">Return to View Users</a></p>';
                            } else {
                                echo '<p>An error occurred while trying to update the user information.</p>';
                            }
                        } else {
                            // No changes detected, so no update is necessary
                            echo '<p>No changes were made to the user information.</p>';
							echo '<p><a href="register-view-users.php">Return to View Users</a></p>';
                        }
                    } else {
                        echo '<p><center>Why are you here? Go back please.</center></p>';
                        echo '<p><a href="register-view-users.php">Return to View Users</a></p>';
                    }
                } else {
                    // Fetching current user information for editing
                    $q = "SELECT fname, lname, email FROM users WHERE user_id=$id";
                    $result = @mysqli_query($dbc, $q);

                    if ($result && mysqli_num_rows($result) == 1) {
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        echo '
                            <form action="edit_user.php" method="post" class="edit-form">
                                <p>First Name: <input type="text" name="fname" value="' . $row['fname'] . '" required></p>
                                <p>Last Name: <input type="text" name="lname" value="' . $row['lname'] . '" required></p>
                                <p>Email: <input type="email" name="email" value="' . $row['email'] . '" required></p>
                                <input type="submit" value="Save Changes" class="button-edit">
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
