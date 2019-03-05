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
 					<li class="page_now">Chỉnh sửa chương trình khuyến mại</li>
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
 												<input type="text" title="" maxlength="50" id="" placeholder="Tên khuyến mại" class="form-control"  name="name" required="" value="<?php echo @arrayMap($data['Sale']['name']);?>">
 											</div>
 										</div>
 									</div>

 									<div class="col-sm-4">
 										<div class="form_add">
 											<div class="form-group">
 												<label>Ngày bắt đầu<span class="color_red">*</span>: </label>
 												<input type="text" maxlength="50" value="<?php echo @date('d/m/Y',$data['Sale']['dateStart']);?>" name="dateStart" id="" placeholder="Từ ngày" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" required>
 											</div>
 										</div>
 									</div>

 									<div class="col-sm-4">
 										<div class="form_add">
 											<div class="form-group">
 												<label>Ngày kết thúc<span class="color_red">*</span>: </label>
 												<input type="text" maxlength="50" name="dateEnd" id="" value="<?php echo @date('d/m/Y',$data['Sale']['dateEnd']);?>" placeholder="Đến ngày" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" required="">
 											</div>
 										</div>
 									</div>
 								  </div>

								  <div class="row">
 									<div class="col-sm-4">
 										<div class="form_add">
 											<div class="form-group">
 												<label>Giá trị giảm (%)<span class="color_red">*</span>: </label>
 												<input type="number" min="0" max="99" title="" maxlength="2" id="" placeholder="Giá trị giảm" class="input_money form-control" name="value" required="" value="<?php echo @arrayMap($data['Sale']['value']);?>">
 											</div>
 										</div>
 									</div>

 									<div class="col-sm-4">
 										<div class="form_add">
 											<div class="form-group">
 												<label>Mức giảm tối đa: </label>
 												<input type="text" title="" maxlength="19" id="" placeholder="Mức giảm tối đa" class="input_money form-control" name="maxValue" value="<?php echo @arrayMap($data['Sale']['maxValue']);?>">
 											</div>
 										</div>
 									</div>
 									<div class="col-sm-4">
 										<div class="form_add">
 											<div class="form-group">
 												<label>Trạng thái<span class="color_red">*</span>: </label>
 												<select name="lock" class="form-control">
 													<option value="0" <?php if(!empty($data['Sale']['lock'])&&$data['Sale']['lock']==0) echo'selected';?>>Kích hoạt</option>
 													<option value="1" <?php if(!empty($data['Sale']['lock'])&&$data['Sale']['lock']==1) echo'selected';?>>Khóa</option>
 												</select>
 											</div>
 										</div>
 									</div>
 								  </div>
 								  <div class="row">
                                    <div class="col-sm-4">
 										<div class="form_add">
 											<div class="form-group">
 												<div onclick="$(this).next().slideToggle()">Vùng: </div>
 												<div style="display: ">
 													<?php
							                          global $listArea;
							                          foreach($listArea as $area){
							                            if(!empty($data['Sale']['area']) && in_array($area['id'], $data['Sale']['area'])){
							                              echo '<input checked type="checkbox" name="area[]" value="'.$area['id'].'"/>'.$area['name'].'<br/>';
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
 												<div onclick="$(this).next().slideToggle()">Tỉnh/thành phố: </div>
 												<div style="display: ">
 													<?php
							                          global $modelOption;
							                          $listCityKiosk=$modelOption->getOption('cityKiosk');
							                          if (!empty($listCityKiosk['Option']['value']['allData'])) {
							                            foreach ($listCityKiosk['Option']['value']['allData'] as $city) {
							                              if (!empty($data['Sale']['idCity']) && in_array($city['id'], $data['Sale']['idCity'])) {
							                                echo '<input checked type="checkbox" name="idCity[]" onchange="getDistrict($(this).val(), 0)" value="' . $city['id'] . '"/>' . arrayMap($city['name']) . '<br/>';
							                              } else {
							                                echo '<input type="checkbox" name="idCity[]" onchange="getDistrict($(this).val(), 0)" value="' . arrayMap($city['id']) . '">' . $city['name'] . '<br/>';
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
 												<div>Quận huyện: </div>
 												<div id="listDistrict">
	 												<?php
	 												  // nếu chỉ có 1 tỉnh/thành phố đc chọn thì in ra các quận huyện thuộc thành phố đó
	 												  // điều này có nghĩa là nếu ko có tp nào đc chọn or chọn nhiều tp thì nó sẽ ko in ra cái quái gì hết
							                          if (!empty($data['Sale']['idCity']) && count($data['Sale']['idCity'] == 1)) {
							                            $id_city = ($data['Sale']['idCity'][0]);
							                            global $modelOption;
							                            $listCityKiosk=$modelOption->getOption('cityKiosk');
							                            foreach ($listCityKiosk['Option']['value']['allData'][(int)$id_city] as $key => $value) {
							                            }
							                            $count = count($value);
							                            for ($i=1; $i <= $count; $i++) {
							                              if (!@in_array($value[$i]['id'], $data['Sale']['idDistrict'])) {
							                                echo '<input type="checkbox" name="idDistrict[]" onchange="getWards('.$id_city.',$(this).val(), 0)" value="'.$value[$i]['id'].'"/>'.$value[$i]['name'].'<br/>';
							                              } else {
							                                echo '<input type="checkbox" name="idDistrict[]" onchange="getWards('.$id_city.',$(this).val(), 0)" checked value="'.$value[$i]['id'].'"/>'.$value[$i]['name'].'<br/>';
							                              }
							                            }
							                          }
							                        ?>
						                    	</div>
 											</div>
 										</div>
 									</div>
 								  </div>
 									<div class="col-sm-4">
 										<div class="form_add">
 											<div class="form-group">
 												<div>Xã phường: </div>
 												<div id="listWards">
	 												<?php
							                          if (!empty($data['Sale']['idDistrict']) && count($data['Sale']['idDistrict'] == 1)) {
							                            $id_distric = $data['Sale']['idDistrict'][0];
							                            $modelWards = new Wards;
							                            $ward=$modelWards->find('all', array('conditions'=>array('idDistrict'=>(int)$id_distric, 'idCity'=>(int)$id_city[0])));
							                            $count=count($ward);
							                            for($i=0;$i<$count;$i++){
							                              if (@in_array($ward[$i]['Wards']['id'], $data['Sale']['wards'])) {
							                                echo '<input type="checkbox" name="wards[]" checked value="'.$ward[$i]['Wards']['id'].'">'.$ward[$i]['Wards']['name'].'<br>';
							                              } else {
							                                echo '<input type="checkbox" name="wards[]" value="'.$ward[$i]['Wards']['id'].'">'.$ward[$i]['Wards']['name'].'<br>';
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
 												<div onclick="$(this).next().slideToggle()">Kênh bán hàng: </div>
 												<div>
 													<?php
							                          global $modelOption;
							                          $listChannelProduct= $modelOption->getOption('listChannelProduct');
							                          if(!empty($listChannelProduct)){
							                            foreach ($listChannelProduct['Option']['value']['allData'] as $key => $value) {
							                              ?>
							                              <input type="checkbox" name="idChannel[]" <?php if(!empty($data['Sale']['idChannel'])&&in_array($value['id'], $data['Sale']['idChannel'])) echo'checked';?> value="<?php echo $value['id'];?>"> <?php echo $value['name'];?></br>
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
 												<div onclick="$(this).next().slideToggle()">Điểm đặt: </div>
 												<div>
 													<?php
							                          if(!empty($listPlace)){
							                            foreach ($listPlace as $key => $value) {
							                              ?>
							                              <input type="checkbox" name="idPlace[]" <?php if(!empty($data['Sale']['idPlace'])&&in_array($value['Place']['id'], $data['Sale']['idPlace'])) echo'checked';?> value="<?php echo $value['Place']['id'];?>"/><?php echo $value['Place']['name'];?><br/>
							                              <?php
							                            }
							                          }
							                        ?>
 												</div>
 											</div>
 										</div>
 									</div>
 								  </div>
 								  <!-- <div class="row"> -->
 								  	<div class="col-sm-6" style="padding-left: 30px">
 										<div class="form_add">
 											<div class="form-group">
 												<div onclick="$(this).next().slideToggle()"><input type="checkbox">Chọn hình thức thanh toán:</div>
 												<div>
 												  <input disabled="" name='typedateEndPay[]' value='1' type='checkbox'> Tiền mặt <br>
						                          <input name='typedateEndPay[]' value='2' <?php if(!empty($data['Sale']['typedateEndPay'])&&in_array('2', $data['Sale']['typedateEndPay'])) echo'checked';?> type='checkbox'> Ví VTC <br>
						                          <input name='typedateEndPay[]' value='3' <?php if(!empty($data['Sale']['typedateEndPay'])&&in_array('3', $data['Sale']['typedateEndPay'])) echo'checked';?> type='checkbox'> Coupon <br>
						                          <input name='typedateEndPay[]' value='4' <?php if(!empty($data['Sale']['typedateEndPay'])&&in_array('4', $data['Sale']['typedateEndPay'])) echo'checked';?> type='checkbox'> QRPay
 												</div>
 											</div>
 										</div>
 									</div>
 									<div class="col-sm-6">
 										<div class="form_add">
 											<div class="form-group">
 												<div onclick="$(this).next().slideToggle()">Mã máy: </div>
 												<div>
 													<?php
							                            if(!empty($listMachine)){
							                              foreach ($listMachine as $valueMachine) {
							                                ?>
							                                <input type="checkbox" name="codeMachine[]" <?php if(!empty($data['Sale']['codeMachine'])&&in_array($valueMachine['Machine']['code'], $data['Sale']['codeMachine'])) echo'checked';?> value="<?php echo $valueMachine['Machine']['code'];?>" /><?php echo $valueMachine['Machine']['code'].' ('.$valueMachine['Machine']['name'].')';?><br/>
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
 											<textarea class="form-control" maxlength="3000" placeholder="Ghi chú" value="" rows="3" name="note"><?php echo @arrayMap($data['Sale']['note']);?></textarea>
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
	    </script>
