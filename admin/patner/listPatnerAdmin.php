<link href="<?php echo $urlHomes . 'app/Plugin/kiosk/admin/style.css'; ?>" rel="stylesheet">
<?php
$breadcrumb = array('name' => 'Danh sách NCC điểm đặt',
	'url' => $urlPlugins . 'admin/kiosk-admin-patner-listPatnerAdmin.php',
	'sub' => array('name' => 'Tất cả')
);
addBreadcrumbAdmin($breadcrumb);
?> 
<!-- <a style="padding: 4px 8px;" href="<?php echo $urlPlugins . 'admin/kiosk-admin-patner-addPatnerAdmin.php'; ?>" class="input">
	<img src="<?php echo $webRoot; ?>images/add.png"> Thêm
</a> -->

<?php
if (!empty($_GET['mess'])&&$_GET['mess']==-2) {
?>
<script type="text/javascript">
	alert("Xóa không thành công. NCC điểm đặt có tồn tại điểm đặt")
</script>
<?php
}
?>
<?php
    if (isset($_GET['stt'])) {
        switch ($_GET['stt']) {
            case 1: echo '<p style="color:red;">Lưu thông tin thành công!</p>';
            break;
            case -1: echo '<p style="color:red;">Lưu thông tin không thành công!</p>';
            break;
            case 2: echo '<p style="color:red;">Xóa thành công!</p>';
            break;
        }
    }
    ?>
<form action="" method="get" accept-charset="utf-8">
	<div class="table-responsive table1">
		<table class="table table-bordered">
			<tr>
				<td>
					<div class="add_p">
						<a href="<?php echo $urlPlugins . 'admin/kiosk-admin-patner-addPatnerAdmin.php'; ?>">Thêm</a>
					</div>
				</td>
				<td>
					<table class="table table-bordered" style="margin-bottom: 0;">
						<tr>
							<td>
								<input type="text" class="form-control" placeholder="Mã NCC điểm đặt" name="code" value="<?php echo @arrayMap($_GET['code']);?>">
							</td>
							<td>
								<input type="text" class="form-control" placeholder="Tên NCC điểm đặt" name="name" value="<?php echo @arrayMap($_GET['name']);?>">
							</td>
							<td>
								<input type="text" name="dateStartConfig" id="dateStartRun" value="<?php echo @arrayMap($_GET['dateStartConfig']);?>" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" class="input_date form-control" placeholder="Ngày triển khai lắp đặt">
							</td>
							<td>
								<input type="text" value="<?php echo @$_GET['dateStart'];?>" name="dateStart" id="" placeholder="Ngày thành lập của điểm đặt" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" class="input_date form-control">
							</td>
							<td rowspan="4">
								<button class="add_p1">Tìm kiếm</button>
								
							</td>
						</tr>
						<tr>
							<td>
								<input type="text" value="<?php echo @$_GET['dateContract'];?>" name="dateContract" id="" placeholder="Ngày hiệu lực hợp đồng" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" class="input_date form-control">
							</td>
							<td>
								<input type="text" class="form-control" placeholder="Số điện thoại" name="phone" value="<?php echo @arrayMap($_GET['phone']);?>">
							</td>
							<td>
								<input type="text" class="form-control" placeholder="Email" name="email" value="<?php echo @$_GET['email'];?>">
							</td>
							<td>
								<input type="text" value="<?php echo @$_GET['dateStartRun'];?>" name="dateStartRun" id="dateStartRun" placeholder="Ngày đưa vào sử dụng máy đầu tiên" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" class="input_date form-control">
							</td>
						</tr>
						<tr>
							<td>
								<input type="text" class="form-control" placeholder="Nhân viên phát triển điểm đặt" name="developmentStaff" value="<?php echo @arrayMap($_GET['developmentStaff']);?>">
							</td>
							<td>
								<input type="text" class="form-control" placeholder="Nhân viên kinh doanh" name="salesStaff" value="<?php echo @arrayMap($_GET['salesStaff']);?>">
							</td>
							<td>
								<select name="idChanel" class="form-control">
									<option value="">Kênh phân phối</option>
									<?php 
									global $modelOption;
									$listChannelProduct= $modelOption->getOption('listChannelProduct');
									if (!empty($listChannelProduct['Option']['value']['allData'])) {
										foreach ($listChannelProduct['Option']['value']['allData'] as $city) {
											if (!isset($_GET['idChanel']) || $_GET['idChanel'] != $city['id']) {
												echo '<option value="' . $city['id'] . '">' . $city['name'] . '</option>';
											} else {
												echo '<option value="' . $city['id'] . '" selected>' . $city['name'] . '</option>';
											}
										}
									}

									?>
								</select>
							</td>
							<td>
								<select name="managementAgency" class="form-control" >
									<option value="">Trực tiếp quản lý điểm đặt</option>
									<?php
									global $listManagementAgency;
									foreach($listManagementAgency as $managementAgency){
										if(empty($_GET['managementAgency']) || $_GET['managementAgency']!=$managementAgency['id']){
											echo '<option value="'.$managementAgency['id'].'">'.$managementAgency['name'].'</option>';
										}else{
											echo '<option selected value="'.$managementAgency['id'].'">'.$managementAgency['name'].'</option>';
										}
									}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td>
								<input type="text" class="form-control" placeholder="Kênh thuê máy" name="rentalChannel" value="<?php echo @arrayMap($_GET['rentalChannel']);?>">
							</td>
							<td>
								<input type="text" class="form-control" placeholder="Kênh bán máy" name="salesChannel" value="<?php echo @arrayMap($_GET['salesChannel']);?>">
							</td>
							<td>
								<input type="text" class="form-control" placeholder="Tọa độ" name="location" value="<?php echo @arrayMap($_GET['location']);?>">
							</td>
							<td>
								<select name="area" class="form-control">
									<option value="">Chọn vùng</option>
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
						</tr>
						<tr>
							<td>
								<select  name="idCity" class="form-control" placeholder="Tỉnh/Thành phố" onchange="getDistrict(this.value, 0)">
									<option value="">Chọn Tỉnh/Thành phố</option>
									<?php
									global $modelOption;
									$listCityKiosk=$modelOption->getOption('cityKiosk');
									if (!empty($listCityKiosk['Option']['value']['allData'])) {
										foreach ($listCityKiosk['Option']['value']['allData'] as $city) {
											if (!isset($_GET['idCity']) || $_GET['idCity'] != $city['id']) {
												echo '<option value="' . $city['id'] . '">' . arrayMap($city['name']) . '</option>';
											} else {
												echo '<option value="' . $city['id'] . '" selected>' .arrayMap($city['name']) . '</option>';
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
							<td>
								<select  name="wards" class="form-control" placeholder="Chọn Xã/Phường" id="listWards" >
                                                            <option value="">Chọn Xã/Phường</option>
                                                            <!--  -->
                                                        </select>
							</td>
							<td>
								<input type="text" class="form-control" placeholder="Số nhà, đường" name="numberHouse" value="<?php echo @arrayMap($_GET['numberHouse']);?>">
							</td>
						</form>
							<form action="" method="POST">
														<td colspan="">
															<input type="" name="inport" value="1" class="hidden">
															<button class="add_p1" type="submit">Xuất file excel</button>
														</td>
														</form>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>




<table id=""  class="table_hy table-bordered">
	<tr>
		<th class="text_table">STT</th>
		<th class="text_table">Tên NCC điểm đặt</th>
		<th class="text_table">Mã NCC điểm đặt</th>
		<th class="text_table">Hành động</th>
	</tr>
	<?php 
	if(!empty($listData)){
		$i=$limit*($page-1);
		foreach ($listData as $key => $value) {
			$i++;
				# code...
			?>
			<tr>
				<td class="text_table"><?php echo $i;?></td>
				<td><?php echo $value['Patner']['name'];?></td>
				<td><?php echo $value['Patner']['code'];?></td>
				<td align="center">
					<button type=""><a style="color: black" href="<?php echo  $urlPlugins.'admin/kiosk-admin-patner-addPatnerAdmin.php?idEdit='.$value['Patner']['id'];?>">Sửa</a></button>
					<button type=""><a style="color: black" onclick='return confirm("Bạn có chắc chắn muốn xóa không ?")' href="<?php echo  $urlPlugins.'admin/kiosk-admin-patner-deletePatnerAdmin.php?idPatner='.$value['Patner']['id'];?>">Xóa</a></button>
				</td>
			</tr>
			<?php 
		}
	}
	?>
</table>
<p>
	<?php
	
	if ($page > 5) {
		$startPage = $page - 5;
	} else {
		$startPage = 1;
	}

	if ($totalPage > $page + 5) {
		$endPage = $page + 5;
	} else {
		$endPage = $totalPage;
	}

	echo '<a href="' . $urlPage . $back . '">Trang trước</a> ';
                for ($i = $startPage; $i <= $endPage; $i++) {
                    echo ' <a href="' . $urlPage . $i . '" ';
                        if (!empty($_GET['page'])&&$_GET['page']==$i) {
                            echo 'class="page"';
                        }
                    echo '>' . $i . '</a> ';
                }
                echo ' <a href="' . $urlPage . $next . '">Trang sau</a> ';

                echo 'Tổng số trang: ' . $totalPage;
                ?>
</p>
<style type="text/css">
    .page
    {
        text-decoration: underline;
    }
</style>
<style type="text/css">
.text_table{
	text-align: center;
}

.table_hy{
	width: 100%;
}
.table_hy th {
	padding: 10px;
}
.table_hy td {
	padding: 10px;
}
</style>
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
            if (!empty(@arrayMap($_GET['idDistrict']))) {
                if (!empty(@arrayMap($_GET['wards']))) {
                    echo 'getWards('.@arrayMap($_GET['idCity']).',' . @arrayMap($_GET['idDistrict']) . ',"' . @arrayMap($_GET['wards']) . '")';
                } else {
                    echo 'getWards('.@arrayMap($_GET['idCity']).',' . @arrayMap($_GET['idDistrict']) . ',0)';
                }
            }
            ?>

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