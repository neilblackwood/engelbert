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
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.ba-throttle-debounce.min.js"></script>
<script>
    /*	CarouFredSel: a circular, responsive jQuery carousel.
        Configuration created by the "Configuration Robot"
        at caroufredsel.dev7studios.com
    */
    $("#carousel").carouFredSel({
        width: 940,
        height: 600,
        items: {
            visible: 1,
            width: 940,
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

        function setPrimaryNavOffset(b){
            if(b.hasClass('isFixed')){
                makeStatic(b)
            }
            //this.__setData("primaryNavOffset",this.elements.primaryNav.offset().top);
            if(b.hasClass('isStatic')){
                makeFixed(b)
            }
            return
        }

        function events(){

            var b=$('#masthead');
            var c=$('#wpc-col-1');

            /*this.view.on("click.shared_header",".locale-toggle",function(c){
                c.preventDefault();
                if(Modernizr.touch){
                    b.toggleLocaleSelector()
                }
            });  */

            if(!Modernizr.touch){
                $(window).on("scroll.main-navigation resize.main-navigation",$.throttle(50,false,function(){
                    position(b, b[0].offsetHeight - $('#menu-primary').height());
                    position(c, b[0].offsetHeight - $('#menu-primary').height());
                })).on("media-query-match.main-navigation",function(){
                    setPrimaryNavOffset(b)
                })
            }

            /*if(!Modernizr.touch){
                $(window).on("scroll.fixed-left resize.fixed-left",$.throttle(50,false,function(){
                    position(c, b[0].offsetHeight - $('#menu-primary').height())
                })).on("media-query-match.fixed-left",function(){
                    setPrimaryNavOffset(c)
                })
            }       */

            /* if(!Modernizr.touch){
                this.view.on("mouseenter.shared_header",function(){
                    b.showSecondaryNav()
                }).on("mouseleave.shared_header",function(){
                    b.hideSecondaryNav()
                })
            }
            this.view.on("click.shared_header",".primary-nav-toggle a",function(c){
                c.preventDefault();
                if(b.__getData("primaryNavIsActive")){
                    b.hidePrimaryNav()
                } else {
                    b.showPrimaryNav()
                }
            });  */
            return
        }

        events();

        function position(target, offset) {
            b = offset;
            //b=this.__getData("primaryNavOffset");
            if(b===0){
                setPrimaryNavOffset(target);
                //b=this.__getData("primaryNavOffset")
            }
            if(b-$(window).scrollTop()<=0){
                makeFixed(target)
            } else {
                makeStatic(target)
            }

            return
        }

        function makeFixed(b) {
            if(Modernizr.touch){
                return
            }
            b.height(b.height()).addClass("isFixed").removeClass("isStatic");
            /* if(a.browser.lteIe10){
                this.forceSearchFieldRepaint()
            }  */
            //this.__setData("isFixed",true);
            return
        }
        function makeStatic(b) {
            if(Modernizr.touch){
                return
            }
            b.removeClass("isFixed").addClass("isStatic").css("height","");
            /*if(a.browser.lteIe10){
                this.forceSearchFieldRepaint()
            }   */
            //this.__setData("isFixed",false);
            return
        }

</script>
</body>
</html>