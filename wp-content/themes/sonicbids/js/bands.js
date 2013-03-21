var carouselWidth = 332;
$(document).ready(function(){
	//set the width for the carousel-slider according to the images it contains
	var totalBoxes = $('.carousel-slider .carousel-img').length;
	$('.carousel-slider').css('width', ((totalBoxes * carouselWidth) -20) + 'px');
	
	//set opacity to 0 for msg boxes - for IE
	$('.carousel-caption').css('opacity', 0);
	
	//box animation on mouse over
	$('.carousel-img').hover(
		function() {
			var currentBox = this;
			var currentMsg = $(currentBox).find('.carousel-msg');
			var scrollRight = '-' + currentMsg.outerWidth() + 'px';
			currentMsg.stop().animate({
				right: scrollRight,
				opacity: 0
			}, 'slow', 'linear');
			$(currentBox).find('.carousel-caption').show().stop().animate({
				opacity: 0.9
			}, 'slow');
		},
		function() {
			var currentBox = this;
			$(currentBox).find('.carousel-caption').stop().animate({
				opacity: 0
			}, 'slow');
			$(currentBox).find('.carousel-msg').stop().animate({
				right: '0px',
				opacity: 1
			}, 'slow', 'linear', function() {
				$(currentBox).find('.carousel-caption').hide();
			});
		}
	);
	
	//slider animation on clicking prev/next
	$('.carousel-next').bind('click', function(e) {
		e.preventDefault();
		$('.carousel-content').animate({
			scrollLeft: '+=' + carouselWidth
		}, 'slow');
	});
	$('.carousel-prev').bind('click', function(e) {
		e.preventDefault();
		$('.carousel-content').animate({
			scrollLeft: '-=' + carouselWidth
		}, 'slow');
	});
});
