<?php
include 'header.php';
?>
<!-- ======= Hero Section ======= -->
<section id="hero" class="hero d-flex align-items-center section-bg" style="background-color:rgba(55, 55, 63, 0.04)">
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
                            <a href="<?= WEB_PATH ?>check_availability/availability_check.php" class="btn btn-warning btn-outline-dark btn-sm" style="border:2px solid black"><span><strong>Check Availability <i class="bi bi-clock-fill"></i></strong></span></a>
                            <a href="<?= WEB_PATH ?>customer/register_customer.php" class="btn btn-warning btn-outline-dark btn-sm" style="font-weight:500;border:2px solid black"><span><strong>Register <i class="bi bi-person-check-fill"></i></strong></span></a>
                        </div>
                    </div>
                    <!--<a href="#check_availability" class="btn-book-a-table">Check Availability</a>-->
                </div>
            </div>
            <div class="col-md-5 mt-3 mb-3" style="width:550px">
                <img src="<?= WEB_PATH ?>assets/img/flash/home_page_side.jpg" style="height:400px;border-radius:10px" class="img-fluid" alt="" data-aos="zoom-out" data-aos-delay="300">
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
                <div class="col-lg-7 position-relative about-img" style="background-image: url(assets/img/about.jpg);border-radius:5px;" data-aos="fade-up" data-aos-delay="150"></div>
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

                        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                            <a href="<?= WEB_PATH ?>index.php?#gallery">
                                <div class="icon-box d-flex flex-column justify-content-center align-items-center" style="height:442px;background-image: url('assets/img/flash/why_us_hall.jpeg');background-size:cover;background-position:center;">
                                    <i class="bi bi-clipboard-data" style="color: #fff"></i>
                                    <h4 style="color:#fff;font-weight:500">MAKE YOUR EVENTS UNFORGETTABLE</h4>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                            <a href="<?= WEB_PATH ?>menu_package/menu_package.php">
                                <div class="icon-box d-flex flex-column justify-content-center align-items-center" style="height:442px;background-image: url('assets/img/flash/why_us_food.jpg');background-size:cover;background-position:center;">
                                    <i class="bi bi-gem" style="color: #fff"></i>
                                    <h4 style="color:#fff;font-weight:500">A WORLD OF DELICIOUS AROMAS AND FLAVOURS</h4>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
                            <a href="<?= WEB_PATH ?>service/service.php">
                                <div class="icon-box d-flex flex-column justify-content-center align-items-center"  style="height:442px;background-image: url('assets/img/flash/why_us_services.jpg');background-size:cover;background-position:center;">
                                    <i class="bi bi-inboxes" style="color: #fff"></i>
                                    <h4 style="color:#fff;font-weight:500">DISCOVER OUR SERVICES</h4>
                                </div>
                            </a>
                        </div>
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
                    <?php
                    $db = dbConn();
                    $sql = "SELECT * FROM customer_review WHERE approval_status='Approved'";
                    $result = $db->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <div class="swiper-slide">
                                <div class="testimonial-item">
                                    <div class="row gy-4 justify-content-center">
                                        <div class="col-lg-6">
                                            <div class="testimonial-content">
                                                <p>
                                                    <i class="bi bi-quote quote-icon-left"></i>
                                                    <?= $row['review']?>
                                                    <i class="bi bi-quote quote-icon-right"></i>
                                                </p>
                                                <h3></h3>
                                                <h4><?= $row['first_name'].' '.$row['last_name']?></h4>
                                                <div class="stars">
                                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 text-center">
                                            <img src="<?=WEB_PATH?>assets/img/review/<?= $row['image']?>" class="img-fluid testimonial-img" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div><!-- End testimonial item -->
                            <?php
                        }
                    }
                    ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>

        </div>
    </section><!-- End Testimonials Section -->

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
                    <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="assets/img/gallery/gallery-8.jpg"><img src="assets/img/gallery/gallery-9.jpg" class="img-fluid" alt=""></a></div>
                    <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="assets/img/gallery/gallery-8.jpg"><img src="assets/img/gallery/gallery-10.jpg" class="img-fluid" alt=""></a></div>
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
                <iframe style="border:0; width: 100%; height: 350px;"  src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1980.3359610187692!2d79.877961!3d6.929761!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae259351c51e4c1%3A0x52a0c7ab2a0e8fdc!2sFlash%20Reception%20Hall!5e0!3m2!1sen!2sus!4v1688495271108!5m2!1sen!2sus" frameborder="0" allowfullscreen></iframe>
            </div><!-- End Google Maps -->
            <div class="row gy-4">
                <div class="col-md-6">
                    <div class="info-item  d-flex align-items-center">
                        <i class="icon bi bi-map flex-shrink-0"></i>
                        <div>
                            <h3>Our Address</h3>
                            <p>297/11,Baseline Road,Dematagoda,Colombo 09.</p>
                        </div>
                    </div>
                </div><!-- End Info Item -->
                <div class="col-md-6">
                    <div class="info-item d-flex align-items-center">
                        <i class="icon bi bi-envelope flex-shrink-0"></i>
                        <div>
                            <h3>Email Us</h3>
                            <p>flashreceptionhall@gmail.com</p>
                        </div>
                    </div>
                </div><!-- End Info Item -->
                <div class="col-md-6">
                    <div class="info-item  d-flex align-items-center">
                        <i class="icon bi bi-telephone flex-shrink-0"></i>
                        <div>
                            <h3>Call Us</h3>
                            <p>0753311911/ 0117073007/ 0117072007</p>
                        </div>
                    </div>
                </div><!-- End Info Item -->
                <div class="col-md-6">
                    <div class="info-item  d-flex align-items-center">
                        <i class="icon bi bi-share flex-shrink-0"></i>
                        <div>
                            <h3>Opening Hours</h3>
                            <div><strong>Mon-Sun:</strong> 8AM - 23PM</div>
                        </div>
                    </div>
                </div><!-- End Info Item -->
            </div>
        </div>
    </section><!-- End Contact Section -->

</main><!-- End #main -->


<?php include 'footer.php'; ?>