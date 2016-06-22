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

</style>
    <!--=== Header section Starts ===-->
    <?php include VIEW_DIR . 'include/header.php';?>
    <div class="header-space">
    </div>

    <!--=== List section Starts ===-->
    <div id="section-list" class="feature-wrap">
        <div class="container list">
            <div class="col-sm-12 row search">
                <form class="form-inline" role="form" action="?" name="form" id="form" method="POST">
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
                    <div class="rate">
                        <div class="col-sm-9" style="padding-left: 0px;">
                            Đánh giá: <?php echo ($movie['avg_rate']) ? $movie['avg_rate'] : 5; ?> / 5
                        </div>
                        <div class="col-sm-3" style="padding-right: 0px;">
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
                    if (trailer.indexOf('watch?v=') == -1 && trailer.indexOf('embed') == -1) {
                        trailer = trailer.replace('youtu.be', 'youtube.com/embed');
                    } else {
                        trailer = trailer.replace('watch?v=', 'embed/');
                    }
                    $('iframe.embed-responsive-item').attr('src', trailer);

                    var html = '<div class="col-sm-8">';
                    html += '<div class="row"><div class="w29 left">Khởi chiếu</div><div class="w70 right">';
                    html += convertNullToString(value.start_date) + '</div></div>';
                    html += '<div class="row"><div class="w29 left">Thể loại</div><div class="w70 right">';
                    html += convertNullToString(value.genre) + '</div></div>';
                    html += '<div class="row"><div class="w29 left">Diễn viên</div><div class="w70 right">';
                    html += convertNullToString(value.actor) + '</div></div>';
                    html += '<div class="row"><div class="w29 left">Thời lượng</div><div class="w70 right">';
                    html += convertNullToString(value.durations) + ' phút</div></div>';
                    html += '<div class="row"><div class="w29 left">Đánh giá</div><div class="w70 right">';

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