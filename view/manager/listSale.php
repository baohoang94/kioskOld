<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<style>
	input {
	    min-width: unset;
	}
</style>
<div class="container-fluid main-container">
	<div class="col-md-12 content">
		
		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="list-inline">
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now">Quản lý chương trình khuyến mại</li>
				</ul>

			</div>

			<div class="main_list_p ">
				<div class="row">
					<div class="col-sm-12">
						<div class="table-responsive table1">
							<table class="table table-bordered">
								<tr>
									<td>
										<div class="add_p">
											<a href="/addSale">Thêm mới</a>
											<br><br>
											<!-- <a href="/uploadCoupon">upload coupon</a> -->
										</div>
									</td>
									<td>
										<form>
											<table class="table table-bordered">
												<tr>
													<td>
														<input type="text" class="form-control" placeholder="Tên khuyến mại" name="name" value="<?php echo @arrayMap($_GET['name']);?>">
													</td>

													<td>
														<input type="text" name="dateStart" id="" value="<?php echo @$_GET['dateStart'];?>" placeholder="Ngày bắt đầu" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control">
													</td>
													<td>
														<input type="text" name="dateEnd" id="" value="<?php echo @$_GET['dateEnd'];?>" placeholder="Ngày kết thúc" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" >
														
													</td>

													<td rowspan="4">
														<button class="add_p1">Tìm kiếm</button>
													</td>
												</tr>
												<tr>
													<td>
														<input type="number" min="0" max="99" name="value" id="" value="<?php echo @arrayMap($_GET['value']);?>" placeholder="Giá trị giảm (%)" title="Giá trị giảm (%)" class="form-control">
													</td>
													<td>
														<input type="text" name="maxValue" id="" value="<?php echo @arrayMap($_GET['maxValue']);?>" placeholder="Mức giảm tối đa" title="Mức giảm tối đa" class="form-control" >
														
													</td>
													<td>
														<select name="lock" class="form-control">
		 													<option value="0" <?php if(!empty($_GET['lock'])&&$_GET['lock']==0) echo'selected';?>>Kích hoạt</option>
		 													<option value="1" <?php if(!empty($_GET['lock'])&&$_GET['lock']==1) echo'selected';?>>Khóa</option>
		 												</select>
													</td>
												</tr>
												<tr>
							                      <td>
													Chọn Vùng <br>
							                          <?php
							                          global $listArea;
							                          foreach($listArea as $area){
							                            if(empty($_GET['area']) || !in_array($area['id'], $_GET['area'])){
							                              echo '<input type="checkbox" name="area[]" value="'.$area['id'].'"/>'.$area['name'].'<br/>';
							                            }else{
							                              echo '<input type="checkbox" checked name="area[]" value="'.$area['id'].'"/>'.$area['name'].'<br/>';
							                            }
							                          }
							                          ?>

							                      </td>
							                      <td>
							                      	Chọn Tỉnh/Thành phố <br>
							                          <?php
							                          global $modelOption;
							                          $listCityKiosk=$modelOption->getOption('cityKiosk');
							                          if (!empty($listCityKiosk['Option']['value']['allData'])) {
							                            foreach ($listCityKiosk['Option']['value']['allData'] as $city) {
							                              if (!isset($_GET['idCity']) || !in_array($city['id'], $_GET['idCity'])) {
							                                echo '<input type="checkbox" name="idCity[]" onchange="getDistrict($(this).val(), 0)" value="' . $city['id'] . '"/>' . arrayMap($city['name']) . '<br/>';
							                              } else {
							                                echo '<input type="checkbox" name="idCity[]" onchange="getDistrict($(this).val(), 0)" value="' . arrayMap($city['id']) . '" checked>' . $city['name'] . '<br/>';
							                              }
							                            }
							                          }
							                          ?>
							                      </td>
							                      <td>
							                      	Chọn Quận/Huyện <br>
							                      	<span id="listDistrict">
							                      	<?php
	 												  // nếu chỉ có 1 tỉnh/thành phố đc chọn thì in ra các quận huyện thuộc thành phố đó
	 												  // điều này có nghĩa là nếu ko có tp nào đc chọn or chọn nhiều tp thì để js xử lý
							                          if (!empty($_GET['idCity']) && count($_GET['idCity'] == 1)) {
							                            $id_city = ($_GET['idCity'][0]);
							                            global $modelOption;
							                            $listCityKiosk=$modelOption->getOption('cityKiosk');
							                            foreach ($listCityKiosk['Option']['value']['allData'][(int)$id_city] as $key => $value) {
							                            }
							                            $count = count($value);
							                            for ($i=1; $i <= $count; $i++) {
							                              // hiển thị các quận huyện đc chọn khi tìm kiếm
							                              if (!@in_array($value[$i]['id'], $_GET['idDistrict'])) {
							                                echo '<input type="checkbox" name="idDistrict[]" onchange="getWards('.$id_city.',$(this).val(), 0)" value="'.$value[$i]['id'].'"/>'.$value[$i]['name'].'<br/>';
							                              } else {
							                                echo '<input type="checkbox" name="idDistrict[]" onchange="getWards('.$id_city.',$(this).val(), 0)" checked value="'.$value[$i]['id'].'"/>'.$value[$i]['name'].'<br/>';
							                              }
							                            }
							                          }
							                        ?>
							                        </span>
							                      </td>
							                    </tr>
							                    <tr>
							                      <td>
							                    	Chọn Xã/Phường <br>
							                        <span id="listWards">
							                        <?php
							                          if (!empty($_GET['idDistrict']) && count($_GET['idDistrict'] == 1)) {
							                            $id_distric = $_GET['idDistrict'][0];
							                            $modelWards = new Wards;
							                            $ward=$modelWards->find('all', array('conditions'=>array('idDistrict'=>(int)$id_distric, 'idCity'=>(int)$id_city[0])));
							                            $count=count($ward);
							                            for($i=0;$i<$count;$i++){
							                              if (@in_array($ward[$i]['Wards']['id'], $_GET['wards'])) {
							                                echo '<input type="checkbox" name="wards[]" checked value="'.$ward[$i]['Wards']['id'].'">'.$ward[$i]['Wards']['name'].'<br>';
							                              } else {
							                                echo '<input type="checkbox" name="wards[]" value="'.$ward[$i]['Wards']['id'].'">'.$ward[$i]['Wards']['name'].'<br>';
							                              }
							                            }
							                          }
							                        ?>
							                        </span>
							                      </td>
							                      <td>
							                      	Chọn kênh bán hàng <br>
							                          <?php
							                          global $modelOption;
							                          $listChannelProduct= $modelOption->getOption('listChannelProduct');
							                          if(!empty($listChannelProduct)){
							                            foreach ($listChannelProduct['Option']['value']['allData'] as $key => $value) {
							                              ?>
							                              <input type="checkbox" name="idChannel[]" <?php if(!empty($_GET['idChannel'])&&in_array($value['id'], $_GET['idChannel'])) echo'checked';?> value="<?php echo $value['id'];?>"> <?php echo $value['name'];?></br>
							                              <?php
							                            }
							                          }
							                          ?>
							                      </td>
							                      <td>
							                    	Hình thức thanh toán<br>
							                        <input disabled="" name='typedateEndPay[]' value='1' type='checkbox'> Tiền mặt <br>
							                        <input name='typedateEndPay[]' value='2' <?php if(!empty($_GET['typedateEndPay'])&&in_array('2', $_GET['typedateEndPay'])) echo'checked';?> type='checkbox'> Ví VTC <br>
							                        <input name='typedateEndPay[]' value='3' <?php if(!empty($_GET['typedateEndPay'])&&in_array('3', $_GET['typedateEndPay'])) echo'checked';?> type='checkbox'> Coupon <br>
							                        <input name='typedateEndPay[]' value='4' <?php if(!empty($_GET['typedateEndPay'])&&in_array('4', $_GET['typedateEndPay'])) echo'checked';?> type='checkbox'> QRPay
							                      </td>
							                    </tr>
							                    <tr>
							                      <td colspan="2">
							                        <div onclick="$(this).next().slideToggle()">Chọn điểm đặt <i class="fa fa-sort-desc" aria-hidden="true"></i></div>
	 												<div style="display: none">
	 													<?php
								                          if(!empty($listPlace)){
								                            foreach ($listPlace as $key => $value) {
								                              ?>
								                              <input type="checkbox" name="idPlace[]" <?php if(!empty($_GET['idPlace'])&&in_array($value['Place']['id'], $_GET['idPlace'])) echo'checked';?> value="<?php echo $value['Place']['id'];?>"/><?php echo $value['Place']['name'];?><br/>
								                              <?php
								                            }
								                          }
								                        ?>
	 												</div>
							                      </td>
							                      <td colspan="2">
							                        <div onclick="$(this).next().slideToggle()">Chọn mã máy <i class="fa fa-sort-desc" aria-hidden="true"></i></div>
	 												<div style="display: none">
	 													<?php
								                            if(!empty($listMachine)){
								                              foreach ($listMachine as $valueMachine) {
								                                ?>
								                                <input type="checkbox" name="codeMachine[]" <?php if(!empty($_GET['codeMachine'])&&in_array($valueMachine['Machine']['code'], $_GET['codeMachine'])) echo'checked';?> value="<?php echo $valueMachine['Machine']['code'];?>" /><?php echo $valueMachine['Machine']['code'].' ('.$valueMachine['Machine']['name'].')';?><br/>
								                                <?php
								                              }
								                            }
								                        ?>
	 												</div>
							                      </td>
							                    </tr>												
											</table>
										</form>
									</td>
								</tr>
							</table>
						</div>
					</div>

					<div class="col-sm-12">
						<div class="table-responsive table1">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th class="text_table">STT</th>
										<th class="text_table">Tên khuyến mại</th>
										<th class="text_table">Ngày bắt đầu</th>
										<th class="text_table">Ngày kết thúc</th>
										<th class="text_table">Giá trị giảm</th>
										<th class="text_table">Mức giảm tối đa</th>
										<th class="text_table">Trạng thái</th>
										<th class="text_table" >Hành động</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if(!empty($listData)){
										global $listStatusCoupon;
										if (!isset($_GET['page'])) {
											$i=0;
										}
										elseif (isset($_GET['page'])&&$_GET['page']==1) {
											$i=0;
										}elseif (isset($_GET['page'])>=2)
										{
											$i=$_GET['page']*15-15;
										} 
										foreach($listData as $key=> $data){
											
											$i++;

											

											echo '
											<tr>
											<td class="text_table">'.$i.'</td>
											<td>'.@$data['Sale']['name'].'</td>
											<td class="text_table">'.@date('d/m/Y',$data['Sale']['dateStart']).'</td>
											<td class="text_table">'.@date('d/m/Y',$data['Sale']['dateEnd']).'</td>
											<td class="text_table">'.@$data['Sale']['value'].'%</td>
											<td class="text_table">'.@number_format($data['Sale']['maxValue']).'</td>
											<td>'.(($data['Sale']['lock'] === 0) ? 'Kích hoạt' : 'Khóa').'</td>
											
											<td>
											<ul class="list-inline list_i" style="">
											<li><a href="/editSale?id='.@$data['Sale']['id'].'" title="Chỉnh sửa"><i class="fa fa-pencil" aria-hidden="true"></i></a></li> 
											<li><a href="/infoSale?id='.@$data['Sale']['id'].'" title="Xem"><i class="fa fa-eye" aria-hidden="true"></i></a></li>
											<li><a onclick="return confirm(\'Bạn có chắc chắn muốn xóa không ?\')" href="/deleteSale?id='.@$data['Sale']['id'].'" title="Xóa" class="bg_red"><i class="fa fa-trash-o" aria-hidden="true"></i></a></li>
											</ul>
											</td>
											</tr>';
										}
									}else{
										echo '<tr><td align="center" colspan="8">Chưa có dữ liệu</td></tr>';
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
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
	    // Xóa các quận huyện khi nhiều thành phố đc chọn
	    if (!empty($_GET['idCity']) && count($_GET['idCity']) != 1) {
	        echo '$("#listDistrict").html("");';
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
	        if(vals.length != 1){
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
	      // xóa các xã phường khi ko phải 1 quận huyện được chọn
	      if (!empty($_GET['idDistrict']) && count($_GET['idDistrict']) != 1) {
	          echo '$("#listWards").html("");';
	      }
	      ?>
	    </script>