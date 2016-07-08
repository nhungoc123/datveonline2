
<!-- Modal -->
<div class="modal fade detail" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        <div class="embed-responsive embed-responsive-16by9 iframe">
            <iframe class="embed-responsive-item" src="" frameborder="0" allowfullscreen></iframe>
        </div>
        <div align="center" class="embed-responsive embed-responsive-16by9 video">
          <video class="embed-responsive-item" controls>
              <source src="" type="video/mp4">
          </video>
      </div>
        <div class="clearfix"></div>
        
        <input id="rating" value="" type="number" min=0 max=5 step=0.5 data-size="ss" >

        <div class="row movie-detail">
            <!-- detail here -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
        <a href="<?php echo HTTP_HOST;?>showtime/" type="button" class="btn btn-primary" >Xem lịch chiếu</a>
      </div>
    </div>
  </div>
</div>

