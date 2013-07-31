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
			<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'twentytwelve' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'twentytwelve' ); ?>"><?php printf( __( 'Proudly powered by %s', 'twentytwelve' ), 'WordPress' ); ?></a>
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
</script>
</body>
</html>