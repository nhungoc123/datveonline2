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
                            <a href="<?php echo HTTP_HOST;?>showtime/#section-showtime" class="fancy-button button-line button-white vertical">
                                Xem lịch chiếu
                                <span class="icon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </a>
                            <a href="<?php echo HTTP_HOST;?>movie/#section-list" class="fancy-button button-line button-white zoom">
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
    <?php //if (count($arrUpcoming) > 0) {?>
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
    <?php //}?>
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
                            Ghế thường: <?php echo TICKET_NORMAL + 5?>k
                            <br/>
                            Ghế VIP: <?php echo TICKET_VIP + 10?>k
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
                        <h4 class="service-title color-scheme">Night Out</h4>
                        <p class="service-description justify">
                            Đêm đến dân tràng cảm xúc với những thước phim đặc sắc.
                            <br/>
                            Ghế thường: <?php echo TICKET_NORMAL + 5?>k
                            <br/>
                            Ghế VIP: <?php echo TICKET_VIP + 10?>k
                            <br/>
                            Thời gian: tối thứ 3 - thứ 6.
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

    <!--=== Subscribe section Starts ===-->
    <section id="section-subscribe" class="subscribe-wrap">
        <div class="section-overlay"></div>
        <div class="container subscribe center">
            <div class="row">
                <div class="col-lg-12">
                    <p class="subscription-success"></p>
                    <p class="subscription-failed"></p>
                    <div class="col-md-10 col-md-offset-1 center section-title">
                        <h3>Bản tin</h3>
                    </div>
                    <form id="subscription-form" method="post" action="?">
                        <input type="email" name="news[email]" required="required" placeholder="Email" class="input-email" />
                        <button type="submit" id="subscription-btn" class="fancy-button button-line button-white large zoom">
                            Đăng ký
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
    
    <!--=== Contact section Starts ===-->
    <section id="section-contact" class="contact-wrap">
    <div class="section-overlay"></div>
        <div class="container contact center animated" data-animation="flipInY" data-animation-delay="1000">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="col-md-10 col-md-offset-1 center section-title">
                        <h3>Để lại lời nhắn</h3>
                    </div>
                    
                    <div class="confirmation">
                        <p><span class="fa fa-check"></span></p>
                    </div>


                    <form class="contact-form" method="post" action="?" id="contact-form">
                        <div class="col-lg-12">
                            <p style="color: red; margin: 0px">
                                <?php 
                                foreach ($arrError as $key => $value)
                                    if (isset($arrError[$key])) echo($value.'<br/>');
                                ?>
                            <p>
                            <input class="input-field form-item" type="text" required="required" name="contact[name]" placeholder="Họ Tên" maxlength="50" value="<?php echo $arrForm['name']?>" />

                            <input class="input-field form-item" type="email" required="required" name="contact[email]" placeholder="Email" value="<?php echo $arrForm['email']?>" />

                            <input class="input-field form-item" type="text" required="required" name="contact[subject]" placeholder="Tiêu đề" maxlength="50" value="<?php echo $arrForm['subject']?>" />
                            <textarea class="textarea-field form-item" rows="10" required="required" name="contact[message]" placeholder="Lời nhắn (ít nhất 30 ký tự)" min="30" maxlength="999"><?php echo $arrForm['message']?></textarea>
                        </div>
                        <button type="submit" class="fancy-button button-line button-white large zoom">
                            Gửi
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

<a href="#0" class="cd-top">Top</a>

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
                    if (trailer.indexOf('http') == -1 && trailer.indexOf('www') == -1) {
                        trailer = '<?php echo VIDEO_DIR;?>'+ trailer;
                        var video = $('.detail video');
                        var videoSrc = $('source', video).attr('src', trailer);
                        video.load();
                        $('.video').show();
                    } else {
                        if (trailer.indexOf('watch?v=') == -1 && trailer.indexOf('embed') == -1) {
                        trailer = trailer.replace('youtu.be', 'youtube.com/embed');
                        } else {
                            trailer = trailer.replace('watch?v=', 'embed/');
                        }
                        $('iframe.embed-responsive-item').attr('src', trailer);
                        $('.iframe').show();
                    }
                    
                    var html = '<div class="col-sm-8">';
                    html += '<div class="row"><div class="w29 left">Khởi chiếu</div><div class="w70 right">';
                    html += convertNullToString(value.start_date) + '</div></div>';
                    html += '<div class="row"><div class="w29 left">Thể loại</div><div class="w70 right">';
                    html += convertNullToString(value.genre) + '</div></div>';
                    html += '<div class="row"><div class="w29 left">Diễn viên</div><div class="w70 right">';
                    html += convertNullToString(value.actor) + '</div></div>';
                    html += '<div class="row"><div class="w29 left">Thời lượng</div><div class="w70 right">';
                    html += convertNullToString(value.durations) + ' phút</div></div>';

                    html += '<div class="row"><div class="w29 left">Đánh giá</div><div class="w70 right"><span class="rate">';

                    var avg_rate = '5';
                    if (value.avg_rate != null) {
                        avg_rate = value.avg_rate ;
                    }
                    avg_rate += ' trên ' + value.rate_times + '</span> (lượt đánh giá)';

                    html += avg_rate + '</div></div></div>';

                    html += '<div class="col-sm-4"><div class="row">' + trumcate(value.description) + '</div></div>';
                    $('.movie-detail').html(html);
                    $('.modal-title').text(value.name);
                    $('#rating').val(value.avg_rate);
                    $('#rating').attr('data-id', value.id);
                    $('#rating').rating('refresh', {
                        showClear:true
                    });
                });
            }
        });
    });

    $('#myModal').on('hidden.bs.modal', function () {
        $('iframe.embed-responsive-item').attr('src', '');
        $('.iframe').hide();
        $('.detail video').each(function () { this.pause() });
        $('.detail video source').attr('src', '');
        $('.video').hide();
    });

    $("#rating").rating({
        clearButton: '',
        starCaptions: function(val) {
            if (val < 3) {
                return val;
            } else {
                return 'Hay';
            }
        },
        starCaptionClasses: function(val) {
            if (val < 3) {
                return 'label label-danger';
            } else {
                return 'label label-success';
            }
        },
        hoverOnClear: false
    });

    $('#rating').on('change', function(e) {
        var id = $(this).data('id');
        var url = "<?php echo HTTP_HOST . 'movie/rate?id='?>" + id;
        $.ajax({
            type: "POST",
            url: url,
            data: {id: id, rate: $(this).val()},
        }).done(function(data) {
            var data = jQuery.parseJSON(data);
            if (data.success == true) {
                var rate = data.rate;

                // $('#rating').val(rate.avg_rate);
                // $('#rating').rating('refresh', {
                //     showClear:true
                // });

                $('.rate').text(rate.avg_rate + ' trên ' + rate.rate_times);
            } else {
                alert(data.msg);
                return false;
            }
        });
    });

    $('#contact-form').submit(function(e) {
        var form = $(this);
        // alert(1233);
        form.submit();
    });
});
</script>
</body>
</html>