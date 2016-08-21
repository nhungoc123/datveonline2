<?php
include_once("../controllers/qluser_control.php");
if($_SESSION['level'] == 0){
	?>
	<script>
		function checkUser(){
			var form = document.getElementById("qluser-form");
			var re=/^[\w.-]+@[\w.-]+\.[A-Za-z]{2,4}$/;

			if(form.f_status.value == '' || form.f_email.value == ''){
				swal({
					type: "error",
					title: "THẤT BẠI!",
					text: "Các trường gắn dấu sao không được để trống",
				});
				return false;
			}else if(re.test(form.f_email.value) == false){
				swal({
					type: "error",
					title: "THẤT BẠI!",
					text: "Email không đúng định dạng",
				});
				return false;
			}else if(form.f_tel.value != form.f_tel2.value){
				swal({
					type: "error",
					title: "THẤT BẠI!",
					text: "Mật khẩu nhập lại không khớp",
				});
				return false;
			}else if(form.f_tel.value.length < 6 || form.f_tel.value.length > 20){
				swal({
					type: "error",
					title: "THẤT BẠI!",
					text: "Mật khẩu phải từ 6 đến 20 ký tự",
				});
				return false;
			}else{
				var params = "email="+form.f_email.value;
				var url = "../controllers/check_email.php";
				var result = false;
				$.ajax({
					type: 'POST',
					url: url,
					dataType: 'text',
					data: params,
					async: false,
					success: function(response) {
						if(response==1){
							result = true;
						}else{
							result = false;
						}
					}
				});
				if(result){
					swal({
						type: "error",
						title: "THẤT BẠI!",
						text: "Email đã được sử dụng",
					});
					return false;
				}
			}

			return true;
		}
	</script>

	<div>
		<fieldset>
			<legend>Quản lý nhân viên</legend>
			<form id="qluser-form" onsubmit="return checkUser();" class="form"  method="post" name="qluser_form" action="?act=qluser&code=<?=$code?>">
				<input type="text" class="sr-only" name="id" value="<?=$user['id']?>">
				<div class="form-group">
					<label for="f_status">Tên (*)</label>
					<input  type="text" class="form-control" id="f_status" name="name" value="<?=$user['name']?>">
				</div>
				<div class="form-group">
					<label for="f_tel">Mật khẩu (*)</label>
					<input type="password" class="form-control" id="f_tel" name="password" value="">
				</div>
				<div class="form-group">
					<label for="f_tel2">Nhập lại mật khẩu (*)</label>
					<input type="password" class="form-control" id="f_tel2" name="repassword" value="">
				</div>
				<div class="form-group">
					<label for="f_email">Email (*)</label>
					<input  type="email" class="form-control" id="f_email" name="email" value="<?=$user['email']?>">
				</div>
				<div class="form-group">
					<label for="f_level">Cấp độ (*)</label>
					<select class="form-control" style="width: 365px;" id="f_level" name="level">
						<?php
						if($user['level'] == 0 && $user['level'] != ''){
							echo "<option value='1' >Nhân viên</option>";
							echo "<option value='0' selected>Quản lý</option>";
						}else{
							echo "<option value='1' selected>Nhân viên</option>";
							echo "<option value='0'>Quản lý</option>";
						}
						?>
					</select>
				</div>
				<button type="submit" name="submit" value="add" class="btn btn-default"><?=$btn?></button>
				<button type="submit" name="submit" value="find" class="btn btn-default">Tìm</button>
				<?=isset($btn_del_find)? $btn_del_find: ''?>
			</form>
		</fieldset>

		<br><hr>
		<fieldset>
			<legend>Danh sách nhân viên</legend>
			<div id="qluser-list" class="table-responsiuser">
				<table class="table table-striped">
					<tr>
						<th>ID</th>
						<th>Tên</th>
						<th>Email</th>
						<th>Cấp độ</th>
						<th>Ngày tạo</th>
						<th>Lần sửa cuối</th>
						<th></th>
					</tr>
					<?php
					if(isset($user_list) && $user_list !== false){
						while ($data = mysql_fetch_array($user_list)) {
							echo"<tr>
							<td>".$data['id']."</td>
							<td>".$data['name']."</td>
							<td>".$data['email']."</td>
							<td>"; if($data['level']==1) echo 'nhân viên'; else if ($data['level']==0) echo 'quản lý'; else echo 'Khóa'; echo "</td>
							<td>".$data['created_at']."</td>
							<td>".$data['updated_at']."</td>
							<td><a href='?act=qluser&id=".$data['id']."&code=1'><button class='btn btn-default'>Sửa</button></a>
								- <a onclick='khoa(event,\"Khách hàng ".$data['name']."\",\"?act=qluser&id=".$data['id']."&code=2\");' ><button class='btn btn-default'>Khóa</button></a> </td>
							</tr>";
						}
					}else{
						echo "<tr><td class='text-center' colspan='6'>Chưa có dữ liệu</td></tr>";
					}
					?>
				</table>
				<nav <?=isset($hide_pag)?$hide_pag:''?>>
					<ul class="pagination" style="float:right">
						<?php if($total_page != 1){?>
							<li <?php if($current_page == 1) echo "class='disabled'"; ?> >
								<a href="<?php if($current_page != 1) echo "?act=qluser&page=".$prev_page."" ?>"  aria-label="Previous">
									<span aria-hidden="true">&laquo;</span>
								</a>
							</li>
							<?php }	?>
							<?php
							if($total_page<7){
								for ($i=1; $i <= $total_page; $i++) { 
									if($i == $current_page){
										echo '<li class="active"><a href="?act=qluser&page='.$i.'">'.$i.'</a></li>';
									}else{
										echo '<li ><a href="?act=qluser&page='.$i.'">'.$i.'</a></li>';
									}
								}
							}else{
								if($current_page>2 && $current_page<=$total_page - 2){
									echo '<li ><a href="?act=qluser&page='.($current_page-2).'">'.($current_page-2).'</a></li>';
									echo '<li ><a href="?act=qluser&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
									echo '<li class="active"><a href="?act=qluser&page='.$current_page.'">'.$current_page.'</a></li>';
									echo '<li ><a href="?act=qluser&page='.($current_page+1).'">'.($current_page+1).'</a></li>';
									echo '<li ><a href="?act=qluser&page='.($current_page+2).'">'.($current_page+2).'</a></li>';
									echo '<li ><a disabled>...</a></li>';
									echo '<li ><a href="?act=qluser&page='.$total_page.'">'.$total_page.'</a></li>';
								}elseif($current_page==1){
									echo '<li class="active"><a href="?act=qluser&page='.$current_page.'">'.$current_page.'</a></li>';
									echo '<li ><a href="?act=qluser&page='.($current_page+1).'">'.($current_page+1).'</a></li>';
									echo '<li ><a href="?act=qluser&page='.($current_page+2).'">'.($current_page+2).'</a></li>';
									echo '<li ><a disabled>...</a></li>';
									echo '<li ><a href="?act=qluser&page='.$total_page.'">'.$total_page.'</a></li>';
								}elseif($current_page==2){
									echo '<li ><a href="?act=qluser&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
									echo '<li class="active"><a href="?act=qluser&page='.$current_page.'">'.$current_page.'</a></li>';
									echo '<li ><a href="?act=qluser&page='.($current_page+1).'">'.($current_page+1).'</a></li>';
									echo '<li ><a href="?act=qluser&page='.($current_page+2).'">'.($current_page+2).'</a></li>';
									echo '<li ><a disabled>...</a></li>';
									echo '<li ><a href="?act=qluser&page='.$total_page.'">'.$total_page.'</a></li>';
								}elseif($current_page==($total_page - 1)){
									echo '<li ><a href="?act=qluser&page=1">1</a></li>';
									echo '<li ><a disabled>...</a></li>';
									echo '<li ><a href="?act=qluser&page='.($current_page-2).'">'.($current_page-2).'</a></li>';
									echo '<li ><a href="?act=qluser&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
									echo '<li class="active"><a href="?act=qluser&page='.$current_page.'">'.$current_page.'</a></li>';
									echo '<li ><a href="?act=qluser&page='.($current_page+1).'">'.($current_page+1).'</a></li>';		
								}elseif($current_page==$total_page){
									echo '<li ><a href="?act=qluser&page=1">1</a></li>';
									echo '<li ><a disabled>...</a></li>';
									echo '<li ><a href="?act=qluser&page='.($current_page-2).'">'.($current_page-2).'</a></li>';
									echo '<li ><a href="?act=qluser&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
									echo '<li class="active"><a href="?act=qluser&page='.$current_page.'">'.$current_page.'</a></li>';	
								}
							}

							?>
							<?php if($total_page != 1){?>
								<li <?php if($current_page == $total_page) echo "class='disabled'" ?> >
									<a href="<?php if($current_page != $total_page) echo "?act=qluser&page=".$next_page."" ?>"  aria-label="Next">
										<span aria-hidden="true">&raquo;</span>
									</a>
								</li>
								<?php }	?>
							</ul>
						</nav>
					</div>
				</fieldset>
			</div>
			<?php
		}
		?>