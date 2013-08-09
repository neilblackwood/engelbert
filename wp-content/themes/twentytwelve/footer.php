<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
	</div><!-- #main .wrapper -->
	<footer id="colophon" role="contentinfo">
		<div class="site-info">
			<?php do_action( 'twentytwelve_credits' ); ?>
			<p>&copy; 2013 Engelbert Stockholm</p>
			<?php /* <a href="<?php echo esc_url( __( 'http://wordpress.org/', 'twentytwelve' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'twentytwelve' ); ?>"><?php printf( __( 'Proudly powered by %s', 'twentytwelve' ), 'WordPress' ); ?></a> */ ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
<script>
    /*	CarouFredSel: a circular, responsive jQuery carousel.
        Configuration created by the "Configuration Robot"
        at caroufredsel.dev7studios.com
    */
    $("#carousel").carouFredSel({
        width: 960,
        height: 600,
        items: {
            visible: 1,
            width: 960,
            height: 600
        },
        scroll: {
            fx: "crossfade"
        },
        auto: {
            timeoutDuration: 6000
        },
        prev: "left",
        next: "right",
        pagination: {
            container: "#pager",
            keys: true,
            anchorBuilder	: function(nr) {
                return "<a href='#'><span>"+nr+"</span></a>";
            }
        },
        swipe: true,
        duration: 3000
    });


        var searchOptions = {
                secondaryNavTransitionSpeed:400,
                searchFieldTransitionSpeed:400
        };

        $('#searchform').submit(function(c){
            if(!$('.widget-area div.field-search').hasClass("field-search-active")){
                c.preventDefault();
                showSearch($('.widget-area div.field-search'))
            } else {
                if($('#s').val()===""){
                    c.preventDefault()
                }
            }
        });

        function showSearch(container) {
            var fieldSearch = container, c=searchOptions.searchFieldTransitionSpeed,d;
            if(Modernizr.csstransitions){fieldSearch.addClass("field-search-animate field-search-active").one("transitionend webkitTransitionEnd mozTransitionEnd oTransitionEnd",function(){fieldSearch.removeClass("field-search-animate");$('#s').focus()})}else{d=fieldSearch.addClass("field-search-active").width();fieldSearch.css({width:0}).animate({width:d},c,function(){fieldSearch.css("width","");fieldSearchInput.focus()})}fieldSearch.addClass("field-search-active");return
        }
</script>
</body>
</html>