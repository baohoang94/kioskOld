<link href="<?php echo $urlHomes . 'app/Plugin/kiosk/admin/style.css'; ?>" rel="stylesheet">

<?php
if(!empty($dataEdit)){
	$name='Chỉnh sửa lỗi';
}else{
	$name="Thêm lỗi mới";
}
$breadcrumb = array('name' => $name,
	'url' => $urlPlugins . 'admin/kiosk-admin-error-listErrorAdmin.php',
	'sub' => array('name' => '')
);
addBreadcrumbAdmin($breadcrumb);
?>
<form action="" method="POST">
	<input type="" name="id" class="hidden" value="<?php echo @$dataEdit['Errormachine']['id'];?>">
	<div class="row">
		<div class="col-sm-3">
			<label>Tên lỗi<span class="color_red">*</span>:</label>
			<input type="" name="name" class="form-control" required=""  value="<?php echo @arrayMap($dataEdit['Errormachine']['name']);?>">
		</div>
		<div class="col-sm-3">
			<label>Mã lỗi<span class="color_red">*</span>:</label>
			<input type="" name="code" class="form-control"  required="" pattern="([a-zA-Z0-9-]+)" title="Nhập mã không chứa nội dung khoảng trắng, ký tự có dấu. Chỉ sử dụng chữ cái (a-z. A-Z), số, dấu gạch ngang " maxlength="50" value="<?php echo @arrayMap($dataEdit['Errormachine']['code']);?>">
		</div>
		<div class="col-sm-3">
			<label>Nhóm lỗi<span class="color_red">*</span>:</label>
			<select name="errorCat" class="form-control" required="">
				<option value="">Lựa chọn nhóm lỗi</option>
				<?php 
				if(!empty($category)){
					foreach ($category['Option']['value']['allData'] as $key => $value) {
                    		# code...
						?>
						<option value="<?php echo $value['id'];?>" <?php if(!empty($dataEdit['Errormachine']['code'])&&$dataEdit['Errormachine']['errorCat']==$value['id']) echo'selected';?>><?php echo $value['name'];?></option>
						<?php 
					}
				}
				?>
			</select>
		</div>
		<div class="col-sm-3">
			<label>Đánh giá mức độ<span class="color_red">*</span>:</label>
			<input type="" name="evaluate" class="form-control" value="<?php echo @arrayMap($dataEdit['Errormachine']['evaluate']);?>" required="">
		</div>
		<div class="col-sm-12">
			<label>Mô tả:</label>
			<textarea type="" name="info" class="form-control" ><?php echo @arrayMap($dataEdit['Errormachine']['info']);?></textarea>
					</div>
		<div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center; margin-bottom: 15px; margin-top:15px;">
			<button type="submit"  class="btn btn-primary">Lưu</button>
		</form>
		<a href="<?php echo $urlPlugins.'admin/kiosk-admin-error-listErrorAdmin.php';?>"  class="btn btn-primary">Quay lại</a>
	</div>
</div>
 