<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: doctorRegister.php"); // Redirect if not logged in
    exit();
}

$doctorusername = $_SESSION['username'] ?? 'Doctor';

// Include DB connection
require_once 'db.php';

$query = "SELECT COUNT(*) AS total_doctors FROM doctors";
$result = $mysqli->query($query);

if ($result) {
    $row = $result->fetch_assoc();
    $total_doctors = $row['total_doctors'];
} else {
    $total_doctors = "Error fetching data: " . $mysqli->error;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DocApp</title>
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- normalize css -->
    <link rel = "stylesheet" href = "style/userNormalize.css">
    <!-- custom css -->
    <link rel = "stylesheet" href = "style/docMain.css">
</head>
<body>
  <style>
  </style>

    <!-- header -->
    <header class = "header bg-blue">
    <nav class="navbar bg-blue">
      <div class="container flex">
        <div class="DocApp_logo_left">
          <img src="imagesforweb/DocApp_Medical_Logo_Design.png" />
        </div>

        <a href="doctorDashboard.php" class="navbar-brand"></a>
        <button type="button" class="navbar-show-btn">
          <img src="imagesforweb/ham-menu-icon.png" />
        </button>

        <div class="navbar-collapse bg-white">
          <button type="button" class="navbar-hide-btn">
            <img src="imagesforweb/close-icon.png" />
          </button>
          <ul class="navbar-nav">
              <li class="nav-item"><a href="#" data-page="services.php" class="nav-link">Service</a></li>
              <li class="nav-item"><a href="#" data-page="doctorsList.php" class="nav-link">Doctors-List</a></li>
              <li class="nav-item"><a href="#" data-page="department.php" class="nav-link">Departments</a></li>
              <li class="nav-item"><a href="#" data-page="blog.php" class="nav-link">Blog</a></li>
              <li class="nav-item"><a href="#" data-page="info.php" class="nav-link">About</a></li>
          </ul>
          <div class="user-menu">
            <button class="user-btn" onclick="toggleDropdown()">
              <img src="imagesforweb/Doctor_icon.jpg" alt="User Icon" class="user-icon" />
              <span class="username"><?php echo $doctorusername; ?></span>
              <span class="arrow" id="arrow">&#9662;</span> <!-- ▼ -->
            </button>

            <div class="dropdown" id="dropdown-menu">
              <a href="doctorsProfile1.php">My Profile</a>
              <a href="editDoctorProfile.php">Edit Profile</a>
              <a href="#">Report a bug</a>
              <a href="#">My Certificates</a>
              <a href="#">My Bookmarks</a>
              <hr />
              <button class="logout-btn" onclick="window.location.href='guest.php'">LOGOUT</button>
            </div>
          </div>
        </div>
      </div>
    </nav>

        
    </header>
    <!-- end of header -->

    <main>
        <div id="content">
        <!-- about section -->
         <div class = "header-inner text-white text-center">
            <div class = "container grid">
                <div class = "header-inner-left">
                    <h1>We're Glad to Have You!<br> </h1>
                    <p class = "lead"></p>
                    <p class = "text text-md">Revolutionize your healthcare journey with our project, redefining how doctor appointments are scheduled and ensuring a seamless, patient-first approach.</p>
                    <div class = "btn-group">
                        <a href="doctor_prescriptions.php" class="btn btn-light-blue">Checkout Appointment</a>
                        <!-- <a href="index1.php" class="btn btn-light-blue">Approach</a> -->
                    </div>
                </div>
                <div class = "header-inner-right">
                    <img src = "imagesforweb/doctor-female.png">
                </div>
            </div>
        </div>
        <section id = "about" class = "about py">
            <div class = "about-inner">
                <div class = "container grid">
                    <div class = "about-left text-center">
                        <div class = "section-head">
                            <h2>About Us</h2>
                            <div class = "border-line"></div>
                        </div>
                        <p class = "text text-lg">Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae molestias delectus facilis, temporibus eum consectetur, a debitis exercitationem quae distinctio aliquid ea ipsam vitae esse amet soluta maxime dolorem? Inventore ut maiores illo ipsum nisi, nulla eligendi unde reiciendis quod voluptas velit sit voluptate perferendis cum pariatur molestiae tenetur repellat!</p>
                        <a href = "#" class = "btn btn-white">Learn More</a>
                    </div>
                    <div class = "about-right flex">
                        <div class = "img">
                            <img src = "imagesforweb/about-img.png">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end of about section -->

        <!-- banner one -->
        <section id="banner-one" class="banner-one text-center">
            <div class="container text-white">
            <h3>Doctor Sign in</h3>
            <blockquote class="lead">
                <i class="fas fa-quote-left"></i> 
                    When you are young and healthy, it never occurs to you that in a single second your whole life could change. 
                <i class="fas fa-quote-right"></i>
            </blockquote>
            <small class="text text-sm">- Anonim Nano</small>
            </div>
        </section>
        <!-- end of banner one -->

        <!-- services section -->
        <section id = "services" class = "services py">
            <div class = "container">
                <div class = "section-head text-center">
                    <h2 class = "lead">The Best Doctor gives the least medicines</h2>
                    <p class = "text text-lg">A perfect way to show your hospital services</p>
                    <div class = "line-art flex">
                        <div></div>
                        <img src = "imagesforweb/4-dots.png">
                        <div></div>
                    </div>
                </div>
                <div class = "services-inner text-center grid">
                    <article class = "service-item">
                        <div class = "icon">
                            <img src = "imagesforweb/service-icon-1.png">
                        </div>
                        <h3>Cardio Monitoring</h3>
                        <p class = "text text-sm">Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis possimus doloribus facilis velit, assumenda tempora quas mollitia quos voluptatibus consequatur!</p>
                    </article>

                    <article class = "service-item">
                        <div class = "icon">
                            <img src = "imagesforweb/service-icon-2.png">
                        </div>
                        <h3>Medical Treatment</h3>
                        <p class = "text text-sm">Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis possimus doloribus facilis velit, assumenda tempora quas mollitia quos voluptatibus consequatur!</p>
                    </article>

                    <article class = "service-item">
                        <div class = "icon">
                            <img src = "imagesforweb/service-icon-3.png">
                        </div>
                        <h3>Emergency Help</h3>
                        <p class = "text text-sm">Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis possimus doloribus facilis velit, assumenda tempora quas mollitia quos voluptatibus consequatur!</p>
                    </article>

                    <article class = "service-item">
                        <div class = "icon">
                            <img src = "imagesforweb/service-icon-4.png">
                        </div>
                        <h3>First Aid</h3>
                        <p class = "text text-sm">Pain itself sits on the dignity of the elite, and we can easily assume the times when those who are happy with their pleasures follow.</p>
                    </article>
                </div>
            </div>
        </section>
        <!-- end of services section -->

        <!-- banner two section -->
        <section id = "banner-two" class = "banner-two text-center">
            <div class = "container grid">
                <div class = "banner-two-left">
                    <img src = "imagesforweb/banner-2-img.png">
                </div>
                <div class = "banner-two-right">
                    <p class = "lead text-white">When you are young and healthy, it never occurs to you that in a single second your whole life could change.</p>
                    <p class="total-doctors">Total registered doctors: <?php echo htmlspecialchars($total_doctors); ?></p>
                    <div class = "btn-group">
                        <a href = "doctorsList.php" class = "btn btn-light-blue" >Doctors_list</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- end of banner two section -->

        <!-- doctors section -->
        <section id = "doc-panel" class = "doc-panel py">
            <div class = "container">
                <div class = "section-head">
                    <h2>Our Doctor Panel</h2>
                </div>

                <div class = "doc-panel-inner grid">
                    <div class = "doc-panel-item">
                        <div class = "img flex">
                            <a href="Profile1.php"> <!-- Add this line -->
                                <img src="imagesforweb/doc-1.png" alt="doctor image">
                                <div class="info text-center bg-blue text-white flex">
                                    <p class="lead">samuel goe</p>
                                    <p class="text-lg">Medicine</p>
                                </div>
                            </a> 
                        </div>
                    </div>

                    <div class = "doc-panel-item">
                        <div class = "img flex">
                            <a href="Profile2.php">
                                <img src = "imagesforweb/doc-2.png" alt = "doctor image">
                                <div class = "info text-center bg-blue text-white flex">
                                    <p class = "lead">elizabeth ira</p>
                                    <p class = "text-lg">Cardiology</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class = "doc-panel-item">
                        <div class = "img flex">
                            <a href="Profile3.php">
                                <img src = "imagesforweb/doc-3.png" alt = "doctor image">
                                <div class = "info text-center bg-blue text-white flex">
                                    <p class = "lead">tanya collins</p>
                                    <p class = "text-lg">Medicine</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end of doctors section -->

        <!-- package services section -->
        <section id = "package-service" class = "package-service py text-center">
            <div class = "container">
                <div class = "package-service-head text-white">
                    <h2>Package Service</h2>
                    <p class = "text text-lg">Best service package for you</p>
                </div>
                <div class = "package-service-inner grid">
                    <div class = "package-service-item bg-white">
                        <div class = "icon flex">
                            <i class = "fas fa-phone fa-2x"></i>
                        </div>
                        <h3>Regular Case</h3>
                        <p class = "text text-sm">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Consequatur, asperiores. Expedita, reiciendis quos beatae at consequatur voluptatibus fuga iste adipisci.</p>
                        <a href = "#" class = "btn btn-blue">Read More</a>
                    </div>

                    <div class = "package-service-item bg-white">
                        <div class = "icon flex">
                            <i class = "fas fa-calendar-alt fa-2x"></i>
                        </div>
                        <h3>Serious Case</h3>
                        <p class = "text text-sm">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Consequatur, asperiores. Expedita, reiciendis quos beatae at consequatur voluptatibus fuga iste adipisci.</p>
                        <a href = "#" class = "btn btn-blue">Read More</a>
                    </div>

                    <div class = "package-service-item bg-white">
                        <div class = "icon flex">
                            <i class = "fas fa-comments fa-2x"></i>
                        </div>
                        <h3>Emergency Case</h3>
                        <p class = "text text-sm">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Consequatur, asperiores. Expedita, reiciendis quos beatae at consequatur voluptatibus fuga iste adipisci.</p>
                        <a href = "#" class = "btn btn-blue">Read More</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- end of package services section -->

        <!-- posts section -->
        <section id = "posts" class = "posts py">
            <div class = "container">
                <div class = "section-head">
                    <h2>Latest Post</h2>
                </div>
                <div class = "posts-inner grid">
                    <article class = "post-item bg-white">
                        <div class = "img">
                            <img src = "imagesforweb/post-1.jpg">
                        </div>
                        <div class = "content">
                            <h4>Inspiring stories of person and family centered care during a global pandemic.</h4>
                            <p class = "text text-sm">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolor voluptas eius recusandae sunt obcaecati esse facere cumque. Aliquid, cupiditate debitis.</p>
                            <p class = "text text-sm">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis quia ipsam, quis iure sed nulla.</p>
                            <div class = "info flex">
                                <small class = "text text-sm"><i class = "fas fa-clock"></i> October 27, 2021</small>
                                <small class = "text text-sm"><i class = "fas fa-comment"></i> 5 comments</small>
                            </div>
                        </div>
                    </article>

                    <article class = "post-item bg-white">
                        <div class = "img">
                            <img src = "imagesforweb/post-2.jpg">
                        </div>
                        <div class = "content">
                            <h4>Inspiring stories of person and family centered care during a global pandemic.</h4>
                            <p class = "text text-sm">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolor voluptas eius recusandae sunt obcaecati esse facere cumque. Aliquid, cupiditate debitis.</p>
                            <p class = "text text-sm">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis quia ipsam, quis iure sed nulla.</p>
                            <div class = "info flex">
                                <small class = "text text-sm"><i class = "fas fa-clock"></i> October 27, 2021</small>
                                <small class = "text text-sm"><i class = "fas fa-comment"></i> 5 comments</small>
                            </div>
                        </div>
                    </article>

                    <article class = "post-item bg-white">
                        <div class = "img">
                            <img src = "imagesforweb/post-3.jpg">
                        </div>
                        <div class = "content">
                            <h4>Inspiring stories of person and family centered care during a global pandemic.</h4>
                            <p class = "text text-sm">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolor voluptas eius recusandae sunt obcaecati esse facere cumque. Aliquid, cupiditate debitis.</p>
                            <p class = "text text-sm">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis quia ipsam, quis iure sed nulla.</p>
                            <div class = "info flex">
                                <small class = "text text-sm"><i class = "fas fa-clock"></i> October 27, 2021</small>
                                <small class = "text text-sm"><i class = "fas fa-comment"></i> 5 comments</small>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>
        <!-- end of posts section -->

        <!-- contact section -->
        <section id = "contact" class = "contact py">
            <div class = "container grid">
                <div class = "contact-left">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2384.6268289831164!2d-6.214682984112116!3d53.29621947996855!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x486709e0c9c80f8f%3A0x92f408d10f2277c2!2sDOC!5e0!3m2!1sen!2snp!4v1636264848776!5m2!1sen!2snp" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
                <div class = "contact-right text-white text-center bg-blue">
                    <div class = "contact-head">
                        <h3 class = "lead">Contact Us</h3>
                        <p class = "text text-md">Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga.</p>
                    </div>
                    <form>
                        <div class = "form-element">
                            <input type = "text" class = "form-control" placeholder="Your name">
                        </div>
                        <div class = "form-element">
                            <input type = "email" class = "form-control" placeholder="Your email">
                        </div>
                        <div class = "form-element">
                            <textarea rows = "5" placeholder="Your Message" class = "form-control"></textarea>
                        </div>
                        <button type = "submit" class = "btn btn-white btn-submit">
                            <i class = "fas fa-arrow-right"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>
        </section></div>
        <!-- end of contact section -->
    </main>


    <!-- footer  -->
    <footer id = "contact" class = "footer text-center">
        <div class = "container">
            <div class = "footer-inner text-white py grid">
                <div class = "footer-item">
                    <h3 class = "footer-head">about us</h3>
                    <div class = "icon">
                        <img src = "imagesforweb/logo.png">
                    </div>
                    <p class = "text text-md">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Debitis saepe incidunt fugiat optio corporis ea!</p>
                    <address>
                        Medic Clinic <br>
                        69 Deerpark Rd, Mount Merrion <br>
                        Co. Dublin, A94 E9D3 <br>
                        Ireland
                    </address>
                </div>

                <div class = "footer-item">
                    <h3 class = "footer-head">tags</h3>
                    <ul class = "tags-list flex">
                        <li>medical care</li>
                        <li>emergency</li>
                        <li>therapy</li>
                        <li>surgery</li>
                        <li>medication</li>
                        <li>nurse</li>
                    </ul>
                </div>

                <div class = "footer-item">
                    <h3 class = "footer-head">Quick Links</h3>
                    <ul>
                        <li><a href = "#" class = "text-white">Our Services</a></li>
                        <li><a href = "#" class = "text-white">Our Plan</a></li>
                        <li><a href = "#" class = "text-white">Privacy Policy</a></li>
                        <li><a href = "#" class = "text-white">Appointment Schedule</a></li>
                    </ul>
                </div>

                <div class = "footer-item">
                    <h3 class = "footer-head">make an appointment</h3>
                    <p class = "text text-md">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatum, omnis.</p>
                    <ul class = "appointment-info">
                        <li>8:00 AM - 11:00 AM</li>
                        <li>2:00 PM - 05:00 PM</li>
                        <li>8:00 PM - 11:00 PM</li>
                        <li>
                            <i class = "fas fa-envelope"></i>
                            <span>appointmentdibo@gmail.com</span>
                        </li>
                        <li>
                            <i class = "fas fa-phone"></i>
                            <span>+003 478 2834(00)</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class = "footer-links">
                <ul class = "flex">
                    <li><a href = "#" class = "text-white flex"> <i class = "fab fa-facebook-f"></i></a></li>
                    <li><a href = "#" class = "text-white flex"> <i class = "fab fa-twitter"></i></a></li>
                    <li><a href = "#" class = "text-white flex"> <i class = "fab fa-linkedin"></i></a></li>
                </ul>
            </div>
        </div>
    </footer>
    <!-- end of footer  -->


    <!-- custom js -->
    <script src = "jsForWeb/dropdown.js"></script>
    <script src="jsForWeb/Scroll.js"></script>
        <script>
        $(".nav-link").click(function (e) {
    e.preventDefault();
    let $this = $(this);
    let page = $this.data("page");

    if (page) {
        // Scroll smoothly to top of content (if desired)
        $('html, body').animate({ scrollTop: $('#content').offset().top }, 500);

        // Load content dynamically
        $("#content").load(page, function (response, status, xhr) {
            if (status === "error") {
                console.error(`Error loading page: ${xhr.status} ${xhr.statusText}`);
                $("#content").html("<p>Sorry, the page could not be loaded.</p>");
            } else {
                // Set active class AFTER content is loaded
                $(".nav-link").removeClass("active");
                $this.addClass("active");
            }
        });

        // Close mobile navbar if open
        $(".navbar-collapse").removeClass("show");
        $(".navbar-show-btn").show();
        $(".navbar-hide-btn").hide();
    }
});

    </script>
    <script>
    $(document).on("click", ".nav-link", function (e) {
        e.preventDefault();
        let page = $(this).data("page");
        if (page) {
            $("#content").load(page + "?partial=1"); // Always request partial
        }
    });

    // ✅ Filter links like ?specialist=fever
    $(document).on("click", ".filter-link", function (e) {
        e.preventDefault();
        let url = $(this).attr("href");
        $("#content").load(url + "&partial=1");
    });

    // ✅ AJAX for Search Form submission
    $(document).on("submit", ".search-form", function (e) {
        e.preventDefault();
        const form = $(this);
        const action = form.attr("action");
        const query = form.serialize(); // Includes specialist if present
        $("#content").load(action + "?" + query + "&partial=1");
    });
</script>
</body>
</html>