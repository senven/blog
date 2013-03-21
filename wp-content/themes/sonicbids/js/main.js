var arrowAnimationRunning = false;
var adjustScroll = 0;
var totalSlides = 1;
var docWidth = 0, minDocWidth = 976, imageWidth = 1440;
var hero_slider_auto = true;
var hero_slider_duration = 2000;
var hero_slider_stop = false;

//adjust the scroll left of the hero slider after loading and when resizing the window
function adjustSlider() {
	var oldDocwidth = docWidth;
	docWidth = $(window).width();
	if (oldDocwidth == 0) {
		//on initial
		adjustScroll = (imageWidth - docWidth) / 2;
		//adjust the hero slider to center if document width is smaller than image
		if (imageWidth > docWidth)
			$('#hero-slider-wrapper').scrollLeft(adjustScroll);
		else
			$('#hero-slider-wrapper').scrollLeft(0);
	} else if (oldDocwidth >= minDocWidth && oldDocwidth <= imageWidth) {
		//on resizing the window
		if (docWidth >= imageWidth)
			docWidth = imageWidth;
		if (docWidth <= minDocWidth)
			docWidth = minDocWidth;
		sliderObj.adjustScroll = (imageWidth - docWidth) / 2;
		$('#hero-slider-wrapper').scrollLeft((sliderObj.scrollAmount * (sliderObj.currentSlide - 1)) + sliderObj.adjustScroll);
	}
}
$(document).ready(function(){
	//adjust the slider width according to the number of images
	totalSlides = $('#hero-slider-wrapper .hero-slider-content').length;
	$('#hero-slider').css('width', (((totalSlides * 1440) + 100) + 'px'));
	
	//set opacity for box-caption - for IE
	$('.box-caption').css('opacity', 0);
	
	//bands box animation on mouse over
	$('.box-links').hover(
		function() {
			var currentBox = this;
			var currentMsg = $(currentBox).find('.box-txt-bg');
			var scrollLeft = '-' + currentMsg.outerWidth() + 'px';
			currentMsg.stop().animate({
				left: scrollLeft,
				opacity: 0
			}, 400, 'linear');
			$(currentBox).find('.box-caption').show().stop().animate({
				opacity: 0.9
			}, 400);
		},
		function() {
			var currentBox = this;
			$(currentBox).find('.box-caption').stop().animate({
				opacity: 0
			}, 400);
			$(currentBox).find('.box-txt-bg').stop().animate({
				left: '0px',
				opacity: 1
			}, 400, 'linear', function() {
				$(currentBox).find('.box-caption').hide();
			});
		}
	);
	
	//create object
	sliderObj = new slider();
	//set prev/next button captions
	sliderObj.changeArrowCaption('init');
	
	//bind the next arrow animation in to arrow elements
	$('.hero-next').hover(function() {
		sliderObj.showArrowCaptionNext();
	}, function() {
		sliderObj.hideArrowCaptionNext();
	});
	$('.hero-prev').hover(function() {
		sliderObj.showArrowCaptionPrev();
	}, function() {
		sliderObj.hideArrowCaptionPrev();
	});
	
	// Hero image slider - Auto slide option
	if(hero_slider_auto){
		setTimeout(function(){ sliderObj.autoload(sliderObj);  }, hero_slider_duration);
	}
	
	//bind the prev/next slide actions in to elements
	$('.hero-next').bind('click', function(e) { 
		e.preventDefault();
		sliderObj.next();
		hero_slider_stop = true;
	});
	$('.hero-prev').bind('click', function(e) { 
		e.preventDefault();
		sliderObj.prev();
		hero_slider_stop = true;
	});
	
	// Adjust slider when window resize
	adjustSlider();
	$(window).resize(adjustSlider);
	
	// In default hide the previous slider arrow
	$('.hero-prev').hide();
	
});

//slider object
function slider() {
	this.slideObj = $('#hero-slider-wrapper');
	this.totalSlides = totalSlides;
	this.currentSlide = 1;
	this.scrollAmount = imageWidth;
	this.adjustScroll = adjustScroll;
	var nextCaption = {};
	var idx = 1;
	$('.hero-slider-content .hero-next-caption').each(function() {
		nextCaption.idx = {};
		if ($(this).find('.caption-middle').html() == '')
			nextCaption[idx] = {captionText: '', captionWidth: $(this).width() + 'px'};
		else
			nextCaption[idx] = {captionText: $(this).find('.caption-middle').html(), captionWidth: ($(this).width() + 10) + 'px'};
		idx++;
		$(this).css({display: 'none', opacity: 0});
	});
	this.nextCaption = nextCaption;
}
//slide image on clicking next arrow
slider.prototype.next = function() {
	this.hideCaption();
	if (this.currentSlide < this.totalSlides) {
		
		this.slideObj.animate({
			scrollLeft: (this.scrollAmount * this.currentSlide) + this.adjustScroll
		}, 'slow');
		this.currentSlide = this.currentSlide + 1;
	}
	else {
		this.slideObj.animate({
			scrollLeft: this.adjustScroll
		}, 'slow');
		this.currentSlide = 1;
	}
	this.showCaption();
	this.changeArrowCaption('next');
	
	//check for first slide and show/hide the arrow
	if (this.currentSlide == 1)
		$('.hero-prev').hide();
	else
		$('.hero-prev').show();
		
}
//slide image on clicking previous arrow
slider.prototype.prev = function() {
	if (this.currentSlide != 1) {
		this.hideCaption();
		this.slideObj.animate({
			scrollLeft: (this.scrollAmount * (this.currentSlide - 2)) + this.adjustScroll
		}, 'slow');
		this.currentSlide = this.currentSlide - 1;
		this.showCaption();
		this.changeArrowCaption('prev');
		//check for first slide and show/hide the arrow
		if (this.currentSlide == 1)
			$('.hero-prev').hide();
		else
			$('.hero-prev').show();
	}
}
//show the caption element from the below in to display area
slider.prototype.showCaption = function() {
	var captionNum = this.currentSlide;
	var currentCaptionBox = $('.hero-slider').eq(captionNum - 1);
	var boxHeight = parseInt(currentCaptionBox.css('height'));
	currentCaptionBox.animate({
		opacity: 1,
		top: (458 - boxHeight) + 'px'
	}, 'slow');
}
//hide the caption element from display area to below
slider.prototype.hideCaption = function() {
	var captionNum = this.currentSlide;
	var currentCaptionBox = $('.hero-slider').eq(captionNum - 1);
	currentCaptionBox.animate({
		opacity: 0,
		top: '480px'
	}, 'slow');
}
//change the caption text in the arrow buttons
slider.prototype.changeArrowCaption = function(mode) {
	var captionNum = this.currentSlide;

	var nextCaptionElement = $('.hero-next .hero-next-caption');	
	var prevCaptionElement = $('.hero-prev .hero-prev-caption');
	
	var prevCaption = '';
	var nextCaption = '';
	//if not in the first page
	if (captionNum > 1) {
		prevCaption = this.nextCaption[captionNum - 1].captionText;
		prevCaptionElement.css('width', this.nextCaption[captionNum - 1].captionWidth);
		if (mode == 'next')
			prevCaptionElement.css('left', '-' + this.nextCaption[captionNum - 1].captionWidth);
	}
	//if not in the last page
	if (captionNum < this.totalSlides) {
		nextCaption = this.nextCaption[captionNum + 1].captionText;
		nextCaptionElement.css('width', this.nextCaption[captionNum + 1].captionWidth);
		if (mode == 'prev')
			nextCaptionElement.css('right', '-' + this.nextCaption[captionNum + 1].captionWidth);
	}
	$('.hero-prev .hero-prev-caption .caption-middle').html(prevCaption);
	$('.hero-next .hero-next-caption .caption-middle').html(nextCaption);
	
	//on initial hide the prev and next captions
	if (mode == 'init') {
		nextCaptionElement.css({opacity: 0, right: '-' + this.nextCaption[captionNum + 1].captionWidth});
		prevCaptionElement.css({opacity: 0, left: '-' + this.nextCaption[captionNum].captionWidth});
		//align the first caption top position
		this.showCaption();
	}
	
}
//show the arrow caption on mouse enter
slider.prototype.showArrowCaptionNext = function() {
	//only do animation if previously animation not running and first 3 slides
	if ( ($('.hero-next .hero-next-caption .caption-middle').html() != '')) {
		$('.hero-next .hero-next-caption').stop().show().animate({
			right: '0px',
			opacity: 0.9
		});
	}
}
//hide the mouse arrow cation on mouse out
slider.prototype.hideArrowCaptionNext = function() {
	var currentWidth = $('.hero-next .hero-next-caption').width();
	$('.hero-next .hero-next-caption').stop().animate({
		right: '-' + currentWidth,
		opacity: 0
	});
}
slider.prototype.showArrowCaptionPrev = function() {
	//only do animation if previously animation not running and last 3 slides
	if (($('.hero-prev .hero-prev-caption .caption-middle').html() != '')) {
		$('.hero-prev-caption').stop().show().animate({
			left: '0px',
			opacity: 0.9
		});
	}
}
slider.prototype.hideArrowCaptionPrev = function() {
	var currentWidth = $('.hero-prev .hero-prev-caption').width();
	$('.hero-prev .hero-prev-caption').stop().animate({
		left: '-' + currentWidth,
		opacity: 0
	});
}

// slider auto load
slider.prototype.autoload = function(sliderObj) {	
	// Check weather the user intract prev / next button
	if(!hero_slider_stop){
		// Rotate the next image
		sliderObj.next();
		setTimeout(function(){ sliderObj.autoload(sliderObj);  }, hero_slider_duration);
	}
}