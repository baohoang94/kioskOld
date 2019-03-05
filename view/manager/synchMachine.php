<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<style type="text/css">
@-webkit-keyframes {
  from {
    -webkit-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  to {
    -webkit-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes rotating {
  from {
    -ms-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -webkit-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  to {
    -ms-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -webkit-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
.rotating {
  -webkit-animation: rotating 1.5s linear infinite;
  -moz-animation: rotating 1.5s linear infinite;
  -ms-animation: rotating 1.5s linear infinite;
  -o-animation: rotating 1.5s linear infinite;
  animation: rotating 1.5s linear infinite;
}
.preloading {
    overflow: hidden;
}
.preload-container {
    width: 100%;
    height: 100%;
    background: #226a94;
    position: fixed;
    top: 0;
    bottom: 0;
    right: 0;
    left: 0;
    z-index: 99999999999;
    display: block;
    padding-right: 17px;
    overflow-x: hidden;
    overflow-y: auto;
    color: #fff;
}
.preload-icon {
    font-size: 66px;
    color: orange;
    margin-top: 20%;
}
</style>
<div id="preload" class="preload-container text-center">
  <h1>Hệ thống đang tiến hành đồng bộ...</h1>
  <span class="glyphicon glyphicon-repeat preload-icon rotating"></span>
  <h3>Xin vui lòng chờ đợi trong giây lát...</h3>
</div>
<script type="text/javascript">
    $(window).load(function() {
        $('.container-fluid').removeClass('preloading');
        $('#preload').delay(1000).fadeOut('fast');
    });
</script>
<div class="container-fluid main-container preloading">
  <div class="row">
    <div class="col-md-12 content text-center">
      <?php 
      if (!empty($mess)) {
        foreach ($mess as $key => $value) {
          echo $value;
        }
      }
       ?>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 content text-center">
      <a class="btn btn-success" href="<?php echo '/priceProduct?id='.@$_GET['idProduct']; ?>">Quay lại</a>
    </div>
  </div>
</div>
<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>
