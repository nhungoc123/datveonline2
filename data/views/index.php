<?php include VIEW_DIR . 'include/head.php';?>

    <!--=== Header section Starts ===-->
    <div id="header" class="header-section">
        
        <?php include VIEW_DIR . 'include/header.php';?>

        <!--=== Home Section Starts ===-->
        <div id="section-home" class="home-section-wrap center">
            <div class="section-overlay"></div>
            <div class="container home">
                <div class="row">
                    <h1 class="well-come">Trải Nghiệm</h1>
                    
                    <div class="col-md-8 col-md-offset-2">
                        <p class="intro-message">Thế giới phim với hàng loạt phim boom tấn</p>
                        
                        <div class="home-buttons">
                            <a href="#" class="fancy-button button-line button-white vertical">
                                Xem lịch chiếu
                                <span class="icon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </a>
                            <a href="<?php echo HTTP_HOST;?>movie/" class="fancy-button button-line button-white zoom">
                                Phim
                                <span class="icon">
                                    <i class="fa fa-film"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--=== Home Section Ends ===-->
    </div>
    
    
    <!--=== Features section Starts ===-->
    <section id="section-feature" class="feature-wrap">
        <div class="container features center">
            <div class="row">
                <div class="col-lg-12">
                        <!--Features container Starts -->
                        <ul id="card-ul" class="features-hold baraja-container">
                            
                            <?php foreach ($arrMovie as $movie) {?>
                            <!-- Single Feature Starts -->
                            <li class="single-feature" title="Card style">
                                <img src="<?php echo UPLOAD_DIR ?><?php echo $movie['image'] ?>" alt="<?php echo $movie['name'] ?>" class="feature-image" style="max-height: 180px"/><!-- Feature Icon -->
                                <h4 class="feature-title color-scheme"><?php echo $movie['name'] ?></h4>
                                <p class="feature-text">
                                    <?php echo Common::truncate($movie['description']) ?>
                                </p>
                                
                                    <a href="#" data-toggle="modal" data-target="#myModal" data-id="<?php echo $movie['id'];?>" class="open-model fancy-button button-line btn-col small vertical">
                                        Chi tiết
                                        <span class="icon">
                                            <i class="fa fa-leaf"></i>
                                        </span>
                                    </a>
                                
                            </li>
                            <!-- Single Feature Ends -->
                            <?php } ?>
                        </ul>
                        <!--Features container Ends -->
                        
                        <!-- Features Controls Starts -->
                        <div class="features-control relative">
                            <button class="control-icon fancy-button button-line no-text btn-col bell" id="feature-prev" title="Previous" >
                                <span class="icon">
                                    <i class="fa fa-arrow-left"></i>
                                </span>
                            </button>
                            <button class="control-icon fancy-button button-line no-text btn-col zoom" id="feature-expand" title="Expand" >
                                <span class="icon">
                                    <i class="fa fa-expand"></i>
                                </span>
                            </button>
                            <button class="control-icon fancy-button button-line no-text btn-col zoom" id="feature-close" title="Collapse" >
                                <span class="icon">
                                    <i class="fa fa-compress"></i>
                                </span>
                            </button>
                            <button class="control-icon fancy-button button-line no-text btn-col bell" id="feature-next" title="Next" >
                                <span class="icon">
                                    <i class="fa fa-arrow-right"></i>
                                </span>
                            </button>
                        </div>
                        <!-- Features Controls Ends -->
                </div>
            </div>
        </div>
    </section>
    <!--=== Features section Ends ===-->

    <!--=== Upcoming section Starts ===-->
    <?php if (count($arrUpcoming) > 0) {?>
    <section id="section-upcoming" class="pricing-wrap">
        <div class="container pricing">
            <div class="row">
                <div class="col-md-10 col-md-offset-1 center section-title">
                    <h3 style="color: #F4F4F4">Phim Sắp Chiếu</h3>
                </div>

                <?php foreach ($arrUpcoming as $key => $movie) {?>
                <!-- Single Upcoming Starts -->
                <div class="col-md-4 col-sm-6 single-pricing-wrap center animated" data-animation="bounceInLeft" data-animation-delay="<?php echo 500 + $key*500;?>">
                    <div class="single-pricing">
                        <div class="pricing-head">
                            <img src="<?php echo UPLOAD_DIR ?><?php echo $movie['image'] ?>" alt="<?php echo $movie['name'] ?>" class="feature-image"/>
                            <h4 class="feature-title color-scheme"><?php echo $movie['name'] ?></h4>
                        </div>
                        <p class="feature-text">
                            <?php echo Common::truncate($movie['description']) ?>
                        </p>

                        <a href="#" data-toggle="modal" data-target="#myModal" data-id="<?php echo $movie['id'];?>" class="open-model fancy-button button-line btn-col small vertical">
                            Chi tiết
                            <span class="icon">
                                <i class="fa fa-leaf"></i>
                            </span>
                        </a>
                    </div>
                </div>
                <!-- Single Upcoming Ends -->
                <?php }?>
            </div>
        </div>
    </section>
    <?php }?>
    <!--=== Upcoming section Ends ===-->

    <!--=== Services section Starts ===-->
    <section id="section-services" class="services-wrap">
        <div class="container services">
            <div class="row">
            
                <div class="col-md-10 col-md-offset-1 center section-title">
                    <h3>Giá Vé</h3>
                </div>
            
                <!-- Single Service Starts -->
                <div class="col-md-6 col-sm-6 service animated" data-animation="fadeInLeft" data-animation-delay="700">
                    <span class="service-icon center"><i class="icon icon-basic-book-pencil fa-3x"></i></span>
                    <div class="service-desc">
                        <h4 class="service-title color-scheme">Chỉ từ <?php echo TICKET_NORMAL?>k - <?php echo TICKET_VIP?>k</h4>
                        <p class="service-description justify">
                            Ngày thường, chỉ từ <?php echo TICKET_NORMAL?>k cho một ghế và <?php echo TICKET_VIP?>k cho ghế vip, bạn có thể xem hàng loạt phim boom tấn hấp dẫn.
                            <br/>
                            Thời gian: từ thứ 3 đến thứ 6.
                        </p>
                    </div>
                </div>
                <!-- Single Service Ends -->
                
                <!-- Single Service Starts -->
                <div class="col-md-6 col-sm-6 service animated" data-animation="fadeInUp" data-animation-delay="700">
                    <span class="service-icon center"><i class="icon icon-basic-paperplane fa-3x"></i></span>
                    <div class="service-desc">
                        <h4 class="service-title color-scheme">Cuối tuần thả ga</h4>
                        <p class="service-description justify">
                            Bạn rảnh rỗi vào cuối tuần và có ý định xem những phim boom tấn hấp dẫn, hãy đến với chúng tôi.
                            <br/>
                            Ghế thường: <?php echo TICKET_WEEKEN?>k
                            <br/>
                            Ghế VIP: <?php echo TICKET_VIP_WEEKEN?>k
                            <br/>
                            Thời gian: thứ 7 - chủ nhật.
                        </p>
                    </div>
                </div>
                <!-- Single Service ends -->
                
                <!-- Single Service Starts -->
                <div class="col-md-6 col-sm-6 service animated" data-animation="fadeInRight" data-animation-delay="700">
                    <span class="service-icon center"><i class="icon icon-basic-heart fa-3x"></i></span>
                    <div class="service-desc">
                        <h4 class="service-title color-scheme">Couple</h4>
                        <p class="service-description justify">
                            Chương trình khuyến mãi dành cho các cặp đôi đang yêu nhau: cuối tuần vẫn tính như ngày thường.
                            <br/>
                            Ghế thường: <?php echo TICKET_NORMAL?>k
                            <br/>
                            Ghế VIP: <?php echo TICKET_VIP?>k
                            <br/>
                            Thời gian: thứ 7 - chủ nhật.
                        </p>
                    </div>
                </div>
                <!-- Single Service Ends -->
                
                <!-- Single Service Starts -->
                <div class="col-md-6 col-sm-6 service animated" data-animation="fadeInUp" data-animation-delay="700">
                    <span class="service-icon center"><i class="icon icon-basic-lightbulb fa-3x"></i></span>
                    <div class="service-desc">
                        <h4 class="service-title color-scheme">Happy Day</h4>
                        <p class="service-description justify">
                            Xem phim thỏa sức chỉ với <?php echo TICKET_HAPPY?>k. Chương trình khuyến mãi cho tất cả các loại ghế.
                            <br/>
                            Thời gian: thứ 2 hàng tuần.
                        </p>
                    </div>
                </div>
                <!-- Single Service Ends -->
            </div>
        </div>
    </section>
    <!--=== Services section Ends ===-->
    
    <!--=== Step-1 section Starts ===-->
    <section id="step-1" class="section-step step-wrap">
        <div class="container step animated" data-animation="bounceInLeft" data-animation-delay="700">
            <div class="row">
                <!-- Step Description Starts -->
                <div class="col-md-8 step-desc">
                    <div class="col-md-2 center">
                        <div class="step-no">
                            <span class="no-inner">1</span>
                        </div>
                    </div>
                    
                    <div class="col-md-10 step-details">
                            <h3 class="step-title color-scheme">Các Bước Mua vé</h3>
                            <p class="step-description">Cillum laboris <strong>consequat</strong>, qui elit retro next level 
                            skateboard freegan hella. Cillum laboris consequat qui elit retro next level 
                            skateboard freegan hella. Cillum laboris consequat skateboard freegan hella</p>
                            
                            <ul class="sub-steps"> <!-- Sub steps here -->
                                <li>
                                    <span class="icon fa fa-comments color-scheme"></span>
                                    <span class="sub-text">skateboard freegan hella. Cillum laboris consequat qui elit</span>
                                </li>
                                <li>
                                    <span class="icon fa fa-pencil-square-o color-scheme"></span>
                                    <span class="sub-text">Documenting collected data</span>
                                </li>
                            </ul>
                    </div> <!-- End step-details -->
                </div>
                <!-- Step Description Ends -->
                <div class="col-md-4 step-img">
                    <img src="<?php echo COMMON_DIR ?>images/note.png" alt="" /> <!-- Step Photo Here -->
                </div>
            </div>
        </div>
    </section>
    <!--=== Step-1 section Ends ===-->
    
    <!--=== Step-2 section Starts ===-->
    <section id="step-2" class="section-step step-even step-wrap">
        <div class="container step animated" data-animation="bounceInRight" data-animation-delay="700">
            <div class="row">
                <!-- Step Description Starts -->
                <div class="col-md-8 step-desc">
                    <div class="col-md-2 center">
                        <div class="step-no">
                            <span class="no-inner">2</span>
                        </div>
                    </div>
                    
                    <div class="col-md-10 step-details">
                            <h3 class="step-title color-scheme">Thanh toán</h3>
                            <p class="step-description">Cillum laboris <strong>consequat</strong>, qui elit retro next level 
                            skateboard freegan hella. Cillum laboris consequat qui elit retro next level 
                            skateboard freegan hella. Cillum laboris consequat skateboard freegan hella</p>
                            
                            <ul class="sub-steps"> <!-- Sub steps here -->
                                <li>
                                    <span class="icon fa fa-comments color-scheme"></span>
                                    <span class="sub-text">skateboard freegan hella. Cillum laboris consequat qui elit</span>
                                </li>
                                <li>
                                    <span class="icon fa fa-pencil-square-o color-scheme"></span>
                                    <span class="sub-text">Documenting collected data</span>
                                </li>
                                
                            </ul>
                    </div><!-- End step-details -->
                </div>
                <!-- Step Description Ends -->
                <div class="col-md-4 step-img">
                    <img src="<?php echo COMMON_DIR ?>images/desk.png" alt="" /> <!-- Step Photo Here -->
                </div>
            </div>
        </div>
    </section>
    <!--=== Step-2 section Ends ===-->
    
    <!--=== Video section Starts ===-->
    <section id="section-video" class="section-video-wrap">
        <div class="section-overlay"></div>
        <div class="container big-video center animated" data-animation="fadeInLeft" data-animation-delay="700">
            <div class="row">
                <div class="col-md-12 section-title">
                    <h3>Describe with a video</h3>
                </div>
                <div class="col-md-10 col-md-offset-1 video-content">
                    <iframe src="http://player.vimeo.com/video/75317749?title=0&amp;byline=0&amp;portrait=0" width="400" height="240"></iframe>
                </div>
            </div>
        </div>
    </section>
    <!--=== Video section Ends ===-->
    
    <!--=== ScreenShots section Starts ===-->
    <section id="section-screenshots" class="screenshots-wrap">
        <div class="container screenshots animated" data-animation="fadeInUp" data-animation-delay="1000">
            <div class="row porfolio-container">
                <div class="col-md-10 col-md-offset-1 center section-title">
                    <h3>Sự Kiện</h3>
                </div>
                <!-- Single screenshot starts -->
                <div class="col-md-4 col-sm-4 col-xs-6">
                    <div class="screenshot">
                        <div class="photo-box">
                            <img src="<?php echo COMMON_DIR ?>images/7.jpg" alt="" />
                            <div class="photo-overlay">
                                <h4>Wordpress theme</h4>
                            </div>
                            <span class="photo-zoom">
                                <a href="single-project.html" class="view-project"><i class="fa fa-search-plus fa-2x"></i></a>
                            </span>
                        </div>
                    </div>
                </div>
                <!-- Single screenshot ends -->
                
                <!-- Single screenshot starts -->
                <div class="col-md-4 col-sm-4 col-xs-6">
                    <div class="screenshot">
                        <div class="photo-box">
                            <img src="<?php echo COMMON_DIR ?>images/2.jpg" alt="" />
                            <div class="photo-overlay">
                                <h4>User Interface design</h4>
                            </div>
                            <span class="photo-zoom">
                                <a href="single-project-2.html" class="view-project"><i class="fa fa-search-plus fa-2x"></i></a>
                            </span>
                        </div>
                        
                    </div>
                </div>
                <!-- Single screenshot ends -->
                
                <!-- Single screenshot starts -->
                <div class="col-md-4 col-sm-4 col-xs-6">
                    <div class="screenshot">
                        <div class="photo-box">
                            <img src="<?php echo COMMON_DIR ?>images/3.jpg" alt="" />
                            <div class="photo-overlay">
                                <h4>PSD template design</h4>
                            </div>
                            <span class="photo-zoom">
                                <a href="single-project.html" class="view-project"><i class="fa fa-search-plus fa-2x"></i></a>
                            </span>
                        </div>
                        
                    </div>
                </div>
                <!-- Single screenshot ends -->
                
                <!-- Single screenshot starts -->
                <div class="col-md-4 col-sm-4 col-xs-6">
                    <div class="screenshot">
                        <div class="photo-box">
                            <img src="<?php echo COMMON_DIR ?>images/4.jpg" alt="" />
                            <div class="photo-overlay">
                                <h4>User Experience design</h4>
                            </div>
                            <span class="photo-zoom">
                                <a href="single-project-2.html" class="view-project"><i class="fa fa-search-plus fa-2x"></i></a>
                            </span>
                        </div>
                        
                    </div>
                </div>
                <!-- Single screenshot ends -->
                
                <!-- Single screenshot starts -->
                <div class="col-md-4 col-sm-4 col-xs-6">
                    <div class="screenshot">
                        <div class="photo-box">
                            <img src="<?php echo COMMON_DIR ?>images/5.jpg" alt="" />
                            <div class="photo-overlay">
                                <h4>Page builder plugin</h4>
                            </div>
                            <span class="photo-zoom">
                                <a href="single-project.html" class="view-project"><i class="fa fa-search-plus fa-2x"></i></a>
                            </span>
                        </div>
                        
                    </div>
                </div>
                <!-- Single screenshot ends -->
                
                <!-- Single screenshot starts -->
                <div class="col-md-4 col-sm-4 col-xs-6">
                    <div class="screenshot">
                        <div class="photo-box">
                            <img src="<?php echo COMMON_DIR ?>images/6.jpg" alt="" />
                            <div class="photo-overlay">
                                <h4>Corporate website</h4>
                            </div>
                            <span class="photo-zoom">
                                <a href="single-project-2.html" class="view-project"><i class="fa fa-search-plus fa-2x"></i></a>
                            </span>
                        </div>
                        
                    </div>
                </div>
                <!-- Single screenshot ends -->
                
            </div>
            
            <div id="portfolio-loader" class="center">
                <div class="loading-circle fa-spin"></div>
            </div> <!--=== Portfolio loader ===-->
            
            <div id="portfolio-load"></div><!--=== ajax content will be loaded here ===-->
            
            <div class="col-md-12 center back-button">
                <a class="backToProject fancy-button button-line bell btn-col" href="#">
                    Back
                    <span class="icon">
                        <i class="fa fa-arrow-left"></i>
                    </span>
                </a>
            </div><!--=== Single portfolio back button ===-->
        </div>
    </section>
    <!--=== ScreenShots section Ends ===-->
    
    <!--=== Testimonials section Starts ===-->
    <section id="section-testimonials" class="testimonials-wrap">
        <div class="section-overlay"></div>
        <div class="container testimonials center animated" data-animation="rollIn" data-animation-delay="500">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="testimonial-slider">
                        <!-- Single Testimonial Starts -->
                        <div class="testimonial">
                            <p class="comment">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam eu sem ante. Nullam quis risus eu 
                                purus commodo dignissim. Donec iaculis ac ex vel posuere. Sed posuere, elit vitae mattis condimentum, 
                                quam urna fringilla magna
                            </p>
                            
                            <h5 class="happy-client">Jhon Doe</h5>
                            <span class="client-info">Executive at CDF Corp.</span>
                        </div>
                        <!-- Single Testimonial Ends -->
                        
                        <!-- Single Testimonial Starts -->
                        <div class="testimonial">
                            <p class="comment">
                                Dolor sit amet, consectetur adipiscing elit. Nullam eu sem ante. Nullam quis risus eu 
                                purus commodo dignissim. Donec iaculis ac ex vel posuere. Sed posuere, elit vitae mattis condimentum, 
                                quam urna fringilla magna
                            </p>
                            
                            <h5 class="happy-client">JB Jeniffer</h5>
                            <span class="client-info">Developer at TTF Corp.</span>
                        </div>
                        <!-- Single Testimonial Ends -->
                        
                        <!-- Single Testimonial Starts -->
                        <div class="testimonial">
                            <p class="comment">
                                Consectetur adipiscing elit. Nullam eu sem ante. Nullam quis risus eu 
                                purus commodo dignissim. Donec iaculis ac ex vel posuere. Sed posuere, elit vitae mattis condimentum, 
                                quam urna fringilla magna
                            </p>
                            
                            <h5 class="happy-client">Chan Jhin</h5>
                            <span class="client-info">CEO of MutiNaTakio.</span>
                        </div>
                        <!-- Single Testimonial Ends -->
                    </div>
                    <div id="bx-pager" class="client-photos">
                        <a data-slide-index="0" href="" class="photo-hold">
                            <span class="photo-bg">
                                <img src="<?php echo COMMON_DIR ?>images/client_1.jpg" alt="" /> <!-- Client photo 1 -->
                            </span>
                        </a>
                        <a data-slide-index="1" href="" class="photo-hold">
                            <span class="photo-bg">
                                <img src="<?php echo COMMON_DIR ?>images/client_2.jpg" alt="" /> <!-- Client photo 2 -->
                            </span>
                        </a>
                        <a data-slide-index="2" href="" class="photo-hold">
                            <span class="photo-bg">
                                <img src="<?php echo COMMON_DIR ?>images/client_3.jpg" alt="" /> <!-- Client photo 3 -->
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=== Testimonials section Ends ===-->
    
    <!--=== Subscribe section Starts ===-->
    <section id="section-subscribe" class="subscribe-wrap">
        <div class="section-overlay"></div>
        <div class="container subscribe center">
            <div class="row">
                <div class="col-lg-12">
                    <p class="subscription-success"></p>
                    <p class="subscription-failed"></p>
                    <div class="col-md-10 col-md-offset-1 center section-title">
                        <h3>Newsletter</h3>
                    </div>
                    <form id="subscription-form">
                        <input type="email" name="EMAIL" required="required" placeholder="Your Email" class="input-email" />
                        <button type="submit" id="subscription-btn" class="fancy-button button-line button-white large zoom">
                            Subscribe
                            <span class="icon">
                                <i class="fa fa-sign-in"></i>
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!--=== Subscribe section Ends ===-->
    
    
    <!--=== Download section Starts ===-->
    <section id="section-download" class="download-wrap">
        <div class="container download center">
            <div class="row">
                <div class="col-lg-12">
                    <div class="col-md-10 col-md-offset-1 center section-title">
                        <h3>Download app</h3>
                    </div>
                    <div class="download-buttons clearfix"> <!-- Download Buttons -->
                        <a class="fancy-button button-line no-text btn-col large zoom" href="#" title="Download from App store">
                            <span class="icon">
                            <i class="fa fa-apple"></i>
                            </span>
                        </a>
                        <a class="fancy-button button-line btn-col no-text large zoom" href="#" title="Download from App store">
                            <span class="icon">
                            <i class="fa fa-android"></i>
                            </span>
                        </a>
                        <a class="fancy-button button-line btn-col no-text large zoom" href="#" title="Download from App store">
                            <span class="icon">
                            <i class="fa fa-windows"></i>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=== Download section Ends ===-->
    
    
    <!--=== Contact section Starts ===-->
    <section id="section-contact" class="contact-wrap">
    <div class="section-overlay"></div>
        <div class="container contact center animated" data-animation="flipInY" data-animation-delay="1000">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="col-md-10 col-md-offset-1 center section-title">
                        <h3>Leave a message</h3>
                    </div>
                    
                    <div class="confirmation">
                        <p><span class="fa fa-check"></span></p>
                    </div>
                    
                    <form class="contact-form support-form">
                        
                        <div class="col-lg-12">
                            <input id="name" class="input-field form-item field-name" type="text" required="required" name="contact-name" placeholder="Name" />

                            <input id="email" class="input-field form-item field-email" type="email" required="required" name="contact-email" placeholder="Email" />

                            <input id="subject" class="input-field form-item field-subject" type="text" required="required" name="contact-subject" placeholder="Subject" />
                            <textarea id="message" class="textarea-field form-item field-message" rows="10" name="contact-message" placeholder="Message"></textarea>
                        </div>
                        <button type="submit" class="fancy-button button-line button-white large zoom subform">
                            Send message
                            <span class="icon">
                                <i class="fa fa-paper-plane-o"></i>
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!--=== Contact section Ends ===-->
<?php include VIEW_DIR . 'movie/movie-detail.php';?>

<?php include VIEW_DIR . 'include/footer.php';?>
<script type="text/javascript">
$(document).ready(function() {
	'use strict';
    $('#myModal').on('show.bs.modal', function(e) {
        // e.preventDefault();
        var id = $(e.relatedTarget).data('id');
        var url = "<?php echo HTTP_HOST . 'movie/get?id='?>" + id;
        $.ajax({
            type: "POST",
            url: url,
            data: {id: id},
        }).done(function(data) {
            var data = jQuery.parseJSON(data);
            if (data.success == true) {
                $.each(data.movie, function(key, value) {
                    var trailer = value.trailer;
                    if (trailer.indexOf('watch?v=') == -1 && trailer.indexOf('embed') == -1) {
                        trailer = trailer.replace('youtu.be', 'youtube.com/embed');
                    } else {
                        trailer = trailer.replace('watch?v=', 'embed/');
                    }
                    $('iframe.embed-responsive-item').attr('src', trailer);

                    var html = '<div class="col-sm-8">';
                    html += '<div class="row"><div class="left">Khởi chiếu</div><div class="right">';
                    html += convertNullToString(value.start_date) + '</div></div>';
                    html += '<div class="row"><div class="left">Thể loại</div><div class="right">';
                    html += convertNullToString(value.genre) + '</div></div>';
                    html += '<div class="row"><div class="left">Diễn viên</div><div class="right">';
                    html += convertNullToString(value.actor) + '</div></div>';
                    html += '<div class="row"><div class="left">Thời lượng</div><div class="right">';
                    html += convertNullToString(value.durations) + ' phút</div></div>';
                    html += '<div class="row"><div class="left">Đánh giá</div><div class="right">';

                    var avg_rate = '5 / 5';
                    if (value.avg_rate != null) {
                        avg_rate = value.avg_rate + ' / 5';
                    }
                    html += avg_rate + '</div></div></div>';

                    html += '<div class="col-sm-4"><div class="row">' + trumcate(value.description) + '</div></div>';
                    $('.movie-detail').html(html);
                    $('.modal-title').text(value.name);
                });
            }
        });
    });

    $('#myModal').on('hidden.bs.modal', function () {
        $('iframe.embed-responsive-item').attr('src', '');
    });
});
</script>
</body>
</html>