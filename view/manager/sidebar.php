
<div class="sidebar_dt">
	<ul class="list-unstyled menu_sibar1"> 
		<li class="has_sub_dt"><a href="javascript:void(0);"><i class="fa fa-briefcase" aria-hidden="true"></i> Máy Kiosk</a>
			<ul class=" menu_sub_dt">
				<li><a href="listDevice.php">Danh sách máy</a></li>
				<li><a href="listDevice.php">Danh sách máy lỗi</a></li>
				<li><a href="listPoint.php">Danh sách điểm đặt</a></li>
			</ul>
		</li>
		<li class="has_sub_dt"><a href="javascript:void(0);"><i class="fa fa-briefcase" aria-hidden="true"></i> Quản lí bán hàng</a>
			<ul class=" menu_sub_dt">
				<li><a href="listProduct.php">Danh sách sản phẩm</a></li>
			</ul>
		</li>
		<li class="has_sub_dt"><a href="javascript:void(0);"><i class="fa fa-briefcase" aria-hidden="true"></i> Quản lí nhân viên</a>
			<ul class=" menu_sub_dt">
				<li><a href="listPersonel.php">Danh sách nhân viên</a></li>
			</ul>
		</li>
		<li class="has_sub_dt"><a href="javascript:void(0);"><i class="fa fa-briefcase" aria-hidden="true"></i> Phân quyền</a>
			<ul class=" menu_sub_dt">
				<li><a href="listBranch.php">Quản lí phân quyền</a></li>
			</ul>
		</li>
		<li class="has_sub_dt"><a href="javascript:void(0);"><i class="fa fa-cog" aria-hidden="true"></i> Báo cáo</a>
			<ul class=" menu_sub_dt">
				<li><a href="reportPayLive.php">Thanh toán trực tiếp</a></li>
				<li><a href="reportPayElectronic.php">Thanh toán qua ví điện tử</a></li>
				<li><a href="reportHistoryOrder.php">Lịch sử mua hàng</a></li>
				<li><a href="reportPayMoney.php">Lịch sử giao dịch thu tiền</a></li>
				<li><a href="reportListProduct.php">Danh sách máy lỗi</a></li>
				<li><a href="reportListError.php">Danh sách lỗi</a></li>
			</ul>
		</li>
		
		<li class="has_sub_dt"><a href="javascript:void(0);"><i class="fa fa-cog" aria-hidden="true"></i> Tài khoản</a>
			<ul class=" menu_sub_dt">
				<li><a href="account.php">Thông tin tài khoản</a></li>
				<li><a href="login.php">Đăng xuất</a></li>
			</ul>
		</li>
	</ul>
</div>

<script type="text/javascript">

	$(document).ready(function() {
		var dem =0;
		// $('.menu_sub_dt').hide();
		$('.has_sub_dt').click(function(){
			// dem++;
			// if(dem %2 !=0){
			// 	$(this).find('.menu_sub_dt').slideDown();
			// } else {
			// 	$(this).find('.menu_sub_dt').slideUp();
			// }
			$(this).find('.menu_sub_dt').slideToggle();
		});
	});
</script>
