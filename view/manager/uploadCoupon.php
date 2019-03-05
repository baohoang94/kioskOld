<!--
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
          <li class="page_now">upload file</li>
        </ul>
      </div>
    </div>

    <form method="POST" enctype="multipart/form-data">
      <table class="table table-bordered">

        <tr>
          <td>
            <div class="col-sm-12 content">
            <div class="add_p">
          <input type="file" name="file" height="20%" width="30%"> nhấn vào đây để chọn file upload(excel)
            </div>
            </div>
          </td>
        </tr>

        </table>
        <tr>
          <td>
            <div class="add_p">
              <input type="submit" name="submit">
            </div>
          </td>
        </tr>

    </form>

</div>

  <?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>
