<?php
if (!isset($_SESSION)) {
    session_start();
    ob_start();
}

if (isset($_SESSION['lang']) and $_SESSION['lang'] == 'CN') {
    $lang = '_cn';
} else {
    $_SESSION['lang'] = 'EN';
    $lang = '_en';
}
?>

<!DOCTYPE html>
<html lang="en">

<?php
$category = '';
$main_menu = 'LINGUISTICS'; //to change

include "../includes/menu_bar_reset.php";
$menu_bar3 = "active";

$_SESSION['active_page'] = 'courses';

include "../includes/header.php";
include "../connections/dbname.php";


?>
<!-- JavaScript -->
<script src="../vendor/js/bundle.min.js"></script>
<script src="../vendor/js/jquery.fancybox.min.js"></script>
<script src="../vendor/js/owl.carousel.min.js"></script>
<script src="../vendor/js/swiper.min.js"></script>
<script src="../vendor/js/jquery.cubeportfolio.min.js"></script>
<script src="../vendor/js/jquery.appear.js"></script>
<script src="../vendor/js/wow.min.js"></script>
<script src="../vendor/js/flip.js"></script>
<script src="../vendor/js/jquery-ui.bundle.js"></script>
<script src="../vendor/js/select2.min.js"></script>
<script src="../vendor/js/jquery.hoverdir.js"></script>
<script src="../vendor/js/hover-item.js"></script>
<script src="../vendor/js/slick.min.js"></script>
<script src="../vendor/js/parallaxie.min.js"></script>

<!-- Custom Scripts -->
<script src="http://maps.google.com/maps/api/js?key=AIzaSyCo_pcAdFNbTDCAvMwAD19oRTuEmb9M50c"></script>
<script src="../resources/js/map.js"></script>
<script src="../vendor/js/contact_us.js"></script>
<script src="../resources/js/script.js"></script>
<script src="scripts/courses.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<style>
    .hero-section {
        position: absolute;
        top: -46px;
        height: 100vh;
        width: 100%;
        background-image: url('../resources/img/courses/courses_bg.png');
        background-size: cover;
        background-position: center top;

    }

    .hero-content {
        text-align: center;
        z-index: 2;
        position: relative;
        padding-top: 200px;
        width: 1036px;
        margin: 0 auto;
    }

    .hero-content h1 {
        font-size: 50px;
        font-weight: 700;
        color: black;
        font-family: 'Poppins', sans-serif;
    }

    .hero-content p {
        font-size: 20px;
        font-weight: 400;
        color: black;
        font-family: 'Poppins', sans-serif;
        margin-top: 32px;
    }

    .hero-buttons {
        display: flex;
        justify-content: center;
        gap: 30px;
        margin-top: 50px;
        flex-wrap: wrap;
        z-index: 2;
        position: relative;
    }

    .hero-button {
        border-radius: 25px;
        width: 350px;
        height: 80px;
        padding: 25px 19px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Poppins', sans-serif;
        font-size: 18px;
        font-weight: 400;
        gap: 15px;
        cursor: pointer;
    }

    .hero-button.green {
        background: #09CA91;
        color: white;
    }

    .hero-button.white {
        background: #fff;
        color: black;
        border: 1px solid #ccc;
    }

    .course-tour-wrapper {
        position: relative;
        margin-top: 150px;
        display: flex;
        justify-content: center;
    }

    @media (max-width: 767px) {
        .hero-content {
            width: 90%;
            padding-top: 150px;
            text-align: justify;
        }

        .hero-content h1 {
            font-size: 28px;
            line-height: 1.4;
            text-align: justify;
        }

        .hero-content p {
            font-size: 15px;
            margin-top: 20px;
            text-align: justify;
        }

        @media (max-width: 767px) {
            .hero-buttons {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 20px;
                margin-top: 30px;
            }

            .hero-button {
                width: 100%;
                max-width: 300px;
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 12px;
                padding: 14px 20px;
                border-radius: 20px;
                font-size: 16px;
                text-align: center;
            }

            .hero-button span {
                flex: 1;
                text-align: center;
            }

            .hero-button svg {
                width: 22px;
                height: 22px;
            }
        }

        .course-tour-wrapper {
            margin-top: 0;
        }

    }
</style>

<body oncontextmenu="return false;" data-spy="scroll" data-target=".navbar" data-offset="90" class="position-relative">

    <!-- Static Hero Section with separated gradient -->
    <!-- Hero Background -->
    <div class="hero-section"></div>

    <!-- Hero Content -->
    <div class="hero-content">
        <h1>
            <span id="hero-header">
                <span id="hero-header-title"></span>
            </span>
        </h1>

    </div>

    <!-- Hero Buttons -->
    <div class="hero-buttons">
        <a class="hero-button green" onclick="scrollToCourses()">
            <span id="hero-button-1" style="color:white;"></span>
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none">
                <path d="M14 1L21 8M21 8L14 15M21 8H1" stroke="white" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </a>

        <a class="hero-button white" onclick="scrollToCourses()">
            <span id="hero-button-2"></span>
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none">
                <path d="M14 1L21 8M21 8L14 15M21 8H1" stroke="black" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </a>

    </div>

    <!-- Begin white container for main content -->
    <div class="course-tour-wrapper">
        <?php include "course_introduction.php"; ?>
    </div>

    <?php include "../includes/address.php"; ?>
    <?php include "../includes/footer.php"; ?>
    <!-- End white container -->

    <div id="page-data" data-page="courses" data-lang="<?php echo $lang ?>"></div>
    <script>console.log('<?php echo $lang . " is the lang"; ?>')</script>
    <script>
        function scrollToCourses() {
            const section = document.getElementById("courseSection");
            const offset = -60;

            const top = section.getBoundingClientRect().top + window.pageYOffset + offset;

            window.scrollTo({
                top,
                behavior: 'smooth'
            });
        }
    </script>
</body>

</html>