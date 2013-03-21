var carouselWidth = 332;
var totalBoxes = 0;
var totalClicks = 0, currentClick = 0;
$(document).ready(function(){
	//set the width for the carousel-slider according to the images it contains
	totalBoxes = $('.carousel-slider .carousel-img').length;
	totalClicks = totalBoxes - 3;
	$('.carousel-slider').css('width', ((totalBoxes * carouselWidth) -20) + 'px');
	
	//set opacity to 0 for msg boxes - for IE
	$('.carousel-caption').css('opacity', 0);
	
	$('.carousel-content').scrollLeft(0);
	
	//box animation on mouse over
	$('.carousel-img').hover(
		function() {
			var currentBox = this;
			var currentMsg = $(currentBox).find('.carousel-msg');
			var scrollRight = '-' + currentMsg.outerWidth() + 'px';
			currentMsg.stop().animate({
				right: scrollRight,
				opacity: 0
			}, 400, 'linear');
			$(currentBox).find('.carousel-caption').show().stop().animate({
				opacity: 0.9
			}, 400);
		},
		function() {
			var currentBox = this;
			$(currentBox).find('.carousel-caption').stop().animate({
				opacity: 0
			}, 400);
			$(currentBox).find('.carousel-msg').stop().animate({
				right: '0px',
				opacity: 1
			}, 400, 'linear', function() {
				$(currentBox).find('.carousel-caption').hide();
			});
		}
	);
	
	//slider animation on clicking prev/next
	$('.carousel-next').bind('click', function(e) {
		e.preventDefault();
		
		if (currentClick < totalClicks) {
			$('.carousel-content').animate({
				scrollLeft: '+=' + carouselWidth
			}, 'slow');
			currentClick++;
		}
		else {
			$('.carousel-content').animate({
				scrollLeft: '0'
			}, 'slow');
			currentClick = 0;
		}
	});
	$('.carousel-prev').bind('click', function(e) {
		e.preventDefault();
		if (currentClick > 0) {
			$('.carousel-content').animate({
				scrollLeft: '-=' + carouselWidth
			}, 'slow');
			currentClick--;
		}
		else {
			$('.carousel-content').animate({
				scrollLeft: (carouselWidth * totalClicks)
			}, 'slow');
			currentClick = totalClicks;
		}
	});
});
