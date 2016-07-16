<?php include VIEW_DIR . 'include/head.php';?>
<style type="text/css">
 .text {
  margin-top: 5px;
 }
</style>
<!--=== Header section Starts ===-->
<?php include VIEW_DIR . 'include/header.php';?>
<div class="header-space">
</div>

<!--=== List section Starts ===-->
<div id="section-checkout" class="feature-wrap">
  <div class="container checkout">
    <div class="col-sm-12">
      <div class="section-title center">
          <h3>Đơn hàng</h3>
      </div>

      <div class="row">
        <div class="col-sm-4">
          <h4>Tổng tiền thanh toán: <?php echo $arrCustomer['payment'] . 'k';?></h4>
          <span>Rạp: <?php echo $Cinema['name'];?> </span>
          -
          <span><?php echo $Movie['performance_time']?></span>
          <span><?php echo $Movie['date']?></span>
          <p> Ghế:
          <?php foreach ($arrTicketSelected as $sid => $seat) {
            echo ' '.chr($seat['row'] + 64).$seat['column'] . ' ' . $arrTicketPrice[$sid] . 'k';
          }?>
          </p>
        </div>
        <div class="col-sm-8">
            <form method="post" action="" class="form-horizontal" role="form" data-toggle="validator" name="form1" id="form1">
                <p style="color: red; margin: 0px">
                <?php 
                foreach ($arrError as $key => $value)
                    if (isset($arrError[$key])) echo($value.'<br/>');
                ?>
                </p>
                <div class="form-group">
                  <label for="cardno" class="col-sm-3 control-label">Số thẻ</label>
                  <div class="col-sm-5">
                    <input id="cardno" class="form-control input-field form-item field-cardno" type="text" name="payment[cardno]" placeholder="Số thẻ" value="<?php echo $arrForm['cardno'];?>" required/>
                  </div>
                </div>

                <div class="form-group">
                  <label for="cardname" class="col-sm-3 control-label">Họ tên chủ thẻ</label>
                  <div class="col-sm-5">
                    <input id="cardname" class="form-control input-field form-item field-cardname" type="text" required name="payment[cardname]" placeholder="Họ tên chủ thẻ" value="<?php echo $arrForm['cardname'];?>"/>
                  </div>
                </div>

                <div class="form-group">
                  <label for="expiredate" class="col-sm-3 control-label">Ngày hết hạn</label>
                  <div class="col-sm-5">
                  <input id="expiredate" class="form-control input-field form-item field-expiredate" type="text" required placeholder="MM/YYYY" name="payment[expiredate]" value="<?php echo $arrForm['expiredate'];?>"/>
                  </div>
                </div>

                <div class="form-group">
                  <label for="cvv" class="col-sm-3 control-label">CVV/CVV2</label>
                  <div class="col-sm-5">
                  <input id="cvv" class="form-control input-field form-item field-cvv" type="text" required name="payment[cvv]" placeholder="CVV" value="<?php echo $arrForm['cvv'];?>"/>
                  <small>Là những chữ số sau cùng của số thẻ</small>
                  </div>
                </div>
                <div class="form-group">
                  <label for="cardtype" class="col-sm-3 control-label">Loại thẻ</label>
                  <div class="col-sm-5">
                  <label class="radio-inline control-label"> <input type="radio" name="payment[cardtype]" id="visa" value="Visa" <?php echo $arrForm['cardtype'] == 'Visa' ? 'checked' : '' ?>> Visa </label>

                  <label class="radio-inline control-label"> <input type="radio" name="payment[cardtype]" id="master" value="MasterCard" <?php echo $arrForm['cardtype'] == 'MasterCard' ? 'checked' : '' ?> > Master Card </label>
                </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label">Tổng tiền</label>
                  <div class="col-sm-5">
                  <p class="text"><?php echo $arrCustomer['payment'] . '.000 VND';?></p>
                  </div>
                </div>

              <div class="center paid">
                <button type="submit" id="paid" class="fancy-button button-line button-white large zoom">
                    Thanh toán
                    <span class="icon">
                        <i class="fa fa-paper-plane-o"></i>
                    </span>
                </button>
              </div>
            </form>
          </div>
        </div>
    </div>
  </div>    
</div>
  <!--=== List section Ends ===-->

  <?php include VIEW_DIR . 'include/footer.php';?>
  <script type="text/javascript">
  $( function() {
      $('#header').click(function() {
        window.location.href = "/#header";
      });
    // $( "#expiredate" ).datepicker({
    //     changeMonth: true,
    //     changeYear: true,
    //     // showButtonPanel: true,
    //     dateFormat: 'mm/yy',
    //     onClose: function(dateText, inst) { 
    //         $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
    //     }
    //   }
    //   );
  });
  </script>
</body>
</html>