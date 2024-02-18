<?php
session_start();
include('db.php');

// التحقق مما إذا كان المستخدم قد قام بتسجيل الدخول (جلسة المستخدم معرفة)
if (!isset($_SESSION['username'])) {
    // إعادة توجيه المستخدم إلى صفحة تسجيل الدخول في حالة عدم تسجيل الدخول
    header("Location: signin.php");
    exit();
}

// مصفوفة لتخزين معلومات الحجوزات
$reservations = [];

// استرجاع اسم المستخدم الحالي من جلسة المستخدم
$username = $_SESSION['username'];

// استعلام للبحث عن معرف المستخدم باستخدام اسم المستخدم
$userResult = $conn->query("SELECT id FROM users WHERE username = '$username'");
if ($userResult->num_rows > 0) {
    $userRow = $userResult->fetch_assoc();
    $userId = $userRow['id'];

    // استعلام لاسترجاع حجوزات المستخدم باستخدام معرف المستخدم
    $sql = "SELECT * FROM reservations WHERE id = $userId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $reservations[] = $row;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dashboard.css">
    <title>Dentist Dashboard</title>
</head>
<body>  
    <h2>اهلا, <?php echo $_SESSION['username']; ?>!
    <h1 class="H1">مواعيدك</h1>
    <table>
        <thead>
            <tr>
                <th>الاسم</th>
                <th>اسم الطبيب</th>
                <th>تاريخ الموعد</th>
                <th>وقت الموعد</th>
                <th>تفاصيل اخرى</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservations as $reservation): ?>
                <tr>
                    <td><?php echo $reservation['Name']; ?></td>
                    <td><?php echo $reservation['Doctor_Name']; ?></td>
                    <td><?php echo $reservation['Preferred_Date']; ?></td>
                    <td><?php echo $reservation['Preferred_Time']; ?></td>
                    <td><?php echo $reservation['Reservationscol']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="A">
        <a href="index.php"><button type="Back" value="Back">للرجوع</button></a>
</div>
</body>
</html>
