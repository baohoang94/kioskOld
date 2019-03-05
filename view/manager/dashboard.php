﻿<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>

<link rel="stylesheet" type="text/css" href="<?php echo $urlHomes . 'app/Plugin/kiosk/view/manager/'; ?>css/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="<?php echo $urlHomes . 'app/Plugin/kiosk/view/manager/'; ?>css/owl.theme.css">
<script src="<?php echo $urlHomes . 'app/Plugin/kiosk/view/manager/'; ?>js/owl.carousel.js"></script>


<style type="text/css" media="screen">
.banner_in{
	height: 800px;
	overflow: hidden;
	position: relative;
}
.owl-prev {
	position: absolute;
	top: 25%;
	left: 0;
}
.owl-next {
	position: absolute;
	top: 25%;
	right: 0;
}
.owl-prev::after {
	display: block;
	content: '\f104';
	font-family: FontAwesome;
}
.owl-next::after {
	display: block;
	content: '\f105';
	font-family: FontAwesome;
}
</style>

<div class="container-fluid main-container">


	<div class="col-md-12 content">
		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="list-inline">
					<li class="page_now"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</li>
				</ul>

			</div>
			<div class="banner_in">
				<div id="owl-demo" class="owl-carousel">

					<div class="item"><img src="<?php echo $urlHomes . 'app/Plugin/kiosk/view/manager/'; ?>images/bg.png" alt=""></div>
					<div class="item"><img src="<?php echo $urlHomes . 'app/Plugin/kiosk/view/manager/'; ?>images/1.jpg" alt=""></div>
					<div class="item"><img src="<?php echo $urlHomes . 'app/Plugin/kiosk/view/manager/'; ?>images/3.jpg" alt=""></div>
					
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		$("#owl-demo").owlCarousel({

			navigation : true,
			slideSpeed : 300,
			paginationSpeed : 400,
			singleItem : true,
			autoPlay: true
		});
	});
</script>

<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>
