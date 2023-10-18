$(document).ready(function(){
	
	$('.lnb').on("mouseover focusin", function(){

			$('.lnb').stop().animate({height:'410px'},200);
			$('.lnb li ul').show();
			$('.bx_line').addClass('on');
			return false;
	})
	$('.lnb').on("mouseleave focusout", function(){
			$('.lnb').stop().animate({height:'45px'},200);
			$('.lnb li ul').hide();
			$('.bx_line').removeClass('on');
			return false;
	})
})



$(document).keydown(function (e) {
		if (e.keyCode == 27) {
				$('.lnb_pc').removeClass('on');
		}
});

$(document).ready(function () {
		var height = '290';
		$('.lnb_pc').on("mouseover focusin", function () {

				$('.lnb_pc').stop().animate({height: height}, 200);
				$('.lnb_pc li ul').show();
				return false;
		})
		$('.lnb_pc').on("mouseleave focusout", function () {
				$('.lnb_pc').stop().animate({height: '85px'}, 200);
				$('.lnb_pc li ul').hide();
				return false;
		})
})
			