
(function($){
    $(document).ready(function(){                
        $('.promote_content').hover(
            function() {
                $(this).find('.promote_txt').show().stop().animate({
                    opacity: 1
                }, 400);
            },
            function() {
                $(this).find('.promote_txt').stop().animate({
                    opacity: 0
                }, 400);
            }
        );
});
})(jQuery);

	