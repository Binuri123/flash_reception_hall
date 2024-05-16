<?php
include 'header.php';
?>
<!-- ======= Hero Section ======= -->
<section id="hero" class="hero d-flex align-items-center section-bg" style="background-color:rgba(55, 55, 63, 0.04)">
    <div class="modal" id="myModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"><strong>Check Availability</strong></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="event" class="form-label">Event</label>
                            </div>
                            <div class="col-md-6">
                                <select class=""></select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                $today = date('Y-m-d');
                                $mindate = date('Y-m-d', strtotime('+14 days', strtotime($today)));
                                $maxdate = date('Y-m-d', strtotime('+1 year', strtotime($today)));
                                ?>
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" min="<?= $mindate ?>" max="<?= $maxdate ?>" class="form-control" placeholder="Pick a Date" id="start_date" name="start_date" value="<?= @$start_date ?>">
                            </div>
                            <div class="col-md-6">
                                <?php
                                $today = date('Y-m-d');
                                $mindate = date('Y-m-d', strtotime('+14 days', strtotime($today)));
                                $maxdate = date('Y-m-d', strtotime('+1 year', strtotime($today)));
                                ?>
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" min="<?= $mindate ?>" max="<?= $maxdate ?>" class="form-control" placeholder="Pick a Date" id="end_date" name="end_date" value="<?= @$end_date ?>">
                            </div>
                        </div>
                        <div class="row">
                            
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning btn-sm" data-bs-dismiss="modal">Close</button>
                    <a class="btn btn-success btn-sm" href="<?= WEB_PATH ?>customer/login.php">Make a Reservation</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-6 mt-3">
                <h3 data-aos="fade-up" style="font-family:cursive">Unforgettable Moments, Unmatched Elegance</h3>
                <p data-aos="fade-up" data-aos-delay="50" style="text-align: justify">
                    Welcome to our exquisite reception hall, where dreams become enchanting celebrations.
                    Discover the perfect setting for your special day, where cherished memories are created.
                    With carefully selected furniture, our venue sets the stage for unforgettable moments. 
                    Indulge in exquisite flavors that evoke emotions and delight taste buds, crafted by our talented chefs.
                </p>
                <div data-aos="fade-up" data-aos-delay="200">
                    <div class="row">
                        <div class="col-md-7">
                            <button type="button" class="btn btn-warning btn-outline-dark" data-bs-toggle="modal" data-bs-target="#myModal" style="font-weight:500;border:2px solid black">
                                Check Availability <i class="bi bi-question"></i>
                            </button>
                            <a href="register.php" class="btn btn-warning btn-outline-dark" style="font-weight:500;border:2px solid black"><span>Register</span> <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                    <!--<a href="#check_availability" class="btn-book-a-table">Check Availability</a>-->
                </div>
            </div>
            <div class="col-md-5 mt-3 mb-3" style="width:550px">
                <img src="assets/img/flash/home_page_side.jpg" style="height:400px;border-radius:10px" class="img-fluid" alt="" data-aos="zoom-out" data-aos-delay="300">
            </div>
        </div>
    </div>
</section><!-- End Hero Section -->
<main id="main">
    <!-- ======= About Section ======= -->
    <section id="about" class="about">
        <div class="container" data-aos="fade-up">
            <div class="section-header" style="font-family: cursive;text-align: center">
                <h2>About Us</h2>
                <p>Learn More <span>About Us</span></p>
            </div>
            <div class="row gy-4">
                <div class="col-lg-7 position-relative about-img" style="background-image: url(assets/img/about.jpg);border-radius:5px" data-aos="fade-up" data-aos-delay="150">
                    <div class="call-us position-absolute">
                        <h4>Check Availability</h4>
                        <p>0753311911 / 0753311811</p>
                    </div>
                </div>
                <div class="col-lg-5 d-flex align-items-end" data-aos="fade-up" data-aos-delay="300">
                    <div class="content ps-0 ps-lg-5">
                        <p class="fst-italic" style="text-align:justify">
                            Welcome to Flash Reception Hall in Dematagoda, where unforgettable celebrations come to life. 
                            With timeless charm and modern luxury, our stunning venue creates cherished memories. 
                            From intimate gatherings to grand receptions, our versatile spaces cater to your needs. 
                            Experience impeccable service and personalized hospitality as we bring your vision to life. 
                            Join us at Flash Reception Hall and make your event a shining success.
                            <!--Welcome to Flash Reception Hall, located in Dematagoda, 
                                where every celebration comes to life with a touch of brilliance. 
                                Discover the perfect setting for your special day, where cherished memories are created and unforgettable moments unfold. 
                                Our stunning reception hall, nestled in the heart of Dematagoda, combines timeless charm with modern luxury, providing an extraordinary venue for your events. 
                                From intimate gatherings to grand receptions, Flash Reception Hall offers versatile spaces tailored to your needs. 
                                Experience impeccable service, meticulous attention to detail, and personalized hospitality as we bring your vision to life. 
                                Join us at Flash Reception Hall, Dematagoda's premier destination, and let us make your event a shining success.-->
                        </p>
                        <p style="text-align:justify">
                            Experience exceptional hospitality at our banquet hall, equipped with all the facilities you need for a memorable reception. 
                            From weddings to conferences, we accommodate up to 250 guests with customizable options. 
                            Enjoy our excellent service and welcoming atmosphere. 
                            Choose us for your next function and create unforgettable moments.
                            <!--Our banquet hall, equipped with all the facilities you need for a memorable reception. 
                                From comfortable furniture to friendly stewards and experienced cooks, we cater to your every need. 
                                Whether it's a wedding, homecoming, party, or conference, we can accommodate up to 250 guests with ample parking available. 
                                Our excellent service etiquette ensures every guest feels welcomed, regardless of their origin or class. 
                                With customizable options for menu, price, and theme, we invite you to explore our services, menus, and environment. 
                                Choose us for your next function and experience exceptional hospitality.-->
                        </p>
                        <div class="position-relative mt-4">
                            <img src="assets/img/about-2.jpg" class="img-fluid" alt="">
                            <a href="https://www.youtube.com/watch?v=LXb3EKWsInQ" class="glightbox play-btn"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End About Section -->

    <!-- ======= Why Us Section ======= -->
    <section id="why-us" class="why-us section-bg" style="background-color:rgba(55, 55, 63, 0.04)">
        <div class="container" data-aos="fade-up">
            <div class="row gy-4">
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="why-box">
                        <h3 style="text-align: center">Why Choose Flash?</h3>
                        <p style="text-align:justify">
                            Experience elegance at Flash Reception Hall, where unforgettable moments unfold. 
                            Our carefully curated furniture sets the stage for your special day. 
                            Delight in exquisite flavors crafted by talented chefs. 
                            Let our courteous stewards and skilled coordinators assist in planning your perfect event. 
                            Accommodating 100-700 guests, our spacious ballroom awaits.
                        </p>
                    </div>
                </div><!-- End Why Box -->
                <div class="col-lg-8 d-flex align-items-center">
                    <div class="row gy-4">
                        <div class="col-xl-4" data-aos="fade-up" data-aos-delay="200">
                            <div class="icon-box d-flex flex-column justify-content-center align-items-center" style="height:442px;background-image: url('assets/img/flash/why_us_hall.jpeg');background-size:cover;background-position:center;">
                                <i class="bi bi-clipboard-data" style="color: #fff"></i>
                                <h4 style="color:#fff;font-weight:500">MAKE YOUR EVENTS UNFORGETTABLE</h4>
                            </div>
                        </div><!-- End Icon Box -->
                        <div class="col-xl-4" data-aos="fade-up" data-aos-delay="300">
                            <div class="icon-box d-flex flex-column justify-content-center align-items-center" style="height:442px;background-image: url('assets/img/flash/why_us_food.jpg');background-size:cover;background-position:center;">
                                <i class="bi bi-gem" style="color: #fff"></i>
                                <h4 style="color:#fff;font-weight:500">A WORLD OF DELICIOUS AROMAS AND FLAVOURS</h4>
                            </div>
                        </div><!-- End Icon Box -->
                        <div class="col-xl-4" data-aos="fade-up" data-aos-delay="400">
                            <div class="icon-box d-flex flex-column justify-content-center align-items-center"  style="height:442px;background-image: url('assets/img/flash/why_us_services.jpg');background-size:cover;background-position:center;">
                                <i class="bi bi-inboxes" style="color: #fff"></i>
                                <h4 style="color:#fff;font-weight:500">DISCOVER OUR SERVICES</h4>
                            </div>
                        </div><!-- End Icon Box -->
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Why Us Section -->

    <!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials section-bg">
        <div class="container" data-aos="fade-up">

            <div class="section-header">
                <h2>Testimonials</h2>
                <p>What Are They <span>Saying About Us</span></p>
            </div>

            <div class="slides-1 swiper" data-aos="fade-up" data-aos-delay="100">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="row gy-4 justify-content-center">
                                <div class="col-lg-6">
                                    <div class="testimonial-content">
                                        <p>
                                            <i class="bi bi-quote quote-icon-left"></i>
                                            Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit rhoncus. Accusantium quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam, risus at semper.
                                            <i class="bi bi-quote quote-icon-right"></i>
                                        </p>
                                        <h3>Saul Goodman</h3>
                                        <h4>Ceo &amp; Founder</h4>
                                        <div class="stars">
                                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 text-center">
                                    <img src="assets/img/testimonials/testimonials-1.jpg" class="img-fluid testimonial-img" alt="">
                                </div>
                            </div>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="row gy-4 justify-content-center">
                                <div class="col-lg-6">
                                    <div class="testimonial-content">
                                        <p>
                                            <i class="bi bi-quote quote-icon-left"></i>
                                            Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid cillum eram malis quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.
                                            <i class="bi bi-quote quote-icon-right"></i>
                                        </p>
                                        <h3>Sara Wilsson</h3>
                                        <h4>Designer</h4>
                                        <div class="stars">
                                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 text-center">
                                    <img src="assets/img/testimonials/testimonials-2.jpg" class="img-fluid testimonial-img" alt="">
                                </div>
                            </div>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="row gy-4 justify-content-center">
                                <div class="col-lg-6">
                                    <div class="testimonial-content">
                                        <p>
                                            <i class="bi bi-quote quote-icon-left"></i>
                                            Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam duis minim tempor labore quem eram duis noster aute amet eram fore quis sint minim.
                                            <i class="bi bi-quote quote-icon-right"></i>
                                        </p>
                                        <h3>Jena Karlis</h3>
                                        <h4>Store Owner</h4>
                                        <div class="stars">
                                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 text-center">
                                    <img src="assets/img/testimonials/testimonials-3.jpg" class="img-fluid testimonial-img" alt="">
                                </div>
                            </div>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="row gy-4 justify-content-center">
                                <div class="col-lg-6">
                                    <div class="testimonial-content">
                                        <p>
                                            <i class="bi bi-quote quote-icon-left"></i>
                                            Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster veniam enim culpa labore duis sunt culpa nulla illum cillum fugiat legam esse veniam culpa fore nisi cillum quid.
                                            <i class="bi bi-quote quote-icon-right"></i>
                                        </p>
                                        <h3>John Larson</h3>
                                        <h4>Entrepreneur</h4>
                                        <div class="stars">
                                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 text-center">
                                    <img src="assets/img/testimonials/testimonials-4.jpg" class="img-fluid testimonial-img" alt="">
                                </div>
                            </div>
                        </div>
                    </div><!-- End testimonial item -->

                </div>
                <div class="swiper-pagination"></div>
            </div>

        </div>
    </section><!-- End Testimonials Section -->

    <!-- ======= Events Section ======= -->
    <section id="events" class="events" style="background-color:rgba(55, 55, 63, 0.04)">
        <div class="container-fluid" data-aos="fade-up">
            <div class="section-header">
                <h2>Events</h2>
                <p>Share <span>Your Moments</span> In Our Restaurant</p>
            </div>
            <div class="slides-3 swiper" data-aos="fade-up" data-aos-delay="100">
                <div class="swiper-wrapper">
                    <div class="swiper-slide event-item d-flex flex-column justify-content-end" style="background-image: url(assets/img/events-1.jpg)">
                        <h3>Custom Parties</h3>
                        <div class="price align-self-start">$99</div>
                        <p class="description">
                            Quo corporis voluptas ea ad. Consectetur inventore sapiente ipsum voluptas eos omnis facere. Enim facilis veritatis id est rem repudiandae nulla expedita quas.
                        </p>
                    </div><!-- End Event item -->
                    <div class="swiper-slide event-item d-flex flex-column justify-content-end" style="background-image: url(assets/img/events-2.jpg)">
                        <h3>Private Parties</h3>
                        <div class="price align-self-start">$289</div>
                        <p class="description">
                            In delectus sint qui et enim. Et ab repudiandae inventore quaerat doloribus. Facere nemo vero est ut dolores ea assumenda et. Delectus saepe accusamus aspernatur.
                        </p>
                    </div><!-- End Event item -->
                    <div class="swiper-slide event-item d-flex flex-column justify-content-end" style="background-image: url(assets/img/events-3.jpg)">
                        <h3>Birthday Parties</h3>
                        <div class="price align-self-start">$499</div>
                        <p class="description">
                            Laborum aperiam atque omnis minus omnis est qui assumenda quos. Quis id sit quibusdam. Esse quisquam ducimus officia ipsum ut quibusdam maxime. Non enim perspiciatis.
                        </p>
                    </div><!-- End Event item -->
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section><!-- End Events Section -->

    <!-- ======= Chefs Section ======= -->
    <!-- End Chefs Section -->

    <!-- ======= Book A Table Section ======= -->
    <section id="check_availability" class="check_availability">
        <div class="container" data-aos="fade-up">
            <div class="section-header">
                <h2>Check Availability</h2>
                <!--<p>Reserve <span>Your Special Day</span> With Us</p>-->
            </div>
            <div class="row g-0">
                <div class="col-lg-4 reservation-img" style="background-image: url(assets/img/flash/check_availability.jpg);" data-aos="zoom-out" data-aos-delay="200"></div>
                <div class="col-lg-8 d-flex align-items-center reservation-form-bg">
                    <form action="book-a-table.php" method="post" role="form" class="php-email-form" data-aos="fade-up" data-aos-delay="100">
                        <div class="row gy-4">
                            <div class="col-lg-4 col-md-6">
                                <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" data-rule="minlen:4" data-msg="Please enter at least 4 chars">
                                <div class="validate"></div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" data-rule="email" data-msg="Please enter a valid email">
                                <div class="validate"></div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <input type="text" class="form-control" name="phone" id="phone" placeholder="Your Phone" data-rule="minlen:4" data-msg="Please enter at least 4 chars">
                                <div class="validate"></div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <input type="text" name="date" class="form-control" id="date" placeholder="Date" data-rule="minlen:4" data-msg="Please enter at least 4 chars">
                                <div class="validate"></div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <input type="text" class="form-control" name="time" id="time" placeholder="Time" data-rule="minlen:4" data-msg="Please enter at least 4 chars">
                                <div class="validate"></div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <input type="number" class="form-control" name="people" id="people" placeholder="# of people" data-rule="minlen:1" data-msg="Please enter at least 1 chars">
                                <div class="validate"></div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <textarea class="form-control" name="message" rows="5" placeholder="Message"></textarea>
                            <div class="validate"></div>
                        </div>
                        <div class="mb-3">
                            <div class="loading">Loading</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Your booking request was sent. We will call back or send an Email to confirm your reservation. Thank you!</div>
                        </div>
                        <div class="text-center"><button type="submit">Check Availability</button></div>
                    </form>
                </div><!-- End Reservation Form -->
            </div>
        </div>
    </section><!-- End Book A Table Section -->

    <!-- ======= Gallery Section ======= -->
    <section id="gallery" class="gallery section-bg" style="background-color:rgba(55, 55, 63, 0.04)">
        <div class="container" data-aos="fade-up">
            <div class="section-header">
                <h2>gallery</h2>
                <p>Check <span>Our Gallery</span></p>
            </div>
            <div class="gallery-slider swiper">
                <div class="swiper-wrapper align-items-center">
                    <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="assets/img/gallery/gallery-1.jpg"><img src="assets/img/gallery/gallery-1.jpg" class="img-fluid" alt=""></a></div>
                    <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="assets/img/gallery/gallery-2.jpg"><img src="assets/img/gallery/gallery-2.jpg" class="img-fluid" alt=""></a></div>
                    <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="assets/img/gallery/gallery-3.jpg"><img src="assets/img/gallery/gallery-3.jpg" class="img-fluid" alt=""></a></div>
                    <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="assets/img/gallery/gallery-4.jpg"><img src="assets/img/gallery/gallery-4.jpg" class="img-fluid" alt=""></a></div>
                    <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="assets/img/gallery/gallery-5.jpg"><img src="assets/img/gallery/gallery-5.jpg" class="img-fluid" alt=""></a></div>
                    <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="assets/img/gallery/gallery-6.jpg"><img src="assets/img/gallery/gallery-6.jpg" class="img-fluid" alt=""></a></div>
                    <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="assets/img/gallery/gallery-7.jpg"><img src="assets/img/gallery/gallery-7.jpg" class="img-fluid" alt=""></a></div>
                    <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="assets/img/gallery/gallery-8.jpg"><img src="assets/img/gallery/gallery-8.jpg" class="img-fluid" alt=""></a></div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section><!-- End Gallery Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up">
            <div class="section-header">
                <h2>Contact</h2>
                <p>Need Help? <span>Contact Us</span></p>
            </div>
            <div class="mb-3">
                <iframe style="border:0; width: 100%; height: 350px;" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621" frameborder="0" allowfullscreen></iframe>
            </div><!-- End Google Maps -->
            <div class="row gy-4">
                <div class="col-md-6">
                    <div class="info-item  d-flex align-items-center">
                        <i class="icon bi bi-map flex-shrink-0"></i>
                        <div>
                            <h3>Our Address</h3>
                            <p>A108 Adam Street, New York, NY 535022</p>
                        </div>
                    </div>
                </div><!-- End Info Item -->
                <div class="col-md-6">
                    <div class="info-item d-flex align-items-center">
                        <i class="icon bi bi-envelope flex-shrink-0"></i>
                        <div>
                            <h3>Email Us</h3>
                            <p>contact@example.com</p>
                        </div>
                    </div>
                </div><!-- End Info Item -->
                <div class="col-md-6">
                    <div class="info-item  d-flex align-items-center">
                        <i class="icon bi bi-telephone flex-shrink-0"></i>
                        <div>
                            <h3>Call Us</h3>
                            <p>+1 5589 55488 55</p>
                        </div>
                    </div>
                </div><!-- End Info Item -->
                <div class="col-md-6">
                    <div class="info-item  d-flex align-items-center">
                        <i class="icon bi bi-share flex-shrink-0"></i>
                        <div>
                            <h3>Opening Hours</h3>
                            <div><strong>Mon-Sat:</strong> 11AM - 23PM;
                                <strong>Sunday:</strong> Closed
                            </div>
                        </div>
                    </div>
                </div><!-- End Info Item -->
            </div>
            <form action="forms/contact.php" method="post" role="form" class="php-email-form p-3 p-md-4">
                <div class="row">
                    <div class="col-xl-6 form-group">
                        <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                    </div>
                    <div class="col-xl-6 form-group">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
                </div>
                <div class="form-group">
                    <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
                </div>
                <div class="my-3">
                    <div class="loading">Loading</div>
                    <div class="error-message"></div>
                    <div class="sent-message">Your message has been sent. Thank you!</div>
                </div>
                <div class="text-center"><button type="submit">Send Message</button></div>
            </form><!--End Contact Form -->
        </div>
    </section><!-- End Contact Section -->

</main><!-- End #main -->


<?php include 'footer.php'; ?>