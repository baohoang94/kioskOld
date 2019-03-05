<!--
// * Người tạo: Nguyễn Tiến Hưng.
// * Ngay tao:
// * Ghi chú:
// * Lịch sử sửa:
  -->
<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>

<div class="container-fluid main-container">

    <div class="panel panel-default">
      <div class="panel-heading">
        <ul class="list-inline">
          <li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
          <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
		  <li class="page_prev"><a href="/syncTransfer"></i> Đối soát dữ liệu</a></li>
          <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
          <li class="page_now">upload dữ liệu từ máy kiosk lên server</li>
        </ul>
      </div>
      <?php
      if(!empty($mess)) echo '<div class="col-sm-12" style="color:red">'.$mess.'</div><br>';
      if(!empty($mess1)) echo '<div class="col-sm-12" style="color:red">'.$mess1.'</div><br>';
      if(!empty($mess2)) echo '<br><div class="col-sm-12" style="color:red">'.$mess2.'</div>';
      if(!empty($mess3)) echo '<div class="col-sm-12" style="color:red">'.$mess3.'</div><br>';
      if(!empty($mess4)) echo '<br><div class="col-sm-12" style="color:red">'.$mess4.'</div>';
      if(!empty($mess5)) echo '<br><div class="col-sm-12" style="color:red">'.$mess5.'</div>';
        ?>

    <form method="POST" enctype="multipart/form-data">
      <table class="table table-bordered">

        <tr>
          <td>
            <div class="col-sm-12 content">
            <div class="add_p">
          <input type="file" name="file[]" id="files" multiple="" directory="" webkitdirectory="" mozdirectory=""> nhấn vào đây để chọn folder upload
            </div>
            </div>
          </td>
        </tr>
        <tr>
          <td>
            <div class="add_p">
              <input type="submit" name="submit" >Lưu các file trong folder vừa chọn lên server(không đọc)
            </div>
          </td>
        </tr>
        </table>
    </form>
</div>
  <div class="">
    <form class="" method="POST">
      <tr>
          <button class="add_p1" name="sync">Tiến hành đọc và lưu dữ liệu các file</button>
      </tr>
    </form>

  </div>
</div>
  <?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>
