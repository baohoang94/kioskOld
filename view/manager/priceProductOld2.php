<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<style media="screen">
  .hid {
    display: none;
  }
  .row .fa {
    cursor: pointer;
  }
  input[type=checkbox] {
    min-width: unset;
    margin-right: 10px;
  }
  .addprice {
    float: right;
  }
  input[type=text] {
    margin: 5px 0;
  }
  .del {
    color: red;
    margin-right: 10px;
  }
  .addprice {
    color: green;
  }
  .row {
    border-bottom: 1px solid #000;
    padding: 1%;
  }
</style>
<script>
  $(document).ready(function(){
      // $(".del").click(function(){
      //   alert('msg');
        // console.log($(this).parent().next());
          // $(this).parent().next().toggle();
          // $(".showit .fa").toggleClass("fa-times-circle-o");
          // $(".showit .fa").toggleClass("fa-ellipsis-h");
      // });
  });
  function slideToggle() {
    // $(".hienthi").click(function(){
      // console.log($(this).parent().next());
      // console.log($(this).parent().next());
        // $(this).parent().next().toggle();
        // $(".showit .fa").toggleClass("fa-times-circle-o");
        // $(".showit .fa").toggleClass("fa-ellipsis-h");
    // });
  }
  function addPrice(id){
    var data = $('#data').html();
        $('.'+id).append('<div class="col-xs-4 col-xs-offset-4 '+id+'1">'+
        'Giá riêng <input name="price" type="text" value=""></div>'+
        '<div class="col-xs-4"><input type="checkbox" checked /><span class="del"><i class="fa fa-times" aria-hidden="true"></i></span><span title="Cài đặt điều kiện" class="hienthi" onclick="$(this).parent().next().fadeToggle()"><i class="fa fa-angle-down" aria-hidden="true"></i></span></div>'+
        '<div style="display:none" class="row"><div id="setting" class="col-xs-12">'+data+'</div></div>');
  }

</script>
<div class="container-fluid main-container">
   <div class="col-xs-12">
			<div class="row">
       <div class="col-xs-4">Kênh bán hàng</div>
       <div class="col-xs-4">Giá bán</div>
       <div class="col-xs-4">Hành động</div>
     </div>
       <?php
       global $modelOption;
       $listChannelProduct=$modelOption->getOption('listChannelProduct');
       if(!empty($listChannelProduct['Option']['value']['allData'])){
         // pr($listChannelProduct['Option']['value']['allData']);
         foreach($listChannelProduct['Option']['value']['allData'] as $components){
        ?>
        <div class="row <?php echo $components['slug']; ?>">
          <div class="col-xs-4"><input name="idChannel" type='checkbox' checked><?php echo $components['name']; ?></div>
          <div class="col-xs-4">Giá chung <input type='text' value='10000'></div>
          <div class="col-xs-4">
            <span class="del"><i class="fa fa-times" aria-hidden="true"></i></span>
            <span class="addprice" title="Thêm một giá bán khác" id="<?php echo $components['slug']; ?>" onclick="addPrice($(this).attr('id'))"><i class="fa fa-plus-square" aria-hidden="true"></i></span>
          </div>
        </div>
      <?php
         }
       }
       ?>
      <div class="row">
        <div class="col-xs-12"><input class="btn btn-primary" type='submit' value='Lưu'> <input class="btn btn-primary" type='submit' value='Phê duyệt'></div>
      </div>
   </div>
   <!-- ... -->
   <form  method="post" >   
   <div class="col-md-12 hidden">
			<div id="data" class="table-responsive table1">
       <table class="table table-bordered">
         <tbody>
                <tr>
                <td>
                  <select name="area" placeholder="Vùng" class="form-control">
                    <option value="">Chọn Vùng</option>
                    <?php
                    global $listArea;
                    foreach($listArea as $area){
                      if(empty($_GET['area']) || $_GET['area']!=$area['id']){
                        echo '<option value="'.$area['id'].'">'.$area['name'].'</option>';
                      }else{
                        echo '<option selected value="'.$area['id'].'">'.$area['name'].'</option>';
                      }
                    }
                    ?>

                  </select>
                </td>
                <td>
                  <select name="idCity" class="form-control" placeholder="Tỉnh/Thành phố" onchange="getDistrict(this.value, 0)">
                    <option value="">Chọn Tỉnh/Thành phố</option>
                    <?php
                    global $modelOption;
                    $listCityKiosk=$modelOption->getOption('cityKiosk');
                    if (!empty($listCityKiosk['Option']['value']['allData'])) {
                      foreach ($listCityKiosk['Option']['value']['allData'] as $city) {
                        if (!isset($_GET['idCity']) || $_GET['idCity'] != $city['id']) {
                          echo '<option value="' . $city['id'] . '">' . arrayMap($city['name']) . '</option>';
                        } else {
                          echo '<option value="' . arrayMap($city['id']) . '" selected>' . $city['name'] . '</option>';
                        }
                      }
                    }
                    ?>

                  </select>
                </td>
                <td>
                  <select  name="idDistrict" class="form-control" placeholder="Huyện/Quận" id="listDistrict" onchange="getWards(idCity.value,this.value, 0)">
                    <option value="">Chọn Quận/Huyện</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>
                  <select name="idPlace" class="form-control" placeholder="Chọn điểm đặt" id="idPlace">
                    <option value="1">Chọn điểm đặt</option>
                    <?php
                    if(!empty($listPlace)){
                      foreach ($listPlace as $key => $value) {

                        ?>
                        <option value="<?php echo $value['Place']['id'];?>" <?php if(!empty($_GET['idPlace'])&&$_GET['idPlace']==$value['Place']['id']) echo'selected';?>><?php echo $value['Place']['name'];?></option>
                        <?php
                      }
                    }

                    ?>
                  </select>
                </td>
                <td>
                  <select class="form-control" name="codeMachine" id="codeMachine">
                    <option value="" >Mã máy</option>
                    <?php
                      if(!empty($listMachine)){
                        foreach ($listMachine as $valueMachine) {
                          ?>
                          <option value="<?php echo $valueMachine['Machine']['code'];?>" <?php if(!empty($_GET['codeMachine'])&&$_GET['codeMachine']==$valueMachine['Machine']['code']) echo'selected';?>><?php echo $valueMachine['Machine']['code'];?></option>
                          <?php
                        }
                      }
                     ?>
                  </select>
                </td>
              </tr>
                <tr>
                  <td colspan="2" style="text-align:right">Hình thức thanh toán</td>
                  <td colspan="1">Chọn all</td>
                </tr>
                <tr>
                  <td colspan="2">
                    Từ ngày: <input class="form-control" type="datetime" placeholder="dd/mm/yyyy hh:mm:ss"> <br>
                    Đến ngày: <input class="form-control" type="datetime" placeholder="dd/mm/yyyy hh:mm:ss"> <br>
                    <input class="btn btn-primary" name="submit" type='submit' value='Lưu'> <input class="btn btn-default" type='submit' value='Quay lại'>
                  </td>
                  <td colspan="1">
                    <input type='checkbox' checked> Tiền mặt <br>
                    <input type='checkbox' checked> Coupon <br>
                    <input type='checkbox' checked> QRPay <br>
                    <input type='checkbox' checked> Ví VTC
                  </td>
                </tr>
         </tbody>
       </table>
     </div>
   </div>
</div>
</form>
<script type="text/javascript">
  var allCity = [];
  <?php
  if (!empty($listCityKiosk['Option']['value']['allData'])) {
    foreach ($listCityKiosk['Option']['value']['allData'] as $key => $value) {
      echo 'allCity["' . $value['id'] . '"]=[];';
      $dem = 0;
      if (isset($value['district']) && count($value['district']) > 0)
        foreach ($value['district'] as $key2 => $value2) {
          $dem++;
          echo 'allCity["' . $value['id'] . '"]["' . $dem . '"]=[];';
          echo 'allCity["' . $value['id'] . '"]["' . $dem . '"]["1"]=' . $value2['id'] . ';';
          echo 'allCity["' . $value['id'] . '"]["' . $dem . '"]["2"]="' . $value2['name'] . '";';
        }
      }
    }
    ?>
    function getDistrict(city, district)
    {
      var mangDistrict = allCity[city];
      var dem = 1;
      var chuoi = "<option value=''>Chọn Quận/Huyện</option>";
      $('#listDistrict').html(chuoi);

      chuoi = "<option value=''>Chọn Quận/Huyện</option>";

      while (typeof (mangDistrict[dem]) != 'undefined')
      {
        if (mangDistrict[dem][1] != district) {
          chuoi += "<option value='" + mangDistrict[dem][1] + "'>" + mangDistrict[dem][2] + "</option>";
        } else {
          chuoi += "<option value='" + mangDistrict[dem][1] + "' selected>" + mangDistrict[dem][2] + "</option>";
        }

        dem++;
      }

      $('#listDistrict').html(chuoi);
      chuoi = "<option value=''>Chọn Xã/Phường</option>";
      $('#listWards').html(chuoi);
    }

    <?php
    if (!empty($_GET['idCity'])) {
      if (!empty($_GET['idDistrict'])) {
        echo 'getDistrict(' . $_GET['idCity'] . ',' . $_GET['idDistrict'] . ')';
      } else {
        echo 'getDistrict(' . $_GET['idCity'] . ',0)';
      }
    }
    ?>
  </script>
  <script type="text/javascript">
    var allWards = [];
    <?php
    if (!empty($listCityKiosk['Option']['value']['allData'])) {
      foreach ($listCityKiosk['Option']['value']['allData'] as $key => $value) {
        echo 'allWards["' . $value['id'] . '"]=[];';
        $dem = 0;
        if (isset($value['district']) && count($value['district']) > 0)
          foreach ($value['district'] as $key2 => $value2) {
            $dem++;
            echo 'allWards["' . $value['id'] . '"]["' . $value2['id'] . '"]=[];';
            $modelWards= new Wards;
            $listWards=$modelWards->find('all',array('conditions'=>array('idCity'=> $value['id'], 'idDistrict'=>$value2['id'] )));
            if (!empty($listWards)) {
              $num=0;
              foreach ($listWards as $key => $value3) {

                $num++;
                echo 'allWards["'. $value3['Wards']['idCity'] . '"]["' . $value3['Wards']['idDistrict'] . '"]["' . $num . '"]=[];';
                echo 'allWards["'. $value3['Wards']['idCity'] . '"]["' . $value3['Wards']['idDistrict'] . '"]["' . $num . '"]["1"]="' . $value3['Wards']['id'] . '";';
                echo 'allWards["'. $value3['Wards']['idCity'] . '"]["' . $value3['Wards']['idDistrict'] . '"]["' . $num . '"]["2"]="' . $value3['Wards']['name'] . '";';

              }
            }
          }
        }
      }
      ?>
      function getWards(city,district, wards)
      {
        var mangWards = allWards[city][district];
        var dem = 1;
        var chuoi = "<option value=''>--- Chọn Xã/Phường ---</option>";
        $('#listWards').html(chuoi);

        chuoi = "<option value=''>--- Chọn Xã/Phường ---</option>";

        while (typeof (mangWards[dem]) != 'undefined')
        {
          if (mangWards[dem][1] != wards) {
            chuoi += "<option value='" + mangWards[dem][1] + "'>" + mangWards[dem][2] + "</option>";
          } else {
            chuoi += "<option value='" + mangWards[dem][1] + "' selected>" + mangWards[dem][2] + "</option>";
          }

          dem++;
        }

        $('#listWards').html(chuoi);

      }

      <?php
      if (!empty($_GET['idDistrict'])) {
        if (!empty($_GET['wards'])) {
          echo 'getWards('.$_GET['idCity'].',' . $_GET['idDistrict'] . ',"' . $_GET['wards'] . '")';
        } else {
          echo 'getWards('.$_GET['idCity'].',' . $_GET['idDistrict'] . ',0)';
        }
      }
      ?>
    </script>
<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>