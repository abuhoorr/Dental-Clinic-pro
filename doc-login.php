<?php
// Include the database connection code from 'db.php'
include('db.php');

// Start or resume a user session
session_start();

// Check if the HTTP request method is POST (typically used for form submissions)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and retrieve the username and password from the POST data
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Execute an SQL query to check if the username and password match in the 'doc' table
    $result = mysqli_query($conn, "SELECT * FROM doc WHERE Username='$username' AND Password='$password' ") or die("Select Error");

    // Fetch the first row of the result (if any) and store it in an associative array
    $row = mysqli_fetch_assoc($result);

    // Check if a row was found (successful login)
    if (is_array($row) && !empty($row)) {
        // Set session variables to store user information
        $_SESSION['valid'] = $row['Email'];
        $_SESSION['username'] = $row['Username'];
        $_SESSION['FullName'] = $row['FullName'];
        $_SESSION['id'] = $row['Id'];
        $_SESSION['role'] = 'doctor'; // Set the role to doctor

        // Redirect the user to the (index.php)
        header("Location: index.php");
        exit();
    } 
    $error_message = "اسم المستخدم أو كلمة المرور غير صحيحة";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/signinup.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>تسجيل دخول الطبيب</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">اسم المستخدم</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>

                <div class="field input">
                <label for="password">كلمة المرور</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="تسجيل الدخول" required>
                </div>
                <?php if(isset($error_message)): ?>
            <div class='message'>
                <p><?php echo $error_message; ?></p>
            </div> <br>
        <?php endif; ?>
            </form>
        </div>
    </div>
</body>
</html>
