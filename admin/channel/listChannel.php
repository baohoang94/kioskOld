<link href="<?php echo $urlHomes . 'app/Plugin/kiosk/admin/style.css'; ?>" rel="stylesheet">
<?php
$breadcrumb= array( 'name'=>'Danh sách kênh bán hàng',
	'url'=>$urlPlugins.'admin/kiosk-admin-channel-listChannel.php',
	'sub'=>array('name'=>'Tất cả')
);
addBreadcrumbAdmin($breadcrumb);
?>    
<div class="thanhcongcu">
	<div class="congcu add_p2" onclick="addDataNew();">
		<!-- <span>
			<input type="image"  src="<?php echo $webRoot;?>images/add.png" />
		</span>
		<br/> -->
		Thêm
	</div>

</div>
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
								<input type="text" class="form-control" placeholder="Mã kênh" name="">
							</td>
							<td>
								<input type="text" class="form-control" placeholder="Tên kênh" name="">
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


<div class="clear"></div>
<br /> -->

<div class="taovien" >
	<form action="" method="post" name="listForm">
		<table id="listTable" cellspacing="0" class="tableList">

			<tr>
				<th align="center"  width="50">STT</th>
				<!-- <td align="center" width="30">ID</td> -->
				<th align="center">Tên kênh bán hàng</th>
				<th align="center" width="165">Hành động</th>
			</tr>
			<?php
			if(!empty($listData['Option']['value']['allData'])){
				$i=0;
				foreach($listData['Option']['value']['allData'] as $components)
				{ 
					$i++;
					?>

					<tr id="trList<?php echo $components['id'];?>">
						<td align="center"> <?php echo $i;?></td>
						<!-- <td align="center" ><?php echo $components['id'];?></td> -->
						<td height="40" id="name<?php echo $components['id'];?>"><?php echo $components['name'];?></td>
						<td align="center">
							<input class="input" type="button" value="Sửa" onclick="changeName(<?php echo $components['id'];?>,'<?php echo $components['name'];?>');">
							&nbsp;
							<input class="input" type="button" value="Xóa" onclick="deleteData('<?php echo $components['id'];?>');">
						</td>
					</tr>
					<?php 
				}
			}
			?>

		</table>
	</form>
</div>
<div id="themData">
	<div class="modal-dialog1">
		<div class="modal-header1">
			<!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
			<!-- <h4 class="modal-title">Kênh phân phối</h4> -->
		</div>
		<form method="post" class="form-group" action="<?php echo $urlPlugins;?>admin/kiosk-admin-channel-saveChannel.php">
			<input type="hidden" value="" name="id" id="idData" />
			<input type="hidden" value="save" name="type" />
			<input type="hidden" value="1" name="redirect" />
			Tên kênh bán hàng<br /><br />
			<input type='text' id='nameData' class="" name="name" value='' />
			&nbsp;&nbsp;<input type='submit' value='Lưu' class='input' />
		</form>
	</div>
</div>

<script type="text/javascript">
	var urlWeb="<?php echo $urlPlugins.'admin/kiosk-admin-channel-saveChannel.php';?>";
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
				url: urlWeb,
				data: { id:id,type:'delete',redirect:0}
			}).done(function( msg ) { 	
				window.location= urlNow;	
			})
			.fail(function() {
				window.location= urlNow;
			});  
		}

	}
</script>
</div>