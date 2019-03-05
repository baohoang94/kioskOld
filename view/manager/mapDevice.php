<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<div class="container-fluid main-container">
	<div class="col-md-12 content">
		
		<div class="panel panel-default listDevice1">
			<div class="panel-heading">
				<ul class="list-inline">
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now"><?php if (isset($_GET['status'])&&$_GET['status']==3) {
						echo "Danh sách máy lỗi";
					} else echo "Danh sách máy" ?></li>
					<?php 
						if (isset($_GET['status'])&&$_GET['status']==3) {
							?>
							<li class="text-right list_map">
								<form class="" action="/listMachineError" method="">
									<select class="form-control"  onchange='this.form.submit()'>
										<option class="hidden">Bản đồ</option>
										<option>Danh sách</option>
									</select>
								</form>
							</li>
							<?php 
						}else{
							?>
							<li class="text-right list_map">
								<form class="" action="/listMachine" method="">
									<select class="form-control"  onchange='this.form.submit()'>
										<option class="hidden">Bản đồ</option>
										<option>Danh sách</option>
									</select>
								</form>
							</li>
							<?php 
						}
					 ?>
					
				</ul>
			</div>


			<div class="main_list_p ">
				<div class="row">
					<div class="col-sm-12">
						<div id="map"></div>
					</div>
				</div>
				
			</div>
		</div>
		<script type="text/javascript">
			<?php 
			$modelMachine= new Machine;
			if(isset($_GET['status'])&&$_GET['status']==3){
			if (!empty($_SESSION['infoStaff']['Staff']['type'])&&$_SESSION['infoStaff']['Staff']['type']=='admin') {
      $conditions = array('lock'=>0,'status'=>'3');
        }
        else
        {
      $conditions = array('lock'=>0,'status'=>'3','idStaff'=>$_SESSION['infoStaff']['Staff']['id']);

        }
			$gettoado=$modelMachine-> find('all',array('conditions'=> $conditions));
		    }else
		    {
		    if (!empty($_SESSION['infoStaff']['Staff']['type'])&&$_SESSION['infoStaff']['Staff']['type']=='admin') {
      $conditions = array('lock'=>0);
        }
        else
        {
      $conditions = array('lock'=>0,'idStaff'=>$_SESSION['infoStaff']['Staff']['id']);

        }
			$gettoado=$modelMachine-> find('all',array('conditions'=>$conditions));
		    }
			$i=0;
			 ?>
			 <?php 
			 $get=$gettoado;
			 $i=0;
			 foreach ($gettoado as $key => $value) {
			 	if (isset($value['Machine']['location'])) {
			 	$mang[]=$value['Machine']['location'] ;
			 	$i++;
			 }
			 }
			 if(!empty($mang))
			 {
			 foreach (array_count_values($mang) as $key => $value) {
			 	if ($value>1) {
			 		$ma[]=$key;
			 	}
			 }
			}
			 $name='';
			  ?>
			var locations = [
			<?php foreach ($gettoado as $key => $value) {
			if (isset($value['Machine']['location'])&&$value['Machine']['location']!=null) {
			$i++; 
			if (!empty($ma)&&in_array($value['Machine']['location'], $ma)) {
				if ($name=='') {
				$name=$value['Machine']['name'];
				}else
				{
				$name=$value['Machine']['name'] .' + '. $name;
				} ?>
			['<a href="#" class="googleMapImg"><?php echo $name ?></a> <br/> ', <?php echo $value['Machine']['location'] ?>, <?php echo $i ?>, "https://maps.google.com/mapfiles/ms/micons/red.png"],
			<?php 
		}else
		{
			?>
			['<a href="#" class="googleMapImg"><?php echo $value['Machine']['name'] ?></a> <br/> ', <?php echo $value['Machine']['location'] ?>, <?php echo $i ?>, "https://maps.google.com/mapfiles/ms/micons/red.png"],
			<?php
		}
	}} ?>
			];
			var map = new google.maps.Map(document.getElementById('map'), {
				zoom: 5,
				center: new google.maps.LatLng(21.03, 105.83),
				mapTypeId: google.maps.MapTypeId.ROADMAP
			});
			var infowindow = new google.maps.InfoWindow();
			var marker, i;
			for (i = 0; i < locations.length; i++) {
				marker = new google.maps.Marker({
					position: new google.maps.LatLng(locations[i][1], locations[i][2]),
					icon: locations[i][4],
					map: map
				});
				google.maps.event.addListener(marker, 'click', (function (marker, i) {
					return function () {
						infowindow.setContent(locations[i][0]);
						infowindow.open(map, marker);
					}
				})(marker, i));
			}
		</script>
		
		<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>