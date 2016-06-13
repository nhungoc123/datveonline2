<?php include VIEW_DIR . 'include/head.php';?>
<style type="text/css">
    .left {
        width: 28%;
        padding-right: 3%;
        text-align: left;
        float: left;
    }
    .right {
        width: 69%;
        text-align: left;
        float: right;
    }
    .movie-detail {
        margin: 10px auto;
        font-family: 'Open Sans', sans-serif;
        font-size: 14px;
        line-height: 150%;
    }
</style>
    <!--=== Header section Starts ===-->
    <?php include VIEW_DIR . 'include/header.php';?>

    <!--=== List section Starts ===-->
    <div id="section-list" class="feature-wrap">
        <div class="container list">
        <?php foreach ($arrList as $movie) {?>
            <div class="col-sm-12 row item">
                <div class="col-sm-3 left">
                    <img src="<?php echo UPLOAD_DIR ?>/<?php echo $movie['image'] ?>" alt="<?php echo $movie['name'] ?>" class="feature-image"/><!-- Feature Icon -->
                </div>
                <div class="col-sm-9 right">
                    <div class="section-title">
                        <a href="#" data-toggle="modal" data-target="#myModal" data-id="<?php echo $movie['id'];?>">
                            <h3>
                                <?php echo $movie['name']; ?>
                            </h3>
                        </a>
                    </div>
                    <div class="rate">
                        Đánh giá: <?php echo $movie['avg_rate']; ?> /5
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
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/J2ccVB_4I44" frameborder="0" allowfullscreen></iframe>
        </div>
        <div class="clearfix"></div>
        <div class="row movie-detail">

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
        <button type="button" class="btn btn-primary">Xem lịch chiếu</button>
      </div>
    </div>
  </div>
</div>

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
            var posting = $.ajax({
                type: "POST",
                url: url,
                data: {id: id},
                // dataType: 'json',
                // contentType: 'application/json'
            }).done(function(data) {
                var data = jQuery.parseJSON(data);
                if (data.success == true) {
                    $.each(data.movie, function(key, value) {
                        var html = '<div class="col-sm-8">';
                        html += '<div class="row"><div class="left">Khởi chiếu</div><div class="right">';
                        html += value.start_date + '</div></div>';
                        html += '<div class="row"><div class="left">Thể loại</div><div class="right">';
                        html += value.genre + '</div></div>';
                        html += '<div class="row"><div class="left">Diễn viên</div><div class="right">';
                        html += value.actor + '</div></div>';
                        html += '<div class="row"><div class="left">Thời lượng</div><div class="right">';
                        html += value.durations + ' phút</div></div>';
                        html += '<div class="row"><div class="left">Đánh giá</div><div class="right">';
                        html += value.avg_rate + '/5</div></div></div>';
                        html += '<div class="col-sm-4"><div class="row">' + value.description + '</div></div>';
                        $('.movie-detail').html(html);
                        // $('.movie-detail').append(html);
                        $('.modal-title').text(value.name);
                        console.log(value);
                    });
                }
            });
           
      });
});
</script>
