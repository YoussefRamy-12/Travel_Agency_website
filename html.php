<?php

$conn = mysqli_connect('localhost', 'root', '', 'user_db');
if (!empty($_POST['go'])) {
    session_start();
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['mail']);
    $pass = md5($_POST['pass']);


    $select = " SELECT * FROM user_form WHERE email = '$email' and password = '$pass' ";

    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_array($result);

        if ($row['user_type'] == 'admin') {
            $_SESSION['admin_name'] = $row['name'];
            header("location: admin/admin_page.php");
        } else {
            $_SESSION['user_name'] = $row['name'];
            header("location:html.php");
        }
    } else {
        $error[] = 'incorrect email or password!';
        session_unset();
        session_destroy();
    }
} else if (!empty($_POST['sign'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = md5($_POST['password']);
    $cpass = md5($_POST['cpassword']);
    $user_type = $_POST['user_type'];

    $select = " SELECT * FROM user_form WHERE email = '$email' and password = '$pass' ";

    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {

        $error[] = 'user already exist!';
    } else {

        if ($pass != $cpass) {
            $error[] = 'password not matched!';
        } else {
            $insert = "INSERT INTO user_form(name, email, password, user_type) VALUES('$name','$email','$pass','user')";
            mysqli_query($conn, $insert);
            header('location:html.php');
        }
    }
} else if (!empty($_POST['book'])) {
    session_start();
    if ($_SESSION['user_name'] == '') {
        header('location:html.php#book');
    } else {
        $user_name = $_SESSION['user_name'];
        $dest = mysqli_real_escape_string($conn, $_POST['dest']);
        $num = mysqli_real_escape_string($conn, $_POST['num']);
        $arrival = mysqli_real_escape_string($conn, $_POST['arrival']);
        $leaving = mysqli_real_escape_string($conn, $_POST['leaving']);

        $insert = "INSERT INTO book(id,user,destination, num, arrival, leaving) VALUES('aa','$user_name','$dest','$num','$arrival','$leaving')";
        mysqli_query($conn, $insert);

        header('location:html.php');
    }
}
function readTripsTable()
{
    $SQL = "select * from tripstable order by id";
    $conn = mysqli_connect('localhost', 'root', '', 'user_db');
    $result = mysqli_query($conn, $SQL);
    while ($res = mysqli_fetch_assoc($result)) {
        $dts[] = $res;
    }
    return $dts;
}
function readTravelsTable()
{
    $SQL = "select * from travelstable order by id";
    $conn = mysqli_connect('localhost', 'root', '', 'user_db');
    $result = mysqli_query($conn, $SQL);
    while ($res = mysqli_fetch_assoc($result)) {
        $dts[] = $res;
    }
    return $dts;
}

?>

<!DOCTYPE html>
<html lang="eng">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Travelopedia</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="css.css">




</head>

<body>

    <header>


        <div id="menu-bar" class="fas fa-bars"></div>
        <div class="logo">
            <img id="logof" src="media/photos/logo2.png" alt="logo">
        </div>
        <a href="#" class="logo"><span>T</span>ravelopedia</a>





        <nav class="navbar">
            <a href="#home">Home</a>
            <a href="#gallery">Gallery</a>
            <a href="#trips">Trips</a>
            <a href="#travels">Travels</a>
            <a href="#services">Services</a>
            <a href="#review">Review</a>
        </nav>

        <div class="icons">
            <i class="fas fa-search" id="search-btn"></i>
            <i class="fas fa-user" id="login-btn"></i>
        </div>
        <nav class="navbar">
            <a href="#"><?php
                        session_start();

                        if (isset($_SESSION['user_name'])) {
                            echo $_SESSION['user_name'];
                        } else {
                            unset($_SESSION['user_name']);
                        }
                        ?></a>
            <a href="logOut.php">
                <?php
                if (isset($_SESSION['user_name'])) {
                    echo 'log out';
                } else {
                    unset($_SESSION['user_name']);
                }
                ?>
            </a>

        </nav>

        <form action="" class="search-bar-container">
            <input type="search" id="search-bar" placeholder="search here...">
            <label for="search-bar" class="fas fa-search"></label>
        </form>
    </header>
    <div class="signup-form-container">



        <form action='' class="sign_up_form" method="POST">
            <i class="fas fa-times" id="form-close2"></i>
            <h3 class="form-title"> Sign Up</h3>
            <input type="text" placeholder="Username" class="box" name="name" />

            <input type="email" placeholder="email adress" class="box" name="email" />

            <input type="password" placeholder="Password" class="box" name="password" />
            <input type="password" placeholder="confirm Password" class="box" name="cpassword" />

            <input type="submit" class="btn" value="submit" name="sign" />
            <p>Already have an account? <a href="#" id="login_form_open">Login</a></p>
            <img src="undraw_world_re_768g.svg" alt="" class="image" />
            <h4 class="form-title"> Or sign up with social platforms</h4>
            <div class="social-media">
                <a href="#" class="social-icon">
                    <i class="fab fa-facebook"></i>
                </a>
                <a href="#" class="social-icon">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="social-icon">
                    <i class="fab fa-google"></i>
                </a>
                <a href="#" class="social-icon">
                    <i class="fab fa-linkedin"></i>
                </a>
            </div>
        </form>
    </div>
    <!-- here we will take login form-->
    <div class="login-form-container">
        <form action='' class="login_form" method="POST">
            <i class="fas fa-times" id="form-close"></i>
            <h3>login</h3>
            <?php
            if (isset($error)) {
                foreach ($error as $error) {
                    echo '<span class="error-msg">' . $error . '</span>';
                };
            };
            ?>
            <input type="email" class="box" placeholder="enter your email" name="mail" />
            <input type="password" class="box" placeholder="enter your password" name="pass" />
            <input type="submit" value="login now" class="btn" name="go" />
            <p>forget password? <a href="#">click here</a></p>
            <p>don't have and account? <a href="#" id="sign_up_form_open">register now</a></p>
        </form>
    </div>
    <section class="home" id="home">
        <div class="content">
            <h3>we are here</h3>
            <p>Life is short and the world is wide!</p>
            <a href="#" class="btn" id="discover_login_form_open">discover more</a>
        </div>
        <div class="controls">
            <span class="vid-btn active" data-src="media/videos/vid-1.mp4"></span>
            <span class="vid-btn" data-src="media/videos/vid-2.mp4"></span>
            <span class="vid-btn" data-src="media/videos/vid-3.mp4"></span>
            <span class="vid-btn" data-src="media/videos/vid-4.mp4"></span>
            <span class="vid-btn" data-src="media/videos/vid-5.mp4"></span>
        </div>
        <div class="video-container">
            <video src="media/videos/vid-1.mp4" id="video-slider" loop autoplay muted></video>

        </div>
    </section>




    <!-- Gallery Section Starts  -->
    <section class="gallery" id="gallery">

        <h1 class="heading">
            <span>G</span>
            <span>A</span>
            <span>L</span>
            <span>L</span>
            <span>E</span>
            <span>R</span>
            <span>Y</span>
        </h1>

        <div class="box-container">

            <div class="box">
                <img src="media/photos/g-1.jpg" alt="">
                <div class="content">
                    <h3>Alexandria</h3>
                    <p> Alexandria has a history that not many others can match . Founded by Alexander the Great, home
                        of Cleopatra, and razzmatazz renegade city of the Mediterranean for much of its life, this
                        seafront city has an appealing days-gone-by atmosphere that can't be beaten.</p>
                </div>
            </div>
            <div class="box">
                <img src="media/photos/g-2.jpg" alt="">
                <div class="content">
                    <h3>Abu Simbel</h3>
                    <p>Even in a country festooned with temples, Abu Simbel is something special. This is Ramses II's
                        great temple, adorned with colossal statuary standing guard outside, and with an interior
                        sumptuously decorated with wall paintings.</p>
                </div>
            </div>
            <div class="box">
                <img src="media/photos/g-3.jpg" alt="">
                <div class="content">
                    <h3>Diving the Red Sea</h3>
                    <p>The coral reefs of the Red Sea are renowned among scuba divers for both the soft corals on
                        display and the vast amount of sea life, ranging from colorful reef fish and nudibranchs, to
                        sharks, dolphins, turtles, rays, and even dugongs.</p>
                </div>
            </div>
            <div class="box">
                <img src="media/photos/g-4.jpg" alt="">
                <div class="content">
                    <h3>Saqqara</h3>
                    <p>Everyone's heard of Giza's Pyramids, but they're not the only pyramids Egypt has up its sleeve.
                        Day-tripping distance from Cairo, Saqqara is a vast necropolis of tombs and pyramids that was
                        utilized during every era of pharaonic rule.</p>
                </div>
            </div>
            <div class="box">
                <img src="media/photos/g-5.jpg" alt="">
                <div class="content">
                    <h3>Egyptian Museum</h3>
                    <p>A treasure trove of the Pharaonic world, Cairo's Egyptian Museum is one of the world's great
                        museum collections. The faded pink mansion in downtown Cairo is home to a dazzling amount of
                        exhibits.</p>
                </div>
            </div>
            <div class="box">
                <img src="media/photos/g-6.jpg" alt="">
                <div class="content">
                    <h3>White Desert</h3>
                    <p>Egypt's kookiest natural wonder is White Desert National Park, out in the Western Desert, just
                        south of Bahariya Oasis. Here, surreally shaped chalk pinnacles and huge boulders loom over the
                        desert plateau, creating a scene that looks like icebergs have found themselves stranded amid a
                        landscape of sand.</p>
                </div>
            </div>
            <div class="box">
                <img src="media/photos/g-7.jpg" alt="">
                <div class="content">
                    <h3>Siwa Oasis</h3>
                    <p>Sitting in isolation, in the western corner of the Western Desert, Siwa is the tranquil tonic to
                        the hustle of Egypt's cities. This gorgeous little oasis, surrounded by date palm plantations
                        and numerous hot-water springs, is one of the Western Desert's most picturesque spots.</p>
                </div>
            </div>
            <div class="box">
                <img src="media/photos/g-8.jpg" alt="">
                <div class="content">
                    <h3>St. Catherine's Monastery</h3>
                    <p>One of the oldest monasteries in the world, St. Catherine's stands at the foot of Mount Sinai,
                        amid the desert mountains of the Sinai Peninsula, where Moses is said to have received the Ten
                        Commandments.</p>
                </div>
            </div>
            <div class="box">
                <img src="media/photos/g-9.jpg" alt="">
                <div class="content">
                    <h3>The Giza pyramid complex</h3>
                    <p>also called the Giza necropolis, is the site on the Giza Plateau in Greater Cairo, Egypt that
                        includes the Great Pyramid of Giza, the Pyramid of Khafre, and the Pyramid of Menkaure, along
                        with their associated pyramid complexes and the Great Sphinx of Giza. All were built during the
                        Fourth Dynasty of the Old Kingdom of Ancient Egypt</p>
                </div>
            </div>

        </div>

    </section>
    <!-- Gallery Section Ends  -->

    <!-- trips section starts  -->

    <section class="trips" id="trips">

        <h1 class="heading">
            <span>T</span>
            <span>R</span>
            <span>I</span>
            <span>P</span>
            <span>S</span>

        </h1>

        <div class="box-container">

            <div class="box">
                <img src="media/photos/luxor.jpg">
                <div class="content">
                    <h3> <i class="fas fa-map-marker-alt"></i>Luxor and Aswan </h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis, nam!</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                    <div class="price"> $80.00 <span>$120.00</span> </div>
                    <button class="btn" id="bookNow1">book now</button>
                </div>
            </div>

            <div class="box">
                <img src="media/photos/siwa.jpg">
                <div class="content">
                    <h3> <i class="fas fa-map-marker-alt"></i> Siwa </h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis, nam!</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                    <div class="price"> $90.00 <span>$120.00</span> </div>
                    <button class="btn" id="bookNow2">book now</button>
                </div>
            </div>

            <div class="box">
                <img src="media/photos/sharmm.jpg">
                <div class="content">
                    <h3> <i class="fas fa-map-marker-alt"></i> Sharm El-Shaikh </h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis, nam!</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                    <div class="price"> $90.00 <span>$120.00</span> </div>
                    <button class="btn" id="bookNow3">book now</button>
                </div>
            </div>

            <div class="box">
                <img src="media/photos/hurghada.jpg">
                <div class="content">
                    <h3> <i class="fas fa-map-marker-alt"></i> Hurghada </h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis, nam!</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                    <div class="price"> $90.00 <span>$120.00</span> </div>
                    <button class="btn" id="bookNow4">book now</button>
                </div>
            </div>

            <div class="box">
                <img src="media/photos/dahab.jpg">
                <div class="content">
                    <h3> <i class="fas fa-map-marker-alt"></i> Dahab </h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis, nam!</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                    <div class="price"> $90.00 <span>$120.00</span> </div>
                    <button class="btn" id="bookNow5">book now</button>
                </div>
            </div>




            <div class="box">
                <img src="media/photos/taba2.jpg">
                <div class="content">
                    <h3> <i class="fas fa-map-marker-alt"></i> Taba </h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis, nam!</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                    <div class="price"> $90.00 <span>$120.00</span> </div>
                    <button class="btn" id="bookNow6">book now</button>
                </div>
            </div>

            <div class="box">
                <img src="media/photos/sant.jpg">
                <div class="content">
                    <h3> <i class="fas fa-map-marker-alt"></i> Siant Catherine </h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis, nam!</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                    <div class="price"> $90.00 <span>$120.00</span> </div>
                    <button class="btn" id="bookNow7">book now</button>
                </div>
            </div>


            <div class="box">
                <img src="media/photos/sharm2.jpg">
                <div class="content">
                    <h3> <i class="fas fa-map-marker-alt"></i>Marsa Alam </h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis, nam!</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                    <div class="price"> $90.00 <span>$120.00</span> </div>
                    <button class="btn" id="bookNow8">book now</button>
                </div>
            </div>
            <div class="box">
                <img src="media/photos/ras.jpg">
                <div class="content">
                    <h3> <i class="fas fa-map-marker-alt"></i> Ras Shaitan</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis, nam!</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                    <div class="price"> $90.00 <span>$120.00</span> </div>
                    <button class="btn" id="bookNow9">book now</button>
                </div>
            </div>



        </div>

    </section>

    <!-- trips section ends -->


    <!-- travels section starts  -->

    <section class="travels" id="travels">

        <h1 class="heading">
            <span>T</span>
            <span>R</span>
            <span>A</span>
            <span>V</span>
            <span>E</span>
            <span>L</span>
            <span>S</span>

        </h1>

        <div class="box-container">

            <div class="box">
                <img src="media/photos/bali.jpg" alt="">
                <div class="content">
                    <h3> <i class="fas fa-map-marker-alt"></i> Bali</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis, nam!</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                    <div class="price"> $90.00 <span>$120.00</span> </div>
                    <button class="btn" id="bookNow10">book now</button>
                </div>
            </div>

            <div class="box">
                <img src="media/photos/hawaii.jpeg" alt="">
                <div class="content">
                    <h3> <i class="fas fa-map-marker-alt"></i> Hawaii </h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis, nam!</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                    <div class="price"> $90.00 <span>$120.00</span> </div>
                    <button class="btn" id="bookNow11">book now</button>
                </div>
            </div>

            <div class="box">
                <img src="media/photos/maldives.jpeg" alt="">
                <div class="content">
                    <h3> <i class="fas fa-map-marker-alt"></i> Maldives </h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis, nam!</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                    <div class="price"> $90.00 <span>$120.00</span> </div>
                    <button class="btn" id="bookNow12">book now</button>
                </div>
            </div>


            <div class="box">
                <img src="media/photos/paris.jpeg" alt="">
                <div class="content">
                    <h3> <i class="fas fa-map-marker-alt"></i> France</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis, nam!</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                    <div class="price"> $90.00 <span>$120.00</span> </div>
                    <button class="btn" id="bookNow13">book now</button>
                </div>
            </div>

            <div class="box">
                <img src="media/photos/mexico.jpg" alt="">
                <div class="content">
                    <h3> <i class="fas fa-map-marker-alt"></i> Mexico </h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis, nam!</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                    <div class="price"> $90.00 <span>$120.00</span> </div>
                    <button class="btn" id="bookNow14">book now</button>
                </div>
            </div>

            <div class="box">
                <img src="media/photos/egypt.jpeg" alt="">
                <div class="content">
                    <h3> <i class="fas fa-map-marker-alt"></i> Egypt </h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis, nam!</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                    <div class="price"> $90.00 <span>$120.00</span> </div>
                    <button class="btn" id="bookNow15">book now</button>
                </div>
            </div>
            <div class="box">
                <img src="media/photos/turkey.jpg" alt="">
                <div class="content">
                    <h3> <i class="fas fa-map-marker-alt"></i> Turkey </h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis, nam!</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                    <div class="price"> $90.00 <span>$120.00</span> </div>
                    <button class="btn" id="bookNow16">book now</button>
                </div>
            </div>

            <div class="box">
                <img src="media/photos/los.jpg" alt="">
                <div class="content">
                    <h3> <i class="fas fa-map-marker-alt"></i> Los Angeles </h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis, nam!</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                    <div class="price"> $90.00 <span>$120.00</span> </div>
                    <button class="btn" id="bookNow17">book now</button>
                </div>
            </div>

            <div class="box">
                <img src="media/photos/japan.jpeg" alt="">
                <div class="content">
                    <h3> <i class="fas fa-map-marker-alt"></i> Japan</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis, nam!</p>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                    <div class="price"> $90.00 <span>$120.00</span> </div>
                    <button class="btn" id="bookNow18">book now</button>
                </div>
            </div>


        </div>

    </section>

    <!-- travels section ends -->

    <!-- book form starts -->

    <div class="bookFormContainer">


        <form action="" method="POST">
            <i class="fas fa-times" id="form-close3"></i>
            <h3 class="form-title"> Book now !</h3>
            <div class="inputBox">
                <h3>where to</h3>
                <select name="dest" id="" class="select">
                    <?php $trips = readTripsTable(); ?>
                    <?php $travels = readTravelsTable(); ?>

                    <optgroup label="Trips">
                        <?php
                        foreach ($trips as $option) {
                        ?>
                            <option value="<?php echo $option['trips']; ?>"><?php echo $option['trips']; ?></option>
                        <?php
                        }
                        ?>
                    </optgroup>
                    <optgroup label="Travels">
                        <?php
                        foreach ($travels as $option) {
                        ?>
                            <option value="<?php echo $option['travels']; ?>"><?php echo $option['travels']; ?></option>
                        <?php
                        }
                        ?>
                    </optgroup>
                </select>

            </div>
            <div class="inputBox">
                <h3>how many</h3>
                <input type="number" placeholder="number of guests" name="num">
            </div>

            <div class="inputBox">
                <h3>arrivals</h3>
                <input type="date" name="arrival">
            </div>
            <div class="inputBox">
                <h3>leaving</h3>
                <input type="date" name="leaving">
            </div>
            <input type="submit" class="btn" value="book now" name="book">
        </form>
    </div>

    <!-- Services Section Starts  -->
    <section class="services" id="services">
        <h1 class="heading">
            <span>S</span>
            <span>E</span>
            <span>R</span>
            <span>V</span>
            <span>I</span>
            <span>C</span>
            <span>E</span>
            <span>S</span>
        </h1>

        <div class="box-container">

            <div class="box">
                <i class="fas fa-hotel"></i>
                <h3>Affordable hotels</h3>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Inventore commodi earum, quis voluptate exercitationem ut minima itaque iusto ipsum corrupti!</p>
            </div>
            <div class="box">
                <i class="fas fa-utensils"></i>
                <h3>Food and drinks</h3>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Inventore commodi earum, quis voluptate exercitationem ut minima itaque iusto ipsum corrupti!</p>
            </div>
            <div class="box">
                <i class="fas fa-bullhorn"></i>
                <h3>Safty guide</h3>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Inventore commodi earum, quis voluptate exercitationem ut minima itaque iusto ipsum corrupti!</p>
            </div>
            <div class="box">
                <i class="fas fa-globe-asia"></i>
                <h3>Around the world</h3>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Inventore commodi earum, quis voluptate exercitationem ut minima itaque iusto ipsum corrupti!</p>
            </div>
            <div class="box">
                <i class="fas fa-plane"></i>
                <h3>Fastest travel</h3>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Inventore commodi earum, quis voluptate exercitationem ut minima itaque iusto ipsum corrupti!</p>
            </div>
            <div class="box">
                <i class="fas fa-hiking"></i>
                <h3>Adventures</h3>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Inventore commodi earum, quis voluptate exercitationem ut minima itaque iusto ipsum corrupti!</p>
            </div>

        </div>

    </section>

    <!-- Services Section Ends  -->


    <!-- Review starts-->
    <section class="review" id="review">
        <h1 class="heading">
            <span>R</span>
            <span>E</span>
            <span>V</span>
            <span>I</span>
            <span>E</span>
            <span>W</span>
        </h1>
        <div class="review-container">
            <div class="card">
                <img id="image" src="media/photos/man1.jpg" alt="Avatar">
                <div class="container">
                    <p class="name">Henry</p>
                    <h4>
                        <span id="checked" class="fa fa-star "></span>
                        <span id="checked" class="fa fa-star "></span>
                        <span id="checked" class="fa fa-star "></span>
                        <span id="checked" class="fa fa-star "></span>
                        <span id="checked" class="fa fa-star"></span>
                    </h4>
                    <p>I am very pleased to say that yet another time it has been a great experience with Travelopedia . the trip was well crafted all arrangments were perfect . Excellent help provided by admins of website. Looking forward for many more trips with you.</p>
                </div>
            </div>
            <div class="card">
                <img id="image" src="media/photos/women.jpg" alt="Avatar">
                <div class="container">
                    <p class="name">Olivia</p>
                    <h4>
                        <span id="checked" class="fa fa-star "></span>
                        <span id="checked" class="fa fa-star "></span>
                        <span id="checked" class="fa fa-star "></span>
                        <span id="checked" class="fa fa-star "></span>
                        <span id="checked" class="fa fa-star"></span>
                    </h4>
                    <p>Everything was provided as promised.</p>
                </div>
            </div>
            <div class="card">
                <img id="image" src="media/photos/man.jpg" alt="Avatar">
                <div class="container">
                    <p class="name">Travis </p>
                    <h4>
                        <span id="checked" class="fa fa-star "></span>
                        <span id="checked" class="fa fa-star "></span>
                        <span id="checked" class="fa fa-star "></span>
                        <span id="checked" class="fa fa-star "></span>
                        <span id="checked" class="fa fa-star-o"></span>
                    </h4>
                    <p>I am delighted by services and support offered by travel agent. Had a memorable trip. </p>
                </div>
            </div>
        </div>
        <div class="review-container">
            <div class="card">
                <img id="image" src="media/photos/women2.png" alt="Avatar">
                <div class="container">
                    <p class="name">Emma</p>
                    <h4>
                        <span id="checked" class="fa fa-star "></span>
                        <span id="checked" class="fa fa-star "></span>
                        <span id="checked" class="fa fa-star "></span>
                        <span id="checked" class="fa fa-star "></span>
                        <span id="checked" class="fa fa-star-o"></span>
                    </h4>
                    <p>Excellent Tue views from hotel balconies and road trips.</p>
                </div>
            </div>
            <div class="card">
                <img id="image" src="media/photos/man2.jpg" alt="Avatar">
                <div class="container">
                    <p class="name">Kevin</p>
                    <h4>
                        <span id="checked" class="fa fa-star "></span>
                        <span id="checked" class="fa fa-star "></span>
                        <span id="checked" class="fa fa-star "></span>
                        <span id="checked" class="fa fa-star "></span>
                        <span id="checked" class="fa fa-star"></span>
                    </h4>
                    <p>Had a very amazing offer and time with travel triangle and the vendor's services were very good. Professional service of great quality.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Review ends-->

    <!-- footer  starts -->
    <footer>
        <div class="footer-content">
            <div class="logofooter">
                <img id="logof" src="media/photos/logo2.png" alt="logo">
                <p id="desc">When we chose “ Travelopedia “ as our company name, we meant more than merely an image for our corporation. The choice was built upon our firm commitment to offer the best service possible for our clients. In order to achieve this objective, it became imperative that we give our clients the hospitality and warm reception that they deserve.</p>
            </div>
            <div class="contactus">
                <ul class="socials">
                    <li><a href="https://www.facebook.com"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="https://www.twitter.com"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="https://www.instagram.com"><i class="fa fa-instagram"></i></a></li>
                </ul>
            </div>
            <div class="footer-bottom">
                <p>copyright &copy;2022 <a>FCIS 2025</a> </p>
            </div>
        </div>
    </footer>
    <!-- footer  end -->


    <script src="js.js"></script>

</body>

</html>