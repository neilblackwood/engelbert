<?php

function catalogue() {
	
	global $post, $categories, $args1;
	$post_data = get_post($post->ID, ARRAY_A);
	if(get_queried_object()->taxonomy){
		$slug	=	get_queried_object()->taxonomy.'/'.get_queried_object()->slug;
	}else{
		$slug = $post_data['post_name'];
	}
	$crrurl	=	get_bloginfo('wpurl').'/'.$slug;
	if(get_query_var('paged')){
		$paged	=	get_query_var('paged');	
	}else{
		 $paged	=	1;	
	}
	$args1 = array(
			'orderby' => 'term_order',
			'order' => 'ASC',
			'hide_empty' => false,
	);

	$terms	=	get_terms('wpccategories',$args1);
	$count	=	count($terms);
	$post_content	=	get_queried_object()->post_content;
	
		if(strpos($post_content,'[wp-catalogue]')!==false){
		
		
		 $siteurl	=	get_bloginfo('siteurl');
		 global $post;
		 $pid	= $post->ID;
		 $guid	=	 $siteurl.'/?page_id='.$pid;
		 if(get_option('catalogue_page_url')){
			update_option( 'catalogue_page_url', $guid );	 
		}else{
			add_option( 'catalogue_page_url', $guid );	
		}
	}
	$term_slug	=	get_queried_object()->slug;
	$term_id = get_queried_object()->term_id;
	$term_parent = get_queried_object()->parent;
	if(!$term_slug){
		$class	=	"active-wpc-cat";	
	}
	
	$catalogue_page_url	=	get_option('catalogue_page_url');

		global $post;
		$terms1 = get_the_terms($post->id, 'wpccategories');
		if($terms1){
		foreach( $terms1 as $term1 ){
			$slug	= $term1->slug;
			$tname	=	$term1->name;
			$tdesc	=	$term1->description;
			$cat_url	=	get_bloginfo('siteurl').'/kategori/'.$slug;
		};
	}

		if(is_single()){
			$pname	=	'>> '.get_the_title();	
		}
		
		$return_string = '<div id="wpc-catalogue-wrapper">';
		//$return_string .= '<div class="wp-catalogue-breadcrumb"> <a href="'.$catalogue_page_url.'">All Products</a> &gt;&gt; <a href="'.$cat_url.'">'.$tname.'</a>  ' . $pname . '</div>';
		$return_string .= '<div id="wpc-col-1">';
        $return_string .= '<ul class="wpc-categories">';
		
		// generating sidebar
		if($count>0){
			//$return_string .= '<li class="wpc-category ' . $class . '"><a href="'. get_option('catalogue_page_url') .'">All Products</a></li>';
       		foreach($terms as $term){
				if($term_slug==$term->slug){
				$class	=	'active-wpc-cat';
			}else{
				$class	=	'';
			}
		        if($term->parent==0){
		            $class .= ' parent';
		        }
		        if($terms[0]==$term){
		            $class .= ' first';
		        }
                if($term->parent <= 3){
                    $return_string .=  '<li class="wpc-category '. $class .'"><a href="'.get_term_link($term->slug, 'wpccategories').'">'. $term->name .'</a></li>';
                }
                if (($term->parent==5&&$term_id==5)||($term_parent==5&&$term->parent==5)) {
                    //Put a foreach in here
                    //foreach($terms as $term){
                    $return_string .=  '<li class="wpc-category '. $class .'"><a href="'.get_term_link($term->slug, 'wpccategories').'">'. $term->name .'</a></li>';
                }
			}
		}else{
			$return_string .=  '<li class="wpc-category"><a href="#">No category</a></li>';	
		}
		
		$return_string .= '</ul>';
        $return_string .=' </div>';

		// products area
		$per_page	=	get_option('pagination');
		if($per_page==0){
			$per_page	=	"-1";
		}
		
		// 
		$term_slug	=	get_queried_object()->slug;
		if($term_slug){
		$args = array(
			'post_type'=> 'wpcproduct',
			'order'     => 'ASC',
			'orderby'   => 'menu_order',
			'posts_per_page'	=> $per_page,
			'paged'	=> $paged,
			'tax_query' => array(
				array(
					'taxonomy' => 'wpccategories',
					'field' => 'slug',
					'terms' => get_queried_object()->slug
				)
		));
		}else{
			$args = array(
			'post_type'=> 'wpcproduct',
			'order'     => 'ASC',
			'orderby'   => 'menu_order',
			'posts_per_page'	=> $per_page,
			'paged'	=> $paged,
			);
		}
		
		// products listing
		$products	=	new WP_Query($args); 
		if($products->have_posts()){
			$tcropping	=	get_option('tcroping');
			if(get_option('thumb_height')){
			$theight	=	get_option('thumb_height');
			}else{
				$theight	=	142;
			}
			if(get_option('thumb_width')){
				$twidth		=	get_option('thumb_width');
			}else{
				$twidth		=	205;
			}
			$i = 1;
			$return_string .= '  <!--col-2-->
						<div id="wpc-col-2">
						<div class="entry-content">
                            <h1>'.$tname.'</h1>
                            <h3>'.$tdesc.'</h3>
						</div>
						<div style="width:20px;border-bottom:1px solid black; margin:0 auto;">
						</div>
						<div id="wpc-products">';
				while($products->have_posts()): $products->the_post();
				$title		=	get_the_title(); 
				$permalink	=	get_permalink();
				$description=	get_post_meta(get_the_id(),'product_description',true);
				$details    =	get_post_meta(get_the_id(),'product_details',true);
				$img		=	get_post_meta(get_the_id(),'product_img1',true);
				$price		=	get_post_meta(get_the_id(),'product_price',true); 
				 $return_string .= '<!--wpc product-->';
				 $return_string .= '<div class="wpc-product">';
				 $return_string .= '<div class="wpc-img" style="width: '. $twidth . 'px; height:' . $theight . 'px; overflow:hidden"><a href="'. $permalink .'" class="wpc-product-link"><img src="'. $img .'" alt="" height="' . $theight . '" width="';
				 if(get_option('tcroping') == 'thumb_scale_fit') { $return_string .= $twidth; };
				 $return_string .= '" /></a></div>';
				 $return_string .= '<p class="wpc-title"><a href="'. $permalink .'">' . $title . '</a></p>';
				 $return_string .= '</div>';
				 $return_string .= '<!--/wpc-product-->';
				if($i == get_option('grid_rows'))
			{
				$return_string .= '<br clear="all" />';
				$i = 0; // reset counter
			}
				$i++;
				endwhile; wp_reset_postdata;
				$return_string .= '</div>';
				if(get_option('pagination')!=0){
				$pages	=	ceil($products->found_posts/get_option('pagination'));
				}
		
			if($pages>1){
			$return_string .= '<div class="wpc-paginations">';
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; 
			for($p=1; $p<=$pages; $p++){
				$cpage	=	'active-wpc-page';
				if($paged==$p){
						$return_string .=    '<a href="' . $crrurl . '/page/'. $p .'" class="pagination-number '. $cpage .'">'. $p .'</a>';
					}else{
						$return_string .=    '<a href="' . $crrurl . '/page/'. $p .'" class="pagination-number">'. $p .'</a>';	
					}
		}
		 $return_string .= '</div>'; 
		}
		}else{
		echo 'No Products';
		}
		
		$return_string .= '</div><div class="clear"></div></div>';
		
		
		return $return_string;
	
}

add_shortcode('wp-catalogue','catalogue');

// Add the top categories to the primary menu
add_filter( 'wp_nav_menu_items', 'your_custom_menu_item', 10, 2 );
function your_custom_menu_item ( $items, $args ) {
    if ($args->theme_location == 'primary') {
        $args1 = array(
                'orderby' => 'term_order',
                'order' => 'ASC',
                'hide_empty' => false,
        );
        $categories = get_terms('wpccategories',$args1);

        $categories_menu = '<li><a href="#" onclick="return false;">Produkter</a><ul>';
        foreach($categories as $category){
            //Limit to the top categories
            if($category->parent == 0){
                $class = 'parent';
            } else {
                $class = '';
            }
            if($category->parent==0&&($categories[0]!=$category)){
                $categories_menu .=  '<li class="border"><hr /></li>';
            }
            if($category->parent <= 3){
                $categories_menu .=  '<li class="'.$class.'"><a href="'.get_term_link($category->slug, 'wpccategories').'">'. $category->name .'</a></li>';
            }
        }

        $categories_menu .= '</ul></li>';
    }
    return $categories_menu . $items;
}
