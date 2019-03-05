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

  input[type=text] {
    margin: 5px 0;
  }
  .del {
    color: red;
  }
 
  .row {
    border-bottom: 1px solid #000;
    padding: 1%;
  }
</style>
<script>
  function multiArea(value){
    if (value.length > 1) {
        $('#listWards').attr('disabled', 'disabled');
        $('#listWards').hide();
        $('#listDistrict').attr('disabled', 'disabled');
        $('#listDistrict').hide();
        $('#idCity').attr('disabled', 'disabled');
        $('#idCity').hide();
      } else {
          $('#listWards').removeAttr('disabled');
          $('#listWards').show();
          $('#listDistrict').removeAttr('disabled');
          $('#listDistrict').show();
          $('#idCity').removeAttr('disabled');
          $('#idCity').show();
      }
  }

</script>
<div class="container-fluid main-container">
  <?php if (!empty($mess)) {
    echo $mess;
  } ?>
   <div class="col-xs-12">
			<div class="row">
       <div class="col-xs-4">Tên sản phẩm</div>
       <div class="col-xs-4">Giá bán</div>
       <div class="col-xs-4">Hành động</div>
     </div>
       
        <div class="row">
          <div class="col-xs-4"><?php echo @$product['Product']['name'] ?></div>
          <div class="col-xs-4">Giá chung <input class="input_money" disabled value='<?php echo @$product['Product']['priceOutput'] ?>'></div>
          <div class="col-xs-4">
            <a href="infoProduct?id=<?php echo @$product['Product']['id'] ?>" title="Xem"><i class="fa fa-eye" aria-hidden="true"></i></a>
            <!-- <span class="addprice" title="Thêm một giá bán khác" onclick="addPrice($(this).attr('id'))"><i class="fa fa-plus-square" aria-hidden="true"></i></span> -->
          </div>
        </div>
        <?php
         if(!empty($sellProduct)){
           foreach($sellProduct as $sellProducts){
        ?>
        <div class="row">
          <div class="col-xs-4 col-xs-offset-4">
            Giá riêng <input class="input_money" disabled value="<?php echo @$sellProducts['SellProduct']['priceSale'] ?>">
          </div>
          <div class="col-xs-4">
            <input onchange="updateStatus($(this).attr('data-id'))" type="checkbox" title="Kích hoạt" data-id="<?php echo @$sellProducts['SellProduct']['id'] ?>" <?php if($sellProducts['SellProduct']['lock']==0) echo 'checked disabled'; ?>>
            <a href="deletePrice?id=<?php echo $sellProducts['SellProduct']['id'] ?>&idProduct=<?php echo @$_GET['id'] ?>" title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa giá bán này ko?')">
              <span class="del"><i class="fa fa-times" aria-hidden="true"></i></span>
            </a>
            &nbsp;
            <span onclick="$(this).parent().next().next().slideToggle()" style="cursor: pointer" title="Điều kiện áp dụng"><i class="fa fa-eye" aria-hidden="true"></i></span>
            &nbsp;
            <a
            <?php 
            if($sellProducts['SellProduct']['lock']==0) echo 'style="display: none"';
            ?>
              data-id="<?php echo @$sellProducts['SellProduct']['id'] ?>"
              class="btn btn-success"
              href="<?php if(in_array('1', $sellProducts['SellProduct']['typedateEndPay'])) echo '/synchMachine?id='.$sellProducts['SellProduct']['id'].'&idProduct='.@$_GET['id']; ?>"
              onclick="updateStatus($(this).attr('data-id'));">
              Phê duyệt
            </a>
          </div>
          <div class="clearfix"></div>
          <div class="table-responsive table1" style="display: none">
             <table class="table table-bordered">
              <caption>Các điều kiện áp dụng cho giá bán riêng</caption>
               <tbody>
                      <tr>
                      <td>
                        <select disabled="" multiple="" placeholder="Vùng" class="form-control">
                          <option value="">Vùng</option>
                          <?php
                          global $listArea;
                          foreach($listArea as $area){
                            if(in_array($area['id'], $sellProducts['SellProduct']['area'])){
                              echo '<option selected value="'.$area['id'].'">'.$area['name'].'</option>';
                            }else{
                              echo '<option value="'.$area['id'].'">'.$area['name'].'</option>';
                            }
                          }
                          ?>
                        </select>
                      </td>
                      <td>
                        <select disabled="" multiple="" class="form-control" placeholder="Tỉnh/Thành phố">
                          <option value="">Tỉnh/Thành phố</option>
                          <?php
                          global $modelOption;
                          $listCityKiosk=$modelOption->getOption('cityKiosk');
                          if (!empty($listCityKiosk['Option']['value']['allData'])) {
                            foreach ($listCityKiosk['Option']['value']['allData'] as $city) {
                              if (!in_array($city['id'], $sellProducts['SellProduct']['idCity'])) {
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
                        
                        <select  disabled="" multiple="" class="form-control" placeholder="Huyện/Quận">
                          <option value="">Quận/Huyện</option>
                          <?php 
                          if (!empty($sellProducts['SellProduct']['idCity']) && count($sellProducts['SellProduct']['idCity'] == 1)) {
                            $id_city = ($sellProducts['SellProduct']['idCity']);
                            global $modelOption;
                            $listCityKiosk=$modelOption->getOption('cityKiosk');
                            foreach ($listCityKiosk['Option']['value']['allData'][(int)$id_city] as $key => $value) {
                            }
                            $count = count($value);
                            for ($i=1; $i <= $count; $i++) {
                              if (!in_array($value[$i]['id'], $sellProducts['SellProduct']['idDistrict'])) {
                                echo '<option value="'.$value[$i]['id'].'">'.$value[$i]['name'].'</option>';
                              } else {
                                echo '<option selected value="'.$value[$i]['id'].'">'.$value[$i]['name'].'</option>';
                              }
                            }
                          }
                          ?>
                        </select>
                      </td>
                      <td>
                        <select disabled="" name="wards[]" class="form-control" placeholder="Chọn Xã/Phường" multiple="">
                          <option value="">Xã/Phường</option>
                        <?php
                          if (!empty($sellProducts['SellProduct']['idDistrict']) && count($sellProducts['SellProduct']['idDistrict'] == 1)) {
                            $id_distric = $sellProducts['SellProduct']['idDistrict'][0];
                            $modelWards = new Wards;
                            $ward=$modelWards->find('all', array('conditions'=>array('idDistrict'=>(int)$id_distric, 'idCity'=>(int)$id_city[0])));
                            $count=count($ward);
                            for($i=0;$i<$count;$i++){
                              if (!in_array($ward[$i]['Wards']['id'], $sellProducts['SellProduct']['wards'])) {
                                echo '<option value="'.$ward[$i]['Wards']['id'].'">'.$ward[$i]['Wards']['name'].'</option>';
                              } else {
                                echo '<option selected value="'.$ward[$i]['Wards']['id'].'">'.$ward[$i]['Wards']['name'].'</option>';
                              }
                            }
                          }
                        ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <select disabled="" class="form-control" multiple="">
                          <option disabled="" value="">Kênh bán hàng</option>
                          <?php
                          global $modelOption;
                          $listChannelProduct= $modelOption->getOption('listChannelProduct');
                          if(!empty($listChannelProduct)){
                            foreach ($listChannelProduct['Option']['value']['allData'] as $key => $value) {
                              ?>
                              <option value="<?php echo $value['id'];?>" <?php if(!empty($sellProducts['SellProduct']['idChannel'])&&in_array($value['id'], $sellProducts['SellProduct']['idChannel'])) echo'selected';?>><?php echo $value['name'];?></option>
                              <?php
                            }
                          }
                          ?>
                        </select>
                      </td>
                      <td colspan="2">
                        <select disabled="" class="form-control" placeholder="Chọn điểm đặt" multiple="">
                          <option disabled="" value="1">Điểm đặt</option>
                          <?php
                          if(!empty($listPlace)){
                            foreach ($listPlace as $key => $value) {

                              ?>
                              <option value="<?php echo $value['Place']['id'];?>" <?php if(!empty($sellProducts['SellProduct']['idPlace'])&&in_array($value['Place']['id'], $sellProducts['SellProduct']['idPlace'])) echo'selected';?>><?php echo $value['Place']['name'];?></option>
                              <?php
                            }
                          }

                          ?>
                        </select>
                      </td>
                      <td>
                        <select disabled="" class="form-control" multiple="">
                          <option value="" >Mã máy</option>
                          <?php
                            if(!empty($listMachine)){
                              foreach ($listMachine as $valueMachine) {
                                ?>
                                <option value="<?php echo $valueMachine['Machine']['code'];?>" <?php if(!empty($sellProducts['SellProduct']['codeMachine'])&&in_array($valueMachine['Machine']['code'], $sellProducts['SellProduct']['codeMachine'])) echo'selected';?>><?php echo $valueMachine['Machine']['code'];?></option>
                                <?php
                              }
                            }
                           ?>
                        </select>
                      </td>
                    </tr>
                      <tr>
                        <td colspan="3" style="text-align:right">Hình thức thanh toán</td>
                        <td colspan="1">Chọn all</td>
                      </tr>
                      <tr>
                        <td colspan="3">
                          Từ ngày : &nbsp <input disabled="" value="<?php if(!empty($sellProducts['SellProduct']['dateStart'])) echo date("d-m-Y H:i:s", $sellProducts['SellProduct']['dateStart']); ?>" type="text" placeholder="dd/mm/yyyy hh:mm:ss"> <br>
                          Đến ngày: <input disabled="" value="<?php if(!empty($sellProducts['SellProduct']['dateEnd'])) echo date("d-m-Y H:i:s", $sellProducts['SellProduct']['dateEnd']); ?>" type="text" placeholder="dd/mm/yyyy hh:mm:ss">
                        </td>
                        <td colspan="1">
                          <input name='typedateEndPay[]' value='1' <?php if(!empty($sellProducts['SellProduct']['typedateEndPay'])&&in_array('1', $sellProducts['SellProduct']['typedateEndPay'])) echo'checked';?> disabled="" type='checkbox'> Tiền mặt <br>
                          <input name='typedateEndPay[]' value='2' <?php if(!empty($sellProducts['SellProduct']['typedateEndPay'])&&in_array('2', $sellProducts['SellProduct']['typedateEndPay'])) echo'checked';?> disabled="" type='checkbox'> Ví VTC <br>
                          <input name='typedateEndPay[]' value='3' <?php if(!empty($sellProducts['SellProduct']['typedateEndPay'])&&in_array('3', $sellProducts['SellProduct']['typedateEndPay'])) echo'checked';?> disabled="" type='checkbox'> Coupon <br>
                          <input name='typedateEndPay[]' value='4' <?php if(!empty($sellProducts['SellProduct']['typedateEndPay'])&&in_array('4', $sellProducts['SellProduct']['typedateEndPay'])) echo'checked';?> disabled="" type='checkbox'> QRPay
                        </td>
                      </tr>
               </tbody>
             </table>
           </div>
        </div> <!-- /row -->
        <?php
           }
         }
        ?>
        <form  method="post">
        <div class="row">
          <div class="col-xs-4 col-xs-offset-4">Thêm giá <input class="input_money" name="price" type="text" value="" required=""></div>
          <div class="col-xs-4">
            <!-- <input name="lock" value="0" type="checkbox" checked="" title="Kích hoạt"> -->
            <span class="del" onclick="$(this).parent().parent().hide();$(this).parent().parent().next().hide()" title="Tôi không muốn nhìn thấy nó"><i class="fa fa-times" aria-hidden="true"></i></span>
            &nbsp;
            <span title="Cài đặt điều kiện" class="hienthi" onclick="$('#setting').slideToggle()"><i class="fa fa-plus-square" aria-hidden="true"></i></span>
          </div>
        </div>
        <div class="row" id="setting" style="display: none">
          <div class="col-md-12">
            <div id="data" class="table-responsive table1">
             <table class="table table-bordered">
              <caption>Cài đặt điều kiện cho giá bán riêng</caption>
               <tbody>
                      <tr>
                      <td>
                        <select name="area[]" multiple="" placeholder="Vùng" class="form-control" onchange="multiArea($(this).val())" title="Nhấn giữ phím Ctrl và click chuột trái để chọn nhiều giá trị">
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
                        <select name="idCity[]" id="idCity" multiple="" class="form-control" placeholder="Tỉnh/Thành phố" onchange="getDistrict($(this).val(), 0)" title="Nhấn giữ phím Ctrl và click chuột trái để chọn nhiều giá trị">
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
                        <select  name="idDistrict[]" multiple="" class="form-control" placeholder="Huyện/Quận" id="listDistrict" onchange="getWards($('#idCity').val(),$(this).val(), 0)" title="Nhấn giữ phím Ctrl và click chuột trái để chọn nhiều giá trị">
                          <option value="">Chọn Quận/Huyện</option>
                        </select>
                      </td>
                      <td>
                        <select name="wards[]" class="form-control" placeholder="Chọn Xã/Phường" id="listWards" multiple="" title="Nhấn giữ phím Ctrl và click chuột trái để chọn nhiều giá trị">
                          <option value="">Chọn Xã/Phường</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <select name="idChannel[]" class="form-control" required="" multiple="" title="Nhấn giữ phím Ctrl và click chuột trái để chọn nhiều giá trị">
                          <option disabled="" value="">Chọn kênh bán hàng</option>
                          <?php
                          global $modelOption;
                          $listChannelProduct= $modelOption->getOption('listChannelProduct');
                          if(!empty($listChannelProduct)){
                            foreach ($listChannelProduct['Option']['value']['allData'] as $key => $value) {
                              # code...
                              ?>
                              <option value="<?php echo $value['id'];?>" <?php if(!empty($_GET['idChannel'])&&$_GET['idChannel']==$value['id']) echo'selected';?>><?php echo $value['name'];?></option>
                              <?php
                            }
                          }
                          ?>
                        </select>
                      </td>
                      <td colspan="2">
                        <select name="idPlace[]" class="form-control" placeholder="Chọn điểm đặt" id="idPlace" multiple="" title="Nhấn giữ phím Ctrl và click chuột trái để chọn nhiều giá trị">
                          <option disabled="" value="1">Chọn điểm đặt</option>
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
                        <select class="form-control" name="codeMachine[]" id="codeMachine" multiple="" title="Nhấn giữ phím Ctrl và click chuột trái để chọn nhiều giá trị">
                          <option disabled="" value="" >Mã máy</option>
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
                        <td colspan="3" style="text-align:right">Hình thức thanh toán</td>
                        <td colspan="1">Chọn all</td>
                      </tr>
                      <tr>
                        <td colspan="3">
                          Từ ngày: <input name="dateStart" class="datetimepicker form-control" type="text" placeholder="dd/mm/yyyy hh:mm:ss"> <br>
                          Đến ngày: <input name="dateEnd" class="datetimepicker form-control" type="text" placeholder="dd/mm/yyyy hh:mm:ss"> <br>
                          <input class="btn btn-primary" name="submit" type='submit' value='Lưu'>
                          <input class="btn btn-success" name="submit" type='submit' value='Phê duyệt'>
                        </td>
                        <td colspan="1">
                          <input name='typedateEndPay[]' value='1' type='checkbox' checked> Tiền mặt <br>
                          <input name='typedateEndPay[]' value='2' type='checkbox' checked> Ví VTC <br>
                          <input name='typedateEndPay[]' value='3' type='checkbox' checked> Coupon <br>
                          <input name='typedateEndPay[]' value='4' type='checkbox' checked> QRPay
                        </td>
                      </tr>
               </tbody>
             </table>
           </div>
        </div>
      </div>
    </form>
   </div>
      
      <!-- <div class="row">
        <div class="col-xs-12"><input class="btn btn-primary" type='submit' value='Lưu'> <input class="btn btn-primary" type='submit' value='Phê duyệt'></div>
      </div> -->
  </div>
   <!-- ... -->
      
   
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
      if (city.length > 1) {
        $('#listWards').attr('disabled', 'disabled');
        $('#listWards').hide();
        $('#listDistrict').attr('disabled', 'disabled');
        $('#listDistrict').hide();
      } else {
        listDistrict
        $('#listWards').removeAttr('disabled');
        $('#listWards').show();
        $('#listDistrict').removeAttr('disabled');
        $('#listDistrict').show();
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
        if(district.length > 1){
          $('#listWards').attr('disabled', 'disabled');
          $('#listWards').hide();
        } else {
          $('#listWards').removeAttr('disabled');
          $('#listWards').show();
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
<script>
  function updateStatus(id) {
    $.get("updateStatusPrice?idPrice="+id, function(data){
    alert(data);
    // location.reload();
    });
  }
</script>
<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>
<!--
  id: id bản ghi
  name: tên bane ghi
  dateStart: ngày bắt đầu
  dateEnd: ngày kết thúc
  value: giá trị giảm (%)
  maxValue: mức giảm tối đa (vnđ)
  lock: lưu hoặc phê duyệt
-->