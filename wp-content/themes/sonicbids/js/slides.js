//header slides animation and arrow animation
var sliderWidth = 976;
var totalSlides = 0;
var currentSlide = 1;

$(document).ready(function(){
	//set the width for the slider container
	totalSlides = $('.inner-slider-images').length;
	$('.inner-slider-container').css('width', (totalSlides * sliderWidth) + 'px');
	
	//make the first slider caption visible
	$('.inner-slider-txt').eq(0).css({
		bottom: '0px',
		opacity: 1
	});
	
	//apply opacity - for IE
	$('.hero-next-caption, .hero-prev-caption').css('opacity', 0);
	
	//hide all the msg-boxes and show the first
	$('.msg-box').css({display: 'none', opacity: 0});
	$('.msg-box:first').css({display: 'block', opacity: 1});
	
	//left/right arrow button animation
	$('.inner-slider-next').hover(function() {
		$('.hero-next-caption').stop().animate({
			right: '0px',
			opacity: 0.9
		});
	}, function() {
		$('.hero-next-caption').stop().animate({
			right: '-182px',
			opacity: 0
		});
	});
	
	$('.inner-slider-prev').hover(function() {
		$('.hero-prev-caption').stop().animate({
			left: '0px',
			opacity: 0.9
		});
	}, function() {
		$('.hero-prev-caption').stop().animate({
			left: '-225px',
			opacity: 0
		});
	});
	
	//slider functionality on clicking prev/next icons
	$('.inner-slider-next').bind('click', function(e) {
		e.preventDefault();
		if (currentSlide < totalSlides) {
			var slideNum = currentSlide;
			currentSlide++;
			showSlide(slideNum, currentSlide);
		}
		else {
			var slideNum = currentSlide;
			currentSlide = 1;
			showSlide(slideNum, currentSlide);
		}
	});
	$('.inner-slider-prev').bind('click', function(e) {
		e.preventDefault();
		if (currentSlide > 1) {
			var slideNum = currentSlide;
			currentSlide--;
			showSlide(slideNum, currentSlide);
		}
		else {
			var slideNum = currentSlide;
			currentSlide = totalSlides;
			showSlide(slideNum, currentSlide);
		}
	});
	
	//success stroy boxes hover animation
	$('.successs-story-box ul li a').hover(function() {
		$(this).find('.story-caption').show().stop().animate({
			opacity: 0.9
		}, 400, 'linear');
	}, function() {
		$(this).find('.story-caption').stop().animate({
			opacity: 0
		}, 400, 'linear', function() {
			$(this).hide();
		});
	});
});

function showSlide(prevIndex, nextIndex) {
	//hide current caption banner
	$('.inner-slider-txt').eq(prevIndex - 1).animate({
		bottom: '-67px',
		opacity: 0
	}, 'slow');
	//slide the image
	var scrollToPosition = ((nextIndex - 1) * sliderWidth) + 'px';
	$('.inner-slider-display').animate({
		scrollLeft: scrollToPosition
	}, 'slow');
	//show the next caption banner
	$('.inner-slider-txt').eq(nextIndex - 1).animate({
		bottom: '0px',
		opacity: 1
	}, 'slow');				
	//change the msg area content
	$('.msg-box').eq(prevIndex - 1).animate({opacity: 0}, 'slow', function() { $(this).hide(); });
	$('.msg-box').eq(nextIndex - 1).show().animate({opacity: 1}, 'slow');
}