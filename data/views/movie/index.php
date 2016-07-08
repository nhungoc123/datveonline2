<?php include VIEW_DIR . 'include/head.php';?>
<style type="text/css">
    .list .search {
        margin-bottom: 10px;
    }
    .list .search .input-group {
        float: right;
    }
    .list .rate .col-sm-3 {
        text-align: right;
    }
    .section-title {
        margin-bottom: 10px;
    }
    .rating .btn-default {
        background: linear-gradient(#d9de28, #85c342);
    }

    .rating .btn-default:hover {
        background: linear-gradient(#969a18, #4e7425);
    }

</style>
    <!--=== Header section Starts ===-->
    <?php include VIEW_DIR . 'include/header.php';?>
    <div class="header-space">
    </div>

    <!--=== List section Starts ===-->
    <div id="section-list" class="feature-wrap">
        <div class="container list">
            <div class="col-sm-12 row search">
                <form class="form-inline" role="form" action="#section-list" name="form" id="form" method="POST">
                <div class="input-group">
                    <input class="form-control" type="text" name="search" />
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </span>
                </div>
                </form>
            </div>
        <?php if (count($arrList) == 0) {?>
        <div class="col-sm-12">
            <p>
                Không có kết quả.
            </p>
        </div>
        <?php } ?>
        <?php foreach ($arrList as $movie) {?>
            <div class="col-sm-12 row item">
                <div class="col-sm-3 left">
                    <img src="<?php echo UPLOAD_DIR ?><?php echo $movie['image'] ?>" alt="<?php echo $movie['name'] ?>" class="feature-image"/><!-- Feature Icon -->
                </div>
                <div class="col-sm-9 row right">
                    <div class="section-title">
                        <a class="open-model" href="#" data-toggle="modal" data-target="#myModal" data-id="<?php echo $movie['id'];?>">
                            <h3>
                                <?php echo $movie['name']; ?>
                            </h3>
                        </a>
                    </div>
                    <div class="col-sm-12 rating">
                        <div class="col-sm-8" style="padding-left: 0px;">
                            <input class="rating-disabled" value="<?php echo ($movie['avg_rate']) ? $movie['avg_rate'] : 5; ?>" type="number" min=0 max=5 step=0.5 data-size="ss"/>
                            <span class="rate"><?php echo ($movie['avg_rate']) ? $movie['avg_rate'] : 5; ?> trên <?php echo $movie['rate_times']?></span> lượt đánh giá
                        </div>
                        <div class="col-sm-4" style="padding-right: 0px;">
                            <a class="btn btn-default open-model" href="#" data-toggle="modal" data-target="#myModal" data-id="<?php echo $movie['id'];?>">
                                Xem chi tiết
                            </a>
                            <a href="<?php echo HTTP_HOST;?>showtime/" class="btn btn-primary">Xem lịch chiếu</a>
                        </div>
                    </div>
                    <div class="genre">
                        Thể loại: <?php echo $movie['genre']; ?>
                    </div>
                    <div class="launch-date">
                        Khởi chiếu: <?php echo $movie['start_date']; ?>
                    </div>
                    <div class="duration">
                        Thời lượng: <?php echo $movie['durations']; ?> phút
                    </div>
                    <div class="actor dash-bottom">
                        Diễn viên: <?php echo $movie['actor']; ?>
                    </div>
                    <div class="desciption dash-bottom">
                        <?php echo $movie['description']; ?>
                    </div>
                </div>
            </div>
        <?php } ?>
        </div>
    </div>
    <!--=== List section Ends ===-->
<?php include VIEW_DIR . 'movie/movie-detail.php';?>

<?php include VIEW_DIR . 'include/footer.php';?>
<script type="text/javascript">
$(function() {
    $('#header').click(function() {
        window.location.href = "/#header";
    });

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
                    }
                    var video = $('.detail video');
                    var videoSrc = $('source', video).attr('src', trailer);
                    video.load();
                    // var trailer = value.trailer;
                    // if (trailer.indexOf('watch?v=') == -1 && trailer.indexOf('embed') == -1) {
                    //     trailer = trailer.replace('youtu.be', 'youtube.com/embed');
                    // } else {
                    //     trailer = trailer.replace('watch?v=', 'embed/');
                    // }
                    // $('iframe.embed-responsive-item').attr('src', trailer);

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
                    avg_rate += ' trên ' + value.rate_times + '</span> lượt đánh giá';

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
        // $('iframe.embed-responsive-item').attr('src', '');
        $('.detail video').each(function () { this.pause() });
        $('.detail video source').attr('src', '');
    });

    $(".rating-disabled").rating({
        clearButton: '',
        disabled: true,
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
});
</script>

</body>
</html>