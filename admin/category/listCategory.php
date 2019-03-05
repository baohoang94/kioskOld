<link href="<?php echo $urlHomes . 'app/Plugin/kiosk/admin/style.css'; ?>" rel="stylesheet">
<?php
$breadcrumb= array( 'name'=>'Danh sách ngành hàng',
	'url'=>$urlPlugins.'admin/kiosk-admin-category-listCategory.php',
	'sub'=>array('name'=>'Tất cả')
);
addBreadcrumbAdmin($breadcrumb);
?>    
<div class="thanhcongcu">
	<div class="congcu add_p2" data-toggle="modal" data-target="#myModal">
		<!-- <span>
			<input type="image"  src="<?php echo $webRoot;?>images/add.png" />
		</span>
		<br/> -->
		Thêm
	</div>

</div>
<?php
if (!empty($_GET['mess'])&&$_GET['mess']==-2) {
?>
<div class="col-sm-12" style="color:red">Xóa không thành công. Ngành hàng có tồn tại sản phẩm</div>

<?php
}
?><?php
if (!empty($_GET['mess'])&&$_GET['mess']==1) {
?>
<div class="col-sm-12" style="color:red">Lưu thông tin thành công</div>

<?php
}
?><?php
if (!empty($_GET['mess'])&&$_GET['mess']==2) {
?>
<div class="col-sm-12" style="color:red">Lưu thông tin thành công</div>
<?php
}
?><?php
if (!empty($_GET['mess'])&&$_GET['mess']==-3) {
?>
<div class="col-sm-12" style="color:red">Ngành hàng đã tồn tại</div>
<?php
}
?>
<!-- <form action="" method="get" accept-charset="utf-8">
	<div class="table-responsive table1">
		<table class="table table-bordered">
			<tr>
				<td>
					<div class="add_p">
						<div class="congcu" onclick="addDataNew();">
							<a href="javascript:void(0);">Thêm</a>
						</div>
					</div>
				</td>
				<td>
					<table class="table table-bordered">
						<tr>
							<td>
								<input type="text" class="form-control" placeholder="Mã danh mục" name="">
							</td>
							<td>
								<input type="text" class="form-control" placeholder="Tên danh mục" name="">
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
</form> -->
<div class="clear"></div>
<br />

<div class="taovien" >
	<form action="" method="post" name="listForm">
		<table id="listTable" cellspacing="0" class="tableList">

			<tr>
				<th align="center" width="50">STT</th>
				<th align="center" width="">Mã ngành hàng</th>
				<th align="center">Tên ngành hàng</th>
				<th align="center" width="165">Hành động </th>
			</tr>
			<?php
			if(!empty($listData['Option']['value']['allData'])){
				$i=0;
				foreach($listData['Option']['value']['allData'] as $components)
				{ 
					$i++;
					?>
					<tr id="trList<?php echo $components['id'];?>">
						<td align="center"><?php echo $i;?></td>
						<td align="center" ><?php echo $components['id'];?></td>
						<td height="40" id="name<?php echo $components['id'];?>"><?php echo $components['name'];?></td>
						<td align="center">
							<input class="input" type="button" value="Sửa" onclick="changeName('<?php echo $components['id'];?>','<?php echo $components['name'];?>');">
							&nbsp;
							<!-- <input class="input" type="button" value="Xóa" onclick="deleteData('<?php echo $components['id'];?>');"> -->
							<a href="<?php echo $urlPlugins.'admin/kiosk-admin-category-deleteCategory?id='.$components['id'] ?>" style="color:black"><input class="input" onclick='return confirm("Bạn có chắc chắn muốn xóa không ?")' type="button" value="Xóa"></a>
						</td>
					</tr>
					<?php 
				}
			}
			?>

		</table>
	</form>
</div>
<div class="modal fade" id="myModal" role="dialog" style="margin-top: 150px;">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Thêm ngành hàng</h4>
        </div>
        <div class="modal-body">
<form class="form-group" method="post" action="<?php echo $urlPlugins;?>admin/kiosk-admin-category-saveCategory.php">
		<input type="hidden" value="save" name="type" />
		<input type="hidden" value="1" name="redirect" />
		Mã ngành hàng<br />
		<input type='text' class="form-control" id='' name="idCat" value='' placeholder="Mã ngành hàng" /> <br>
		Tên ngành hàng<br />
		<input type='text' id='' class="form-control" name="name" value='' placeholder="Tên ngành hàng" /> <br>
		&nbsp;&nbsp;<input type='submit' value='Lưu' class='input' />
	</form>        </div>
        
      </div>
      
    </div>
  </div>
<div id="themData">
	    <div class="modal-dialog1">

	<form method="post" class="form-group" action="<?php echo $urlPlugins;?>admin/kiosk-admin-category-saveCategory.php">
		<input type="hidden" value="save" name="type" />
		<input type="hidden" value="edit" name="type2" />
		<input type="hidden" value="1" name="redirect" />
		<input type="hidden" name="idCat" id='idData' value="" ><!-- 
		Mã danh mục sản phẩm<br />
		<input type='text' class="form-control" disabled="" id='idData' name="" value='' /> <br> -->
		Tên ngành hàng<br />
		<input type='text' class="form-control" id='nameData' name="name" value='' />
		&nbsp;&nbsp;<input type='submit' value='Lưu' class='input' />
	</form>
</div>
</div>

<script type="text/javascript">
	var urlWeb="<?php echo $urlPlugins.'admin/kiosk-admin-category-saveCategory.php';?>";
	var urlW="<?php echo $urlPlugins.'admin/kiosk-admin-category-deleteCategory.php';?>";
	var urlNow="<?php echo $urlNow;?>";

	function changeName(id,name)
	{
		document.getElementById("idData").value= id;
		document.getElementById("nameData").value= name;
		$('#themData').lightbox_me({
			centered: true, 
			onLoad: function() { 
				$('#themData').find('input:first').focus()
			}
		});
	}
	
	function addDataNew()
	{
		document.getElementById("idData").value= '';
		document.getElementById("nameData").value= '';
		$('#themData').lightbox_me({
			centered: true, 
			onLoad: function() { 
				$('#themData').find('input:first').focus()
			}
		});
	}
	
	function deleteData(id)
	{
		var r= confirm("Bạn có chắc chắn muốn xóa không ?");
		if(r==true)
		{
			$.ajax({
				type: "POST",
				url: urlW,
				data: { id:id,type:'delete',redirect:0}
			})
			.done(function( msg ) { 	
				window.location= urlNow;	
			})
			.fail(function() {
				window.location= urlNow;
			});  
		}

	}
</script>
</div>