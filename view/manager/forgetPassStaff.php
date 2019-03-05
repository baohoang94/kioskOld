<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Quên mật khẩu</title>
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/kiosk/view/manager'; ?>/css/bootstrap-theme.min.css">
 <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/kiosk/view/manager'; ?>/css/bootstrap.min.css">
 <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" media="all">
 <link href="<?php echo $urlHomes . 'app/Plugin/kiosk/view/manager'; ?>/css/style_l.css" rel="stylesheet" media="all">
 <link href="<?php echo $urlHomes . 'app/Plugin/kiosk/view/manager'; ?>/css/style.css" rel="stylesheet" media="all">
 <link href="<?php echo $urlHomes . 'app/Plugin/kiosk/view/manager'; ?>/css/slide.css" rel="stylesheet" media="all">
 <link href="https://fonts.googleapis.com/css?family=Comfortaa:300,400,700" rel="stylesheet">
 <script src="<?php echo $urlHomes . 'app/Plugin/kiosk/view/manager'; ?>/js/jquery-2.2.4.js"></script>
 <script src="<?php echo $urlHomes . 'app/Plugin/kiosk/view/manager'; ?>/js/bootstrap.min.js"></script>

</head>
<body class="manufaturerLogin">
	<style type="text/css">


  </style>

  <div class="container">
    <div class="row">
      <div class="Absolute-Center is-Responsive">
        <div id="logo-container">Quên mật khẩu</div>
        <div class="col-sm-12 col-md-10 col-md-offset-1">
          <?php if(isset($_GET['mess'])){
          switch ($_GET['mess']) {
             case '-1':
               $mess='Tài khoản không tồn tại trong hệ thống';
               break;
             case '1':
               $mess='Tài khoản đã bị khóa. Vui lòng liên hệ với quản trị viên';
               break;
             default:
               # code...
               break;
           } ?>
<span class="color_red"><?php echo $mess; ?></span>            
        
          <?php } ?>
          <form action="" id="loginForm1" method="POST">
            <div class="form-group input-group">
              <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
              <input class="form-control" type="text" name='code' placeholder="Mã nhân viên" maxlength="50" required="" />          
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-def btn-block">Gửi yêu cầu</button>
            </div>
            <div class="form-group text-center">
              <a href="/login">Quay lại đăng nhập</a>
            </div>
            
          </form>        
        </div>  
      </div>    
    </div>
  </div>

</body>
</html>