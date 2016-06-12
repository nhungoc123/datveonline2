<?php include VIEW_DIR . 'include/head.php';?>

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
                        <a href="#" data-toggle="modal" data-target="#myModal">
                            <h3>
                                <?php echo $movie['name']; ?>
                            </h3>
                        </a>
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
<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<?php include VIEW_DIR . 'include/footer.php';?>
<script type="text/javascript">
$(document).ready(function() {
    'use strict';
    $('#section-list').css('margin-top', '80px'); 
    $('.sticky-bar-wrap').css('margin-top', '0px');
    // $('#header').click(function() {

    // });
});
</script>
