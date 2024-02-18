<?php
include('db.php'); 
session_start(); 

// التحقق مما إذا كان الطلب هو POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // استخراج اسم المستخدم من جلسة المستخدم
    $name = $_SESSION['username'];

    // استعلام قاعدة البيانات للحصول على بيانات المستخدم (البريد الإلكتروني، الهاتف، والمعرف)
    $user_query = "SELECT id, email, phone FROM users WHERE Username='$name'";
    $user_result = $conn->query($user_query);

    if ($user_result->num_rows > 0) {
        $user_row = $user_result->fetch_assoc();
        $userId = $user_row['id'];  // الحصول على معرف المستخدم
        $email = $user_row['email'];
        $phone = $user_row['phone'];

        // استخراج معرف الطبيب الذي تم اختياره
        $doctorId = $_POST['doctor'];

        // استعلام للبحث عن بيانات الطبيب باستخدام معرف الطبيب
        $doctor_query = "SELECT * FROM doc WHERE id = $doctorId";
        $doctor_result = $conn->query($doctor_query);

        if ($doctor_result->num_rows > 0) {
            $doctor_row = $doctor_result->fetch_assoc();
            $doctorName = $doctor_row['FullName'];
            $doctorSpecialization = $doctor_row['specialization'];

            // استخراج تواريخ الحجز والوقت والرسالة من الطلب
            $date = $_POST['date'];
            $time = $_POST['time'];
            $message = $_POST['message'];

            // إدراج بيانات الحجز في قاعدة البيانات
            $sql = "INSERT INTO reservations (id, Name, email, phone, Preferred_Date, Preferred_Time, Reservationscol, Doctor_Name) 
                    VALUES ('$userId', '$name', '$email', '$phone', '$date', '$time', '$message', '$doctorName')";

            if ($conn->query($sql) === TRUE) {
                // إعادة توجيه المستخدم إلى صفحة اللوحة بعد نجاح الإدراج
                header("Location: dashboard.php"); 
                exit(); 
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "الطبيب غير موجود";
        }
    } else {
        echo "المستخدم غير موجود";
    }
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الحجوزات</title>
    <link rel="stylesheet" href="css/reservation.css">
</head>
<body>
    <header>
        <h1>Dental Clinic Reservations</h1>
    </header>
    <main>
        <section class="reservation-form">
            <h2>حجز موعد</h2>
            <form id="reservationForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

                <!-- Add Dropdown Menu for Choosing a Doctor -->
                <label for="doctor">اختيار الطبيب</label>
                <select id="doctor" name="doctor" required>
                    <option value="">اختر الطبيب</option>
                    <?php
                    $doctor_query = "SELECT * FROM doc";
                    $doctor_result = $conn->query($doctor_query);

                    if ($doctor_result->num_rows > 0) {
                        while ($row = $doctor_result->fetch_assoc()) {
                            echo "<option value='{$row['id']}'>{$row['FullName']}</option>";
                        }
                    }
                    ?>
                </select>

                <label for="date">الموعد المفضل</label>
                <input type="date" id="date" name="date" required>

                <label for="time">الوقت المفضل</label>
                <input type="time" id="time" name="time" required>

                <label for="message">تفاصيل إضافية(اختياري)</label>
                <textarea id="message" name="message" rows="4"></textarea>
                <input type="reset" value="اعاده تعيين">
                <button type="submit">تقديم الحجز</button>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2023 Dental Clinic. All rights reserved.</p>
    </footer>
</body>
</html>
