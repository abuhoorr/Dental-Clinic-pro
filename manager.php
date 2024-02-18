<?php
session_start();

include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $result = mysqli_query($conn, "SELECT * FROM manager WHERE Username='$username' AND Password='$password' ") or die("Select Error");

    $row = mysqli_fetch_assoc($result);

    if (is_array($row) && !empty($row)) {
        $_SESSION['valid'] = $row['Email'];
        $_SESSION['username'] = $row['Username'];
        $_SESSION['Firstname'] = $row['Firstname'];
        $_SESSION['id'] = $row['Id'];
        $_SESSION['role'] = 'manager';
        header("Location: manager.php");
        exit();
    } 

    $error_message = "اسم المستخدم أو كلمة المرور غير صحيحة";
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'manager') {
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
            <header>تسجيل دخول المدير</header>
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
<?php
} else {
    // If logged in, show the dashboard with the table
    $doctors_result = mysqli_query($conn, "SELECT DISTINCT Doctor_Name FROM reservations") or die("Error fetching doctors");
    $doctors = [];

    while ($row = mysqli_fetch_assoc($doctors_result)) {
        $doctorName = $row['Doctor_Name'];
        $reservations_result = mysqli_query($conn, "SELECT * FROM reservations WHERE Doctor_Name='$doctorName'") or die("Error fetching reservations");
        $patients = [];
        while ($reservation = mysqli_fetch_assoc($reservations_result)) {
            $patients[] = $reservation;
        }
        $doctors[$doctorName] = $patients;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dashboard.css">
    <title>Manager Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['role']; ?>! 
    <div class="A">
    <a href="logout.php"><button type="submit" value="Back">تسجيل خروج</button></a>
    </div>
    <table style="width:100%; border-collapse: collapse; margin-top: 20px; text-align: left;">
        <thead>
            <tr>
                <th>اسم الدكتور</th>
                <th>اسم المريض</th>
                <th>البريد الالكتروني</th>
                <th>رقم الجوال</th>
                <th>تاريخ الموعد</th>
                <th>وقت الموعد</th>
                <th>اضافات اخرى</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($doctors as $doctorName => $patients): ?>
                <?php foreach ($patients as $patient): ?>
                    <tr>
                        <td><?php echo $doctorName; ?></td>
                        <td><?php echo $patient['Name']; ?></td>
                        <td><?php echo $patient['Email']; ?></td>
                        <td><?php echo $patient['Phone']; ?></td>
                        <td><?php echo $patient['Preferred_Date']; ?></td>
                        <td><?php echo $patient['Preferred_Time']; ?></td>
                        <td><?php echo $patient['Reservationscol']; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
<?php
}
?>