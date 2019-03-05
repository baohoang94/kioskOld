<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">
	<div class="col-md-12 content">
		
		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="list-inline">
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_prev"><a href="/listCompany"> Danh sách công ty</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_prev"><a href="/listBranch?idCompany=<?php echo $_GET['idCompany'];?>"> Danh sách chi nhánh</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now">Danh sách khối phòng ban</li>
				</ul>

			</div>
<?php
if (!empty($_GET['mess'])&&$_GET['mess']==-2) {
	?>
<script type="text/javascript">
	alert('Xóa không thành công. Khối phòng ban quyền có tồn tại nhân viên');
</script>
<?php
}
?>
			<div class="main_list_p ">
				<div class="row">
					<div class="col-sm-12">
						<div class="table-responsive table1">
							<table class="table table-bordered">
								<tr>
									<td>
										<div class="add_p">
											<a href="/addPermission?idCompany=<?php echo $_GET['idCompany'];?>&idBranch=<?php echo $_GET['idBranch'];?>">Thêm khối phòng ban mới</a>
										</div>
									</td>
									<td>
										<form action="" method="GET">
											<input type="" name="idCompany" value="<?php echo @arrayMap($_GET['idCompany']);?>" class="hidden">
											<input type="" name="idBranch" value="<?php echo @arrayMap($_GET['idBranch']);?>" class="hidden">
											<table class="table table-bordered">
												<tr>
													<td>
														<input type="text" value="<?php echo @arrayMap($_GET['code']);?>" class="form-control" placeholder="Mã khối phòng ban" name="code">
													</td>
													<td>
														<input type="text" value="<?php echo @arrayMap($_GET['name']);?>" class="form-control" placeholder="Tên khối phòng ban" name="name">
													</td>
													<td>
														<input type="text" value="<?php echo @arrayMap($_GET['leader']);?>" class="form-control" placeholder="Tên trưởng khối phòng ban" name="leader">
													</td>
													<td>
														<input type="text" class="input_money form-control" value="<?php echo @arrayMap($_GET['numberStaff']);?>" class="form-control" placeholder="Số nhân viên" name="numberStaff">
													</td>
													<td>
														<button class="add_p1">Tìm kiếm</button>
													</td>
												</tr>
												
											</table>
										</form>
									</td>
								</tr>
							</table>
						</div>
					</div>

					<div class="col-sm-12">
						<div class="table-responsive table1">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th class="text_table">STT</th>
										<th class="text_table">Mã khối phòng ban</th>
										<th class="text_table">Tên khối phòng ban</th>
										<th class="text_table">Trưởng khối phòng ban</th>
										<th class="text_table">Số nhân viên</th>
										<th class="text_table">Hành động</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if(!empty($listData)){
										if (!isset($_GET['page'])) {
											$i=0;
										}
										elseif (isset($_GET['page'])&&$_GET['page']==1) {
											$i=0;
										}elseif (isset($_GET['page'])>=2)
										{
											$i=$_GET['page']*15-15;
										} 
										foreach($listData as $data){
											$i++;
											echo '<tr>
											<td class="text_table">'.$i.'</td>
											<td><a href="/listStaffCompany?idCompany='.$data['Permission']['idCompany'].'&idBranch='.$data['Permission']['idBranch'].'&idPermission='.$data['Permission']['id'].'">'.@$data['Permission']['code'].'</a></td>
											<td><a href="/listStaffCompany?idCompany='.$data['Permission']['idCompany'].'&idBranch='.$data['Permission']['idBranch'].'&idPermission='.$data['Permission']['id'].'">'.$data['Permission']['name'].'</a></td>
											<td>'.@$data['Permission']['leader'].'</td>
											<td class="text_table"><a href="/listStaffCompany?idCompany='.$data['Permission']['idCompany'].'&idBranch='.$data['Permission']['idBranch'].'&idPermission='.$data['Permission']['id'].'">'.$data['Permission']['numberStaff'].'</a></td>
											<td class="">
											<ul class="list-inline list_i" style="">
											<li><a href="/addPermission?id='.$data['Permission']['id'].'&idCompany='.$data['Permission']['idCompany'].'&idBranch='.$data['Permission']['idBranch'].'" title="Chỉnh sửa"><i class="fa fa-pencil" aria-hidden="true"></i></a></li> 
											<li><a href="/infoPermission?id='.$data['Permission']['id'].'&idCompany='.$data['Permission']['idCompany'].'&idBranch='.$data['Permission']['idBranch'].'" title="Chỉnh sửa"><i class="fa fa-eye" aria-hidden="true"></i></a></li>
											<li><a onclick="return confirm(\'Bạn có chắc chắn muốn khóa khối phòng ban không ?\')" href="/deletePermission?id='.$data['Permission']['id'].'&idCompany='.$data['Permission']['idCompany'].'&idBranch='.$data['Permission']['idBranch'].'" title="Xóa" class="bg_red"><i class="fa fa-trash-o" aria-hidden="true"></i></a></li>
											</ul>
											</td>
											</tr>';
										}
									}else{
										echo '<tr><td align="center" colspan="9">Chưa có dữ liệu</td></tr>';
									}
									?>
								</tbody>
							</table>
						</div>
						<div class=" text-center p_navigation" style="<?php if(($totalPage==1)||empty($listData)) echo'display: none;';?>">
							<nav aria-label="Page navigation">
								<ul class="pagination">
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
									?>
									<li class="<?php if($totalPage==1) echo'disabled';?>">
										<a href="<?php echo $urlPage . $back; ?>" aria-label="Previous">
											<span aria-hidden="true">«</span>
										</a>
									</li>
									<?php 
									for ($i = $startPage; $i <= $endPage; $i++) {
										if ($i != $page) {
											echo '	<li><a href="' . $urlPage . $i . '">' . $i . '</a></li>';
										} else {
											echo '<li class="active"><a href="' . $urlPage . $i . '">' . $i . '</a></li>';
										}
									}
									?>
									<li>
										<a href="<?php echo $urlPage . $next ?>" aria-label="Next">
											<span aria-hidden="true">»</span>
										</a>
									</li>
								</ul>
							</nav>
						</div>
					</div>
				</div>


			</div>
		</div>
	</div>

	<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>