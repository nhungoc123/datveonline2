<?php
include_once("../controllers/qlkhachhang_control.php");

?>
<div>
	<fieldset>
		<legend>Quản lý khách hàng</legend>
		<form id="qlkhachhang-form" class="form" name="qlkhachhang_form" action="?act=qlkhachhang&code=<?=$code?>" method="post">
			<input type="text" class="sr-only" name="id" value="<?=$khachhang['id']?>">
			<div class="form-group">
				<label for="f_status">Tên (*)</label>
				<input  type="text" class="form-control" id="f_status" name="name" value="<?=$khachhang['name']?>">
			</div>
			<div class="form-group">
				<label for="f_tel">Số điện thoại (*)</label>
				<input  type="number" class="form-control" id="f_tel" name="tel" value="<?=$khachhang['tel']?>">
			</div>
			<div class="form-group">
				<label for="f_email">Email (*)</label>
				<input  type="email" class="form-control" id="f_email" name="email" value="<?=$khachhang['email']?>">
			</div>
			<button type="submit" name="submit" value="add" class="btn btn-default"><?=$btn?></button>
			<button type="submit" name="submit" value="find" class="btn btn-default">Tìm</button>
			<?=isset($btn_del_find)? $btn_del_find: ''?>
		</form>
	</fieldset>

	<br><hr>
	<fieldset>
		<legend>Danh sách khách hàng</legend>
		<div id="qlkhachhang-list" class="table-responsikhachhang">
			<table class="table table-striped">
				<tr>
					<th>ID</th>
					<th>Tên</th>
					<th>SĐT</th>
					<th>Email</th>
					<th>Thanh toán</th>
					<th>Ngày tạo</th>
					<th>Lần sửa cuối</th>
					<th></th>
				</tr>
				<?php
				if(isset($khachhang_list) && $khachhang_list !== false){
				while ($data = mysql_fetch_array($khachhang_list)) {
					echo"<tr>
					<td>".$data['id']."</td>
					<td>".$data['name']."</td>
					<td>".$data['tel']."</td>
					<td>".$data['email']."</td>
					<td>".$data['payment']."</td>
					<td>".$data['created_at']."</td>
					<td>".$data['updated_at']."</td>
					<td><a href='?act=qlkhachhang&id=".$data['id']."&code=1'><button class='btn btn-default'>Sửa</button></a>
						- <a onclick='xoa(event,\"Khách hàng ".$data['name']."\",\"?act=qlkhachhang&id=".$data['id']."&code=2\");' ><button class='btn btn-default'>Khóa</button></a> </td>
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
							<a href="<?php if($current_page != 1) echo "?act=qlkhachhang&page=".$prev_page."" ?>"  aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
						</li>
						<?php }	?>
						<?php
						if($total_page<7){
							for ($i=1; $i <= $total_page; $i++) { 
								if($i == $current_page){
									echo '<li class="active"><a href="?act=qlkhachhang&page='.$i.'">'.$i.'</a></li>';
								}else{
									echo '<li ><a href="?act=qlkhachhang&page='.$i.'">'.$i.'</a></li>';
								}
							}
						}else{
							if($current_page>2 && $current_page<=$total_page - 2){
								echo '<li ><a href="?act=qlkhachhang&page='.($current_page-2).'">'.($current_page-2).'</a></li>';
								echo '<li ><a href="?act=qlkhachhang&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
								echo '<li class="active"><a href="?act=qlkhachhang&page='.$current_page.'">'.$current_page.'</a></li>';
								echo '<li ><a href="?act=qlkhachhang&page='.($current_page+1).'">'.($current_page+1).'</a></li>';
								echo '<li ><a href="?act=qlkhachhang&page='.($current_page+2).'">'.($current_page+2).'</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qlkhachhang&page='.$total_page.'">'.$total_page.'</a></li>';
							}elseif($current_page==1){
								echo '<li class="active"><a href="?act=qlkhachhang&page='.$current_page.'">'.$current_page.'</a></li>';
								echo '<li ><a href="?act=qlkhachhang&page='.($current_page+1).'">'.($current_page+1).'</a></li>';
								echo '<li ><a href="?act=qlkhachhang&page='.($current_page+2).'">'.($current_page+2).'</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qlkhachhang&page='.$total_page.'">'.$total_page.'</a></li>';
							}elseif($current_page==2){
								echo '<li ><a href="?act=qlkhachhang&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
								echo '<li class="active"><a href="?act=qlkhachhang&page='.$current_page.'">'.$current_page.'</a></li>';
								echo '<li ><a href="?act=qlkhachhang&page='.($current_page+1).'">'.($current_page+1).'</a></li>';
								echo '<li ><a href="?act=qlkhachhang&page='.($current_page+2).'">'.($current_page+2).'</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qlkhachhang&page='.$total_page.'">'.$total_page.'</a></li>';
							}elseif($current_page==($total_page - 1)){
								echo '<li ><a href="?act=qlkhachhang&page=1">1</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qlkhachhang&page='.($current_page-2).'">'.($current_page-2).'</a></li>';
								echo '<li ><a href="?act=qlkhachhang&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
								echo '<li class="active"><a href="?act=qlkhachhang&page='.$current_page.'">'.$current_page.'</a></li>';
								echo '<li ><a href="?act=qlkhachhang&page='.($current_page+1).'">'.($current_page+1).'</a></li>';		
							}elseif($current_page==$total_page){
								echo '<li ><a href="?act=qlkhachhang&page=1">1</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qlkhachhang&page='.($current_page-2).'">'.($current_page-2).'</a></li>';
								echo '<li ><a href="?act=qlkhachhang&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
								echo '<li class="active"><a href="?act=qlkhachhang&page='.$current_page.'">'.$current_page.'</a></li>';	
							}
						}
						
						?>
						<?php if($total_page != 1){?>
							<li <?php if($current_page == $total_page) echo "class='disabled'" ?> >
								<a href="<?php if($current_page != $total_page) echo "?act=qlkhachhang&page=".$next_page."" ?>"  aria-label="Next">
									<span aria-hidden="true">&raquo;</span>
								</a>
							</li>
							<?php }	?>
						</ul>
					</nav>
				</div>
			</fieldset>
		</div>