<link href="<?php echo $urlHomes . 'app/Plugin/kiosk/admin/style.css'; ?>" rel="stylesheet">

<?php
$breadcrumb = array('name' => 'Tỉnh/Thành phố',
    'url' => $urlPlugins . 'admin/kiosk-admin-city-listCityAdmin.php',
    'sub' => array('name' => $listCityKiosk['Option']['value']['allData'][$_GET['idCity']]['name'],
					'sub' => array('name'=>'Quận/Huyện',
						'sub' => array('name'=>$listCityKiosk['Option']['value']['allData'][$_GET['idCity']]['district'][$_GET['idDistrict']]['name']))
					)
);
addBreadcrumbAdmin($breadcrumb);
?>
<div class="them">
	<form action="" method="POST">
		<table id="listTable" cellspacing="0" class="tableList">
			<input type="" name="idDistrict" class="hidden" value="<?php echo @$_GET['idDistrict'];?>">
			<input type="" name="idCity" class="hidden" value="<?php echo @$_GET['idCity'];?>">
			<input type="" name="id" class="hidden" value="<?php echo @$data['Wards']['id'];?>">
			<tr>
				<td>
					<input type="" name="name" class="form-control" required="" value="<?php echo @arrayMap($data['Wards']['name']);?>" placeholder="Tên Xã/Phường">
				</td>
				<td>
					<input type="submit" name="" value="Lưu">
				</td>
			</tr>
		</table>
	</form>
</div>
<div class="show">
	<table id="listTable" cellspacing="0" class="tableList">
		<tr>
			<th>STT</th>
			<th>Tên Xã/Phường</th>
			<th>Hành động</th>
		</tr>
		<?php 
	
			$i=$limit*($page-1);
		
		if(!empty($listData)){

			
			foreach ($listData as $key => $value) {
				$i++;
						# code...
				?>
				<tr>
					<td><?php echo $i;?></td>
					<td><?php echo $value['Wards']['name'];?></td>
					<td align="center"> 
						<button type=""><a style="color: black" href="<?php echo $urlPlugins . 'admin/kiosk-admin-city-listWardsAdmin.php?idDistrict='.$_GET['idDistrict'].'&idCity='.$_GET['idCity'].'&idEdit='.$value['Wards']['id']?>">Sửa</a></button>
						<button type=""><a style="color: black" onclick="return confirm('Bạn có chắc chắn muốn xóa không?');" href="<?php echo $urlPlugins . 'admin/kiosk-admin-city-deleteWardsAdmin.php?idDistrict='.$_GET['idDistrict'].'&idCity='.$_GET['idCity'].'&idDelete='.$value['Wards']['id']?>">Xóa</a></button>
					</td>
				</tr>
				<?php 

			}
		}
		?>
	</table>
</div>
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
		echo ' <a href="' . $urlPage . $i . '">' . $i . '</a> ';
	}
	echo ' <a href="' . $urlPage . $next . '">Trang sau</a> ';

	echo 'Tổng số trang: ' . $totalPage;
	?>
</p>