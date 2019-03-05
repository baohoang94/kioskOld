<!-- <footer class="pull-left footer">
</footer>
</div>
-->

<script src="https://www.jqueryscript.net/demo/Easy-jQuery-Input-Mask-Plugin-inputmask/dist/jquery.inputmask.bundle.min.js"></script>

<script src="<?php echo $urlHomes . 'app/Plugin/kiosk/view/manager'; ?>/js/ace-elements.min.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/kiosk/view/manager'; ?>/js/number-divider.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/kiosk/view/manager'; ?>/js/ace.min.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/kiosk/view/manager'; ?>/js/jquery.maskedinput.min.js"></script>


<link rel="stylesheet" type="text/css" href="<?php echo $urlHomes . 'app/Plugin/kiosk/view/manager'; ?>/css/jquery.datetimepicker.css"/>
<script src="<?php echo $urlHomes . 'app/Plugin/kiosk/view/manager'; ?>/js/jquery.datetimepicker.full.js"></script>


<script type="text/javascript">
	$(function () {
		$('.navbar-toggle-sidebar').click(function () {
			$('.navbar-nav').toggleClass('slide-in');
			$('.side-body').toggleClass('body-slide-in');
			$('#search').removeClass('in').addClass('collapse').slideUp(200);
		});

		$('#search-trigger').click(function () {
			$('.navbar-nav').removeClass('slide-in');
			$('.side-body').removeClass('body-slide-in');
			$('.search-input').focus();
		});
	});
</script>

<!-- <script type="text/javascript">
	jQuery(function ($) {
		$('.input-mask-date').mask('99/99/9999', {placeholder: "dd/mm/yyyy"});
	});
</script> -->


<script>
	$(document).ready(function(){
		$("input.input_date").inputmask();
		$("input.input-mask-date").inputmask();

		// $('.input_money').numbertor({
		// 	allowEmpty: true
		// });
		$('.input_money').divide({delimiter: '.',
			divideThousand: true});

		$('.input_money').on('paste', function () {
			var element = this;
			var text = $(element).val();
			if(!isNaN(text)){
				$(element).val("");
				console.log('Phải nhập số');
			}
		});


	});
</script>

<script>
	StartDate = '2000/03/01';

	$.datetimepicker.setLocale('vi');
	$('.datetimepicker').datetimepicker({
		dayOfWeekStart : 1,
		
		disabledDates:['1986/01/08','1986/01/09','1986/01/10'],
		format:'d/m/Y H:i:s',
		// startDate:	'2018/01/08',

		lang: 'vi',
		// minDate: new Date()
		minDate: StartDate

	});





	$( "input.datetimepicker" ).attr("pattern", '([0-3][0-9])\/([0-1][0-9])\/([0-2][0-9]{3})[ ]([0-5][0-9])\:([0-5][0-9])\:([0-5][0-9])');
	$( "input.datetimepicker" ).attr("title", 'Nhập đúng định dạng dd/mm/yyyy hh:mm:ss. Ví dụ: 20/10/2017 14:02:16');
	$( "input.datetimepicker" ).attr("maxlength", '19');

</script>
<script>
	// $(document).ready(function() {
	// 	$("body").mouseup(function(e)
	// 	{
	// 		var button_ul = $(".xdsoft_datetimepicker ");
	// 		var button_ul1 = $("input ");
	// 		if (!button_ul.is(e.target) && button_ul.has(e.target).length === 0 && !button_ul1.is(e.target) && button_ul1.has(e.target).length === 0)
	// 		{
	// 			$('button[type="submit"]').trigger('click');
	// 		}
	// 	});
	// });

	// $(document).on('focus', 'input.datetimepicker', function () {
	// 	$(document).keydown(function(objEvent) {
	// 		if (objEvent.keyCode == 8 || objEvent.keyCode == 46) {
	// 			objEvent.preventDefault();
	// 		}
	// 	});
	// });
</script>



</body>
</html>