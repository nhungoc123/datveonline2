<?php
include_once("../controllers/qlghe_control.php");

?>

<div>
	<fieldset>
		<legend>Quản lý ghế</legend>
		<form id="qlghe-form" class="form" name="qlghe_form" action="?act=qlghe&code=<?=$code?>" method="post">
			<input type="text" class="sr-only" name="id" value="<?=$ghe['id']?>">
			<div class="form-group">
				<label for="f_row">Hàng (*)</label>
				<input  type="text" class="form-control" id="f_row" name="row" value="<?=$ghe['row']?>">
			</div>
			<div class="form-group">
				<label for="f_col">Cột (*)</label>
				<input  type="text" class="form-control" id="f_col" name="column" value="<?=$ghe['column']?>">
			</div>
			<div class="form-group">
				<label for="f_type">Loại (*)</label>
				<select  id="f_type" name="type" class="form-control"  style="width:365px">
					<option value="">Chọn loại</option>
					<?php
					foreach ($type as $item) {
						if($ghe['type'] == $item){
							echo"<option value='".$item."' selected>".$item."</option>";
						}else{
							echo"<option value='".$item."'>".$item."</option>";
						}
					}
					?>
				</select>
			</div>
			<div class="form-group">
				<label for="f_rap">Rạp chiếu (*)</label>
				<select  id="f_rap" name="cinema_id" class="form-control"  style="width:365px">
					<option value="">Chọn rạp chiếu</option>
					<?php
					while ($data = mysql_fetch_array($rapchieu_list)) {
						if($ghe['cinema_id'] == $data['id']){
							echo"<option value='".$data['id']."' selected>".$data['name']."</option>";
						}else{
							echo"<option value='".$data['id']."'>".$data['name']."</option>";
						}
					}
					?>
				</select>
			</div>
			<!-- <button type="submit" name="submit" value="add" class="btn btn-default"><?=$btn?></button> -->
			<button type="submit" name="submit" value="find" class="btn btn-default">Tìm</button>
			<?=isset($btn_del_find)? $btn_del_find: ''?>
		</form>
	</fieldset>

	<br><hr>
	<fieldset>
		<legend>Danh sách ghế</legend>
		<div id="qlghe-list">
			<table class="table table-striped">
				<tr>
					<th>ID</th>
					<th>Hàng</th>
					<th>Cột</th>
					<th>Loại</th>
					<th>Rạp chiếu</th>
					<th>Ngày tạo</th>
					<th>Lần sửa cuối</th>
					<th style="min-width:160px"></th>
				</tr>
				<?php
				if(isset($ghe_list) && $ghe_list !== false){
					while ($data = mysql_fetch_array($ghe_list)) {
						echo"<tr>
						<td>".$data['id']."</td>
						<td>".$data['row']."</td>
						<td>".$data['column']."</td>
						<td>".$data['type']."</td>
						<td>".$data['c_name']."</td>
						<td>".$data['created_at']."</td>
						<td>".$data['updated_at']."</td>
						<td>
							<a href='?act=qlghe&id=".$data['id']."&code=1'><button class='btn btn-default'>Sửa</button></a>
							
							<a onclick='xoa(event,\"ghế hàng ".$data['row']." cột ".$data['column']." rạp phim ".$data['c_name']."\",\"?act=qlghe&id=".$data['id']."&code=2\");'><button class='btn btn-default sr-only'>Xóa</button></a> </td>
						</tr>";
					}
				}else{
					echo "<tr><td class='text-center' colspan='8'>Chưa có dữ liệu</td></tr>";
				}
				?>
			</table>
			<nav <?=isset($hide_pag)?$hide_pag:''?>>
				<ul class="pagination" style="float:right">
					<?php if($total_page != 1){?>
						<li <?php if($current_page == 1) echo "class='disabled'"; ?> >
							<a href="<?php if($current_page != 1) echo "?act=qlghe&page=".$prev_page."" ?>"  aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
						</li>
						<?php }	?>
						<?php
						if($total_page<7){
							for ($i=1; $i <= $total_page; $i++) { 
								if($i == $current_page){
									echo '<li class="active"><a href="?act=qlghe&page='.$i.'">'.$i.'</a></li>';
								}else{
									echo '<li ><a href="?act=qlghe&page='.$i.'">'.$i.'</a></li>';
								}
							}
						}else{
							if($current_page>2 && $current_page<=$total_page - 2){
								echo '<li ><a href="?act=qlghe&page='.($current_page-2).'">'.($current_page-2).'</a></li>';
								echo '<li ><a href="?act=qlghe&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
								echo '<li class="active"><a href="?act=qlghe&page='.$current_page.'">'.$current_page.'</a></li>';
								echo '<li ><a href="?act=qlghe&page='.($current_page+1).'">'.($current_page+1).'</a></li>';
								echo '<li ><a href="?act=qlghe&page='.($current_page+2).'">'.($current_page+2).'</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qlghe&page='.$total_page.'">'.$total_page.'</a></li>';
							}elseif($current_page==1){
								echo '<li class="active"><a href="?act=qlghe&page='.$current_page.'">'.$current_page.'</a></li>';
								echo '<li ><a href="?act=qlghe&page='.($current_page+1).'">'.($current_page+1).'</a></li>';
								echo '<li ><a href="?act=qlghe&page='.($current_page+2).'">'.($current_page+2).'</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qlghe&page='.$total_page.'">'.$total_page.'</a></li>';
							}elseif($current_page==2){
								echo '<li ><a href="?act=qlghe&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
								echo '<li class="active"><a href="?act=qlghe&page='.$current_page.'">'.$current_page.'</a></li>';
								echo '<li ><a href="?act=qlghe&page='.($current_page+1).'">'.($current_page+1).'</a></li>';
								echo '<li ><a href="?act=qlghe&page='.($current_page+2).'">'.($current_page+2).'</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qlghe&page='.$total_page.'">'.$total_page.'</a></li>';
							}elseif($current_page==($total_page - 1)){
								echo '<li ><a href="?act=qlghe&page=1">1</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qlghe&page='.($current_page-2).'">'.($current_page-2).'</a></li>';
								echo '<li ><a href="?act=qlghe&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
								echo '<li class="active"><a href="?act=qlghe&page='.$current_page.'">'.$current_page.'</a></li>';
								echo '<li ><a href="?act=qlghe&page='.($current_page+1).'">'.($current_page+1).'</a></li>';		
							}elseif($current_page==$total_page){
								echo '<li ><a href="?act=qlghe&page=1">1</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qlghe&page='.($current_page-2).'">'.($current_page-2).'</a></li>';
								echo '<li ><a href="?act=qlghe&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
								echo '<li class="active"><a href="?act=qlghe&page='.$current_page.'">'.$current_page.'</a></li>';	
							}
						}
						
						?>
						<?php if($total_page != 1){?>
							<li <?php if($current_page == $total_page) echo "class='disabled'" ?> >
								<a href="<?php if($current_page != $total_page) echo "?act=qlghe&page=".$next_page."" ?>"  aria-label="Next">
									<span aria-hidden="true">&raquo;</span>
								</a>
							</li>
							<?php }	?>
						</ul>
					</nav>
		</div>
	</fieldset>
</div>