<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<style type="text/css">
@-webkit-keyframes {
  from {
    -webkit-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  to {
    -webkit-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes rotating {
  from {
    -ms-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -webkit-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  to {
    -ms-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -webkit-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
.rotating {
  -webkit-animation: rotating 1.5s linear infinite;
  -moz-animation: rotating 1.5s linear infinite;
  -ms-animation: rotating 1.5s linear infinite;
  -o-animation: rotating 1.5s linear infinite;
  animation: rotating 1.5s linear infinite;
}
.preloading {
    overflow: hidden;
}
.preload-container {
    width: 100%;
    height: 100%;
    background: #226a94;
    position: fixed;
    top: 0;
    bottom: 0;
    right: 0;
    left: 0;
    z-index: 99999999999;
    display: block;
    padding-right: 17px;
    overflow-x: hidden;
    overflow-y: auto;
    color: #fff;
}
.preload-icon {
    font-size: 66px;
    color: orange;
    margin-top: 20%;
}
</style>
<div id="preload" class="preload-container text-center">
	<h1>Đang xử lý...</h1>
	<span class="glyphicon glyphicon-repeat preload-icon rotating"></span>
	<h3>Vui lòng chờ...</h3>
</div>
<script type="text/javascript">
    $(window).load(function() {
        $('.container-fluid').removeClass('preloading');
        $('#preload').delay(1000).fadeOut('fast');
    });
</script>
<div class="container-fluid main-container preloading">

	<div class="col-md-12 content">

		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="list-inline">
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now">
						Tổng hợp doanh thu 2 năm
					</li>
				</ul>
			</div>
			<form method="post">
				<button class="btn btn-primary" type="submit" name="inport">Xuất file excel</button>
			</form>
			<div class="main_list_p ">
				<div class="row">
					<div class="col-sm-12">
						<div class="table-responsive table1">
							
						</div>
					</div>
					<div class="col-sm-12">
						<div class="table-responsive table1">
							<table class="table table-bordered table-hover">
								<caption>Tổng hợp doanh thu năm <?php echo $curYear; ?></caption>
								<thead>
									<tr>
										<th class="text_table"></th>
										<th class="text_table">Tháng 1</th>
										<th class="text_table">Tháng 2</th>
										<th class="text_table">Tháng 3</th>
										<th class="text_table">Tháng 4</th>
										<th class="text_table">Tháng 5</th>
										<th class="text_table">Tháng 6</th>
										<th class="text_table">Tháng 7</th>
										<th class="text_table">Tháng 8</th>
										<th class="text_table">Tháng 9</th>
										<th class="text_table">Tháng 10</th>
										<th class="text_table">Tháng 11</th>
										<th class="text_table">Tháng 12</th>
										<th class="text_table">Tổng cộng</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<!-- <td>Số lượng bán ra</td> -->
								<?php 
									if(!empty($data["quantity$curYear"])) {
										foreach ($data["quantity$curYear"] as $key => &$value) {
											echo '<td>';
											if (is_numeric($value)) {
												echo number_format($value);
											} else {
												echo $value;
											}
											echo '</td>';
										}
									}
								?>
									</tr>
									<tr>
										<?php 
											if(!empty($data["money$curYear"])) {
												foreach ($data["money$curYear"] as $key => &$value) {
													echo '<td>';
													if (is_numeric($value)) {
														echo number_format($value);
													} else {
														echo $value;
													}
													echo '</td>';
												}
											}
										?>
									</tr>
									<tr>
										<!-- <td>Doanh thu</td> -->
										<?php 
											if(!empty($data["revenue$curYear"])) {
												foreach ($data["revenue$curYear"] as $key => &$value) {
													echo '<td>';
													if (is_numeric($value)) {
														echo number_format($value);
													} else {
														echo $value;
													}
													echo '</td>';
												}
											}
										?>
									</tr>
									<tr>
										<!-- <td>Giá vốn</td> -->
										<?php 
											if(!empty($data["capital$curYear"])) {
												foreach ($data["capital$curYear"] as $key => &$value) {
													echo '<td>';
													if (is_numeric($value)) {
														echo number_format($value);
													} else {
														echo $value;
													}
													echo '</td>';
												}
											}
										?>
									</tr>
									<tr>
										<!-- <td>Lợi nhuận</td> -->
										<?php 
											if(!empty($data["profit$curYear"])) {
												foreach ($data["profit$curYear"] as $key => &$value) {
													echo '<td>';
													if (is_numeric($value)) {
														echo number_format($value);
													} else {
														echo $value;
													}
													echo '</td>';
												}
											}
										?>
									</tr>
									<tr>
										<!-- <td>Tỉ lệ lợi nhuận</td> -->
										<?php 
											if(!empty($data["profitRate$curYear"])) {
												foreach ($data["profitRate$curYear"] as $key => &$value) {
													echo '<td>';
													if (is_numeric($value)) {
														echo number_format($value);
													} else {
														echo $value;
													}
													echo ' %</td>';
												}
											}
										?>
									</tr>
								</tbody>
							</table>
							<table class="table table-bordered table-hover">
								<caption>Tổng hợp doanh thu năm <?php echo $preYear; ?></caption>
								<thead>
									<tr>
										<th class="text_table"></th>
										<th class="text_table">Tháng 1</th>
										<th class="text_table">Tháng 2</th>
										<th class="text_table">Tháng 3</th>
										<th class="text_table">Tháng 4</th>
										<th class="text_table">Tháng 5</th>
										<th class="text_table">Tháng 6</th>
										<th class="text_table">Tháng 7</th>
										<th class="text_table">Tháng 8</th>
										<th class="text_table">Tháng 9</th>
										<th class="text_table">Tháng 10</th>
										<th class="text_table">Tháng 11</th>
										<th class="text_table">Tháng 12</th>
										<th class="text_table">Tổng cộng</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<?php 
											if(!empty($data["quantity$preYear"])) {
												foreach ($data["quantity$preYear"] as $key => &$value) {
													echo '<td>';
													if (is_numeric($value)) {
														echo number_format($value);
													} else {
														echo $value;
													}
													echo '</td>';
												}
											}
										?>
									</tr>
									<tr>
										<!-- <td>Doanh số</td> -->
										<?php 
											if(!empty($data["money$preYear"])) {
												foreach ($data["money$preYear"] as $key => &$value) {
													echo '<td>';
													if (is_numeric($value)) {
														echo number_format($value);
													} else {
														echo $value;
													}
													echo '</td>';
												}
											}
										?>
									</tr>
									<tr>
										<!-- <td>Doanh thu</td> -->
										<?php 
											if(!empty($data["revenue$preYear"])) {
												foreach ($data["revenue$preYear"] as $key => &$value) {
													echo '<td>';
													if (is_numeric($value)) {
														echo number_format($value);
													} else {
														echo $value;
													}
													echo '</td>';
												}
											}
										?>
									</tr>
									<tr>
										<!-- <td>Giá vốn</td> -->
										<?php 
											if(!empty($data["capital$preYear"])) {
												foreach ($data["capital$preYear"] as $key => &$value) {
													echo '<td>';
													if (is_numeric($value)) {
														echo number_format($value);
													} else {
														echo $value;
													}
													echo '</td>';
												}
											}
										?>
									</tr>
									<tr>
										<!-- <td>Lợi nhuận</td> -->
										<?php 
											if(!empty($data["profit$preYear"])) {
												foreach ($data["profit$preYear"] as $key => &$value) {
													echo '<td>';
													if (is_numeric($value)) {
														echo number_format($value);
													} else {
														echo $value;
													}
													echo '</td>';
												}
											}
										?>
									</tr>
									<tr>
										<!-- <td>Tỉ lệ lợi nhuận</td> -->
										<?php 
											if(!empty($data["profitRate$preYear"])) {
												foreach ($data["profitRate$preYear"] as $key => &$value) {
													echo '<td>';
													if (is_numeric($value)) {
														echo number_format($value);
													} else {
														echo $value;
													}
													echo ' %</td>';
												}
											}
										?>
									</tr>
								</tbody>
							</table>
							<table class="table table-bordered table-hover">
								<caption>Chênh lệch</caption>
								<thead>
									<tr>
										<th class="text_table"></th>
										<th class="text_table">Tháng 1</th>
										<th class="text_table">Tháng 2</th>
										<th class="text_table">Tháng 3</th>
										<th class="text_table">Tháng 4</th>
										<th class="text_table">Tháng 5</th>
										<th class="text_table">Tháng 6</th>
										<th class="text_table">Tháng 7</th>
										<th class="text_table">Tháng 8</th>
										<th class="text_table">Tháng 9</th>
										<th class="text_table">Tháng 10</th>
										<th class="text_table">Tháng 11</th>
										<th class="text_table">Tháng 12</th>
										<th class="text_table">Tổng cộng</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<!-- <td>Số lượng bán ra</td> -->
										<?php 
											if(!empty($data['quantityDifference'])) {
												foreach ($data['quantityDifference'] as $key => &$value) {
													echo '<td>';
													if (is_numeric($value)) {
														echo number_format($value);
													} else {
														echo $value;
													}
													echo '</td>';
												}
											}
										?>
									</tr>
									<tr>
										<!-- <td>Doanh số</td> -->
										<?php 
											if(!empty($data['moneyDifference'])) {
												foreach ($data['moneyDifference'] as $key => &$value) {
													echo '<td>';
													if (is_numeric($value)) {
														echo number_format($value);
													} else {
														echo $value;
													}
													echo '</td>';
												}
											}
										?>
									</tr>
									<tr>
										<!-- <td>Doanh thu</td> -->
										<?php 
											if(!empty($data['revenueDifference'])) {
												foreach ($data['revenueDifference'] as $key => &$value) {
													echo '<td>';
													if (is_numeric($value)) {
														echo number_format($value);
													} else {
														echo $value;
													}
													echo '</td>';
												}
											}
										?>
									</tr>
									<tr>
										<!-- <td>Giá vốn</td> -->
										<?php 
											if(!empty($data['capitalDifference'])) {
												foreach ($data['capitalDifference'] as $key => &$value) {
													echo '<td>';
													if (is_numeric($value)) {
														echo number_format($value);
													} else {
														echo $value;
													}
													echo '</td>';
												}
											}
										?>
									</tr>
									<tr>
										<!-- <td>Lợi nhuận</td> -->
										<?php 
											if(!empty($data['profitDifference'])) {
												foreach ($data['profitDifference'] as $key => &$value) {
													echo '<td>';
													if (is_numeric($value)) {
														echo number_format($value);
													} else {
														echo $value;
													}
													echo '</td>';
												}
											}
										?>
									</tr>
									<tr>
										<!-- <td>Tỉ lệ lợi nhuận</td> -->
										<?php 
											if(!empty($data['profitRateDifference'])) {
												foreach ($data['profitRateDifference'] as $key => &$value) {
													echo '<td>';
													if (is_numeric($value)) {
														echo number_format($value);
													} else {
														echo $value;
													}
													echo ' %</td>';
												}
											}
										?>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>
