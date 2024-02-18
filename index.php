<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عيادة اسنان</title>
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- normalize css -->
    <link rel="stylesheet" href="css/normalize.css">
    <!-- custom css -->
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <!-- header -->
    <header class="header bg-blue">
        <nav class="navbar bg-blue">
            <div class="container flex">
                <a href="index.php" class="navbar-brand">
                    <img src="images/logo.png" alt="site logo">
                </a>
                <button type="button" class="navbar-show-btn">
                    <img src="images/ham-menu-icon.png">
                </button>
                <div class="navbar-collapse bg-white">
                    <button type="button" class="navbar-hide-btn">
                        <img src="images/close-icon.png">
                    </button>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="#" class="nav-link">الصفحة الرئيسية</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">من نحن</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">تواصل معنا</a>
                        </li>
                        
                        <?php
                        if (isset($_SESSION['username']) && $_SESSION['role'] === 'patient') {
                            echo '<li class="nav-item">';
                            echo '<div class="nav-link">Hello, ' . $_SESSION['username'] . '</div>';
                            echo '</li>';
                            echo '<li class="nav-item">';
                            echo '<a href="logout.php" class="nav-link">تسجيل الخروج</a>';
                            echo '</li>';                       
                    
                        } else {
                        
                            echo '<li class="nav-item">';
                            echo '<a href="dashboard-doctor.php" class="nav-link">لوحة الطبيب</a>';
                            echo '</li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="header-inner text-white text-center">
            <div class="container grid">
                <div class="header-inner-left">
                    <h1> شريك الصحة<br> <span></span> الأكثر ثقة</h1>
                    <p class="lead">أفضل خدمة طبية تقدم لك</p>
                    <br>
                    <h2>العناية بالأسنان</h2>
                    <p class="text text-md">يضم قسم طب الأسنان نخبة من الأطباء الذين يسعون دوماً لتطبيق مفهوم فن وعلم طب الأسنان بتقديم رعاية مرتكزة على أحدث الأسس العلمية لكافة الفئات العمرية باستخدام أحدث التقنيات الرقمية والطرق العلاجية الحديثة. ويقدم قسم طب الأسنان كافة تخصصات طب الأسنان والتي تركز على رفع مستوى العناية الفموية الوقائية في بيئة علاجية تقدم أعلى مستويات الوقاية والتعقيم لكافة مراجعينا بهدف رسم ابتسامة واثقة صحية.</p>
                    <?php
                    if (!isset($_SESSION['username'])) {
                        echo '<div class="btn-group">';
                        echo '<a href="signup.php" class="btn btn-white">إنشاء حساب</a>';
                        echo '<a href="signin.php" class="btn btn-light-blue">تسجيل دخول</a>';
                        echo '</div>';
                    }
                    ?>
                </div>
                <div class="header-inner-left">
                    <img src="images/header.png">
                </div>
            </div>
        </div>
    </header>
    <!-- end of header -->
    <main>
        <!-- about section -->
        <section id="about" class="about py">
            <div class="about-inner">
                <div class="container grid">
                    <div class="about-left text-center">
                        <div class="section-head">
                            <?php
                            if (isset($_SESSION['username']) && $_SESSION['role'] === 'patient') {
                                echo '<h1>للحجز أو لرؤية مواعيدك</h1>';
                                echo '<a href="Reservation.php" class="btn btn-white">احجز هنا</a>';
                                echo '<a href="dashboard.php" class="btn btn-light-blue">لرؤية مواعيدك</a>';
                            }
                            ?>
                        </div>
                    </div>
                
                    </div>
                    <div class="about-right flex">

                    </div>
                </div>
            </div>
        </section>
        <!-- end of about section -->

        <!-- banner one -->
        <section id="banner-one" class="banner-one text-center">
            <div class="container text-white">
                <blockquote class="lead"><i class="fas fa-quote-left"></i>عندما تكون شابًا وتتمتع بصحة جيدة، لا يمكن أن يخطر ببالك أبدًا أن حياتك كلها يمكن أن تتغير في ثانية واحدة<i class="fas fa-quote-right"></i></blockquote>
                <small class="text text-sm">- حكمة</small>
            </div>
        </section>
        <!-- end of banner one -->

        <!-- doctors section -->
        <section id="doc-panel" class="doc-panel py">
            <div class="container">
                <div class="section-head2">
                    <h2>الأطباء المتميزين لدينا</h2>
                </div>

                <div class="doc-panel-inner grid">
                    <div class="doc-panel-item">
                        <div class="img flex">
                            <img src="images/doc-1.png" alt="doctor image">
                            <div class="info text-center bg-blue text-white flex">
                                <p class="lead">ارثر مورقان</p>
                                <p class="text-lg">طب الاسنان</p>
                            </div>
                        </div>
                    </div>

                    <div class="doc-panel-item">
                        <div class="img flex">
                            <img src="images/doc-2.png" alt="doctor image">
                            <div class="info text-center bg-blue text-white flex">
                                <p class="lead">إليزابيث إيرا</p>
                                <p class="text-lg">طب الاسنان</p>
                            </div>
                        </div>
                    </div>

                    <div class="doc-panel-item">
                        <div class="img flex">
                            <img src="images/doc-3.png" alt="doctor image">
                            <div class="info text-center bg-blue text-white flex">
                                <p class="lead">تانيا كولينز</p>
                                <p class="text-lg">طب الأسنان</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer id="footer" class="footer text-center">
        <div class="container">
            <div class="footer-inner text-white py grid">
                <div class="footer-item">
                    <h3 class="footer-head">من نحن</h3>
                    <p class="text text-md">نحن عيادة مختصة في طب الاسنان</p>
                    <address>
                        عيادة اسنان <br>
                        حائل
                        <br>
                        طريق الملك فهد
                    </address>
                </div>
                <div class="footer-item">
                    <h3 class="footer-head">تواصل معنا</h3>
                    <ul>
                        <li><i class="fas fa-envelope"></i>
                            <span>cwww@gmail.com</span></li>
                        <li><i class="fas fa-phone"></i>
                            <span>966+0123456789</span></li>
                    </ul>
                </div>
                <div class="footer-item">
                    <h3 class="footer-head">اوقات العمل</h3>
                    <p class="text text-md">لمعرفة اوقات عمل العيادة</p>
                    <ul class="appointment-info">
                        <li>8:00AM - 12:00PM</li>
                        <li>2:00PM - 12:00AM</li>
                    </ul>
                </div>
            </div>
            <div class="footer-links">
                <ul class="flex">
                    <li><a href="#" class="text-white flex"> <i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="#" class="text-white flex"> <i class="fab fa-twitter"></i></a></li>
                    <li><a href="#" class="text-white flex"> <i class="fab fa-linkedin"></i></a></li>
                </ul>
            </div>
        </div>
    </footer>
    <script src="js/script.js"></script>
</body>

</html>
