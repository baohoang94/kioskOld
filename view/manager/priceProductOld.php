<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<style media="screen">
  .hid {
    display: none;
  }
  td .fa {
    cursor: pointer;
  }
  input[type=checkbox] {
    min-width: unset;
  }
  .del {
    color: red;
  }
  .addprice {
    color: green;
  }
  .showit {
    float: right;
  }
</style>
<script>
  $(document).ready(function(){
      $(".showit").click(function(){
          $(".hid").toggle();
          $(".showit .fa").toggleClass("fa-times-circle-o");
          $(".showit .fa").toggleClass("fa-ellipsis-h");
      });
  });
  function addPrice(id){
        $('tr.'+id).after('<tr class="'+id+'1"><td class="text_table"><td class="text_table"></td></td>'+
        '<td class="text_table">Giá riêng <input type="text" value="9000"></td>'+
        '<td class="text_table"><input type="checkbox" checked=""<span class="del"><i class="fa fa-times" aria-hidden="true"></i></span>'+
        '<span class="addprice" id="truong-hoc" onclick="addPrice($(this).attr(\'id\'))"><i class="fa fa-plus-square" aria-hidden="true"></i></span>'+
        '<span class="showit"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></span></td></tr>');
        $(this).remove();
  }
</script>
<div class="container-fluid main-container">
   <div class="col-md-12">
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
           <?php
           global $modelOption;
           $listChannelProduct=$modelOption->getOption('listChannelProduct');
           if(!empty($listChannelProduct['Option']['value']['allData'])){
             // pr($listChannelProduct['Option']['value']['allData']);
             foreach($listChannelProduct['Option']['value']['allData'] as $components){
            ?>
            <tr class="<?php echo $components['slug']; ?>">
              <td class="text_table"><input type='checkbox' checked></td>
              <td class="text_table"><?php echo $components['name']; ?></td>
              <td class="text_table">Giá chung <input type='text' value='10000'></td>
              <td class="text_table">
                <input type='checkbox' checked>
                <span class="del"><i class="fa fa-times" aria-hidden="true"></i></span>
                <span class="addprice" id="<?php echo $components['slug']; ?>" onclick="addPrice($(this).attr('id'))"><i class="fa fa-plus-square" aria-hidden="true"></i></span>
                <span class="showit"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></span>
              </td>
            </tr>
          <?php
             }
           }
           ?>
              <tr>
                <td colspan="4"><input class="btn btn-primary" type='submit' value='Lưu'> <input class="btn btn-primary" type='submit' value='Phê duyệt'></td>
              </tr>
         </tbody>
       </table>
     </div>
   </div>
   <!-- ... -->
   <div class="col-md-12 hid">
			<div class="table-responsive table1">
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