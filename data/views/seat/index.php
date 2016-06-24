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
    <div class="col-md-12">
      <div class="main">
        <div id="seat-layout">
          <div class="col-md-10 col-md-offset-1 center section-title">
            <h3 style="color: #F4F4F4"><?php echo $Cinema['name']?></h3>
          </div>
          <table class="seat-map small" id="seat-map">
            <tbody>
              <tr>
                <td class="index"></td>
                <td class="aisle"></td>
                <td class="aisle"></td>
                <td class="aisle"></td>
                <td class="aisle"></td>
                <td class="aisle"></td>
                <td class="aisle"></td>
                <td class="aisle"></td>
                <td class="aisle"></td>
                <td class="aisle"></td>
                <td class="aisle"></td>
                <td class="aisle"></td>
              </tr>

              <?php foreach ($arrSeat as $key => $Seat) {?>
                <?php if ($Seat['column'] == 1) { ?>
                  <tr>
                  <td class="index"><?php echo $lineChar = chr($Seat['row']+64);?>
                <?php } ?>
                  
                    <td class="seat <?php if ($Seat['type'] == VIP) echo "vip";?> <?php if ($arrTickets[$key]['status']) echo "unavailable";?>" id="seat-<?php echo $lineChar.sprintf('%02d', $Seat['column']);?>" data-tid="<?php echo $arrTickets[$key]['id'] ?>" data-sid="<?php echo $key; ?>">
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
  </div>
  <!--=== List section Ends ===-->

  <?php include VIEW_DIR . 'include/footer.php';?>
  <script type="text/javascript">
  var _selected = [];
  var _seat = <?php echo json_encode($arrSeat); ?>;
  var _ticketPrice = <?php echo json_encode($arrTicketPrice); ?>;
  var _now = date.getTime();
    $(function() {
      console.log(_ticketPrice);
      $('#header').click(function() {
        window.location.href = "/#header";
      });

      $('.seat').click(function(e) {
          var tid = $(this).data('tid');
          var sid = $(this).data('sid');
        if ($(this).hasClass('chosen')) {
          $(this).removeClass('chosen');
          if (tid != null && sid != null) {
            console.log(_selected);
            _selected = $.grep(_selected, function(value) {
              return value !== tid;
            });
            console.log(_selected);
          }
        } else {
          $(this).addClass('chosen');
          if (tid != null && sid != null) {
            console.log(tid);
            _selected.push(tid);
            console.log(_selected);
            showChosen(sid);
          }
        }
      });

      function showChosen(sid)
      {
        if (_seat[sid] != null) {
          var _chosen = _seat[sid];
          if (_chosen.type == '<?php echo VIP?>') {
            
          }
          console.log(_seat[sid]);
        }
      }
    });
  </script>

</body>
</html>