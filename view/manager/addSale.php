 <?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
 <style>
	input {
	    min-width: unset;
	}
	.row {
	    margin-right: 0;
	    margin-left: 0;
	}
</style>
 <div class="container-fluid main-container">

 	<div class="col-md-12 content">

 		<div class="panel panel-default">
 			<div class="panel-heading">
 				<ul class="list-inline">
					<!-- <li class="back_page"><a href="/listCoupon"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></li> -->
 					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
 					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
 					<li class="page_prev"><a href="/listSale"> Danh sách khuyến mại</a></li>
 					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
 					<li class="page_now"><?php if(empty($data)){ echo'Thêm khuyến mại mới';}else{echo'Chỉnh sửa khuyến mại';}?></li>
 				</ul>
 			</div>
 			<!-- <div class="main_list_p "> -->
 				<div class="main_add_p">
 					<form action="" method="post">
 						<?php
 							if(!empty($mess)) echo '<div class="col-sm-12" style="color:red">'.$mess.'</div>';
 						?>
 							<div class="row">
 								<div class="col-sm-12">
								  <div class="row">
 									<div class="col-sm-4">
 										<div class="form_add">
 											<div class="form-group">
 												<label>Tên khuyến mại<span class="color_red">*</span>: </label>
 												<input type="text" title="" maxlength="50" id="" placeholder="Tên khuyến mại" class="form-control"  name="name" required="" value="<?php echo @arrayMap($data['Coupon']['name']);?>">
 											</div>
 										</div>
 									</div>

 									<div class="col-sm-4">
 										<div class="form_add">
 											<div class="form-group">
 												<label>Ngày bắt đầu<span class="color_red">*</span>: </label>
 												<input type="text" maxlength="50" value="<?php echo @$data['Coupon']['dateStart']['text'];?>" name="dateStart" id="" placeholder="Từ ngày" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" required>
 											</div>
 										</div>
 									</div>

 									<div class="col-sm-4">
 										<div class="form_add">
 											<div class="form-group">
 												<label>Ngày kết thúc<span class="color_red">*</span>: </label>
 												<input type="text" maxlength="50" name="dateEnd" id="" value="<?php echo @$data['Coupon']['dateEnd']['text'];?>" placeholder="Đến ngày" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" required="">
 											</div>
 										</div>
 									</div>
 								  </div>

								  <div class="row">
 									<div class="col-sm-4">
 										<div class="form_add">
 											<div class="form-group">
 												<label>Giá trị giảm (%)<span class="color_red">*</span>: </label>
 												<input type="number" min="0" max="99" title="" maxlength="2" id="" placeholder="Giá trị giảm" class="input_money form-control" name="value" required="" value="<?php echo @arrayMap($data['Coupon']['quantity']);?>">
 											</div>
 										</div>
 									</div>

 									<div class="col-sm-4">
 										<div class="form_add">
 											<div class="form-group">
 												<label>Mức giảm tối đa: </label>
 												<input type="text" title="" maxlength="19" id="" placeholder="Mức giảm tối đa" class="input_money form-control" name="maxValue" value="<?php echo @arrayMap($data['Coupon']['value']);?>">
 											</div>
 										</div>
 									</div>
 									<div class="col-sm-4">
 										<div class="form_add">
 											<div class="form-group">
 												<label>Trạng thái<span class="color_red">*</span>: </label>
 												<select name="lock" class="form-control">
 													<option value="0" <?php if(!empty($data['Coupon']['status'])&&$data['Coupon']['status']=='active') echo'selected';?>>Kích hoạt</option>
 													<option value="1" <?php if(!empty($data['Coupon']['status'])&&$data['Coupon']['status']=='lock') echo'selected';?>>Khóa</option>
 												</select>
 											</div>
 										</div>
 									</div>
 								  </div>
 								  <div class="row">
                                    <div class="col-sm-4">
 										<div class="form_add">
 											<div class="form-group">
 												<div onclick="$(this).next().slideToggle()">Chọn vùng <i class="fa fa-sort-desc" aria-hidden="true"></i> </div>
 												<div style="display: ">
 													<?php
							                          global $listArea;
							                          foreach($listArea as $area){
							                            if(empty($_GET['area']) || $_GET['area']!=$area['id']){
							                              echo '<input type="checkbox" name="area[]" value="'.$area['id'].'"/>'.$area['name'].'<br/>';
							                            }else{
							                              echo '<input type="checkbox" name="area[]" value="'.$area['id'].'"/>'.$area['name'].'<br/>';
							                            }
							                          }
							                        ?>
 												</div>
 											</div>
 										</div>
 									</div>
                                    <div class="col-sm-4">
 										<div class="form_add">
 											<div class="form-group">
 												<div onclick="$(this).next().slideToggle()">Chọn tỉnh/thành phố <i class="fa fa-sort-desc" aria-hidden="true"></i> </div>
 												<div style="display: ">
 													<?php
							                          global $modelOption;
							                          $listCityKiosk=$modelOption->getOption('cityKiosk');
							                          if (!empty($listCityKiosk['Option']['value']['allData'])) {
							                            foreach ($listCityKiosk['Option']['value']['allData'] as $city) {
							                              if (!isset($_GET['idCity']) || $_GET['idCity'] != $city['id']) {
							                                echo '<input type="checkbox" name="idCity[]" onchange="getDistrict($(this).val(), 0)" value="' . $city['id'] . '"/>' . arrayMap($city['name']) . '<br/>';
							                              } else {
							                                echo '<input type="checkbox" name="idCity[]" onchange="getDistrict($(this).val(), 0)" value="' . arrayMap($city['id']) . '" checked>' . $city['name'] . '<br/>';
							                              }
							                            }
							                          }
							                        ?>
 												</div>
 											</div>
 										</div>
 									</div>
 									<div class="col-sm-4">
 										<div class="form_add">
 											<div class="form-group">
 												<div onclick="$(this).next().slideToggle()">Chọn quận huyện <i class="fa fa-sort-desc" aria-hidden="true"></i> </div>
 												<div style="display: ">
 													<span id="listDistrict">
							                        </span>
 												</div>
 											</div>
 										</div>
 									</div>
 								  </div>
 									<div class="col-sm-4">
 										<div class="form_add">
 											<div class="form-group">
 												<div onclick="$(this).next().slideToggle()">Chọn Xã phường <i class="fa fa-sort-desc" aria-hidden="true"></i> </div>
 												<div style="display: ">
 													<span id="listWards">
							                        </span>
 												</div>
 											</div>
 										</div>
 									</div>
 									<div class="col-sm-4">
 										<div class="form_add">
 											<div class="form-group">
 												<div onclick="$(this).next().slideToggle()">Chọn kênh bán hàng <i class="fa fa-sort-desc" aria-hidden="true"></i> </div>
 												<div style="display: none">
 													<?php
							                          global $modelOption;
							                          $listChannelProduct= $modelOption->getOption('listChannelProduct');
							                          if(!empty($listChannelProduct)){
							                            foreach ($listChannelProduct['Option']['value']['allData'] as $key => $value) {
							                              # code...
							                              ?>
							                              <input type="checkbox" name="idChannel[]" <?php if(!empty($_GET['idChannel'])&&$_GET['idChannel']==$value['id']) echo'checked';?> value="<?php echo $value['id'];?>"> <?php echo $value['name'];?></br>
							                              <?php
							                            }
							                          }
							                        ?>
 												</div>
 											</div>
 										</div>
 									</div>
 									<div class="col-sm-4">
 										<div class="form_add">
 											<div class="form-group">
 												<div onclick="$(this).next().slideToggle()">Chọn hình thức thanh toán <i class="fa fa-sort-desc" aria-hidden="true"></i></div>
 												<div style="display: ">
 												  <input disabled="" name='typedateEndPay[]' value='1' type='checkbox'> Tiền mặt <br>
						                          <input name='typedateEndPay[]' value='2' type='checkbox'> Ví VTC <br>
						                          <input name='typedateEndPay[]' value='3' type='checkbox'> Coupon <br>
						                          <input name='typedateEndPay[]' value='4' type='checkbox'> QRPay
 												</div>
 											</div>
 										</div>
 									</div>
 								  </div>
 								  <!-- <div class="row"> -->
 								  	<div class="col-sm-6" style="padding-left: 30px">
 										<div class="form_add">
 											<div class="form-group">
 												<div onclick="$(this).next().slideToggle()">Chọn điểm đặt <i class="fa fa-sort-desc" aria-hidden="true"></i> </div>
 												<div style="display: none">
 													<?php
							                          if(!empty($listPlace)){
							                            foreach ($listPlace as $key => $value) {
							                              ?>
							                              <input type="checkbox" name="idPlace[]" <?php if(!empty($_GET['idPlace'])&&$_GET['idPlace']==$value['Place']['id']) echo'checked';?> value="<?php echo $value['Place']['id'];?>"/><?php echo $value['Place']['name'];?><br/>
							                              <?php
							                            }
							                          }
							                        ?>
 												</div>
 											</div>
 										</div>
 									</div>
 									<div class="col-sm-6">
 										<div class="form_add">
 											<div class="form-group">
 												<div style="cursor: pointer" onclick="$(this).next().slideToggle()">Chọn mã máy <i class="fa fa-sort-desc" aria-hidden="true"></i></div>
 												<div id="listMachine" style="display: none">
 													<?php
							                            if(!empty($listMachine)){
							                              foreach ($listMachine as $valueMachine) {
							                                ?>
							                                <input type="checkbox" name="codeMachine[]" <?php if(!empty($_GET['codeMachine'])&&$_GET['codeMachine']==$valueMachine['Machine']['code']) echo'checked';?> value="<?php echo $valueMachine['Machine']['code'];?>" /><?php echo $valueMachine['Machine']['code'].' ('.$valueMachine['Machine']['name'].')';?><br/>
							                                <?php
							                              }
							                            }
							                        ?>
 												</div>
 											</div>
 										</div>
 									</div>
 								  <!-- </div> -->
 								  <!-- <div class="row"> -->
 									<div class="col-sm-12">
 										<div class="form-group">
 											<label> Ghi chú: </label>
 											<textarea class="form-control" maxlength="3000" placeholder="Ghi chú" value="" rows="3" name="note"><?php echo @arrayMap($data['Coupon']['note']);?></textarea>
 										</div>
 									</div>
 									<div class="col-sm-12" style="<?php if(empty($data)) echo'display: none;';?>">
 										<div class="form-group">
 											<label> Lý do sửa<span class="color_red">*</span>: </label>
 											<textarea class="form-control" maxlength="3000" value="" rows="3" name="reason" <?php if(!empty($data))echo'required=""';?> placeholder="Lý do sửa"></textarea>

 										</div>
 									</div>
 									<div class="col-sm-12">
 										<div class="form-group">
 											<button class="btn_ad" style="display: inline-block !important;">Lưu</button>
 											<span class="btn_ad_back"><a href="/listSale">Quay lại</a></span>
 										</div>
 									</div>
 								  <!-- </div> -->
 								</div>
 							</div>

 						</form>
 					</div>

 				</div>

 				<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>
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
	    	var checkboxes = document.getElementsByName('idCity[]');
			var vals = [];
			for (var i=0, n=checkboxes.length;i<n;i++) 
			{
			    if (checkboxes[i].checked) 
			    {
			        vals.push(checkboxes[i].value);
			    }
			}

	      if (vals.length != 1) {
	      	chuoi = "";
	      	$('#listDistrict').html(chuoi);
			$('#listWards').html(chuoi);
	      } else if (vals.length === 1) {
	        var mangDistrict = allCity[vals[0]];
	        var dem = 1;
	        var chuoi = "";
	        $('#listDistrict').html(chuoi);

	        chuoi = "";

	        while (typeof (mangDistrict[dem]) != 'undefined')
	        {
	          if (mangDistrict[dem][1] != district) {
	            chuoi += "<input type='checkbox' name='idDistrict[]' onchange='getWards("+vals[0]+",$(this).val(), 0)' value='" + mangDistrict[dem][1] + "' />" + mangDistrict[dem][2] + "<br/>";
	          } else {
	            chuoi += "<input type='checkbox' name='idDistrict[]' onchange='getWards("+vals[0]+",$(this).val(), 0)' value='" + mangDistrict[dem][1] + "' checked>" + mangDistrict[dem][2] + "<br/>";
	          }

	          dem++;
	        }
	        $('#listDistrict').parent().slideDown();
	        $('#listDistrict').html(chuoi);
	        chuoi = "";
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
	    	var checkboxes = document.getElementsByName('idDistrict[]');
			var vals = [];
			for (var i=0, n=checkboxes.length;i<n;i++) 
			{
			    if (checkboxes[i].checked) 
			    {
			        vals.push(checkboxes[i].value);
			    }
			}
			var len = vals.length
	        if( len != 1){
	          var chuoi = "";
	          $('#listWards').html(chuoi);
	        } else if (vals.length === 1) {
	          var mangWards = allWards[city][vals[0]];
	          var dem = 1;
	          var chuoi = "";
	          $('#listWards').html(chuoi);

	          chuoi = "";

	          while (typeof (mangWards[dem]) != 'undefined')
	          {
	            if (mangWards[dem][1] != wards) {
	              chuoi += "<input type='checkbox' name='wards[]' value='" + mangWards[dem][1] + "'/>" + mangWards[dem][2] + "<br/>";
	            } else {
	              chuoi += "<input type='checkbox' name='wards[]' value='" + mangWards[dem][1] + "' checked />" + mangWards[dem][2] + "<br/>";
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
	      function getMachine() {
	      	var checkboxes = document.getElementsByName('idPlace[]');
			var vals = [];
			for (var i=0, n=checkboxes.length;i<n;i++) 
			{
			    if (checkboxes[i].checked) 
			    {
			        vals.push(checkboxes[i].value);
			    }
			}
			$.get("ajaxMachine?idPlace="+vals, function(data){
		    $('#listMachine').slideDown();
		    $('#listMachine').html(data);
		    });
	      }
	    </script>
<!-- 
fields in place table
	area 
	idCity
	idDistrict
	wards
	idChannel
fields in machine table
	idPlace
if idPlace changed then send data by ajax and find idMachine in machine table
 -->