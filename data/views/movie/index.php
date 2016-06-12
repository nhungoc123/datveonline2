<?php include VIEW_DIR . 'include/head.php';?>

    <!--=== Header section Starts ===-->
        <?php include VIEW_DIR . 'include/header.php';?>

    <!--=== List section Starts ===-->
    <section id="section-list" class="feature-wrap">
        <div class="container list">
        <?php foreach ($arrList as $movie) {?>
            <div class="col-sm-12 row item">
                <div class="col-sm-3 left">
                    <img src="<?php echo UPLOAD_DIR ?>/<?php echo $movie['image'] ?>" alt="<?php echo $movie['name'] ?>" class="feature-image"/><!-- Feature Icon -->
                </div>
                <div class="col-sm-9 right">
                    <div class="section-title">
                        <a href="#">
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
    </section>
    <!--=== List section Ends ===-->

<?php include VIEW_DIR . 'include/footer.php';?>