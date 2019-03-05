<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php global $metaTitleMantan; echo $metaTitleMantan;?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- 	<?php echo $urlThemeActive;?>
-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" media="all">
<link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/kiosk/view/manager'; ?>/css/style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<link href="https://fonts.googleapis.com/css?family=Comfortaa:300,400,700" rel="stylesheet">

<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBe23YIH_bS2jxaFHMnvalNLEbD93cUkUs"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<!-- <link rel="stylesheet" href="css/select2.min.css">
<script src="js/select2.min.js"></script> -->
</head>
<body>
	<style>
	header{
		background: #226a94;
	}
	.logo img{
		max-height: 56px;
	}
	.btn_ad{
		display: inline-block !important;
	}


</style>
<header>
	<div class="container">
		<div class="row">
			<div class="col-sm-2">
				<div class="logo">
					<a href="/dashboard"><img src="<?php echo $urlHomes . 'app/Plugin/kiosk/view/manager/'; ?>images/logo.png" class="img-responsive" alt=""></a>
				</div>
			</div>
			<?php
			global $urlNow;
			$s1=ltrim($urlNow,'http://');
			$s2=ltrim($s1,$infoSite['Option']['value']['domain']);
			?>
			<div class="col-sm-10">
				<div id='cssmenu'>
					<ul class="list-inline text-center">
						<li class='<?php if($s2=='/listMachine'||$s2=='/addMachine'||strlen(strstr($s2, 'addMachine'))>0||strlen(strstr($s2, 'infoMachine'))>0||strlen(strstr($s2, 'structureMachine'))>0||strlen(strstr($s2, 'addTrench'))>0||strlen(strstr($s2, 'settingFloorMachine'))>0||strlen(strstr($s2, 'infoTrench'))>0||strlen(strstr($s2, 'addPlace'))>0||strlen(strstr($s2, 'infoPlace'))>0||strlen(strstr($s2, 'addErrorMachine'))>0||$s2=='/listPlace'||$s2=='/addPlace'||$s2=='/listMachineError'||$s2=='/addErrorMachine'||$s2=='/listErrorMachine') echo'active';?> has-sub'><a href='#'>Máy Kiosk</a>
							<ul>
								<li class=''><a href='/listMachine'>Danh sách máy</a></li>
								<li class=''><a href='/listPlace'>Danh sách điểm đặt</a></li>
								<li class=''><a href='/listMachineError'>Danh sách máy lỗi</a></li>
								<li class=''><a href='/listErrorMachine'>Danh sách lỗi</a></li>
							</ul>
						</li>
						<li class='has-sub <?php if($s2=='/listTransfer'||$s2=='/listCollection'||$s2=='/transactionWhitCoupon'||$s2=='/transactionWhitCash'||$s2=='/transactionWhitQRViettin'||$s2=='/machinesTransfer'||$s2=='/listProductByMachine'||$s2=='/syncTransfer') echo'active';?>'><a href='#'>Tra cứu</a>
							<ul>
								<li class=''><a href='/listTransfer'>Lịch sử giao dịch mua hàng</a></li>
								<li class=''><a href='/listCollection'>Lịch sử thu tiền tại máy</a></li>
								<li class=''><a href='/listProductByMachine'>Tra cứu sản phẩm theo máy</a></li>
								<!--
								<li class=''><a href='/transactionWhitCoupon'>Lịch sử giao dịch Coupon</a></li>
								<li class=''><a href='/transactionWhitCash'>Lịch sử giao dịch tiền mặt</a></li>
								<li class=''><a href='/transactionWhitQRViettin'>Lịch sử giao dịch QR VietinBank</a></li> -->
								<li class=''><a href='/machinesTransfer'>Tra cứu máy không có giao dịch</a></li>
								<li class=''><a href='/syncTransfer'>Đối soát dữ liệu</a></li>

							</ul>
						</li>
						<li class='has-sub <?php if($s2=='/listProduct'||$s2=='/addProduct'||strlen(strstr($s2, 'addProduct'))>0||strlen(strstr($s2, 'infoCoupon'))>0||strlen(strstr($s2, 'infoProduct'))>0||strlen(strstr($s2, 'addCoupon'))>0||$s2=='/listCoupon'||$s2=='/addCoupon') echo'active';?>'><a href='#'>Quản lý bán hàng</a>
							<ul>
								<li class=''><a href='/listProduct'>Danh sách sản phẩm</a></li>
								<li class=''><a href='/listCoupon'>Danh sách mã coupon</a></li>
								<li class=''><a href='/listSale'>Danh sách khuyến mại</a></li>
							</ul>
						</li>
						<li class='has-sub <?php if($s2=='/listCompany'||strlen(strstr($s2, 'addCompany'))>0||strlen(strstr($s2, 'infoBranch?idCompany'))>0||strlen(strstr($s2, 'infoPermission?id='))>0||strlen(strstr($s2, 'infoStaffCom?id='))>0||strlen(strstr($s2, 'infoStaffCompany?id='))>0||strlen(strstr($s2, 'viewCompany'))>0||strlen(strstr($s2, 'listBranch?idCompany'))>0||strlen(strstr($s2, 'addBranch?idCompany'))>0||strlen(strstr($s2, 'addPermission?id'))>0||strlen(strstr($s2, 'listStaffCompany?id'))>0||strlen(strstr($s2, 'addStaffCompany'))>0||strlen(strstr($s2, 'permissionStaff'))>0||strlen(strstr($s2, 'informationStaff'))>0||strlen(strstr($s2, 'groupPermission'))>0||$s2=='/addCompany'||$s2=='/listAllStaff') echo'active';?>' ><a href='#'>Quản lý nhân viên</a>
							<ul>
								<li class=''><a href='/listCompany'>Danh sách công ty</a></li>
								<li class=''><a href='/listAllStaff'>Danh sách nhân viên</a></li>
							</ul>
						</li>
						<li class='has-sub <?php if($s2=='/listReportBySuppliers'||$s2=='/listReportBySuppliersOrderProduct'||$s2=='/listReportTotalSalesByPlace'||$s2=='/listReportMachineByProvince'||$s2=='/listReportMachineByPlace'||$s2=='/listRevenueByBranch'||$s2=='/listRevenueByBranch'||$s2=='/listRevenueByBranchOrderSupplier'||$s2=='/lisstReportRevenueByPlaceOnDay' ||$s2=='/listRevenueByCash'||$s2=='/listRevenueByCard') echo'active';?>'><a href='#'>Báo cáo</a>
							<ul>
								<li class=''><a href='/listReportBySuppliers'>01: BC bán hàng theo nhà cung cấp</a></li>
								<li class=''><a href='/listReportBySuppliersOrderProduct'>02: BC bán hàng NCC theo sản phẩm</a></li>
								<li class=''><a href='/listReportTotalSalesByPlace'>03: BC bán hàng theo điểm đặt máy</a></li>
								<li class=''><a href='/listReportMachineByProvince'>04: BC phân bố máy theo tỉnh</a></li>
								<li class=''><a href='/listReportMachineByPlace'>05: BC phân bố máy theo điểm đặt</a></li>
								<li class=''><a href='/listRevenueByBranch'>06: BC bán hàng theo chi nhánh</a></li>
							<!-- 	<li class=''><a href='/listRevenueByBranchOrderSupplier'>BC doanh thu các chi nhánh theo nhà cung cấp </a></li> -->
								<li class=''><a href='/lisstReportRevenueByPlaceOnDay'>07: Tổng hợp doanh thu theo điểm bán</a></li>

								<li class=''><a href='/listRevenueByCash'>08: Tổng hợp doanh thu tiền mặt</a></li>
								<li class=''><a href='/listRevenueByCard'>09: Tổng hợp doanh thu thẻ</a></li>
							</ul>
						</li>
						<li class='has-sub <?php if($s2=='/testEverything') echo'active';?>'><a href='#'>Test</a>
							<ul>
								<li class=''><a href='/testEverything'>Test cac thu</a></li>

							</ul>
						</li>
						<li class='has-sub'><a href='#'>Quản lý giá</a>
							<ul>
								<li class=''><a href='/priceTransport'>Quản lý chi phí vận chuyển</a></li>
								<li class=''><a href='/priceManage'>Quản lý giá nhập sản phẩm</a></li>
								<li class=''><a href='/reportByMachine'>Báo cáo doanh thu theo máy</a></li>
								<li class=''><a href='/reportRevenue2Year'>Báo cáo doanh thu 2 năm</a></li>
							</ul>
						</li>
						<li class='has-sub <?php if($s2=='/infoStaff') echo'active';?>'><a href='#'>Tài khoản</a>
							<ul>
								<li class=''><a href='/infoStaff'>Thông tin tài khoản</a></li>
								<li class=''><a href='/logout'>Đăng xuất</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</header>



<script src="<?php echo $urlHomes . 'app/Plugin/kiosk/view/manager'; ?>/js/script.js"></script>
