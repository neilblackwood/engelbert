<?php get_header(); ?>
<!--Content-->
<?php echo get_option('inn_temp_head'); ?>	
		<?php 
		$catalogue_page_url	=	get_option('catalogue_page_url');
	    $terms	=	get_terms('wpccategories');
		global $post;
		$terms1 = get_the_terms($post->id, 'wpccategories');
		if($terms1){
		foreach( $terms1 as $term1 ){
			$slug	= $term1->slug;
			$parent = $term1->parent;
			$tname	=	$term1->name;
			$cat_url	=	get_bloginfo('siteurl').'/kategori/'.$slug;
		};

		//Horrible way of looping to get the parent category we want, but works.
		if($terms){
		    foreach($terms as $term ){
                if($parent==$term->parent) {
                    foreach($terms as $parentTerm){
                        // Only if the parent is Everyday Jewelry then take back to parent category.
                        if($term->parent==$parentTerm->term_id&&$parentTerm->parent==3){
                            $cat_url = get_term_link($parentTerm->slug, 'wpccategories') . '#' . $slug;
                        }
                    }
                }

             }
        }
	}

		if(is_single()){
			$pname	=	'&gt;&gt;'.get_the_title();	
		}
		//echo '<div class="wp-catalogue-breadcrumb"> <a href="'.$catalogue_page_url.'">All Products</a> &gt;&gt; <a href="'.$cat_url.'">'.$tname.'</a>  ' . $pname . '</div>';
		 ?>
    	<div id="wpc-catalogue-wrapper">
		<?php

		
		global $post;
		$terms1 = get_the_terms($post->id, 'wpccategories');
		
		if($terms1 !=null || $term1 !=null){
			foreach( $terms1 as $term1 ){
				$slug		= $term1->slug;
		  		$term_id	= $term1->term_id;
			};
		}
		global $wpdb;	
		
	 $args = array(
			'orderby' => 'term_order',
			'order' => 'ASC',
			'hide_empty' => true,
		);
        $terms	=	get_terms('wpccategories',$args);
		$count	=	count($terms);
/* echo '<div id="wpc-col-1">
        <ul class="wpc-categories">';
		if($count>0){
			echo '<li class="wpc-category"><a href="'. get_option('catalogue_page_url') .'">All Products</a></li>';
       		foreach($terms as $term){
				if($term->slug==$slug){
				$class	=	'active-wpc-cat';
			}else{
				$class	=	'';
			}
			echo '<li  class="wpc-category ' . $class . '"><a href="'.get_term_link($term->slug, 'wpccategories').'">'. $term->name .'</a></li>'; 	
			}
		}else{
			echo '<li  class="wpc-category"><a href="#">No category</a></li>';	
		}
        echo '</ul>
        </div>';

        */
	?>
        <!--/Left-menu-->
        <!--col-2-->

        <div id="wpc-product">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php 
			$img1		=	get_post_meta($post->ID,'product_img1',true);
			$img2		=	get_post_meta($post->ID,'product_img2',true);
			$img3		=	get_post_meta($post->ID,'product_img3',true);
		?>	 
        <div id="wpc-product-gallery">
        <?php 
			if(get_option('image_height')){
				$img_height	=	get_option('image_height');
			}else{
				$img_height	=	580;
			}
			if(get_option('image_width')){
				$img_width	=	get_option('image_width'); 
			}else{
				$img_width	=	580;
			}
			$icroping	=	get_option('croping');
		?>
        
        <div class="product-img-view vignette" style="width:<?php echo $img_width; ?>px; height:<?php echo $img_height; ?>px;">
        <a href="#" class="opener"><img class="vignette" src="<?php echo $img1; ?>" alt="" id="img1" height="<?php echo $img_height; ?>" width="<?php echo($icroping == 'image_scale_crop')? '' : $img_width; ?>" /></a>
        <a href="#" class="opener"><img class="vignette" src="<?php echo $img2; ?>" alt="" id="img2" height="<?php echo $img_height; ?>" width="<?php echo($icroping == 'image_scale_crop')? '' : $img_width; ?>" style="display:none;" /></a>
        <a href="#" class="opener"><img class="vignette" src="<?php echo $img3; ?>" alt="" id="img3" height="<?php echo $img_height; ?>" width="<?php echo($icroping == 'image_scale_crop')? '' : $img_width; ?>" style="display:none;"  /></a>
        </div>
        <div class="clear"></div>
        <h5><a href="#" id="opener">View Image in Full Size</a></h5>
        <div id="dialog"></div>
        </div>
        <?php $product_description = get_post_meta($post->ID, 'product_description', true); ?>
        <?php $product_details = get_post_meta($post->ID, 'product_details', true); ?>
        <?php $product_price = get_post_meta($post->ID, 'product_price', true); ?>

    <article class="post">
        <div class="entry-content">
            <h4><?php echo '<a href="'.$cat_url.'">'.$tname.'</a>'; ?></h4>
            <h2><?php echo get_the_title() ?></h2>
        </div>
        <div id="tabs">
          <ul>
            <li><a href="#description"><?php _e("Description", "wp-catalogue"); ?></a></li>
            <li><a href="#details"><?php _e("Details", "wp-catalogue"); ?></a></li>
          </ul>
          <div id="description">
            <p><?php echo $product_description; ?></p>
          </div>
          <div id="details">
            <p><?php echo $product_details; ?></p>
          </div>
        </div>
		<div class="entry-content">
            <?php the_content(); ?>
        <?php
			if(get_option('next_prev')==1){
		echo '<p class="wpc-next-prev">';
		previous_post_link('%link', 'Previous');
		next_post_link('%link', 'Next');
		echo '</p>';
		
	
		}
		?>
        </div>
        <h5><span class="product-price"><?php if($product_price): ?>Price: <span><?php echo $product_price; ?></span><?php else: ?><?php _e("Price on request", "wp-catalogue"); ?><?php endif; ?></span></h5>
        <div class="wpc-product-img">
        <?php if($img1 && $img2): ?>
        <div class="new-prdct-img"><img src="<?php echo $img1; ?>" alt="" width="67" height="67" id="img1" /></div>
		<?php endif; if($img2): ?>
        <div class="new-prdct-img"><img src="<?php echo $img2; ?>" alt="" width="67" height="67" id="img2"/></div>
		<?php endif; if($img3):?>
        <div class="new-prdct-img"><img src="<?php echo $img3; ?>" alt="" width="67" height="67" id="img3"/></div>
		<?php endif; ?>
        </div>

</article>
        <?php endwhile; endif; ?>
        </div>
        <!--/col-2-->
    <div class="clear"></div>
    </div>
<?php echo get_option('inn_temp_foot'); ?>
  <!--/Content-->
<?php get_footer();