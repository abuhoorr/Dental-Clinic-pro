<?php

include('db.php'); 

session_start(); 

// التحقق مما إذا كان المستخدم قد تم تسجيل الدخول (جلسة المستخدم مفقودة أو غير معرفة)
if (!isset($_SESSION['username'])) {
    // إعادة توجيه المستخدم إلى صفحة تسجيل الدخول للأطباء
    header("Location: doc-login.php");
    exit();
}

// مصفوفة لتخزين معلومات الحجوزات
$reservations = [];

// استخراج اسم المستخدم الحالي من جلسة المستخدم
$username = $_SESSION['username'];

// استعلام SQL لاسترجاع الحجوزات المرتبطة بمستخدم الطبيب
$sql = "SELECT r.*, d.FullName as DoctorName
        FROM reservations r
        INNER JOIN doc d ON r.Doctor_Name = d.FullName
        WHERE d.Username='$username'";

// تنفيذ الاستعلام واستلام النتائج
$result = $conn->query($sql);

// إذا كان هناك نتائج (حجوزات)
if ($result->num_rows > 0) {
    // استخراج البيانات وتخزينها في مصفوفة الحجوزات
    while($row = $result->fetch_assoc()) {
        $reservations[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dashboard.css">
    <title>مواعيد الطبيب</title>
</head>
<body>
        <h2>Welcome,Dr <?php echo $_SESSION['username']; ?>!</h2>
    <div class="A">    
            <a href="logout.php"><button type="submit" value="Back">تسجيل خروج</button></a>
    </div>
            <h1>مواعيد المريض</h1>
    <table>
        <thead>
            <tr>
                <th>اسم المريض</th>
                <th>تاريخ الموعد</th>
                <th>وقت الموعد</th>
                <th>تفاصيل اخرى</th>
            </tr>
        </thead>
            <tbody>
                <?php foreach ($reservations as $reservation): ?>
                    <tr>
                    <td><?php echo $reservation['Name']; ?></td>
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

