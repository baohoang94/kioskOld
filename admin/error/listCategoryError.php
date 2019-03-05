<link href="<?php echo $urlHomes . 'app/Plugin/kiosk/admin/style.css'; ?>" rel="stylesheet">
<?php
$breadcrumb = array('name' => 'Nhóm lỗi',
	'url' => $urlPlugins . 'admin/kiosk-admin-error-listCategoryError.php',
	'sub' => array('name' => '')
);
addBreadcrumbAdmin($breadcrumb);
?>
<!-- <form action="" method="get" accept-charset="utf-8">
	<div class="table-responsive table1">
		<table class="table table-bordered">
			<tr>
				<td>
					<input type="text" class="form-control" placeholder="Tên nhóm" name="">
				</td>
				<td rowspan="3">
					<button class="add_p1">Tìm kiếm</button>
				</td>
			</tr>
		</table>
	</div>
</form> -->



<form action="" method="POST">
	<div class="row">
		<input type="" name="id" class="hidden" value="<?php echo @$dataEdit['id'];?>">
		<div class="col-sm-6">
			<label>Tên nhóm: </label>
			<input type="" name="name" required="" class="form-control" value="<?php echo @arrayMap($dataEdit['name']);?>">
		</div>
		<div class="col-sm-6">
			<label></label>
			<button type="submit"  class="btn btn-primary" style="margin-top: 22px">Lưu</button>
		</div>
	</div>
</form>
<br>
<table id=""  class="table_hy table-bordered">
	<tr>
		<th class="text_table">STT</th>
		<th class="text_table">Tên nhóm</th>
		<th class="text_table">Hành động</th>
	</tr>
	<?php 
	if(!empty($listData)){
		$i=0;
		foreach ($listData['Option']['value']['allData'] as $key => $value) {
			$i++;
				# code...
			?>
			<tr>
				<td class="text_table"><?php echo $i;?></td>
				<td><?php echo $value['name'];?></td>
				<td align="center">
					<button type=""><a style="color: black" href="<?php echo  $urlPlugins . 'admin/kiosk-admin-error-listCategoryError.php?idEdit='.$value['id'];?>">Sửa</a></button>
					<button type=""><a style="color: black" onclick="return confirm('Bạn có chắc chắn muốn xóa không ?');" href="<?php echo  $urlPlugins . 'admin/kiosk-admin-error-deleteCategoryError.php?id='.$value['id'];?>">Xóa</a></button>
				</td>
			</tr>
			<?php 
		}
	}
	?>
</table>
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