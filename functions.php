<?php
// Add custom Theme Functions here

add_filter('wp_nav_menu_objects', 'my_wp_nav_menu_objects', 10, 2);
function my_wp_nav_menu_objects( $items, $args ) {
	foreach( $items as &$item ) {
		$moi_nhat = get_field('moi_nhat', $item);
		if ( $moi_nhat ) {
			$danh_muc = get_field('danh_muc', $item);
			if( !empty($danh_muc) ) {
				$args_products = array(
					'post_type'				=> 'product',
					'post_status'			=> 'publish',
					'ignore_sticky_posts'	=> 1,
					'posts_per_page'		=> '1',
					'meta_query'			=> array(
						array(
							'key'		=> '_visibility',
							'value'		=> array('catalog', 'visible'),
							'compare'	=> 'IN'
						)
					),
					'tax_query'			=> array(
						array(
							'taxonomy'	=> 'product_cat',
							'field'		=> 'term_id', //This is optional, as it defaults to 'term_id'
							'terms'		=> $danh_muc,
							'operator'	=> 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
						)
					)
				);
				$products_new = new WP_Query($args_products);
				$pro = array();
				if ( $products_new->have_posts() ) {
					while ( $products_new->have_posts() ) {
						$products_new->the_post();
						global $product;
						$pro['name'] = $product->name;
						$pro['image'] = $product->get_image();
						$pro['url'] = get_permalink( get_the_ID() );

						// $product = wc_get_product( get_the_ID() )
						$pro['price'] = $product->get_price();
						$pro['sale'] = $product->get_sale_price();
					}
				} else {
					// no posts found
				}
				wp_reset_postdata();
				$item->classes = array('sp_moi_nhat');
				$pro['price'] = ( !empty($pro['sale']) ) ? '<span class="price">'.$pro['price'].'đ</span><span class="sale">'.$pro['sale'].'đ</span>' : $pro['price'].'đ';
				$item->title = '<b></b>
				<span>'.$item->title.'</span>
				<div class="spmoinhat"><a href="'.$pro['url'].'">'.$pro['image'].'
				<p class="name">'.$pro['name'].'</p>
				<p class="price">'.$pro['price'].'</p>
				</a></div><style>#wide-nav ul.nav > li#menu-item-'.$item->menu_item_parent.' > ul.nav-dropdown {min-height: 255px;}</style>';
			}
		} else {
			$icon = get_field('icon', $item);
			$icon_hover = (!empty(get_field('icon_hover', $item))) ? get_field('icon_hover', $item) : $icon ;
			if( $icon ) {
				$item->title = (wp_is_mobile())
				? '<img class="icon-main-menu icon-menu-normal" src="'.$icon.'" alt="'.$item->title.'"><span class="icon-menu-title">'.$item->title.'</span>'
				: '<img class="icon-main-menu icon-menu-normal" src="'.$icon.'" alt="'.$item->title.'">
				<img class="icon-main-menu icon-menu-hover" src="'.$icon_hover.'" alt="'.$item->title.'"><span class="icon-menu-title">'.$item->title.'</span>';
			}
		}
	}
	return $items;
}

add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
function woo_remove_product_tabs( $tabs ) {

    // unset( $tabs['description'] );
    // unset( $tabs['reviews'] );
    unset( $tabs['additional_information'] );
    unset( $tabs['pwb_tab'] );

    return $tabs;
}

// Chèn đánh giá
add_action( 'woocommerce_before_add_to_cart_form', 'bbloomer_custom_action_rating', 5 );
function bbloomer_custom_action_rating() {
	$rating = ceil(get_post_meta(get_the_ID(), '_wc_average_rating', true));
	for ($i=0; $i < $rating; $i++) {
        $rangking .= '<i class="fa fa-star" aria-hidden="true"></i>';
    }
    for ($i=0; $i < 5-$rating; $i++) {
        $rangking .= '<i class="fa fa-star-o" aria-hidden="true"></i>';
    }
    echo '<p class="value rangking">Đánh giá sản phẩm: '.$rangking.' '.$review.'</p>';
}
// Chèn lược xem
add_action( 'woocommerce_after_single_variation', 'bbloomer_custom_action_views', 5 );
function bbloomer_custom_action_views() {
	$views = get_post_meta(get_the_ID(), 'namdh_post_views_count', true);
	$sales = get_post_meta(get_the_ID(), 'total_sales', true);
	echo '<p class="value views">'.$views.' người đang xem sản phẩm này.</p>';
	echo ($sales > 0)
		? '<p class="value sales">'.$sales.' người đã mua sản phẩm này.</p>'
		: '<p class="value sales">Bạn sẽ là người đầu tiên mua sản phẩm này.</p>';
}

// Đếm số lần xem post
function namdh_post_views_count($postID) {
    $count_key = 'namdh_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

function namdh_track_post_views ($post_id) {
    if ( !is_single() ) return;
    if ( empty ( $post_id) ) {
        global $post;
        $post_id = $post->ID;    
    }
    namdh_post_views_count($post_id);
}
add_action( 'wp_head', 'namdh_track_post_views');