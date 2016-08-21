<?php
include_once("../controllers/qlphim_control.php");

?>
<script type="text/javascript">
	
	function xemTrailer(url){
		if(url.substring(0,4) == 'http'){
			$("#src-youtube").show();
			$("#src-trailer").hide();
			var video = document.getElementById('src-youtube');
			video.src = url;
		}else{
			$("#src-trailer").show();
			$("#src-youtube").hide();
			url = '<?=HTTP_HOST.VIDEO_DIR?>'+url;
			var video = document.getElementById('src-trailer');
			video.src = url;
			video.play();
		}
	}


	

	function getExtension(filename) {
		var parts = filename.split('.');
		return parts[parts.length - 1];
	}

	function isImage(filename) {
		var ext = getExtension(filename);
		switch (ext.toLowerCase()) {
			case 'image/gif':
			case 'image/pjpeg':
			case 'image/jpeg':
			case 'image/jpg':
			case 'image/png':
			case 'image/x-png':
			return true;
		}
		return false;
	}

	function isVideo(filename) {
		var ext = getExtension(filename);
		console.log(ext);
		switch (ext.toLowerCase()) {
			case 'video/mp4':
			case 'video/x-matroska':
			case 'video/avi':
			return true;
		}
		return false;
	}
	$(document).ready(function(){
		$('#myModal').on('hidden.bs.modal', function () {
			var video = document.getElementById('src-trailer');
			video.src="";
			var youtube = document.getElementById('src-youtube');
			youtube.src="";
		});

		$('#f_image').change(function(){
			var file = this.files[0];
			var name = file.name;
			var size = file.size;
			var type = file.type;


			if(!isImage(type)){
				swal({
					type: "error",
					title: "THẤT BẠI!",
					text: "Chỉ chấp nhận các file đuôi sau .png, .jpg, .bmp, .gif",
				});
				this.value = "";
				return false;
			}

			if(size > 2*1048576){
				swal({
					type: "error",
					title: "THẤT BẠI!",
					text: "Kích thước file trailer không được quá 2mb",
				});
				this.value = "";
				return false;
			}
		})
		$('#f_trailer').change(function(){
			var file = this.files[0];
			var name = file.name;
			var size = file.size;
			var type = file.type;


			if(!isVideo(type)){
				swal({
					type: "error",
					title: "THẤT BẠI!",
					text: "Chỉ chấp nhận các file đuôi sau .mp4, .mkv",
				});
				this.value = "";
				return false;
			}

			if(size > 64*1048576){
				swal({
					type: "error",
					title: "THẤT BẠI!",
					text: "Kích thước file trailer không được quá 64mb",
				});
				this.value = "";
				return false;
			}
		})
	});
</script>
<div>
	<fieldset>
		<legend>Quản lý phim</legend>
		<form id="qlphim-form"  class="form" name="qlphim_form" action="?act=qlphim&code=<?=$code?>" method="post" enctype="multipart/form-data">
			<input type="text" class="sr-only" name="id" value="<?=$phim['id']?>">
			<div class="form-group">
				<label for="f_name">Tên phim (*)</label>
				<input  type="text" class="form-control" id="f_name" name="name" value="<?=$phim['name']?>">
			</div>
			<div class="form-group">
				<label for="f_genre">Thể loại</label>
				<input  type="text" class="form-control" id="f_genre" name="genre" value="<?=$phim['genre']?>">
			</div>
			<div class="form-group">
				<label for="f_desc">Mô tả</label>
				<textarea class="form-control" name="description" id="f_desc" style="width:365px"><?=$phim['description']?></textarea>
			</div>
			<div class="form-group">
				<label for="f_image">Ảnh phim (*)</label>
				<input  type="file" class="form-control" name="image" accept=".jpg,.png,.gif" id="f_image" style="width:365px"/>
			</div>
			<div class="form-group">
				<label for="f_actor">Diễn viên</label>
				<input  type="text" class="form-control" id="f_actor" name="actor" value="<?=$phim['actor']?>">
			</div>
			<div class="form-group">
				<label for="f_year">Năm</label>
				<input  type="text" class="form-control" id="f_year" name="year" value="<?=$phim['year']?>">
			</div>
			<div class="form-group">
				<label for="f_durations">Thời lượng (phút)</label>
				<input  type="text" class="form-control" id="f_durations" name="durations" value="<?=$phim['durations']?>">
			</div>
			<div class="form-group">
				<label for="f_trailer">Trailer</label>
				<input  type="file" class="form-control" id="f_trailer" accept=".mp4,.mkv,.avi" name="trailer" style="width:365px">
			</div>
			<div class="form-group">
				<label for="f_trailer2">(Hoặc link trailer)</label>
				<input  type="text" class="form-control" id="f_trailer2" name="trailer2">
			</div>
			<button type="submit" name="submit" value="add" class="btn btn-default"><?=$btn?></button>
			<button type="submit" name="submit" value="find" class="btn btn-default">Tìm</button>
			<?=isset($btn_del_find)? $btn_del_find: ''?>
		</form>
	</fieldset>

	<br><hr>
	<fieldset>
		<legend>Danh sách phim</legend>
		<div id="qlphim-list" class="table-responsive">
			<table class="table table-striped">
				<tr>
					<th>ID</th>
					<th>Tên phim</th>
					<th>Thể loại</th>
					<th>Mô tả</th>
					<th>Ảnh phim</th>
					<th>Diễn viên</th>
					<th>Năm</th>
					<th>Thời lượng</th>
					<th style="max-width:200px; overflow:hidden">Trailer</th>
					<th>Ngày tạo</th>
					<th>Lần sửa cuối</th>
					<th style="min-width:160px"></th>
				</tr>
				<?php
				if(isset($phim_list) && $phim_list !== false){
					while ($data = mysql_fetch_array($phim_list)) {
						echo"<tr>
						<td>".$data['id']."</td>
						<td>".$data['name']."</td>
						<td>".$data['genre']."</td>
						<td>".$data['description']."</td>
						<td><img src='".HTTP_HOST.UPLOAD_DIR.$data['image']."' style='width:150px'/></td>
						<td>".$data['actor']."</td>
						<td>".$data['year']."</td>
						<td>".$data['durations']."</td>
						<td>"; if($data['trailer'] != ''){
							echo "<button type='button' onclick='xemTrailer(\"".$data['trailer']."\")' class='btn btn-small' data-toggle='modal' data-target='#myModal'>
							Xem trailer
						</button>";
					}
					echo "
				</td>
				<td>".$data['created_at']."</td>
				<td>".$data['updated_at']."</td>
				<td><a href='?act=qlphim&id=".$data['id']."&code=1'><button class='btn btn-default'>Sửa</button></a>
					- <a onclick='xoa(event,\"phim ".$data['name']."\",\"?act=qlphim&id=".$data['id']."&code=2\");' ><button class='btn btn-default'>Xóa</button></a> </td>
				</tr>";
			}}else{
				echo "<tr><td class='text-center' colspan='12'>Chưa có dữ liệu</td></tr>";
			}
			?>
		</table>
		<nav <?=isset($hide_pag)?$hide_pag:''?>>
			<ul class="pagination" style="float:right">
				<?php if($total_page != 1){?>
					<li <?php if($current_page == 1) echo "class='disabled'"; ?> >
						<a href="<?php if($current_page != 1) echo "?act=qlphim&page=".$prev_page."" ?>"  aria-label="Previous">
							<span aria-hidden="true">&laquo;</span>
						</a>
					</li>
					<?php }	?>
					<?php
					if($total_page<7){
						for ($i=1; $i <= $total_page; $i++) { 
							if($i == $current_page){
								echo '<li class="active"><a href="?act=qlphim&page='.$i.'">'.$i.'</a></li>';
							}else{
								echo '<li ><a href="?act=qlphim&page='.$i.'">'.$i.'</a></li>';
							}
						}
					}else{
						if($current_page>2 && $current_page<=$total_page - 2){
							echo '<li ><a href="?act=qlphim&page='.($current_page-2).'">'.($current_page-2).'</a></li>';
							echo '<li ><a href="?act=qlphim&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
							echo '<li class="active"><a href="?act=qlphim&page='.$current_page.'">'.$current_page.'</a></li>';
							echo '<li ><a href="?act=qlphim&page='.($current_page+1).'">'.($current_page+1).'</a></li>';
							echo '<li ><a href="?act=qlphim&page='.($current_page+2).'">'.($current_page+2).'</a></li>';
							echo '<li ><a disabled>...</a></li>';
							echo '<li ><a href="?act=qlphim&page='.$total_page.'">'.$total_page.'</a></li>';
						}elseif($current_page==1){
							echo '<li class="active"><a href="?act=qlphim&page='.$current_page.'">'.$current_page.'</a></li>';
							echo '<li ><a href="?act=qlphim&page='.($current_page+1).'">'.($current_page+1).'</a></li>';
							echo '<li ><a href="?act=qlphim&page='.($current_page+2).'">'.($current_page+2).'</a></li>';
							echo '<li ><a disabled>...</a></li>';
							echo '<li ><a href="?act=qlphim&page='.$total_page.'">'.$total_page.'</a></li>';
						}elseif($current_page==2){
							echo '<li ><a href="?act=qlphim&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
							echo '<li class="active"><a href="?act=qlphim&page='.$current_page.'">'.$current_page.'</a></li>';
							echo '<li ><a href="?act=qlphim&page='.($current_page+1).'">'.($current_page+1).'</a></li>';
							echo '<li ><a href="?act=qlphim&page='.($current_page+2).'">'.($current_page+2).'</a></li>';
							echo '<li ><a disabled>...</a></li>';
							echo '<li ><a href="?act=qlphim&page='.$total_page.'">'.$total_page.'</a></li>';
						}elseif($current_page==($total_page - 1)){
							echo '<li ><a href="?act=qlphim&page=1">1</a></li>';
							echo '<li ><a disabled>...</a></li>';
							echo '<li ><a href="?act=qlphim&page='.($current_page-2).'">'.($current_page-2).'</a></li>';
							echo '<li ><a href="?act=qlphim&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
							echo '<li class="active"><a href="?act=qlphim&page='.$current_page.'">'.$current_page.'</a></li>';
							echo '<li ><a href="?act=qlphim&page='.($current_page+1).'">'.($current_page+1).'</a></li>';		
						}elseif($current_page==$total_page){
							echo '<li ><a href="?act=qlphim&page=1">1</a></li>';
							echo '<li ><a disabled>...</a></li>';
							echo '<li ><a href="?act=qlphim&page='.($current_page-2).'">'.($current_page-2).'</a></li>';
							echo '<li ><a href="?act=qlphim&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
							echo '<li class="active"><a href="?act=qlphim&page='.$current_page.'">'.$current_page.'</a></li>';	
						}
					}

					?>
					<?php if($total_page != 1){?>
						<li <?php if($current_page == $total_page) echo "class='disabled'" ?> >
							<a href="<?php if($current_page != $total_page) echo "?act=qlphim&page=".$next_page."" ?>"  aria-label="Next">
								<span aria-hidden="true">&raquo;</span>
							</a>
						</li>
						<?php }	?>
					</ul>
				</nav>
			</div>
		</fieldset>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Trailer phim</h4>
				</div>
				<div class="modal-body">
					<video id="src-trailer" controls="" autoplay="" width="550" name="media">
						<source  src=""  />
					</video>
					<iframe id="src-youtube" width="550" height="400" src="">
					</iframe>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

