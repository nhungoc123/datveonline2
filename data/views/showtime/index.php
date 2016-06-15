<?php include VIEW_DIR . 'include/head.php';?>

<style type="text/css">
    /*#section-showtime {
        background-color: #333;
        color: #e5e5e5;
    }*/

    .showtime .btn-date {
        display: inline-block;
        margin-right: 10px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        border: 1px solid #2f425e;
        height: 38px;
        line-height: 36px;
        background-color: #666;
        color: #e5e5e5;
        padding: 0 15px;
        font-size: 14px;
        opacity: 0.5;
    }
    .showtime a.btn-date:hover {
        background-color: #ffffff;
        color: #404040;
    }

    .showtime a.active {
        background-color: #ffffff;
        color: #404040;
    }

    .slider, .bx-controls {
        display: none;
    }
    /*.showtime .well div.slider.all {
        display: block !important;
    }*/
    /*#myCarousel {
        height: 246px;
    }*/

</style>
    <!--=== Header section Starts ===-->
    <?php include VIEW_DIR . 'include/header.php';?>
    <div class="header-space">
    </div>

    <!--=== List section Starts ===-->
    <div id="section-showtime" class="feature-wrap">
        <div class="container showtime">
            <div class="col-md-12">
                <div class="well">
                    <?php foreach ($arrDate as $key => $date) {?>
                    <a href="#" class="btn btn-date" data-date="<?php echo $date?>">
                        <?php echo $date?>
                    </a>
                    <?php }?>
                </div>
            </div>
            <div class="col-md-12">
                <div class="well">
                    <div class="slider all">
                    <?php foreach ($arrMovie as $key => $value) {?>
                        <?php foreach ($value as $v) {?>
                            <div class="slide"><img style="max-height: 200px" src="<?php echo UPLOAD_DIR . $v['image'];?>"></div>
                        <?php } ?>
                    <?php } ?>
                    </div>

                    <?php foreach ($arrMovie as $key => $value) {?>
                        <div class="slider <?php echo $key ?>">
                        <?php foreach ($value as $v) {?>
                            <div class="slide"><img src="<?php echo UPLOAD_DIR . $v['image'];?>"></div>
                        <?php } ?>
                        </div>
                    <?php } ?>
                </div>
                <!--/well-->
            </div>
        </div>
    </div>
    <!--=== List section Ends ===-->

<?php include VIEW_DIR . 'include/footer.php';?>
<script type="text/javascript">

$(function() {
    $('#header').click(function() {
        window.location.href = "/#header";
    });
    
    $('.slider').bxSlider({
        slideWidth: 200,
        minSlides: 2,
        maxSlides: 5,
        moveSlides: 1,
        slideMargin: 10
    });

    // var _element = $('div.well div.all');
    //     console.log(_element);

    //     _element.show();

    //     _element.parentsUntil('div.well', 'div.bx-wrapper').find('.bx-controls').show();

    showMovie('all');
    // $('.showtime .well div.all').parentsUtil('div.well', 'div.bx-wrapper').show();
    // function changeSelectedDate(_this, date) {
    // var btn = document.getElementByClass('btn-date');
    
    // this.classList.add("active");
    // }
    $('.btn-date').click(function(e) {
        hideMovie();
        var _class = $(this).data('date');
        // console.log(_class);
        showMovie(_class);
        // console.log($(this).data('date'));
    });

    function showMovie(_tag)
    {
        _tag = _tag.toString() || 'all';
        // _tag = '.well .'+_tag;
        var _element = $('div.well div.'+_tag);
        _element.show();

        _element.parentsUntil('div.well', 'div.bx-wrapper').find('.bx-controls').show();
    }

    function hideMovie()
    {
        console.log(123);
        var _tag = 'slider';
        var _class = $('.'+_tag);
        _class.hide();
        _class.parentsUntil('div.well', 'div.bx-wrapper').find('.bx-controls').hide();
    }
});
</script>

</body>
</html>