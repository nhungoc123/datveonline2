<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<head>
<script src="js/jquery-1.8.2.js"></script>
<script language="javascript">
	function login_check()
	{
		var email=document.getElementById("email").value;
		var password=document.getElementById("password").value;
		var params = "email="+email+"&password="+password;
		var url = "controllers/login_control.php";
		$.ajax({
			type: 'POST',
			url: url,
			dataType: 'text',
			data: params,
			beforeSend: function() {
				document.getElementById("status").innerHTML= 'checking...'  ;
			},
			success: function(response) {
				if(response==1){
					window.location = "views/index.php";
				}else{
					document.getElementById("status").innerHTML= response;
				}

			}
		});
	}
</script>
<link rel="stylesheet" href="style.css">
</head>
<body>
	<div id='logindiv'>

		<label>Tên đăng nhập</label>
		<input name="email"  id="email" type="text" value="admin@stu.vn">
		<label>Password:</label>
		<input name="password" id="password" type="password" value="admin">
		<input value="Đăng nhập" name="submit" class="submit" type="submit" onclick='login_check();'>
		<div id='status'></div>
	</div>	

</body>
</html>


