<?php 
function liveSearch()
{
	$modelStaff = new Staff();
	if (isset($_GET['key'])) {
		$conditions['code']= array('$regex'=>createSlugMantan(trim($_GET['key'])));
	}
	$listStaff = $modelStaff->find('all',array('conditions'=>$conditions));
	foreach ($listStaff as $key => $value) {
		echo '<p>'.$value['Staff']['code'].'</p>';
	}
}
function load(){
	global $modelOption;
	$modelPatner= new Patner;
	$listChannel=$modelOption->getOption('listChannelProduct');
	$listCityKiosk = $modelOption->getOption('cityKiosk');
	$patner=$modelPatner->getPatner($_POST['id'],array());
	if(!empty($patner)){
		?>
		<div class="col-sm-4">
			<div class="form_add">
				<div class="form-group">
					<label>Tên điểm đặt<span class="color_red">*</span>: </label>
					<input type="text" title="" maxlength="50" placeholder="Tên điểm đặt" id="" class="form-control" value="<?php echo @arrayMap($data['Place']['name']);?>" name="name" required="">
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form_add">
				<div class="form-group">
					<label>Mã điểm đặt<span class="color_red">*</span>: </label>
					<input type="text" title="" maxlength="50" placeholder="Mã điểm đặt"  id="updatecode" class="form-control" value="<?php echo @arrayMap($data['Place']['code']);?>" name="code" required="" pattern="[a-zA-Z0-9-]+$">
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form_add">
				<div class="form-group">
					<label>Tọa độ GPS<span class="color_red">*</span>: </label>
					<input type="text" title="" maxlength="50" id=""  placeholder="Tọa độ GPS" class="form-control" value="<?php echo @arrayMap($patner['Patner']['location']);?>" name="gps" required="">
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form_add">
				<div class="form-group">
					<label>Ngày triển khai lắp đặt<span class="color_red">*</span>: </label>
					<input type="text" name="dateStartConfig" id="dateStartConfig"  placeholder="Ngày triển khai lắp đặt" value="<?php echo @$patner['Patner']['dateStartConfig'];?>" data-inputmask="'alias': 'date'"  pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" required="">
				</div>
			</div>
		</div>


		<div class="col-sm-4">
			<div class="form_add">
				<div class="form-group">
					<label>Ngày hiệu lực hợp đồng<span class="color_red">*</span>: </label>
					<input type="text" name="dateContract" id="dateContract" placeholder="Ngày hiệu lức hợp đồng"  value="<?php echo @$patner['Patner']['dateContract'];?>" data-inputmask="'alias': 'date'"  pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" required="">
					<!-- <input type="text" name="dateContract" id="dateContract" value="<?php echo @$patner['Patner']['dateContract'];?>" data-inputmask="'alias': 'date'"  pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" required=""> -->
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form_add">
				<div class="form-group">
					<label>Thời hạn hợp đồng của điểm đặt<span class="color_red">*</span>: </label>
					<input type="text" name="timeContract" id="timeContract"  placeholder="Thời hạn hợp đồng của điểm đặt"  class="form-control" required="">

				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form_add">
				<div class="form-group">
					<label>Ngày thành lập của điểm đặt<span class="color_red">*</span>: </label>
					<input type="text" name="dateStart" id="dateStart"  placeholder="Ngày thành lập của điểm đặt" value="<?php echo @$patner['Patner']['dateStart'];?>" data-inputmask="'alias': 'date'"  pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" required="">
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form_add">
				<div class="form-group">
					<label>Số điện thoại người liên lạc<span class="color_red">*</span>: </label>
					<input type="text" name="phone" maxlength="50" placeholder="Số điện thoại người liên lạc"  value="<?php echo @arrayMap($patner['Patner']['phone']);?>" class="form-control" required="">
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form_add">
				<div class="form-group">
					<label>Email người liên lạc<span class="color_red">*</span>: </label>
					<input type="email" title="" maxlength="50" id=""  placeholder="Email người liên lạc" value="<?php echo @arrayMap($patner['Patner']['email']);?>" class="form-control" name="email" required="">
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form_add">
				<div class="form-group">
					<label>Ngày đưa vào sử dụng máy đầu tiên<span class="color_red">*</span>: </label>
					<input type="text" name="dateStartRun" id="dateStartRun" value="<?php echo @$patner['Patner']['dateStartRun'];?>" data-inputmask="'alias': 'date'"  placeholder="Ngày đưa vào sử dụng máy đầu tiên"  pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" required="">
				</div>
			</div>
		</div>

		<div class="col-sm-4">
			<div class="form_add">
				<div class="form-group">
					<label>Nhân viên phát triển điểm đặt<span class="color_red">*</span>: </label>
					<input type="text" title="" maxlength="50" id="" placeholder="Nhân viên phát triển điểm đặt"  class="form-control" value="<?php echo @arrayMap($patner['Patner']['developmentStaff']);?>" name="developmentStaff" required="">
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form_add">
				<div class="form-group">
					<label>Nhân viên kinh doanh<span class="color_red">*</span>: </label>
					<input type="text" title="" maxlength="50" id="" placeholder="Nhân viên kinh doanh "  class="form-control" value="<?php echo @arrayMap($patner['Patner']['salesStaff']);?>" name="salesStaff" required="">
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form_add">
				<div class="form-group">
					<label>Trực tiếp quản lý điểm đặt<span class="color_red">*</span>: </label>
					<select name="managementAgency" class="form-control">
						<option value="">Trực tiếp quản lý điểm đặt</option>
						<?php
						global $listManagementAgency;
						foreach($listManagementAgency as $managementAgency){
							if(empty($patner['Patner']['managementAgency']) || $patner['Patner']['managementAgency']!=$managementAgency['id']){
								echo '<option value="'.$managementAgency['id'].'">'.$managementAgency['name'].'</option>';
							}else{
								echo '<option selected value="'.$managementAgency['id'].'">'.$managementAgency['name'].'</option>';
							}
						}
						?>
					</select>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form_add">
				<div class="form-group">
					<label>Kênh thuê máy<span class="color_red">*</span>: </label>
					<input type="text" title="" placeholder="Kênh thuê máy" maxlength="50" id="" class="form-control" value="<?php echo @arrayMap($patner['Patner']['rentalChannel']);?>" name="rentalChannel" required="">
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form_add">
				<div class="form-group">
					<label>Kênh bán máy<span class="color_red">*</span>: </label>
					<input type="text" title="" placeholder="Kênh bán máy" maxlength="50" id="" class="form-control" value="<?php echo @arrayMap($patner['Patner']['salesChannel']);?>" name="salesChannel" required="">
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form_add">
				<div class="form-group">
					<label for="">Chọn Vùng<span class="color_red">*</span>:</label>
					<select name="area" placeholder="Chọn Vùng" class="form-control">
						<?php
						global $listArea;
						foreach($listArea as $area){
							if(empty($patner['Patner']['area']) || $patner['Patner']['area']!=$area['id']){
								echo '<option value="'.$area['id'].'">'.$area['name'].'</option>';
							}else{
								echo '<option selected value="'.$area['id'].'">'.$area['name'].'</option>';
							}
						}
						?>
					</select>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
				<div class="form_add">
					<div class="form-group">
						<label for="">Chọn Tỉnh/Thành phố <span class="color_red">*</span>:</label>
						<select required name="idCity" class="form-control" placeholder="Chọn Tỉnh/Thành phố" onchange="getDistrict(this.value, 0)">
							<option value="">Chọn Tỉnh/Thành phố</option>
							<?php
							if (!empty($listCityKiosk['Option']['value']['allData'])) {
								foreach ($listCityKiosk['Option']['value']['allData'] as $city) {
									if (!isset($patner['Patner']['idCity']) || $patner['Patner']['idCity'] != $city['id']) {
										echo '<option value="' . $city['id'] . '">' . $city['name'] . '</option>';
									} else {
										echo '<option value="' . $city['id'] . '" selected>' . $city['name'] . '</option>';
									}
								}
							}
							?>
						</select>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form_add">
					<div class="form-group">
						<label for="">Chọn Quận/Huyện<span class="color_red">*</span>:</label>
						<select  name="idDistrict"  required class="form-control" placeholder="Huyện/Quận" id="listDistrict" onchange="getWards(idCity.value,this.value, 0)">
										<option value="">Chọn Quận/Huyện</option>
									</select>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form_add">
					<div class="form-group">
						<label for="">Chọn Xã/Phường<span class="color_red">*</span>:</label>
						<select  name="wards"  required class="form-control" placeholder="Chọn Xã/Phường" id="listWards" >
										<option value="">Chọn Xã/Phường</option>
										<!--  -->
									</select>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form_add">
					<div class="form-group">
						<label>Số nhà, đường<span class="color_red">*</span>: </label>
						<input type="text" title="" placeholder="Số nhà, đường" maxlength="200" id="" value="<?php echo @arrayMap($patner['Patner']['numberHouse']);?>" class="form-control" name="numberHouse" required="">
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form_add">
					<div class="form-group">
						<label>Kênh bán hàng <span class="color_red">*</span>: </label>
						<select name="idChannel" class="form-control">
							<option value="">Kênh bán hàng</option>
							<?php 
							foreach ($listChannel['Option']['value']['allData'] as $key => $value) {
								if (isset($patner['Patner']['idChannel'])&&$patner['Patner']['idChannel']==$value['id']) {
																?>
							<option value="<?php echo $value['id'] ?>" selected><?php echo $value['name'] ?></option>
							<?php
							}else
							{
							echo '<option value="'.$value['id'].'" >'.$value['name'].'</option>';

							}
						}
							 ?>														
						</select>
						</div>
					</div>
				</div>
			<div class="col-sm-12">
				<div class="form-group">
					<label>Mô tả điểm đặt máy: </label>
					<textarea class="form-control" name="note" placeholder="Mô tả điểm đặt máy" rows="3" ><?php echo @arrayMap($patner['Patner']['note']);?></textarea>

				</div>
			</div>
			<script src="https://www.jqueryscript.net/demo/Easy-jQuery-Input-Mask-Plugin-inputmask/dist/jquery.inputmask.bundle.min.js"></script>

<script src="http://kiosk.webmantan.com/app/Plugin/kiosk/view/manager/js/ace-elements.min.js"></script>
<script src="http://kiosk.webmantan.com/app/Plugin/kiosk/view/manager/js/number-divider.js"></script>
<script src="http://kiosk.webmantan.com/app/Plugin/kiosk/view/manager/js/ace.min.js"></script>
<script src="http://kiosk.webmantan.com/app/Plugin/kiosk/view/manager/js/jquery.maskedinput.min.js"></script>

<script>
	$(document).ready(function(){
		$("input.input_date").inputmask();
		$("input.input-mask-date").inputmask();

		// $('.input_money').numbertor({
		// 	allowEmpty: true
		// });
		$('.input_money').divide({delimiter: '.',
			divideThousand: true});

		$('.input_money').on('paste', function () {
			var element = this;
			var text = $(element).val();
			if(!isNaN(text)){
				$(element).val("");
				console.log('Phải nhập số');
			}
		});


	});
</script>
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

					}

					<?php
					if (!empty($patner['Patner']['idCity'])) {
						if (!empty($patner['Patner']['idDistrict'])) {
							echo 'getDistrict(' . $patner['Patner']['idCity'] . ',' . $patner['Patner']['idDistrict'] . ')';
						} else {
							echo 'getDistrict(' . $patner['Patner']['idCity'] . ',0)';
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
				// echo 'allWards["'. $value['Wards']['idCity'] . '"]=[];';
				// echo 'allWards["'. $value['Wards']['idCity'] . '"]["' . $value['Wards']['idDistrict'] . '"]=[];';
				
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
				var chuoi = "<option value=''>Chọn Xã/Phường</option>";
				$('#listWards').html(chuoi);

				chuoi = "<option value=''>Chọn Xã/Phường</option>";

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
			if (!empty($patner['Patner']['idDistrict'])) {
				if (!empty($patner['Patner']['wards'])) {
					echo 'getWards('.$patner['Patner']['idCity'].',' . $patner['Patner']['idDistrict'] . ',"' . $patner['Patner']['wards'] . '")';
				} else {
					echo 'getWards('.$patner['Patner']['idCity'].',' . $patner['Patner']['idDistrict'] . ',0)';
				}
			}
			?>
			

		</script>
			<?php 
		}
	}
	function loadError(){
		$key=trim($_POST['key']);
		$modelErrormachine = new Errormachine;
		$listError=$modelErrormachine->find('all',array(
			'conditions' =>array('code'=>array('$regex' => $key)),
			'fields'=>array('name','code','info')
		));
	//pr($listError);
		if(!empty($_POST['id'])){
			echo'Xeom ';
		}
		?>
		<style>
		.vertical-menu {
			width: 370px;
			height: 150px;
			overflow-y: auto;
		}

		.vertical-menu .trang {
			background-color: #eee;
			color: black;
			display: block;
			padding: 12px;
			text-decoration: none;
			margin: 0 0 0;
			border: 1px solid #e2d9d9;
		}
		.vertical-menu button:hover{
			background-color: #ccc;
		}
		.vertical-menu .trang:hover {
			background-color: #ccc;
		}

		.vertical-menu .trang.active {
			background-color: #4CAF50;
			color: white;
		}
	</style>
	<script type="text/javascript">
	// $(".trang").click(function(){
	// 	$(".trang").hide();
	// });
</script>
<div class="vertical-menu">
	<?php 
	if(!empty($listError)){
		$i=0;
		foreach ($listError as $key => $value) {
			$i++;
			# code...
			?>
			<div class="trang" id="cua<?php echo $i;?>">
				Mã lỗi: <span id="code<?php echo $i;?>"><?php echo $value['Errormachine']['code'];?></span>
				<br>
				Tên lỗi: <span id="name<?php echo $i;?>"><?php echo $value['Errormachine']['name'];?></span><br>
				Mô tả:<span class="" id="info<?php echo $i;?>"><?php echo $value['Errormachine']['info'];?></span>
				<!-- </button> -->
			</div>
			<script type="text/javascript">
				$("#cua<?php echo $i;?>").click(function(){
					var code<?php echo $i;?>=$("#code<?php echo $i;?>").html();
					var name<?php echo $i;?>=$("#name<?php echo $i;?>").html();
					var info<?php echo $i;?>=$("#info<?php echo $i;?>").html();
					$('#errorCode').val(code<?php echo $i;?>);
					$('#errorName').val(name<?php echo $i;?>);
					$('#noteError').val(info<?php echo $i;?>);
					//$('.concua').hide();
				});
			</script>
			<?php 
		}

	}
	?>
</div>
<?php 

}
function checkNumber(){
	$number=str_replace ( array('    ',',','.') ,'',$_POST['number'] );
	$number1=number_format($number, 0, ',', '.');
	?>
	<p style="background: #e3c2c2;padding: 5px;" class="thaythe">
		<?php echo $number1;?>
	</p>
	<script type="text/javascript">
		$('.thaythe').click(function(){
			var giatri=$('.thaythe').html();
			if(giatri){
			}
			

		});
	</script>
	<?php 
}
?>