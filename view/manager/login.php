<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Đăng nhập hệ thống Kiosk</title>
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
        <div class="logo_login text-center" style="max-width: 100px; display: block; margin:0 auto; margin-bottom: 15px;">
        <img src="<?php echo $urlHomes . 'app/Plugin/kiosk/view/manager/'; ?>images/logo.png" class="img-responsive" alt="">
          
        </div>
        <div id="logo-container">Đăng nhập</div>
        <?php
          if(!empty($mess)){
            echo '<p style="color: red;text-align: center;">'.$mess.'</p>';
          }
        ?>
        <div class="col-sm-12 col-md-10 col-md-offset-1">
          <form action="" id="loginForm" method="POST">
            <div class="form-group input-group">
              <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
              <input class="form-control" type="text" name='code' placeholder="Mã nhân viên" maxlength="50" required="" />          
            </div>
            <div class="form-group input-group">
              <span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
              <input class="form-control" type="password" name='pass' placeholder="Mật khẩu" required="" />     
            </div>
            <div class="form-group">
              <input type="checkbox" id="luumk" name="" style="min-width: auto;"> <label for="luumk">Ghi nhớ mật khẩu?</label>
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-def btn-block">Đăng nhập</button>
            </div>
            <div class="form-group text-center">
              <a href="/forgetPassStaff">Quên mật khẩu ?</a>
            </div>
          </form>        
        </div>  
      </div>    
    </div>
  </div>

</body>
</html>