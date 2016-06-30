<?php include VIEW_DIR . 'include/head.php';?>

<style type="text/css">

</style>
<!--=== Header section Starts ===-->
<?php include VIEW_DIR . 'include/header.php';?>
<div class="header-space">
</div>

<!--=== List section Starts ===-->
<div id="section-seat" class="feature-wrap">
  <div class="container seat">
    <div class="col-md-8">
      <div class="main">
        <div id="seat-layout">
          <div class="col-md-10 col-md-offset-1 center section-title">
            <h3 style="color: #F4F4F4"><?php echo $Cinema['name']?></h3>
          </div>
          <div class="col-sm-12">
          <table class="seat-map small" id="seat-map">
            <tbody>
            <?php for ($index=1; $index <=$column ; $index++) { ?>
              <?php if ($index == 1) { ?>
                <tr>
                <td class="index"></td>
              <?php } ?>
              <td class="aisle"></td>
            <?php }?>
              <td class="aisle"></td>
              </tr>

              <?php foreach ($arrSeat as $key => $Seat) {?>
                <?php if ($Seat['column'] == 1) { ?>
                  <tr>
                  <td class="index"><?php echo $lineChar = chr($Seat['row']+64);?>
                <?php } ?>
                  
                    <td class="seat <?php if ($Seat['type'] == VIP) echo "vip";?> <?php if ($arrTickets[$key]['status']) echo "unavailable";?>" id="seat-<?php echo $lineChar.sprintf('%02d', $Seat['column']);?>" data-tid='<?php echo $arrTickets[$key]["id"]; ?>' data-sid="<?php echo $key; ?>">
                    <?php echo sprintf('%02d', $Seat['column']);?>
                    </td>

                <?php if ($Seat['column'] == $column) { ?>
                  <?php if ($Seat['row'] == $row) {?>
                    <td class="entrance"></td>
                  <?php } else {?>
                    <td class="aisle"></td>
                  <?php } ?>
                    </tr>

                <?php } ?>
              <?php } ?>
            </tbody>
          </table>
          </div>

          </div>
        </div>
      </div>

      <div class="col-sm-4 payment">
            <div class="center section-title">
                <div><h4><?php echo $Movie['name']?></h4></div>
                <div class="right"><button class="btn btn-default disabled"><?php echo $arrPerformance[$Movie['performance_id']]?></button>
                <button class="btn btn-default disabled"><?php echo $Movie['date']?></button>
            </div>
            </div>
            <div class="confirmation">
                <p><span class="fa fa-check"></span></p>
            </div>

            <div class="">
              <h5>Thanh toán</h5>
            </div>
            <form method="post" action="" class="payment-form" role="form" data-toggle="validator" name="form1" id="form1">
              <div class="price">
                <div class="seat-number">Số ghế: 0 ghế</div>
                <div class="total-price">Thành tiền: 0 VND</div>
              </div>
              <div class="information">
                <p style="color: red; margin: 0px">
                <?php 
                foreach ($arrError as $key => $value)
                    if (isset($arrError[$key])) echo($value.'<br/>');
                ?>
                <p>
                <input id="name" class="input-field form-item field-name" type="text" name="customer[name]" placeholder="Name" value="<?php echo $arrForm['name'];?>" required/>

                <input id="email" class="input-field form-item field-email" type="email" required name="customer[email]" placeholder="Email" value="<?php echo $arrForm['email'];?>"/>

                <input id="tel" class="input-field form-item field-tel" type="tel" required name="customer[tel]" placeholder="Tel" value="<?php echo $arrForm['tel'];?>"/>
              </div>
              <div class="center paid">
                <button type="submit" id="paid" class="fancy-button button-line button-white large zoom">
                    Đặt vé
                    <span class="icon">
                        <i class="fa fa-paper-plane-o"></i>
                    </span>
                </button>
              </div>
            </form>

          </div>
    </div>
  </div>
  <!--=== List section Ends ===-->

  <?php include VIEW_DIR . 'include/footer.php';?>
  <script type="text/javascript">
    var _selected = [];
    var _seat = <?php echo json_encode($arrSeat); ?>,
        _ticketPrice = <?php echo json_encode($arrTicketPrice); ?>;
    var date = new Date(), 
        _nowTime = date.getTime(), 
        _nowDay = date.getDay(), 
        night = new Date(date.setHours(<?php echo NIGHT_TIME?>, 0, 0, 0));
    var isWeeken = (_nowDay == 0) || (_nowDay == 6), 
        isNight = (_nowTime >= night.getTime()),
        isHappyDay = (_nowDay == <?php echo HAPPYDAY?>);
    var _total = 0;
    $(function() {
      $('#header').click(function() {
        window.location.href = "/#header";
      });


      $('.seat').click(function(e) {
        if ($(this).hasClass('unavailable')) {
          return false;
        }
          var tid = $(this).data('tid');
          var sid = $(this).data('sid');
        if ($(this).hasClass('chosen')) {
          $(this).removeClass('chosen');
          if (tid != null && sid != null) {
            _selected = $.grep(_selected, function(value) {
              return value !== tid;
            });
            _total = showChosen(sid, 'SUB');

            showTotal(_selected.length, _total);
          }
        } else {
          $(this).addClass('chosen');
          if (tid != null && sid != null) {
            _selected.push(tid);
            _total = showChosen(sid, 'ADD');

            showTotal(_selected.length, _total);
          }
        }
        console.log(_selected);
      });


      $('#form1').submit(function(_e) {
        var form = $(this);
        if (_selected.length <= 0) {
          alert('Xin vui lòng chọn ghế!!!');
          return false;
        }

        $.each(_selected, function(key, _chosen) {
          var html = '<input type="hidden" name="seat[]" value="'+_chosen;
          html += '" />';
          form.append(html);
        });
        return true;
      });

      function showChosen(sid, _type = 'ADD') {
        if (_seat[sid] != null) {
          var _chosen = _seat[sid];
          var ticketPrice = calcPrice(_chosen.type);
          if (_type == 'ADD') {
            _total = parseInt(_total) + parseInt(ticketPrice);
          } else if (_total >= ticketPrice) {
            _total = parseInt(_total) - parseInt(ticketPrice);
          }
        }
        return _total;
      }

      function calcPrice(_type) {
        var price = _ticketPrice['NORMAL'] || 50;
        if (!isHappyDay) {
          if (_type == '<?php echo VIP?>') {
            price = _ticketPrice['VIP'] || 70;
          }

          if (isNight) {
            price = parseInt(price) + parseInt(5);
          }
          if (isWeeken) {
            price = parseInt(price) + parseInt(10);
          }
        }
        
        return price;
      }

      function showTotal(_count, _total) {
        var html = '<div class="seat-number">Số ghế: '+_count;
        html += ' ghế</div>';
        html += '<div class="total-price">Thành tiền: '+_total;
        html += 'K VND</div>';
        $('.price').html(html);
      }

    });
  </script>

</body>
</html>