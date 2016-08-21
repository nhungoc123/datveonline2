<?php
include_once("../config.php");
if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];
}else{
    header('Location: '.$root.'');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Quản lý vé xem phim</title>
    
    <link href="<?=$root?>css/styles.css" rel="stylesheet" type="text/css" />
    <link href="<?=$root?>css/madisonisland.css" rel="stylesheet" type="text/css" />
    <link href="<?=$root?>css/cgv.css" rel="stylesheet" type="text/css" />

    <link href="<?=$root?>css/index.css" rel="stylesheet" type="text/css" />
    <link href="<?=$root?>css/header.css" rel="stylesheet" type="text/css" />
    <link href="<?=$root?>css/css.css" rel="stylesheet" type="text/css" />
    <link href="<?=$root?>css/footer.css" rel="stylesheet" type="text/css"  />
    <link href="<?=$root?>css/bootstrap.css" rel="stylesheet" type="text/css"  />
    <link href="<?=$root?>css/sweetalert.css" rel="stylesheet" type="text/css"  />
    <link href="<?=$root?>css/bootstrap-datepicker.css" rel="stylesheet" type="text/css"  />



    <script type="text/javascript" src="<?=$root?>js/jquery-1.12.4.js"></script>
    <script type="text/javascript" src="<?=$root?>js/sweetalert.min.js"></script>
    <script type="text/javascript" src="<?=$root?>js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="<?=$root?>js/bootstrap.js"></script>
    <script type="text/javascript" src="<?=$root?>js/index.js"></script>
    <script src="<?=$root?>js/sorttable.js"></script>
    <script type="text/javascript">

        function xoa(e,data,url) {
            e.preventDefault();
            swal({   
                title: "Xác nhận",   
                text: "Bạn có muốn xóa "+data+" !",
                type: "warning",
                showConfirmButton:  true,
                showCancelButton: true,
                confirmButtonText: "Xóa",
                cancelButtonText: "Hủy"
            },
            function(isConfirm) {
                if (isConfirm) {
                    swal.close();
                    window.location.href = url;
                } else {
                    return false;
                }
            });
        }

        function khoa(e,data,url) {
            e.preventDefault();
            swal({   
                title: "Xác nhận",   
                text: "Bạn có muốn khóa "+data+" !",
                type: "warning",
                showConfirmButton:  true,
                showCancelButton: true,
                confirmButtonText: "Khóa",
                cancelButtonText: "Hủy"
            },
            function(isConfirm) {
                if (isConfirm) {
                    swal.close();
                    window.location.href = url;
                } else {
                    return false;
                }
            });
        }

        function error(data,url){
            //e.preventDefault();
            swal({
                type: "error",
                title: "THẤT BẠI!",
                text: data,
            },function(){
                window.location.href = url;
            });
        }

        function success(data,url){
            //e.preventDefault();
            swal({
                type: "success",
                title: "THÀNH CÔNG!",
                text: data,
            },function(){
                window.location.href = url;
            });
        }


    </script>
</head>

<body class="background">
    <?php 
    include_once("header.php");
    ?>
    <div class="main-container-full">
        <div class="main-container col1-layout">
            <div class="main">          
                <div class="col-main">
                    <?php 
                    include_once("container.php");
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php 
    include_once("footer.php");
    ?>
</body>
</html>
