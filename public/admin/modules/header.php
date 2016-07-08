<?php
if(isset($_SESSION['user'])){
  $user = $_SESSION['user'];
}else{
  header('Location: ' + URL_HOST);
}
?>
<div class="wrapper">
  <noscript>
    &lt;div class="global-site-notice noscript"&gt;
    &lt;div class="notice-inner"&gt;
    &lt;p&gt;
    &lt;strong&gt;JavaScript seems to be disabled in your browser.&lt;/strong&gt;&lt;br /&gt;
    You must have JavaScript enabled in your browser to utilize the functionality of this website.                &lt;/p&gt;
    &lt;/div&gt;
    &lt;/div&gt;
  </noscript>
  <style type="text/css">
    #header a{
      color:#4f4f4f;
      font-weight: bold;
      font-size: 16px;
    }
  </style>
  <div class="page">
    <header class="header-container-full">
      <div class="header-language-background">
        <div class="header-language-container">
          <div class="header-language-container-left">
          </div>

          <div class="header-language-container-right">     
            <div class="header-top-account">
              <div class="links">
                <ul>
                  <li class=" last" id="top_register">Chào <?=$user['name']?> - <a href="<?=$root?>modules/logout.php">Đăng xuất</a></li>
                </ul>
              </div>
            </div>
          </div>        
        </div>
      </div>

      <div id="header">
        <div class="page-header-container">
          <a class="logo" href="<?=$root?>modules/index.php">
            <img src="<?=$root?>img/cgvlogo.png" alt="CGV CINEMAS" class="large">
            <img src="<?=$root?>img/cgvlogo.png" alt="CGV CINEMAS" class="small">
          </a>

          <div class="store-language-container"></div>

          <!-- Skip Links -->

          <div class="skip-links">
          </div>

          <!-- Navigation -->

          <div id="header-nav" class="">
          <ul class="nav nav-tabs" style="border:none;">
            <li role="presentation" class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                PHIM <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li ><a href="?act=qlphim">Quản lý phim</a></li>
                <li ><a href="?act=qlphimrap">Quản lý phim - rạp</a></li>
              </ul>
            </li>

            <li role="presentation" class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                LỊCH CHIẾU <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li ><a  href="?act=qlxuatchieu">Quản lý xuất chiếu</a></li>
                <li><a class="level1" href="?act=qllichchieu">Quản lý lịch chiếu</a></li>
              </ul>
            </li>

            <li role="presentation" class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                RẠP CHIẾU <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li ><a href="?act=qlrapchieu">Quản lý rạp chiếu</a></li>
                <li ><a class="level1" href="?act=qlghe">Quản lý ghế</a></li>
              </ul>
            </li>

           <li role="presentation"><a href="?act=qlve">VÉ</a></li>

            <li role="presentation" class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                TÀI KHOẢN <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
               <li ><a href="?act=qlkhachhang">Quản lý khách hàng</a></li>
               <li ><a class="level1" href="?act=qluser">Quản lý nhân viên</a></li>
             </ul>
           </li>

           <li role="presentation" class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
              THỐNG KÊ <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li ><a href="?act=thongkedoanhthu">Thống kê doanh thu</a></li>
              <li ><a class="level1" href="?act=thongkephim">Thống kê phim</a></li>
            </ul>
          </li>
        </ul>
          </div>




        <!-- Search -->


      </div>
      <div style="display: none;">
        <div id="main-popup">
        </div>
      </div>

    </div>

  </header>