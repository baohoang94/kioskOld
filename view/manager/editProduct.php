<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<style media="screen">
  .hid {
    display: none;
  }
  .show {
    cursor: pointer;
  }
</style>
<script>
  $(document).ready(function(){
      $(".show").click(function(){
          $(".hid").toggle();
          $(".show .fa").toggleClass("fa-times-circle-o");
          $(".show .fa").toggleClass("fa-ellipsis-h");
      });
  });
</script>
<div class="container-fluid main-container">
 <div class="col-md-12 content">
   <div class="panel panel-default">
     <div class="panel-heading">
       <ul class="list-inline">
         <!-- <li class="back_page"><a href="/listCoupon"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></li> -->
         <li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
         <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
         <li class="page_now">Quản lý giá bán sản phẩm</li>
       </ul>
     </div>
     <!-- <div class="main_list_p "> -->
       <div class="main_add_p">
           <div class="col-md-6">
 						<div class="table-responsive table1">
               <table class="table table-bordered">
                 <thead>
                   <tr>
											<th class="text_table"></th>
                     <th class="text_table">Kênh bán hàng</th>
                     <th class="text_table">Giá bán</th>
											 <th class="text_table">Hành động</th>
                   </tr>
                 </thead>
                 <tbody>
                        <tr>
                        <td class="text_table"><input type='checkbox' checked></td>
                        <td class="text_table">Khu công nghiệp</td>
                        <td class="text_table">
                          Giá chung <input type='text' value='10000'> <br>
                          Giá bán 1 <input type='text' value='9000'> <br>
                          Giá bán 2 <input type='text' value='11000'>
                        </td>
                        <td class="text_table">x <br> <span class="show"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></span></td>
                        </tr>
                        <tr>
                        <td class="text_table"><input type='checkbox' checked></td>
                        <td class="text_table">Tòa nhà</td>
                        <td class="text_table">
                          Giá chung <input type='text' value='10000'>
                        </td>
                        <td class="text_table">x</td>
                        </tr>
                        <tr>
                        <td class="text_table"><input type='checkbox' checked></td>
                        <td class="text_table">Trường học</td>
                        <td class="text_table">
                          Giá chung <input type='text' value='10000'>
                        </td>
                        <td class="text_table">x</td>
                        </tr>
                        <tr>
                        <td class="text_table"><input type='checkbox' checked></td>
                        <td class="text_table">Bệnh viện</td>
                        <td class="text_table">
                          Giá chung <input type='text' value='10000'>
                        </td>
                        <td class="text_table">x</td>
                        </tr>
                        <tr>
                          <td colspan="4"><input class="btn btn-primary" type='submit' value='Lưu'> <input class="btn btn-primary" type='submit' value='Phê duyệt'></td>
                        </tr>
                 </tbody>
               </table>
             </div>
           </div>
           <!-- ... -->
           <div class="col-md-6 hid">
 						<div class="table-responsive table1">
               <table class="table table-bordered">
                 <thead>
                   <tr>
											 <th class="text_table">CHọn vùng</th>
                       <th class="text_table">Chọn tỉnh/TP</th>
                       <th class="text_table">Chọn quận huyện</th>
											 <th class="text_table">Chọn NCC điểm đặt</th>
											 <th class="text_table">Chọn điểm đặt</th>
											 <th class="text_table">Chọn máy</th>
                   </tr>
                 </thead>
                 <tbody>
                        <tr>
                        <td class="text_table">Chọn all</td>
                        <td class="text_table">Chọn all</td>
                        <td class="text_table">Chọn all</td>
                        <td class="text_table">Chọn all</td>
                        <td class="text_table">Chọn all</td>
                        <td class="text_table">Chọn all</td>
                        </tr>
                        <tr>
                        <td class="text_table">Miền Bắc</td>
                        <td class="text_table">Hà Nội</td>
                        <td class="text_table">Hai bà trưng</td>
                        <td class="text_table">Viettinbank</td>
                        <td class="text_table">18 Trần Duy Hưng</td>
                        <td class="text_table">Máy 002</td>
                        </tr>
                        <tr>
                          <td colspan="4" style="text-align:right">Hình thức thanh toán</td>
                          <td colspan="2">Chọn all</td>
                        </tr>
                        <tr>
                          <td colspan="4">
                            Từ ngày: <input class="form-control" type="datetime" placeholder="dd/mm/yyyy hh:mm:ss"> <br>
                            Đến ngày: <input class="form-control" type="datetime" placeholder="dd/mm/yyyy hh:mm:ss"> <br>
                            <input class="btn btn-primary" type='submit' value='Lưu'> <input class="btn btn-default" type='submit' value='Quay lại'>
                          </td>
                          <td colspan="2">
                            [x] Tiền mặt <br>
                            [x] Coupon <br>
                            [x] QRPay <br>
                            [x] Ví VTC
                          </td>
                        </tr>
                 </tbody>
               </table>
             </div>
           </div>
         </div>
       </div>
   </div>
</div>
<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>
