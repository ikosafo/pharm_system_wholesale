<?php include('config.php'); ?>
<!DOCTYPE html>
<html lang="en-GB">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Link of CSS files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/remixicon.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/odometer.min.css">
    <link rel="stylesheet" href="assets/css/fancybox.css">
    <link rel="stylesheet" href="assets/css/aos.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <link rel="stylesheet" href="assets/css/dark-theme.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    <title>
        <?php echo getCompanyName(); ?>
    </title>
    <link rel="icon" type="image/png" href="assets/img/custom/godswisdom.png">
</head>

<body>

    <!--Preloader starts-->
    <div class="loader js-preloader">
        <div class="absCenter">
            <div class="loaderPill">
                <div class="loaderPill-anim">
                    <div class="loaderPill-anim-bounce">
                        <div class="loaderPill-anim-flop">
                            <div class="loaderPill-pill"></div>
                        </div>
                    </div>
                </div>
                <div class="loaderPill-floor">
                    <div class="loaderPill-floor-shadow"></div>
                </div>
            </div>
        </div>
    </div>
    <!--Preloader ends-->


    <!-- Page Wrapper End -->
    <div class="page-wrapper">

        <!-- Header Section Start -->
        <header class="header-wrap style1">
            <div class="header-top">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <div class="header-top-left">
                                <ul class="contact-info list-style">
                                    <li>
                                        <span><i class="ri-customer-service-fill"></i></span>
                                        <p>Premium Customer Support</p>
                                    </li>
                                    <li>
                                        <span><i class="ri-phone-fill"></i></span>
                                        <a href="tel:<?php echo getCompanyTelephone(); ?>"><?php echo getCompanyTelephone(); ?></a>
                                    </li>
                                    <li>
                                        <span><i class="ri-map-pin-fill"></i></span>
                                        <p>
                                            <?php $companyaddress = getCompanyAddress();;
                                            // Word to be removed
                                            $wordToRemove = " - Accra";
                                            // Removing the specified word from the string
                                            $result = str_replace($wordToRemove, "", $companyaddress);
                                            echo $result;
                                            ?>
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="header-top-right">
                                <div class="select-lang">
                                    <i class="ri-earth-fill"></i>
                                    <div class="navbar-option-item navbar-language dropdown language-option">
                                        <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="lang-name"></span>
                                        </button>
                                        <div class="dropdown-menu language-dropdown-menu">
                                            <a class="dropdown-item" href="#">
                                                <img src="assets/img/uk.png" alt="flag">
                                                Eng
                                            </a>
                                            <a class="dropdown-item" href="#">
                                                <img src="assets/img/china.png" alt="flag">
                                                简体中文
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <ul class="social-profile list-style style1">
                                    <li>
                                        <a href="https://whatsapp.com/">
                                            <i class="ri-whatsapp-line"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://facebook.com/">
                                            <i class="ri-facebook-fill"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://twitter.com/">
                                            <i class="ri-twitter-fill"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://linkedin.com/">
                                            <i class="ri-linkedin-fill"></i>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-bottom">
                <div class="container">
                    <nav class="navbar navbar-expand-md navbar-light">
                        <a class="navbar-brand" href="/">
                            <img class="logo-light" src="assets/img/custom/logo.png" alt="logo">
                            <img class="logo-dark" src="assets/img/custom/logo.png" alt="logo">
                        </a>
                        <div class="collapse navbar-collapse main-menu-wrap" id="navbarSupportedContent">
                            <div class="menu-close d-lg-none">
                                <a href="javascript:void(0)"> <i class="ri-close-line"></i></a>
                            </div>
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item">
                                    <a href="/" class="nav-link active">
                                        Home
                                    </a>

                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        About Us
                                        <i class="ri-arrow-down-s-line"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">Company Overview</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">Mission & Values</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">Our Team</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">Testimonials</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        Services
                                        <i class="ri-arrow-down-s-line"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">Wholesale Services</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">Logistics & Operations</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">Medical Advisory Services</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        Products
                                        <i class="ri-arrow-down-s-line"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">Pharmaceuticals</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">Medical Supplies</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">Health & Wellness</a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="nav-item">
                                    <a href="#" class="nav-link">Contact Us</a>
                                </li>
                                <li class="nav-item d-lg-none">
                                    <a href="#" class="nav-link btn style1">Call Now</a>
                                </li>
                            </ul>
                            <div class="other-options md-none">
                                <div class="option-item">
                                    <button class="searchbtn"><i class="ri-search-line"></i></button>
                                </div>
                                <div class="option-item">
                                    <a href="#" class="btn style1">Call Now</a>
                                </div>
                            </div>

                        </div>
                    </nav>
                    <div class="search-area">
                        <input type="search" placeholder="Search Here..">
                        <button type="submit"><i class="ri-search-line"></i></button>
                    </div>
                    <div class="mobile-bar-wrap">
                        <button class="searchbtn d-lg-none"><i class="ri-search-line"></i></button>
                        <div class="mobile-menu d-lg-none">
                            <a href="javascript:void(0)"><i class="ri-menu-line"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Header Section End -->