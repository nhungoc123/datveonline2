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

    .showtime a.btn-date.active {
        background-color: #ffffff;
        color: #404040;
    }
    /*#movie-slider .well {
    	display: none;
    }*/

    /*.slider, .bx-controls {
        display: none;
    }*/
    /*.showtime .well div.slider.all {
        display: block !important;
    }*/
    /*#myCarousel {
        height: 246px;
    }*/
.hovereffect {
  width: 100%;
  height: 100%;
  float: left;
  overflow: hidden;
  position: relative;
  text-align: center;
  cursor: default;
}

.hovereffect .overlay {
  position: absolute;
  overflow: hidden;
  width: 80%;
  height: 80%;
  left: 10%;
  top: 10%;
  border-bottom: 1px solid #FFF;
  border-top: 1px solid #FFF;
  -webkit-transition: opacity 0.35s, -webkit-transform 0.35s;
  transition: opacity 0.35s, transform 0.35s;
  -webkit-transform: scale(0,1);
  -ms-transform: scale(0,1);
  transform: scale(0,1);
}

.hovereffect:hover .overlay {
  opacity: 1;
  filter: alpha(opacity=100);
  -webkit-transform: scale(1);
  -ms-transform: scale(1);
  transform: scale(1);
}

.hovereffect img {
  display: block;
  position: relative;
  -webkit-transition: all 0.35s;
  transition: all 0.35s;
}

.hovereffect:hover img {
  filter: url('data:image/svg+xml;charset=utf-8,<svg xmlns="http://www.w3.org/2000/svg"><filter id="filter"><feComponentTransfer color-interpolation-filters="sRGB"><feFuncR type="linear" slope="0.6" /><feFuncG type="linear" slope="0.6" /><feFuncB type="linear" slope="0.6" /></feComponentTransfer></filter></svg>#filter');
  filter: brightness(0.6);
  -webkit-filter: brightness(0.6);
}

.hovereffect h2 {
  text-transform: uppercase;
  text-align: center;
  position: relative;
  font-size: 17px;
  background-color: transparent;
  color: #FFF;
  padding: 1em 0;
  opacity: 0;
  filter: alpha(opacity=0);
  -webkit-transition: opacity 0.35s, -webkit-transform 0.35s;
  transition: opacity 0.35s, transform 0.35s;
  -webkit-transform: translate3d(0,-100%,0);
  transform: translate3d(0,-100%,0);
}

.hovereffect a, hovereffect p {
  color: #FFF;
  padding: 1em 0;
  opacity: 0;
  filter: alpha(opacity=0);
  -webkit-transition: opacity 0.35s, -webkit-transform 0.35s;
  transition: opacity 0.35s, transform 0.35s;
  -webkit-transform: translate3d(0,100%,0);
  transform: translate3d(0,100%,0);
}

.hovereffect:hover a, .hovereffect:hover p, .hovereffect:hover h2 {
  opacity: 1;
  filter: alpha(opacity=100);
  -webkit-transform: translate3d(0,0,0);
  transform: translate3d(0,0,0);
}

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
	            <div id="movie-slider">
	                <?php $cnt = 0;?>

	                <?php foreach ($arrMovie as $key => $value) {?>
	                	<?php if ($key == 'all') {
	                		continue;
	                	} ?>
	                	<div class="well <?php echo $key ?>">
	                        <div class="slider <?php echo $cnt;?>">
	                    	<?php $cnt++;?>
	                        <?php foreach ($value as $v) {?>
	                            <div class="slide hovereffect" data-id="<?php echo $v['id'];?>" data-date="<?php echo $key;?>">
	                            	<img class="img-responsive" style="max-height: 200px" src="<?php echo UPLOAD_DIR . $v['image'];?>">
	                            	<div class="overlay">
					                <h2><?php echo $v['name'];?></h2>
					            </div>
	                            </div>
	                        <?php } ?>
	                        </div>
	                    </div>
	                	<!--/well-->
	                <?php } ?>
	            </div>
            </div>

            <div class="col-md-12" id="movie-performance">
                    <?php foreach ($arrMovie as $key => $movie) {?>
	                    <?php if ($key == 'all') {
	                		continue;
	                	} ?>
	                	<div class="well <?php echo $key;?>">
		                	<?php foreach ($movie as $k => $v) {?>
			            	<div class="panel panel-primary <?php echo $v['id'];?>">
			            		<div class="panel-heading"><?php echo $v['name'];?></div>
								<div class="panel-body">
									<ul class="list-inline">
									<?php foreach ($arrShowtime[$key][$k] as $showtime) { ?>
                    <?php $nowtime = time();
                      $disable = '';
                    if ($nowtime >= strtotime($arrPerformance[$showtime])) {
                      $disable = 'disabled';
                    }
                    ?>
									<li ><a href="/seat/?st=<?php echo $v['showtimes_id'];?>&pf=<?php echo $showtime;?>" class="btn btn-default <?php echo $disable ?>"><?php echo $arrPerformance[$showtime] ?></a></li>
									<?php } ?>
									</ul>
								</div>
			            	</div>
			            	<?php } ?>
		            	</div>
                    <?php } ?>
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

    $('#movie-slider .slider').each(function(index, element) {
    	$('#movie-slider .'+index).bxSlider({
	        slideWidth: 200,
	        minSlides: 2,
	        maxSlides: 5,
	        moveSlides: 1,
	        slideMargin: 10
	    });
    });

	hideMovie();
    showMovie();
    hideShowtime();
    showShowtime();

    $('.btn-date').click(function(e) {
        hideMovie();
        var date = $(this).data('date');
        showMovie(date);
        $(this).addClass('active');
        hideShowtime();
        showShowtime(date);
    });

    $('#movie-slider .slide').click(function() {
    	var id =$(this).data('id');
    	var date =$(this).data('date');
    	hideShowtime();
    	showShowtime(date, id);
    });

    function showMovie(_tag) {
        if (_tag) {
			var _element = $('div#movie-slider div.'+_tag);
	        _element.show();
        } else {
        	$('.btn-date').first().addClass('active');
        	$('div#movie-slider div.well').first().show();
        }
    }

    function hideMovie() {
    	$('#movie-slider .well').hide();
    	$('.btn-date').each(function() {
    		$(this).removeClass('active');
    	});
    }

    function showShowtime(_date, _id) {
    	if (_id && _date) {
			var _element = $('#movie-performance .'+ _date);
	        _element.show();
	        _element.find('.panel').each(function(index, element) {
	        	$(this).hide();
	        });
	        var _panel = _element.find('.'+_id);
	        _panel.show();
        } else if (_date) {
        	var _element = $('#movie-performance .'+ _date);
        	_element.show();
        	_element.find('.panel').each(function(index, element) {
	        	$(this).show();
	        });
        } else {
        	$('div#movie-performance div.well').first().show();
        }
    }

    function hideShowtime() {
    	$('div#movie-performance div.well').hide();
    }
});
</script>

</body>
</html>