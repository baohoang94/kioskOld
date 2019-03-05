<link href="<?php echo $urlHomes . 'app/Plugin/kiosk/admin/style.css'; ?>" rel="stylesheet">
<?php
if(!empty($dataEdit)){
	$name='Chỉnh sửa NCC điểm đặt';
}else{
	$name="Thêm NCC điểm đặt";
}
$breadcrumb = array('name' => $name,
	'url' => $urlPlugins . 'admin/kiosk-admin-patner-addPatnerAdmin.php',
	'sub' => array('name' => '')
);
addBreadcrumbAdmin($breadcrumb);

?>

<form action="" method="POST">
	<div class="row">
		<input type="" name="id" class="hidden" value="<?php echo @$dataEdit['Patner']['id'];?>">
		<div class="col-sm-4">
			<p><b>Tên NCC điểm đặt<span class="color_red">*</span></b>:</p>	
			<input type="" maxlength="50" required="" name="name" placeholder="Tên NCC điểm đặt" class="form-control" value="<?php echo @arrayMap($dataEdit['Patner']['name']);?>">
		</div>
		<div class="col-sm-4">
			<p><b>Mã NCC điểm đặt<span class="color_red">*</span></b>:</p>	
			<input type="" maxlength="50" required="" name="code" pattern="([a-zA-Z0-9-]+)" title="Nhập mã không chứa nội dung khoảng trắng, ký tự có dấu. Chỉ sử dụng chữ cái (a-z. A-Z), số, dấu gạch ngang " maxlength="50" placeholder="Mã NCC điểm đặt" class="form-control" value="<?php echo @arrayMap($dataEdit['Patner']['code']);?>">
		</div>
		<div class="col-sm-4">
			<label>Ngày triển khai lắp đặt<span class="color_red">*</span>: </label>
			<input type="text" maxlength="50" name="dateStartConfig" id="dateStartConfig" placeholder="Ngày triển khai lắp đặt" value="<?php echo @arrayMap($dataEdit['Patner']['dateStartConfig']);?>" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" required=""> 
		</div>
		
	</div>
	<div class="row">
		<div class="col-sm-4">
			<label>Ngày thành lập của điểm đặt<span class="color_red">*</span>: </label>
			<input type="text" name="dateStart" id="dateStart" value="<?php echo @arrayMap($dataEdit['Patner']['dateStart']);?>" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  placeholder="Ngày thành lập của điểm đặt"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" required="">
		</div>
		<div class="col-sm-4">
			<label>Ngày hiệu lực hợp đồng<span class="color_red">*</span>: </label>
			<input type="text" name="dateContract" id="dateContract" value="<?php echo @arrayMap($dataEdit['Patner']['dateContract']);?>" data-inputmask="'alias': 'date'" placeholder="Ngày hiệu lực hợp đồng"  pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" required="">
		</div>
		<div class="col-sm-4">
			<label>Số điện thoại người liên lạc<span class="color_red">*</span>: </label>
			<input type="text" name="phone" maxlength="50" placeholder="Số điện thoại người liên lạc"  value="<?php echo @arrayMap($dataEdit['Patner']['phone']);?>" class="form-control" required="">
		</div>
		<div class="col-sm-4">
			<label>Email người liên lạc<span class="color_red">*</span>: </label>
			<input type="email" title="" maxlength="50" id=""  placeholder="Email người liên lạc" value="<?php echo @arrayMap($dataEdit['Patner']['email']);?>" class="form-control" name="email" required="" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[a-zA-Z]{2,3}$">
		</div>
		<div class="col-sm-4">
			<label>Ngày đưa vào sử dụng máy đầu tiên<span class="color_red">*</span>: </label>
			<input type="text" name="dateStartRun" id="dateStartRun" value="<?php echo @arrayMap($dataEdit['Patner']['dateStartRun']);?>" data-inputmask="'alias': 'date'"  placeholder="Ngày đưa vào sử dụng máy đầu tiên" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" required="">
		</div>
		<div class="col-sm-4">
			<label>Nhân viên phát triển điểm đặt<span class="color_red">*</span>: </label>
			<input type="text" title="" maxlength="50" id="" class="form-control"  placeholder="Nhân viên phát triển điểm đặt"  value="<?php echo @arrayMap($dataEdit['Patner']['developmentStaff']);?>" name="developmentStaff" required="">
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<label>Nhân viên kinh doanh<span class="color_red">*</span>: </label>
			<input type="text" title="" maxlength="50" id="" class="form-control" placeholder="Nhân viên kinh doanh"  value="<?php echo @arrayMap($dataEdit['Patner']['salesStaff']);?>" name="salesStaff" required="">
		</div>
		<div class="col-sm-4">
			<p><b>Kênh bán hàng<span class="color_red">*</span>:</b></p>	
			<select name="idChannel" class="form-control" required="">
				<option value="">Lựa chọn</option>
				<?php 
				if(!empty($listChannel)){
					foreach ($listChannel['Option']['value']['allData'] as $key => $value) {
							# code...
						?>
						<option value="<?php echo $value['id'];?>"<?php if(!empty($dataEdit['Patner']['idChannel'])&&$dataEdit['Patner']['idChannel']==$value['id']) echo'selected';?>><?php echo $value['name'];?></option>
						<?php 
					}
				}
				?>
			</select>
		</div>
		<div class="col-sm-4">
			<label>Trực tiếp quản lý điểm đặt<span class="color_red">*</span>: </label>
			<select name="managementAgency" class="form-control" required="">
				<option value="">Lựa chọn</option>
				<?php
				global $listManagementAgency;
				foreach($listManagementAgency as $managementAgency){
					if(empty($dataEdit['Patner']['managementAgency']) || $dataEdit['Patner']['managementAgency']!=$managementAgency['id']){
						echo '<option value="'.$managementAgency['id'].'">'.$managementAgency['name'].'</option>';
					}else{
						echo '<option selected value="'.$managementAgency['id'].'">'.$managementAgency['name'].'</option>';
					}
				}
				?>
			</select>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<label>Kênh thuê máy<span class="color_red">*</span>: </label>
			<input type="text" title="" maxlength="50" id=""  placeholder="Kênh thuê máy" class="form-control" value="<?php echo @arrayMap($dataEdit['Patner']['rentalChannel']);?>" name="rentalChannel" required="">
		</div>
		
		<div class="col-sm-4">
			<label>Kênh bán máy<span class="color_red">*</span>: </label>
			<input type="text" title="" maxlength="50" id=""  placeholder="Kênh thuê máy" class="form-control" value="<?php echo @arrayMap($dataEdit['Patner']['salesChannel']);?>" name="salesChannel" required="">		
				</div>
		<div class="col-sm-4">
			<p><b>Tọa độ<span class="color_red">*</span>:</b></p>	
			<input type="" required="" name="location" placeholder="VD :20.9789411,105.8481691" class="form-control" value="<?php echo @arrayMap($dataEdit['Patner']['location']);?>">
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<label for="">Chọn Vùng<span class="color_red">*</span>:</label>
			<select name="area" placeholder="" class="form-control" required="">
				<option value="">Chọn Vùng</option>
				<?php
				global $listArea;
				foreach($listArea as $area){
					if(empty($dataEdit['Patner']['area']) || $dataEdit['Patner']['area']!=$area['id']){
						echo '<option value="'.$area['id'].'">'.$area['name'].'</option>';
					}else{
						echo '<option selected value="'.$area['id'].'">'.$area['name'].'</option>';
					}
				}
				?>
			</select>
		</div>
		<div class="col-sm-4">
			<label for="">Chọn Tỉnh/Thành phố<span class="color_red">*</span>:</label>
			<select required name="idCity" class="form-control" placeholder="Tỉnh/Thành phố" onchange="getDistrict(this.value, 0)">
				<option value="">Chọn Tỉnh/Thành phố</option>
				<?php
				if (!empty($listCityKiosk['Option']['value']['allData'])) {
					foreach ($listCityKiosk['Option']['value']['allData'] as $city) {
						if (!isset($dataEdit['Patner']['idCity']) || $dataEdit['Patner']['idCity'] != $city['id']) {
							echo '<option value="' . $city['id'] . '">' . $city['name'] . '</option>';
						} else {
							echo '<option value="' . $city['id'] . '" selected>' . $city['name'] . '</option>';
						}
					}
				}
				?>
			</select>
		</div>
		<div class="col-sm-4">
			<label for="">Chọn Quận/Huyện<span class="color_red">*</span>:</label>
			<select  name="idDistrict" class="form-control" placeholder="Huyện/Quận" id="listDistrict" onchange="getWards(idCity.value,this.value, 0)">
                                                            <option value="">Chọn Quận/Huyện</option>
                                                        </select>
		</div>
		<div class="col-sm-4">
			<label for="">Chọn Xã phường<span class="color_red">*</span>:</label>
			<select  name="wards" class="form-control" placeholder="Chọn Xã/Phường" id="listWards" >
                                                            <option value="">Chọn Xã/Phường</option>
                                                            <!--  -->
                                                        </select>
		</div>
		<div class="col-sm-4">
			<label>Số nhà, đường<span class="color_red">*</span>: </label>
			<input type="text" title="" maxlength="200" id=""  placeholder="Số nhà, đường" value="<?php echo @arrayMap($dataEdit['Patner']['numberHouse']);?>" class="form-control" name="numberHouse" required="">
		</div>
		<div class="col-sm-12">
			<label>Mô tả:</label>
			<textarea class="form-control" name="note" maxlength="3000"  placeholder="Mô tả" rows="3" ><?php echo @arrayMap($dataEdit['Patner']['note']);?></textarea>
			<!-- <?php
			showEditorInput('note','note',@$dataEdit['Patner']['note']);
			?> -->
		</div>
		<?php if (!empty($dataEdit)) {?>
		<div class="col-sm-12" >
			<label>Lý do sửa<span class="color_red">*</span>: </label>
			<textarea class="form-control" name="reason" required="" maxlength="3000"  placeholder="Lý do sửa" rows="3" ></textarea>
			<!-- <?php
			showEditorInput('note','note',@$dataEdit['Patner']['note']);
			?> -->
		</div>
		<?php } ?>
		<div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center; margin-bottom: 15px; margin-top:15px;">
			<button type="submit"  class="btn btn-primary">Lưu</button>
		</form>
		<a href="<?php echo $urlPlugins.'admin/kiosk-admin-patner-listPatnerAdmin.php';?>"  class="btn btn-primary">Quay lại</a>
	</div>

<div class="row">
	<div class="form-group">
		<label class="col-sm-2 control-label">Bản đồ <span class="required color_red">*</span></label>
		<div class="col-sm-8">
			<a href="javascript:void( 0 );" class="btn btn-primary btn-sm" onclick="getByAdress();">Lấy bản đồ từ địa chỉ</a>
			&nbsp; Tọa độ GPS 
			<input type="text" name="coordinates"  id="coordinates" class="text_area" value="<?php
			if (isset($tmpVariable['data']['Route']['latGPS']) && isset($tmpVariable['data']['Route']['longGPS']))
				echo $tmpVariable['data']['Route']['latGPS'].','.$tmpVariable['data']['Route']['longGPS'];
			?>" />
			<br />
			<input type="text" id="address" class="form-control" value="" style="margin-top: 20px;" />
			<br />
			<a href="javascript:void( 0 );" class="btn btn-primary btn-sm" onclick="searchAdress();">Tìm</a>
			<span> Di chuột và chọn địa điểm trên bản đồ</span>
			<script type="text/javascript">
				function searchAdress()
				{
					addressNote = document.getElementById('address').value;
					getLocationFromAddress(addressNote);
				}
				function getByAdress()
				{
                        //addressNote = $("#detailAddress").val() + ', ' + $("#district :selected").text() + ', ' + $("#city :selected").text();
                        addressNote = $("#detailAddress").val();
                        getLocationFromAddress(addressNote);
                        document.getElementById('address').value = addressNote;
                    }
                </script>

            </div>
        </div>
        <div id="map-canvas" style="width: 100%; height: 500px"></div>
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

		}

		<?php
		if (!empty($dataEdit['Patner']['idCity'])) {
			if (!empty($dataEdit['Patner']['idDistrict'])) {
				echo 'getDistrict(' . $dataEdit['Patner']['idCity'] . ',' . $dataEdit['Patner']['idDistrict'] . ')';
			} else {
				echo 'getDistrict(' . $dataEdit['Patner']['idCity'] . ',0)';
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
            if (!empty(@arrayMap($dataEdit['Patner']['idDistrict']))) {
                if (!empty(@arrayMap($dataEdit['Patner']['wards']))) {
                    echo 'getWards('.@arrayMap($dataEdit['Patner']['idCity']).',' . @arrayMap($dataEdit['Patner']['idDistrict']) . ',"' . @arrayMap($dataEdit['Patner']['wards']) . '")';
                } else {
                    echo 'getWards('.@arrayMap($dataEdit['Patner']['idCity']).',' . @arrayMap($dataEdit['Patner']['idDistrict']) . ',0)';
                }
            }
            ?>

        </script>
	<script type="text/javascript">
		var map;
		var geocoder;
		var marker;

		function initialize() {
			geocoder = new google.maps.Geocoder();
			var mapDiv = document.getElementById('map-canvas');
        // Create the map object
        map = new google.maps.Map(mapDiv, {
        	<?php
        	if (isset($tmpVariable['data']['Route']['latGPS']) && isset($tmpVariable['data']['Route']['longGPS'])) {
        		echo 'center: new google.maps.LatLng(' . $tmpVariable['data']['Route']['latGPS'] . ','.$tmpVariable['data']['Route']['longGPS'].'),';
        	} else {
        		echo '';
        	}
        	?>
        	zoom: 10,
        	mapTypeId: google.maps.MapTypeId.ROADMAP,
        	streetViewControl: false
        });
        // Create the default marker icon
        marker = new google.maps.Marker({
        	map: map,
        	<?php
        	if (isset($tmpVariable['data']['Route']['latGPS']) && isset($tmpVariable['data']['Route']['longGPS'])) {
        		echo 'position: new google.maps.LatLng(' . $tmpVariable['data']['Route']['latGPS'] . ','.$tmpVariable['data']['Route']['longGPS']. '),';
        	} else {
        		echo 'position: new google.maps.LatLng(16.496281,107.219443),';
        	}
        	?>
        	draggable: true
        });
        // Add event to the marker
        google.maps.event.addListener(marker, 'drag', function () {
        	geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
        		if (status == google.maps.GeocoderStatus.OK) {
        			if (results[0]) {
        				document.getElementById('address').value = results[0].formatted_address;
        				document.getElementById('coordinates').value = marker.getPosition().toUrlValue();
        			}
        		}
        	});
        });
    }
    function getLocationFromAddress(address) {
        //var address = document.getElementById('address').value;
        geocoder.geocode({'address': address}, function (results, status) {
        	if (status == google.maps.GeocoderStatus.OK) {
        		map.setCenter(results[0].geometry.location);
        		marker.setPosition(results[0].geometry.location);
        		document.getElementById('coordinates').value = results[0].geometry.location.lat().toFixed(7) + ',' + results[0].geometry.location.lng().toFixed(7);
        	} else {
        		alert('Không tìm thấy địa điểm trên bản đồ.');
        	}
        });
    }
    // Initialize google map
    google.maps.event.addDomListener(window, 'load', initialize);
</script>

<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8Lo3pUlPzJUuT58ie2WP0WXq6YNMYHOg&callback=initialize">
</script>
<script src="https://www.jqueryscript.net/demo/Easy-jQuery-Input-Mask-Plugin-inputmask/dist/jquery.inputmask.bundle.min.js"></script>

<script>
	$(document).ready(function(){
		$("input.input_date").inputmask();
		$("input.input-mask-date").inputmask();
	});
</script>