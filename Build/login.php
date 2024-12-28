<?php
session_start();
include 'db_connection.php';

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if username and password have been posted
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Prepare query to check credentials
        $query = "SELECT * FROM Users WHERE username = '$username'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            // Verify the password
            if ($password == $user['password']) {  // Use password_verify() if passwords are hashed
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['user_role'] = $user['user_role'];

                // Redirect based on user role
                if ($user['user_role'] == 'customer') {
                    header("Location: customer_dashboard.php");
                } elseif ($user['user_role'] == 'employee') {
                    header("Location: employee_dashboard.php");
                } elseif ($user['user_role'] == 'admin') {
                    header("Location: admin_dashboard.php");
                }
                exit();
            } else {
                echo "Invalid login details";
            }
        } else {
            echo "Invalid login details";
        }
    } else {
        echo "Please fill in both fields.";
    }
}
?>
