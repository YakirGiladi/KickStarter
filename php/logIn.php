<?php
    // First start a session. This should be right at the top of your login page.
    session_start();
    
    // get data from client
    $jsonObject=$_POST['data'];

    if (strlen($jsonObject["email"]) > 0 && strlen($jsonObject['password']) > 0 ) {
        $email = $jsonObject["email"];
        $pass = $jsonObject["password"];
        $pass = md5($pass[0].$pass.$pass[0]);

        // Connect to the database and select the user based on their provided email address.
        // Be sure to retrieve their password and any other information you want to save for the user session.
        $servername = "localhost";
        $username =  "power.bi";
        $password = "Wono7981";
        $dbname = "kickstarter";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $sql = "SELECT id, email, password, name, type FROM users WHERE email = '" . $email . "' LIMIT 1";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if ($row['password'] == $pass) {

                $_SESSION['is_auth'] = $row['type'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['name'] = $row['name'];

                echo 1;
                exit;
            }
            else {
                echo "Invalid email or password. Please try again.";
            }
        }
        else {
           echo "Invalid email or password. Please try again.";
        }
    }
    else {
        echo "Please enter an email and password to login.";
    }
    
?>

