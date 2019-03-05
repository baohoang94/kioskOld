<link href="<?php echo $urlHomes . 'app/Plugin/kiosk/admin/style.css'; ?>" rel="stylesheet">
<?php
$breadcrumb = array('name' => 'Danh sách lỗi',
	'url' => $urlPlugins . 'admin/kiosk-admin-error-listErrorAdmin.php',
	'sub' => array('name' => '')
);
addBreadcrumbAdmin($breadcrumb);
?>
<!-- <a style="padding: 4px 8px;" href="<?php echo $urlPlugins . 'admin/kiosk-admin-error-addErrorAdmin.php'; ?>" class="input">
	<img src="<?php echo $webRoot; ?>images/add.png">Thêm
</a> -->

<form action="" method="get" accept-charset="utf-8">
	<div class="table-responsive table1">
		<table class="table table-bordered">
			<tr>
				<td>
					<div class="add_p">
						<a href="<?php echo $urlPlugins . 'admin/kiosk-admin-error-addErrorAdmin.php'; ?>">Thêm</a>
					</div>
				</td>
				<td>
					<table class="table table-bordered">
						<tr>
							<td>
								<input type="text" class="form-control" placeholder="Mã lỗi" name="code"  value="<?php echo @$_GET['code']?>">
							</td>
							<td>
								<input type="text" class="form-control" placeholder="Tên lỗi" name="name"  value="<?php echo @$_GET['name']?>">
							</td>
							<td>
								<input type="text" class="form-control" placeholder="Đánh giá mức độ" name="evaluate" value="<?php echo @$_GET['evaluate']?>">
							</td>
							<td>
								<select name="category" class="form-control">
									<option value="">Nhóm lỗi</option>
									<?
										if(!empty($category)){
											foreach ($category['Option']['value']['allData'] as $key => $value) {
												# code...
												?>
												<option value="<?php echo $value['id'];?>" <?php if(!empty($_GET['category'])&&$_GET['category']==$value['id'])echo'selected';?>><?php echo $value['name'];?></option>
												<?php 
											}
										}
									?>
								</select>
							</td>
							<td rowspan="3">
								<button class="add_p1">Tìm kiếm</button>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
</form>
<table id=""  class="table_hy table-bordered">
	<tr>
		<th class="text_table">STT</th>
		<th class="text_table">Tên lỗi</th>
		<th class="text_table">Mã lỗi</th>
		<th class="text_table">Nhóm lỗi</th>
		<th class="text_table">Đánh giá mức độ</th>
		<th class="text_table">Hành động</th>
	</tr>
	<?php if(!empty($listData)){
		$i=$limit*($page-1);
		foreach ($listData as $key => $value) {
			$i++;
			# code...
			?>
			<tr>
				<tr>
					<td class="text_table"><?php echo $i;?></td>
					<td><?php echo $value['Errormachine']['name'];?></td>
					<td><?php echo $value['Errormachine']['code'];?></td>
					<td><?php if(!empty($value['Errormachine']['errorCat'])) echo @$category['Option']['value']['allData'][$value['Errormachine']['errorCat']]['name'];?></td>
					<td><?php echo @$value['Errormachine']['evaluate'];?></td>
					<td align="center">
						<button type=""><a style="color: black" href="<?php echo $urlPlugins . 'admin/kiosk-admin-error-addErrorAdmin.php?idEdit='.$value['Errormachine']['id']; ?>">Sửa</a></button>
						<button type=""><a style="color: black" onclick="return confirm('Bạn có chắc chắn muốn xóa không ?');" href="<?php echo $urlPlugins . 'admin/kiosk-admin-error-deleteErrorMachineAdmin.php?id='.$value['Errormachine']['id']; ?>">Xóa</a></button>
					</td>
				</tr>
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